<?php
namespace iao;

use Contao\Database as DB;

/**
 * @copyright  Sven Rhinow 2011-2018
 * @author     sr-tag Sven Rhinow Webentwicklung <http://www.sr-tag.de>
 * @package    invoice_and_offer
 * @license    LGPL
 * @filesource
 */

/**
 * Table tl_iao_credit
 */
$GLOBALS['TL_DCA']['tl_iao_credit'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'ptable'                      => 'tl_iao_projects',
		'ctable'                      => array('tl_iao_credit_items'),
		'doNotCopyRecords'		  	  => true,
		'switchToEdit'                => true,
		'enableVersioning'            => false,
		'onload_callback' => array
		(
			array('iao\iaoDcaCredit', 'generateCreditPDF'),
			array('iao\iaoDcaCredit', 'checkPermission'),
		),
		'oncreate_callback' => array
		(
			array('iao\iaoDcaCredit', 'preFillFields'),
			array('iao\iaoDcaCredit', 'setMemmberfieldsFromProject'),
		),
		'sql' => array
		(
			'keys' => array
			(
				'id' => 'primary',
				'pid' => 'index'
			)
		)
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 1,
			'fields'                  => array('credit_tstamp'),
			'flag'                    => 8,
			'panelLayout'             => 'filter;search,limit'
		),
		'label' => array
		(
			'fields'                  => array('title','credit_id_str'),
			'format'                  => '%s (%s)',
			'label_callback'          => array('iao\iaoDcaCredit', 'listEntries'),
		),
		'global_operations' => array
		(
			'all' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'                => 'act=select',
				'class'               => 'header_edit_all',
				'attributes'          => 'onclick="Backend.getScrollOffset();" accesskey="e"'
			)
		),
		'operations' => array
		(
			'edit' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_credit']['edit'],
				'href'                => 'table=tl_iao_credit_items',
				'icon'                => 'edit.gif',
				'attributes'          => 'class="contextmenu"'
			),
			'editheader' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_credit']['editheader'],
				'href'                => 'act=edit',
				'icon'                => 'header.gif',
				'button_callback'     => array('iao\iaoDcaCredit', 'editHeader'),
				// 'attributes'          => 'class="edit-header"'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_credit']['copy'],
				'href'                => 'act=copy',
				'icon'                => 'copy.gif'
			),

			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_credit']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"',
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_credit']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			),
			'toggle' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_credit']['toggle'],
				'icon'                => 'ok.gif',
				'button_callback'     => array('iao\iaoDcaCredit', 'toggleIcon')
			),
			'pdf' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_credit']['pdf'],
				'href'                => 'key=pdf',
				'icon'                => 'iconPDF.gif',
				'button_callback'     => array('iao\iaoDcaCredit', 'showPDFButton')
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'__selector__'                => array(),
		'default'                     => '{settings_legend},setting_id,pid;title;{credit_id_legend:hide},credit_id,credit_id_str,credit_tstamp,credit_pdf_file,expiry_date;{address_legend},member,address_text;{text_legend},before_template,before_text,after_template,after_text;{extend_legend},noVat;{status_legend},published,status;{notice_legend:hide},notice'
	),

	// Subpalettes
	'subpalettes' => array
	(

	),

	// Fields
	'fields' => array
	(
		'id' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL auto_increment"
		),
		'pid' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_credit']['pid'],
			'foreignKey'              => 'tl_iao_projects.title',
			'filter'                  => true,
			'sorting'                 => true,
			'flag'                    => 11,
			'inputType'               => 'select',
			'eval'                    => array('tl_class'=>'w50','includeBlankOption'=>false, 'chosen'=>true),
			'sql'                     => "int(10) unsigned NOT NULL default '0'",
			'relation'                => array('type'=>'belongsTo', 'load'=>'eager')
		),
		'tstamp' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),	
		'sorting' => array
		(
			'sql'					  => "int(10) unsigned NOT NULL default '0'"
		),	
		'setting_id' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_credit']['setting_id'],
			'exclude'                 => true,
			'filter'                  => true,
			'sorting'                 => true,
			'flag'                    => 11,
			'inputType'               => 'select',
			'options_callback'        => array('iao\iaoDcaCredit', 'getSettingOptions'),
			'eval'                    => array('tl_class'=>'w50','includeBlankOption'=>false, 'chosen'=>true),
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'title' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_credit']['title'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>255),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'credit_tstamp' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_credit']['credit_tstamp'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'datim', 'doNotCopy'=>true, 'datepicker'=>$this->getDatePickerString(), 'tl_class'=>'w50 wizard'),
			'load_callback' => array
			(
				array('iao\iaoDcaCredit', 'generateCreditTstamp')
			),
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'expiry_date' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_credit']['expiry_date'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'date', 'doNotCopy'=>true, 'datepicker'=>$this->getDatePickerString(), 'tl_class'=>'w50 wizard'),
			'load_callback' => array
			(
				array('iao\iaoDcaCredit', 'generateExpiryDate')
			),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'credit_id' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_credit']['credit_id'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'alnum', 'doNotCopy'=>true, 'spaceToUnderscore'=>true, 'maxlength'=>128, 'tl_class'=>'w50'),
			'save_callback' => array
			(
				array('iao\iaoDcaCredit', 'setFieldCreditNumber')
			),
			'sql'					  => "int(10) unsigned NOT NULL default '0'"
		),
		'credit_id_str' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_credit']['credit_id_str'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('doNotCopy'=>true, 'spaceToUnderscore'=>true, 'maxlength'=>128, 'tl_class'=>'w50'),
			'save_callback' => array
			(
				array('iao\iaoDcaCredit', 'createCreditNumberStr')
			),
			'sql'					  => "varchar(255) NOT NULL default ''"
		),
		'credit_pdf_file' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_credit']['credit_pdf_file'],
			'exclude'                 => true,
			'inputType'               => 'fileTree',
			'eval'                    => array('fieldType'=>'radio', 'tl_class'=>'clr','extensions'=>'pdf','files'=>true, 'filesOnly'=>true, 'mandatory'=>false),
			'sql'					  => "varchar(255) NOT NULL default ''"
		),
		'member' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_credit']['member'],
			'exclude'                 => true,
			'filter'                  => true,
			'sorting'                 => true,
			'flag'                    => 11,
			'inputType'               => 'select',
			'options_callback'        => array('iao\iaoDcaCredit', 'getMemberOptions'),
			'eval'                    => array('tl_class'=>'w50','includeBlankOption'=>true,'submitOnChange'=>true, 'chosen'=>true),
			'save_callback' => array
			(
				array('iao\iaoDcaCredit', 'fillAdressText')
			),
			'sql'					  => "varbinary(128) NOT NULL default ''"
		),
		'address_text' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_credit']['address_text'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'textarea',
			'eval'                    => array('rte'=>'tinyMCE','style'=>'height:60px;', 'tl_class'=>'clr'),
			'explanation'             => 'insertTags',
			'sql'					  => "mediumtext NULL"
		),
		'before_template' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_credit']['before_template'],
			'exclude'                 => true,
			'filter'                  => true,
			'sorting'                 => true,
			'flag'                    => 11,
			'inputType'               => 'select',
			'options_callback'        => array('iao\iaoDcaCredit', 'getBeforeTemplate'),
			'eval'                    => array('tl_class'=>'w50','includeBlankOption'=>true,'submitOnChange'=>true),
			'save_callback' => array
			(
				array('iao\iaoDcaCredit', 'fillBeforeTextFromTemplate')
			),
			'sql'					  => "int(10) unsigned NOT NULL default '0'"
		),
		'before_text' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_credit']['before_text'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'textarea',
			'eval'                    => array('rte'=>'tinyMCE', 'helpwizard'=>true,'style'=>'height:60px;', 'tl_class'=>'clr'),
			'explanation'             => 'insertTags',
			'sql'					  => "text NULL"
		),
		'after_template' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_credit']['before_template'],
			'exclude'                 => true,
			'filter'                  => true,
			'sorting'                 => true,
			'flag'                    => 11,
			'inputType'               => 'select',
			'options_callback'        => array('iao\iaoDcaCredit', 'getAfterTemplate'),
			'eval'                    => array('tl_class'=>'w50','includeBlankOption'=>true,'submitOnChange'=>true),
			'save_callback' => array
			(
				array('iao\iaoDcaCredit', 'fillAfterTextFromTemplate')
			),
			'sql'					  => "int(10) unsigned NOT NULL default '0'"
		),
		'after_text' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_credit']['after_text'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'textarea',
			'eval'                    => array('rte'=>'tinyMCE', 'helpwizard'=>true,'style'=>'height:60px;', 'tl_class'=>'clr'),
			'explanation'             => 'insertTags',
			'sql'					  => "text NULL"
		),
		'price_netto' => array
		(
			'sql'					  => "varchar(64) NOT NULL default '0'"
		),
		'price_brutto' => array
		(
			'sql'					  => "varchar(64) NOT NULL default '0'"
		),
		'published' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_credit']['published'],
			'exclude'                 => true,
			'filter'                  => true,
			'flag'                    => 1,
			'inputType'               => 'checkbox',
			'eval'                    => array('doNotCopy'=>true),
			'sql'					  => "char(1) NOT NULL default ''"
		),
		'status' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_credit']['status'],
			'exclude'                 => true,
			'filter'                  => true,
			'flag'                    => 1,
			'inputType'               => 'select',
			'options'				=>  &$GLOBALS['TL_LANG']['tl_iao_credit']['status_options'],
            'eval'					=> array('doNotCopy'=>true),
			'sql'					=> "char(1) NOT NULL default ''"
		),
		'noVat' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_credit']['noVat'],
			'filter'                  => true,
			'flag'                    => 1,
			'inputType'               => 'checkbox',
			'eval'                    => array('doNotCopy'=>true),
			'sql'					  => "char(1) NOT NULL default ''"
		),
		'notice' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_credit']['notice'],
			'exclude'                 => true,
			'search'		  => true,
			'filter'                  => false,
			'inputType'               => 'textarea',
			'eval'                    => array('mandatory'=>false, 'cols'=>'10','rows'=>'10','style'=>'height:100px','rte'=>false),
			'sql'					  => "text NULL"
		),
		// -- Backport C2 SQL-Import
		'sendEmail' => array(
				'sql' 					=> "varchar(64) NOT NULL default '0'"
		),
		'sendEmail' => array(
				'sql' 					=> "varchar(64) NOT NULL default '0'"
		),
		'FromEmail' => array(
				'sql' 					=> "varchar(64) NOT NULL default '0'"
		),
		'ToEmail' => array(
				'sql' 					=> "varchar(64) NOT NULL default '0'"
		),
		'alias' => array(
				'sql' 					=> "varchar(64) NOT NULL default '0'"
		),
		//--
	)
);


/**
 * Class iaoDcaCredit
 * @package iao
 */
class iaoDcaCredit  extends \iao\iaoBackend
{

	protected $settings = array();

	/**
	 * Import the back end user object
	 */
	public function __construct()
	{
		parent::__construct();
		$this->import('BackendUser', 'User');
	}

	/**
	 * Check permissions to edit table tl_iao_credit
	 */
	public function checkPermission()
	{
		$this->checkIaoModulePermission('tl_iao_credit');
	}
	
	/**
	* prefill eny Fields by new dataset
	*/
	public function preFillFields($table, $id, $set, $obj)
	{
		$objProject = IaoProjectsModel::findProjectByIdOrAlias($set['pid']);
		$settingId = ($objProject !== null && $objProject->setting_id != 0) ? $objProject->setting_id : 1;
		$settings = $this->getSettings($settingId);
		$creditId = $this->generateCreditNumber(0, $settings);
		$creditIdStr = $this->createCreditNumberStr('', $creditId, time(), $settings);

		$set = array
		(
			'credit_id' => $creditId,
			'credit_id_str' => $creditIdStr
		);

        DB::getInstance()->prepare('UPDATE '.$table.' %s WHERE `id`=?')
						->set($set)
						->limit(1)
						->execute($id);
	}

    /**
	 * fill date-Field if this empty
	 * @param mixed
	 * @param object
	 * @return integer
	 */
	public function  generateCreditDate($varValue, \DataContainer $dc)
	{
		return ($varValue==0) ? date($GLOBALS['TL_CONFIG']['dateFormat']) : $varValue;
	}

	/**
	 * fill date-Field if this empty
	 * @param $varValue mixed
	 * @param $dc object
	 * @return mixed
	 */
	public function  generateExpiryDate($varValue, \DataContainer $dc)
	{
		$settings = $this->getSettings($dc->activeRecord->setting_id);

		if($varValue==0)
	    {
			$format = ( $settings['iao_credit_expiry_date'] ) ? $settings['iao_credit_expiry_date'] : '+3 month';
			$tstamp = ($dc->activeRecord->credit_tstamp) ? $dc->activeRecord->credit_tstamp : time();
			$varValue = strtotime($format,$tstamp);
	    }
	    return  $varValue;
	}

    /**
     * @param \DataContainer $dc
     */
	public function updateExpiryToTstmp(\DataContainer $dc)
	{
        $objCredits = IaoCreditModel::findAll();

        if(is_object($objCredits)) while($objCredits->next())
   		{
   			if(!stripos($objCredits->expiry_date,'-')) continue;

			$set = array('expiry_date' => strtotime($objCredits->expiry_date));
            DB::getInstance()->prepare('UPDATE `tl_iao_credit` %s WHERE `id`=?')
						->set($set)
						->execute($objCredits->id);
   		}
	}

	/**
	 * fill date-Field if this empty
	 * @param $varValue mixed
	 * @param $dc object
	 * @return integer
	 */
	public function  generateCreditTstamp($varValue, \DataContainer $dc)
	{
		return ((int)$varValue == 0) ? time() : $varValue;
	}

	/**
	 * fill Adress-Text
     * @param $intMember integer
	 * @param $dc object
	 * @return integer
	 */
	public function fillAdressText($intMember, \DataContainer $dc)
	{
		if(trim(strip_tags($dc->activeRecord->address_text)) == '')
		{
            $text = $this->getAdressText($intMember);

			DB::getInstance()->prepare('UPDATE `tl_iao_credit` SET `address_text`=? WHERE `id`=?')
				   ->limit(1)
				   ->execute($text, $dc->id);
		}
		return $intMember;
	}

	/**
	 * fill Text before if this field is empty
     * @param $varValue integer
	 * @param $dc object
	 * @return integer
	 */
	public function fillBeforeTextFromTemplate($varValue, \DataContainer $dc)
	{
		if(strip_tags($dc->activeRecord->before_text) == '')
		{
			if(strlen($varValue)<=0) return $varValue;

			//hole das ausgewähte Template
            $objTemplate = IaoTemplatesModel::findById($varValue);

            //hole den aktuellen Datensatz als DB-Object
            $objDbCredit = IaoCreditModel::findById($dc->id);

            // ersetzte evtl. Platzhalter
			$text = $this->changeIAOTags($objTemplate->text, 'credit' , $objDbCredit);

			// schreibe das Textfeld
		    DB::getInstance()->prepare('UPDATE `tl_iao_credit` SET `before_text`=? WHERE `id`=?')
				   ->limit(1)
				   ->execute($text, $dc->id);
		}
		return $varValue;
	}

	/**
     * fill Text after if this field is empty
     * @param $varValue integer
     * @param $dc object
     * @return integer
	 */
	public function fillAfterTextFromTemplate($varValue, \DataContainer $dc)
	{

		if(strip_tags($dc->activeRecord->after_text)=='')
		{
			if(strlen($varValue)<=0) return $varValue;

            //hole das ausgewähte Template
            $objTemplate = IaoTemplatesModel::findById($varValue);

            //hole den aktuellen Datensatz als DB-Object
            $objDbCredit = IaoCreditModel::findById($dc->id);

            // ersetzte evtl. Platzhalter
            $text = $this->changeIAOTags($objTemplate->text, 'credit' , $objDbCredit);

		    DB::getInstance()->prepare('UPDATE `tl_iao_credit` SET `after_text`=? WHERE `id`=?')
				   ->limit(1)
				   ->execute($objTemplate->text,$dc->id);
		}
		return $varValue;
	}


	/**
	 * get all template with position = 'credit_before_text'
	 * @param object
	 * @return array
	 */
	public function getBeforeTemplate(\DataContainer $dc)
	{
		$varValue= array();

		$all = DB::getInstance()->prepare('SELECT `id`,`title` FROM `tl_iao_templates` WHERE `position`=?')
		->execute('credit_before_text');

		while($all->next())
		{
			$varValue[$all->id] = $all->title;
		}

		return $varValue;
	}

	/**
	 * get all credit after template
	 * @param object
	 * @return array
	 */
	public function getAfterTemplate(\DataContainer $dc)
	{
		$varValue= array();

		$all = DB::getInstance()->prepare('SELECT `id`,`title` FROM `tl_iao_templates` WHERE `position`=?')
		->execute('credit_after_text');

		while($all->next())
		{
			$varValue[$all->id] = $all->title;
		}

		return $varValue;
	}

	/**
	 * Return the edit header button
	 * @param array
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @return string
	 */
	public function editHeader($row, $href, $label, $title, $icon, $attributes)
	{
		return ($this->User->isAdmin || count(preg_grep('/^tl_iao_credit::/', $this->User->alexf)) > 0) ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.specialchars($title).'"'.$attributes.'>'.$this->generateImage($icon, $label).'</a> ' : '';
	}

	/**
	* wenn GET-Parameter passen dann wird eine PDF erzeugt
	*
	*/
	public function generateCreditPDF(\DataContainer $dc)
	{
		if(\Input::get('key') == 'pdf' && (int) \Input::get('id') > 0) $this->generatePDF((int) \Input::get('id'), 'credit');
	}

	/**
	 * Generate a "PDF" button and return it as string
	 * @param array
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @return string
	 */
	public function showPDFButton($row, $href, $label, $title, $icon)
	{
		$settings = $this->getSettings($row['setting_id']);

		if (!$this->User->isAdmin)	return '';

	    $objPdfTemplate = 	\FilesModel::findByUuid($settings['iao_credit_pdf']);	
		if(strlen($objPdfTemplate->path) < 1 || !file_exists(TL_ROOT . '/' . $objPdfTemplate->path) ) return;  // template file not found

		$href = 'contao/main.php?do=iao_credit&amp;key=pdf&amp;id='.$row['id'];
		return '<a href="'.$href.'" title="'.specialchars($title).'">'.$this->generateImage($icon, $label).'</a> ';
	}

	/**
	* fill field invoice_id_str if it's empty
	* @param string
	* @param object
	* @return string
	*/
	public function setFieldCreditNumberStr($varValue, \DataContainer $dc)
	{
		$settings = $this->getSettings($dc->activeRecord->setting_id);
		$tstamp = ($dc->activeRecord->date) ?: time();

		return $this->createCreditNumberStr($varValue, $dc->activeRecord->credit_id, $tstamp, $settings);
	}

	/**
	 * generate a Credit-number-string if not set
	 * @param string
	 * @param integer
	 * @param integer
	 * @param array
	 * @return string
	 */
	public function createCreditNumberStr($varValue, $creditId, $tstamp, $settings)
	{

		if(strlen($varValue) < 1)
		{
			$format = $settings['iao_credit_number_format'];
			$format =  str_replace('{date}',date('Ymd', $tstamp), $format);
			$format =  str_replace('{nr}', $creditId, $format);
			$varValue = $format;
		}
		return $varValue;
	}

	/**
	* fill field invoice_id if it's empty
	* @param string
	* @param object
	* @return string
	*/
	public function setFieldCreditNumber($varValue, \DataContainer $dc)
	{
		$settings = $this->getSettings($dc->activeRecord->setting_id);
		return $this->generateCreditNumber($varValue, $settings);
	}
	

	/**
	 * Autogenerate an credit number if it has not been set yet
	 * @param mixed
	 * @param object
	 * @return string
	 */
	public function generateCreditNumber($varValue, $settings)
	{
		$autoNr = false;
		$varValue = (int) $varValue;
        $id = \Input::get('id');

		// Generate credit_id if there is none
		if($varValue == 0)
		{
			$objNr = DB::getInstance()->prepare("SELECT `credit_id` FROM `tl_iao_credit` ORDER BY `credit_id` DESC")
			->limit(1)
			->execute();

			if($objNr->numRows < 1 || $objNr->credit_id == 0)  $varValue = $settings['iao_credit_startnumber'];
			else  $varValue =  $objNr->credit_id +1;
	    }
	    else
	    {
			$objNr = DB::getInstance()->prepare("SELECT `credit_id` FROM `tl_iao_credit` WHERE `id`=? OR `credit_id`=?")
			->limit(1)
			->execute($id, $varValue);

			// Check whether the CreditNumber exists
			if ($objNr->numRows > 1 )
			{
				if (!$autoNr)
				{
					throw new \Exception(sprintf($GLOBALS['TL_LANG']['ERR']['aliasExists'], $varValue));
				}

				$varValue .= '-' . $id;
			}
	    }

	    return $varValue;
      }

    /**
     * List a particular record
     * @param array
     * @return string
     */
    public function listEntries($arrRow)
    {
		$result = DB::getInstance()->prepare("SELECT `firstname`,`lastname`,`company` FROM `tl_member`  WHERE id=?")
		->limit(1)
		->execute($arrRow['member']);

	    $row = $result->fetchAssoc();

		return '
		<div class="comment_wrap">
		<div class="cte_type status' . $arrRow['status'] . '"><strong>' . $arrRow['title'] . '</strong> '.$arrRow['credit_id_str'].'</div>
		<div>'.$GLOBALS['TL_LANG']['tl_iao_credit']['price_brutto'][0].': <strong>'.number_format($arrRow['price_brutto'],2,',','.').' '.$GLOBALS['TL_CONFIG']['currency_symbol'].'</strong></div>
		<div>'.$GLOBALS['TL_LANG']['tl_iao_credit']['member'][0].': '.$row['firstname'].' '.$row['lastname'].' ('.$row['company'].')</div>
		'.(($arrRow['notice'])?"<div>".$GLOBALS['TL_LANG']['tl_iao_credit']['notice'][0].":".$arrRow['notice']."</div>": '').'
		</div>' . "\n    ";
    }

	/**
	 * Return the "toggle visibility" button
	 * @param array
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @return string
	 */
	public function toggleIcon($row, $href, $label, $title, $icon, $attributes)
	{
		$this->import('BackendUser', 'User');

		if (strlen($this->Input->get('tid')))
		{
			$this->toggleVisibility($this->Input->get('tid'), ($this->Input->get('state')));
			$this->redirect($this->getReferer());
		}

		$href .= '&amp;tid='.$row['id'].'&amp;state='.($row['status']==1 ? 2 : 1);

		if ($row['status']==2)
		{
			$icon = 'logout.gif';
		}

		return '<a href="'.$this->addToUrl($href).'" title="'.$GLOBALS['TL_LANG']['tl_iao_credit']['toggle'].'"'.$attributes.'>'.\Image::getHtml($icon, $label).'</a> ';
	}

	/**
	 * Disable/enable a user group
	 * @param integer
	 * @param boolean
	 */
	public function toggleVisibility($intId, $blnVisible)
	{
		// Check permissions to edit
		$this->Input->setGet('id', $intId);
		$this->Input->setGet('act', 'toggle');

		// Check permissions to publish
		if (!$this->User->isAdmin && !$this->User->hasAccess('tl_iao_credit::status', 'alexf'))
		{
			$this->log('Not enough permissions to publish/unpublish comment ID "'.$intId.'"', 'tl_iao_credit toggleActivity', TL_ERROR);
			$this->redirect('contao/main.php?act=error');
		}

        $objVersions = new \Versions('tl_iao_credit', $intId);
        $objVersions->initialize();

		// Trigger the save_callback
		if (is_array($GLOBALS['TL_DCA']['tl_iao_credit']['fields']['status']['save_callback']))
		{
			foreach ($GLOBALS['TL_DCA']['tl_iao_credit']['fields']['status']['save_callback'] as $callback)
			{
				$this->import($callback[0]);
				$blnVisible = $this->$callback[0]->$callback[1]($blnVisible, $this);
			}
		}
        $status = ($blnVisible==1 ) ? '1' : '2';
		// Update the database
		DB::getInstance()->prepare("UPDATE tl_iao_credit SET status=? WHERE id=?")
		->execute($status, $intId);

        $objVersions->create();
	}
}
