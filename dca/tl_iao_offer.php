<?php
namespace iao;

use Contao\Database as DB;
/**
 * @copyright  Sven Rhinow 2011-2013
 * @author     sr-tag Sven Rhinow Webentwicklung <http://www.sr-tag.de>
 * @package    invoice_and_offer
 * @license    LGPL
 * @filesource
 */

/**
 * Table tl_iao_offer
 */
$GLOBALS['TL_DCA']['tl_iao_offer'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'ptable'                      => 'tl_iao_projects',
		'ctable'                      => array('tl_iao_offer_items'),
		'doNotCopyRecords'			  => true,
		'switchToEdit'                => true,
		'enableVersioning'            => false,
		'onload_callback' => array
		(
			array('iao\iaoDcaOffer', 'generateOfferPDF'),
			array('iao\iaoDcaOffer', 'checkPermission'),
			array('iao\iaoDcaOffer', 'updateExpiryToTstmp')
		),
		'oncreate_callback' => array
		(
			array('iao\iaoDcaOffer', 'preFillFields'),
			array('iao\iaoDcaOffer', 'setMemmberfieldsFromProject'),
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
			'fields'                  => array('offer_tstamp'),
			'flag'                    => 8,
			'panelLayout'             => 'filter;search,limit'
		),
		'label' => array
		(
			'fields'                  => array('title','offer_id_str'),
			'format'                  => '%s (%s)',
			'label_callback'          => array('iao\iaoDcaOffer', 'listEntries'),
		),
		'global_operations' => array
		(
			'importOffer' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_offer']['importOffer'],
				'href'                => 'key=importOffer',
				'class'               => 'global_import',
				'attributes'          => 'onclick="Backend.getScrollOffset();"'
			),
			'exportOffer' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_offer']['exportOffer'],
				'href'                => 'key=exportOffer',
				'class'               => 'global_export',
				'attributes'          => 'onclick="Backend.getScrollOffset();"'
			),
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
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_offer']['edit'],
				'href'                => 'table=tl_iao_offer_items',
				'icon'                => 'edit.gif',
				'attributes'          => 'class="contextmenu"'
			),
			'editheader' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_offer']['editheader'],
				'href'                => 'act=edit',
				'icon'                => 'header.gif',
				'button_callback'     => array('iao\iaoDcaOffer', 'editHeader'),
				// 'attributes'          => 'class="edit-header"'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_offer']['copy'],
				'href'                => 'act=copy',
				'icon'                => 'copy.gif'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_offer']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"',
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_offer']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			),
			'invoice' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_offer']['invoice'],
				'href'                => 'key=addInvoice',
				'icon'                => 'system/modules/invoice_and_offer/html/icons/kontact_todo.png',
				'button_callback'     => array('iao\iaoDcaOffer', 'addInvoice')
			),
			'toggle' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_credit']['toggle'],
				'icon'                => 'ok.gif',
				#'attributes'          => 'onclick="Backend.getScrollOffset(); return AjaxRequest.toggleVisibility(this, %s);"',
				'button_callback'     => array('iao\iaoDcaOffer', 'toggleIcon')
			),
			'pdf' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_offer']['pdf'],
				'href'                => 'do=iao_offer&key=pdf',
				'icon'                => 'iconPDF.gif',
				'button_callback'     => array('iao\iaoDcaOffer', 'showPDFButton')
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'__selector__'                => array(),
		'default'                     => '{settings_legend},setting_id,pid;{title_legend},title;{offer_id_legend:hide},offer_id,offer_id_str,offer_tstamp,offer_pdf_file,expiry_date;{address_legend},member,address_text;{text_legend},before_template,before_text,after_template,after_text;{status_legend},published,status;{extend_legend},noVat;{notice_legend:hide},notice'
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
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_offer']['pid'],
			'foreignKey'              => 'tl_iao_projects.title',
			'filter'                  => true,
			'sorting'                 => true,
			'flag'                    => 11,
			'inputType'               => 'select',
			'eval'                    => array('tl_class'=>'w50','includeBlankOption'=>false, 'chosen'=>true,'submitOnChange'=>true),
			'sql'                     => "int(10) unsigned NOT NULL default '0'",
			'relation'                => array('type'=>'belongsTo', 'load'=>'eager'),
            'save_callback' => array
            (
                array('iao\iaoDcaOffer', 'fillMemberAndAddressFields')
            ),
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
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_offer']['setting_id'],
			'exclude'                 => true,
			'filter'                  => true,
			'sorting'                 => true,
			'flag'                    => 11,
			'inputType'               => 'select',
			'options_callback'        => array('iao\iaoDcaOffer', 'getSettingOptions'),
			'eval'                    => array('tl_class'=>'w50','includeBlankOption'=>false, 'chosen'=>true),
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'title' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_offer']['title'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>255,'tl_class'=>'long'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'offer_tstamp' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_offer']['offer_tstamp'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'datim', 'doNotCopy'=>true, 'datepicker'=>$this->getDatePickerString(), 'tl_class'=>'w50 wizard'),
			'load_callback' => array
			(
				array('iao\iaoDcaOffer', 'generateOfferTstamp')
			),
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'expiry_date' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_offer']['expiry_date'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'date', 'doNotCopy'=>true, 'datepicker'=>$this->getDatePickerString(), 'tl_class'=>'w50 wizard'),
			'load_callback' => array
			(
				array('iao\iaoDcaOffer', 'generateExpiryDate')
			),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'offer_id' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_offer']['offer_id'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'alnum', 'doNotCopy'=>true, 'spaceToUnderscore'=>true, 'maxlength'=>128, 'tl_class'=>'w50'),
			'save_callback' => array
			(
				array('iao\iaoDcaOffer', 'setFieldOfferNumber')
			),
			'sql'					  => "int(10) unsigned NOT NULL default '0'"
		),
		'offer_id_str' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_offer']['offer_id_str'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('doNotCopy'=>true, 'spaceToUnderscore'=>true, 'maxlength'=>128, 'tl_class'=>'w50'),
			'save_callback' => array
			(
				array('iao\iaoDcaOffer', 'setFieldOfferNumberStr')
			),
			'sql'					  => "varchar(255) NOT NULL default ''"
		),
		'offer_pdf_file' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_offer']['offer_pdf_file'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'fileTree',
			'eval'                    => array('fieldType'=>'radio', 'tl_class'=>'clr','extensions'=>'pdf','files'=>true, 'filesOnly'=>true, 'mandatory'=>false),
			'sql'					  => "varchar(255) NOT NULL default ''"
		),
		'member' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_offer']['member'],
			'exclude'                 => true,
			'filter'                  => true,
			'sorting'                 => true,
			'search'                  => true,
			'flag'                    => 11,
			'inputType'               => 'select',
			// 'foreignKey'              => 'tl_member.company',
			'options_callback'        => array('iao\iaoDcaOffer', 'getMemberOptions'),
			'eval'                    => array('tl_class'=>'w50','includeBlankOption'=>true,'submitOnChange'=>true, 'chosen'=>true),
			'save_callback' => array
			(
				array('iao\iaoDcaOffer', 'fillAddressSaveCallback')
			),
			'sql'					  => "varbinary(128) NOT NULL default ''"
		),
		'address_text' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_offer']['address_text'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'textarea',
			'eval'                    => array('rte'=>'tinyMCE','style'=>'height:60px;', 'tl_class'=>'clr'),
			'explanation'             => 'insertTags',
			'sql'					  => "mediumtext NULL"
		),
		'before_template' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_offer']['before_template'],
			'exclude'                 => true,
			'sorting'                 => true,
			'flag'                    => 11,
			'inputType'               => 'select',
			'options_callback'        => array('iao\iaoDcaOffer', 'getBeforeTemplate'),
			'eval'                    => array('tl_class'=>'w50','includeBlankOption'=>true,'submitOnChange'=>true, 'chosen'=>true),
			'save_callback' => array
			(
				array('iao\iaoDcaOffer', 'fillBeforeText')
			),
			'sql'					  => "int(10) unsigned NOT NULL default '0'"
		),
		'before_text' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_offer']['before_text'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'textarea',
			'eval'                    => array('rte'=>'tinyMCE', 'helpwizard'=>true,'style'=>'height:60px;', 'tl_class'=>'clr'),
			'explanation'             => 'insertTags',
			'sql'					  => "text NULL"
		),
		'after_template' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_offer']['after_template'],
			'exclude'                 => true,
			'sorting'                 => true,
			'flag'                    => 11,
			'inputType'               => 'select',
			'options_callback'        => array('iao\iaoDcaOffer', 'getAfterTemplate'),
			'eval'                    => array('tl_class'=>'w50','includeBlankOption'=>true,'submitOnChange'=>true, 'chosen'=>true),
			'save_callback' => array
			(
				array('iao\iaoDcaOffer', 'fillAfterText')
			),
			'sql'					  => "int(10) unsigned NOT NULL default '0'"
		),
		'after_text' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_offer']['after_text'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'textarea',
			'eval'                    => array('rte'=>'tinyMCE', 'helpwizard'=>true,'style'=>'height:60px;', 'tl_class'=>'clr'),
			'explanation'             => 'insertTags',
			'sql'					  => "text NULL"
		),
		'published' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_offer']['published'],
			'exclude'                 => true,
			'filter'                  => true,
			'flag'                    => 1,
			'inputType'               => 'checkbox',
			'eval'                    => array('doNotCopy'=>true),
			'sql'					  => "char(1) NOT NULL default ''"
		),
		'status' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_offer']['status'],
			'exclude'                 => true,
			'filter'                  => true,
			'flag'                    => 1,
			'inputType'               => 'select',
			'options'                 => &$GLOBALS['TL_LANG']['tl_iao_offer']['status_options'],
			'sql'					=> "char(1) NOT NULL default ''"
		),
		'noVat' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_offer']['noVat'],
			'exclude'                 => true,
			'filter'                  => true,
			'flag'                    => 1,
			'inputType'               => 'checkbox',
			'eval'                    => array('doNotCopy'=>true,'tl_class'=>'w50'),
			'sql'					  => "char(1) NOT NULL default ''"
		),
		'notice' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_offer']['notice'],
			'exclude'                 => true,
			'search'		  => true,
			'filter'                  => false,
			'inputType'               => 'textarea',
			'eval'                    => array('mandatory'=>false, 'cols'=>'10','rows'=>'10','style'=>'height:100px','rte'=>false),
			'sql'					  => "text NULL"
		),
		'price_netto' => array
		(
			'sql' 					=> "varchar(64) NOT NULL default '0'"
		),
		'price_brutto' => array
		(
			'sql' 					=> "varchar(64) NOT NULL default '0'"
		),
		'pdf_import_dir' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_offer']['pdf_import_dir'],
			'eval'                    => array('fieldType'=>'radio', 'files'=>false, 'filesOnly'=>false, 'class'=>'mandatory'),
			'sql'					  => "text NULL"
		),
		'csv_source' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_offer']['csv_source'],
			'eval'                    => array('fieldType'=>'radio', 'files'=>true, 'filesOnly'=>true, 'extensions'=>'csv', 'class'=>'mandatory'),
			'sql'					  => "text NULL"
		),
		'csv_posten_source' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_offer']['csv_posten_source'],
			'eval'                    => array('fieldType'=>'radio', 'files'=>true, 'filesOnly'=>true, 'extensions'=>'csv', 'class'=>'mandatory'),
			'sql'					  => "text NULL"
		),
		// -- Backport C2 SQL-Import
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
 * Class tl_iao_offer
 */
class iaoDcaOffer extends iaoBackend
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
	 * Check permissions to edit table tl_iao_offer
	 */
	public function checkPermission()
	{
		$this->checkIaoModulePermission('tl_iao_offer');
	}
	
	/**
     * prefill eny Fields by new dataset
     * @param string
     * @param integer
     * @param array
	*/
	public function preFillFields($table, $id, $set)
	{
		$objProject = IaoProjectsModel::findProjectByIdOrAlias($set['pid']);
		$settingId = ($objProject !== null && $objProject->setting_id != 0) ? $objProject->setting_id : 1;
		$settings = $this->getSettings($settingId);

		$offerId = $this->generateOfferNumber(0, $settings);
		$offerIdStr = $this->generateOfferNumberStr('', $offerId, time(), $settings);
		
		$set = array
		(
			'offer_id' => $offerId,
			'offer_id_str' => $offerIdStr
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
	 * @return int
	 */
	public function  generateExpiryDate($varValue, \DataContainer $dc)
	{
		$settings = $this->getSettings($dc->activeRecord->setting_id);

		if($varValue == 0)
		{
			$format = ( $settings['iao_offer_expiry_date'] ) ? $settings['iao_offer_expiry_date'] : '+3 month';
			$tstamp = ($dc->activeRecord->offer_tstamp) ? $dc->activeRecord->offer_tstamp : time();
			$varValue = strtotime($format,$tstamp);
		}
		return  $varValue;
	}

    /**
     * @param \DataContainer $dc
     */
	public function updateExpiryToTstmp(\DataContainer $dc)
	{
		$offerObj = IaoOfferModel::findAll();

	   	while($offerObj->next())
   		{
   			if(!stripos($offerObj->expiry_date,'-')) continue;

			$set = array('expiry_date' => strtotime($offerObj->expiry_date));
			DB::getInstance()->prepare('UPDATE `tl_iao_offer` %s WHERE `id`=?')
						->set($set)
						->execute($offerObj->id);
   		}
	}

	/**
	 * fill date-Field if this empty
	 * @param mixed
	 * @param object
	 * @return integer
	 */
	public function  generateOfferTstamp($varValue, \DataContainer $dc)
	{
		return ((int)$varValue == 0) ? time() : $varValue;
	}

    /**
     * fill Member And Address-Text
     * @param $varValue integer
     * @param $dc object
     * @return $value string
     */
    public function fillMemberAndAddressFields($varValue, \DataContainer $dc)
    {
        if((strlen($varValue) < 1)) return $varValue;

        $objProj = IaoProjectsModel::findProjectByIdOrAlias($varValue);
        if(is_object($objProj))
        {
            if((int) $objProj->member > 0)
            {
                $addressText = $this->getAddressText($objProj->member);

                $set = [
                    'member' => $objProj->member,
                    'address_text' => $addressText
                ];

            } else {
                $set = [
                    'member' => '',
                    'address_text' => ''
                ];
            }

            DB::getInstance()->prepare("UPDATE `tl_iao_offer` %s WHERE `id`=?")
                ->limit(1)
                ->set($set)
                ->execute($dc->id);

        }

        return $varValue;
    }
	/**
	 * fill Adress-Text
     * @param $varValue mixed
	 * @param $dc object
	 * @return mixed
	 */
	public function fillAddressSaveCallback($varValue, \DataContainer $dc)
	{
        if(strlen($varValue) < 1) return $varValue;

        $text = $this->getAddressText($varValue);

        DB::getInstance()->prepare('UPDATE `tl_iao_offer` SET `address_text`=? WHERE `id`=?')
                ->limit(1)
                ->execute($text,$dc->id);

		return $varValue;
	}

	/**
	 * get address text
     * @param $memberId integer
	 * @return string
	 */
	public function getAddressText($memberId)
	{
        $text = '';
        $objMember = \MemberModel::findById((int) $memberId);

        if(is_object($objMember)) {
            $text = '<p>'.$objMember->company.'<br />'.($objMember->gender!='' ? $GLOBALS['TL_LANG']['tl_iao_offer']['gender'][$objMember->gender].' ':'').($objMember->title ? $objMember->title.' ':'').$objMember->firstname.' '.$objMember->lastname.'<br />'.$objMember->street.'</p>';
            $text .='<p>'.$objMember->postal.' '.$objMember->city.'</p>';
        }

		return $text;
	}

	/**
     * fill Text before if this field is empty
     * @param $varValue integer
     * @param $dc object
     * @return integer
	 */
	public function fillBeforeText($varValue, \DataContainer $dc)
	{
		if(strip_tags($dc->activeRecord->before_text) == '')
		{
			if(strlen($varValue)<=0) return $varValue;

            //hole das ausgewähte Template
            $objTemplate = IaoTemplatesModel::findById($varValue);

            //hole den aktuellen Datensatz als DB-Object
            $objDbOffer = IaoOfferModel::findById($dc->id);

			$text = $this->changeIAOTags($objTemplate->text, 'offer', $objDbOffer);

            // schreibe das Textfeld
            $set =['before_text' => $text];
			DB::getInstance()->prepare('UPDATE `tl_iao_offer` %s WHERE `id`=?')
                ->set($set)
                ->limit(1)
                ->execute($dc->id);
		}
		return $varValue;
	}

	/**
     * fill Text after if this field is empty
     * @param $varValue integer
     * @param $dc object
     * @return integer
	 */
	public function fillAfterText($varValue, \DataContainer $dc)
	{
		if(strip_tags($dc->activeRecord->after_text) == '')
		{
			if(strlen($varValue) < 1) return $varValue;

            //hole das ausgewähte Template
            $objTemplate = IaoTemplatesModel::findById($varValue);

            //hole den aktuellen Datensatz als DB-Object
            $objDbOffer = IaoOfferModel::findById($dc->id);

            // ersetzte evtl. Platzhalter
            $text = $this->changeIAOTags($objTemplate->text,'offer', $objDbOffer);

            // schreibe das Textfeld
            $set =['after_text' => $text];
			DB::getInstance()->prepare('UPDATE `tl_iao_offer` SET `after_text`=? WHERE `id`=?')
				->set($set)
                ->limit(1)
				->execute($text,$dc->id);
		}
		return $varValue;
	}

	/**
     * get all template with position = 'offer_before_text'
     * @param object
     * @return array
	 */
	public function getBeforeTemplate(\DataContainer $dc)
	{
		$varValue= array();

		$all = DB::getInstance()->prepare('SELECT `id`,`title` FROM `tl_iao_templates` WHERE `position`=?')
					->execute('offer_before_text');

		while($all->next())
		{
			$varValue[$all->id] = $all->title;
		}

		return $varValue;
	}

	/**
     * get all template with position = 'offer_after_text'
     * @param object
     * @return array
	 */
	public function getAfterTemplate(\DataContainer $dc)
	{
		$varValue= array();

		$all = DB::getInstance()->prepare('SELECT `id`,`title` FROM `tl_iao_templates` WHERE `position`=?')
					->execute('offer_after_text');

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
		return ($this->User->isAdmin || count(preg_grep('/^tl_iao_offer::/', $this->User->alexf)) > 0) ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.specialchars($title).'"'.$attributes.'>'.$this->generateImage($icon, $label).'</a> ' : '';
	}

	/**
	 * generate invoice from this offer
	 * @param $row array
	 * @param $href string
	 * @param $label string
	 * @param $title string
	 * @param $icon string
	 * @return string
	 */
    public function addInvoice($row, $href, $label, $title, $icon)
    {
		if (!$this->User->isAdmin)
		{
			return '';
		}

		if (\Input::get('key') == 'addInvoice' && \Input::get('id') == $row['id'])
		{
			//Insert Invoice-Entry
			$set = array
			(
				'pid' => (\Input::get('projId')) ? : $row['pid'],
				'tstamp' => time(),
				'invoice_tstamp' => time(),
				'title' => $row['title'],
				'address_text' => $row['address_text'],
				'member' => $row['member'],
				'price_netto' => $row['price_netto'],
				'price_brutto' => $row['price_brutto'],
				'noVat' => $row['noVat'],
				'notice' => $row['notice'],
		    );

			$result = DB::getInstance()->prepare('INSERT INTO `tl_iao_invoice` %s')
							->set($set)
							->execute();

			$newInvoiceID = $result->insertId;

			//Insert Postions for this Entry
			if($newInvoiceID)
			{
				$posten = DB::getInstance()->prepare('SELECT * FROM `tl_iao_offer_items` WHERE `pid`=? ')
								->execute($row['id']);

				if(is_object($posten)) while($posten->next())
				{
					//Insert Invoice-Entry
					$postenset = [
						'pid' => $newInvoiceID,
						'tstamp' => $posten->tstamp,
						'type' => $posten->type,
						'headline' => $posten->headline,
						'headline_to_pdf' => $posten->headline_to_pdf,
						'sorting' => $posten->sorting,
						'date' => $posten->date,
						'time' => $posten->time,
						'text' => $posten->text,
						'count' => $posten->count,
						'amountStr' => $posten->amountStr,
						'operator' => $posten->operator,
						'price' => $posten->price,
						'price_netto' => $posten->price_netto,
						'price_brutto' => $posten->price_brutto,
						'published' => $posten->published,
						'vat' => $posten->vat,
						'vat_incl' => $posten->vat_incl
                    ];

					DB::getInstance()->prepare('INSERT INTO `tl_iao_invoice_items` %s')
									->set($postenset)
									->execute();
				}

				// Update the database
                $set = ['status'=>'2'];

				DB::getInstance()->prepare("UPDATE tl_iao_offer %s WHERE id=?")
                                ->set($set)
								->execute($row['id']);

				$this->redirect($this->addToUrl('do=iao_invoice&table=tl_iao_invoice&id='.$newInvoiceID.'&act=edit') );
		    }
		}
		
		$link = (\Input::get('onlyproj') == 1) ? 'do=iao_offer&amp;id='.$row['id'].'&amp;projId='.\Input::get('id') : 'do=iao_offer&amp;id='.$row['id'].'';
		$link = $this->addToUrl($href.'&amp;'.$link);
		$link = str_replace('table=tl_iao_offer&amp;','',$link);
		return '<a href="'.$link.'" title="'.specialchars($title).'">'.\Image::getHtml($icon, $label).'</a> ';
	}

    /**
     * wenn GET-Parameter passen dann wird eine PDF erzeugt
     * @param \DataContainer $dc
     */
	public function generateOfferPDF(\DataContainer $dc)
	{
		if(\Input::get('key') == 'pdf' && (int) \Input::get('id') > 0) $this->generatePDF((int) \Input::get('id'), 'offer');
	}

	/**
	 * Generate a "PDF" button and return it as pdf-document on Browser
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

		// wenn kein Admin dann kein PDF-Link	
		if (!$this->User->isAdmin) return '';

		// Wenn keine PDF-Vorlage dann kein PDF-Link
	    $objPdfTemplate = 	\FilesModel::findByUuid($settings['iao_offer_pdf']);			
		if(strlen($objPdfTemplate->path) < 1 || !file_exists(TL_ROOT . '/' . $objPdfTemplate->path) ) return false;  // template file not found

		$href = 'contao/main.php?do=iao_offer&amp;key=pdf&amp;id='.$row['id'];
		return '<a href="'.$href.'" title="'.specialchars($title).'">'.\Image::getHtml($icon, $label).'</a> ';

	}

	/**
	* fill field offer_id_str if it's empty
	* @param string
	* @param object
	* @return string
	*/
	public function setFieldOfferNumberStr($varValue, \DataContainer $dc)
	{
		$settings = $this->getSettings($dc->activeRecord->setting_id);
		$tstamp = ($dc->activeRecord->tstamp)?: time();

		return $this->generateOfferNumberStr($varValue, $dc->activeRecord->offer_id, $tstamp, $settings);
	}

	/**
	 * create an offer-number-string and replace placeholder
	 * @param string
	 * @param integer
	 * @param integer
	 * @param array
	 * @return string
	 */
	public function generateOfferNumberStr($varValue, $offerId, $tstamp, $settings)
	{
		if(strlen($varValue) < 1)
		{
			$format = 		$settings['iao_offer_number_format'];
			$format =  str_replace('{date}',date('Ymd',$tstamp), $format);
			$format =  str_replace('{nr}',$offerId, $format);
			$varValue = $format;
		}
		return $varValue;
	}

	/**
	* fill field offer_id if it's empty
	* @param string
	* @param object
	* @return string
	*/
	public function setFieldOfferNumber($varValue, \DataContainer $dc)
	{
		$settings = $this->getSettings($dc->activeRecord->setting_id);
		return $this->generateOfferNumber($varValue, $settings);
	}
	
	/**
	 * generate a offer-number if not set
	 * @param mixed
	 * @param object
	 * @return string
	 */
	public function generateOfferNumber($varValue, $settings)
	{
		$autoNr = false;
		$varValue = (int) $varValue;

		// Generate offer_id if there is none
		if($varValue == 0)
		{
			$autoNr = true;
			$objNr = DB::getInstance()->prepare("SELECT `offer_id` FROM `tl_iao_offer` ORDER BY `offer_id` DESC")
									->limit(1)
									->execute();

			if($objNr->numRows < 1 || $objNr->offer_id == 0)  $varValue = $settings['iao_offer_startnumber'];
			else  $varValue =  $objNr->offer_id +1;
		}
		else
		{
			$objNr = DB::getInstance()->prepare("SELECT `offer_id` FROM `tl_iao_offer` WHERE `id`=? OR `offer_id`=?")
									->limit(1)
									->execute(\Input::get('id'),$varValue);

			// Check whether the OfferNumber exists
			if ($objNr->numRows > 1 )
			{
				if (!$autoNr)
				{
					throw new \Exception(sprintf($GLOBALS['TL_LANG']['ERR']['aliasExists'], $varValue));
				}

				$varValue .= '-' . \Input::get('id');
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
		$settings = $this->getSettings($arrRow['settings_id']);

		$result = DB::getInstance()->prepare("SELECT `firstname`,`lastname`,`company` FROM `tl_member`  WHERE id=?")
						->limit(1)
						->execute($arrRow['member']);

		$row = $result->fetchAssoc();

		return '
		<div class="comment_wrap">
		<div class="cte_type status' . $arrRow['status'] . '"><strong>' . $arrRow['title'] . '</strong> '.$arrRow['offer_id_str'].'</div>
		<div>'.$GLOBALS['TL_LANG']['tl_iao_offer']['price_brutto'][0].': <strong>'.number_format($arrRow['price_brutto'],2,',','.').' '.$settings['iao_currency_symbol'].'</strong></div>
		<div>'.$GLOBALS['TL_LANG']['tl_iao_offer']['member'][0].': '.$row['firstname'].' '.$row['lastname'].' ('.$row['company'].')</div>
		'.(($arrRow['notice'])?"<div>".$GLOBALS['TL_LANG']['tl_iao_offer']['notice'][0].":".$arrRow['notice']."</div>": '').'
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

		if (strlen(\Input::get('tid')))
		{
			$this->toggleVisibility(\Input::get('tid'), (\Input::get('state')));
			$this->redirect($this->getReferer());
		}

		$href .= '&amp;tid='.$row['id'].'&amp;state='.($row['status']==1 ? 2 : 1);

		if ($row['status']==2)
		{
			$icon = 'logout.gif';
		}

		return '<a href="'.$this->addToUrl($href).'" title="'.$GLOBALS['TL_LANG']['tl_iao_offer']['toggle'].'"'.$attributes.'>'.\Image::getHtml($icon, $label).'</a> ';
	}

	/**
	 * Disable/enable a offer
	 * @param integer
	 * @param boolean
	 */
	public function toggleVisibility($intId, $blnVisible)
	{
		// Check permissions to edit
		$this->Input->setGet('id', $intId);
		$this->Input->setGet('act', 'toggle');

		// Check permissions to publish
		if (!$this->User->isAdmin && !$this->User->hasAccess('tl_iao_offer::status', 'alexf'))
		{
			$this->log('Not enough permissions to publish/unpublish comment ID "'.$intId.'"', 'tl_iao_offer toggleActivity', TL_ERROR);
			$this->redirect('contao/main.php?act=error');
		}

        $objVersions = new \Versions('tl_iao_offer', $intId);
        $objVersions->initialize();

        // Trigger the save_callback
		if (is_array($GLOBALS['TL_DCA']['tl_iao_offer']['fields']['status']['save_callback']))
		{
			foreach ($GLOBALS['TL_DCA']['tl_iao_offer']['fields']['status']['save_callback'] as $callback)
			{
				$this->import($callback[0]);
				$blnVisible = $this->$callback[0]->$callback[1]($blnVisible, $this);
			}
		}

		// Update the database
        $set = ['status'=>($blnVisible==1 ? '1' : '2')];

		DB::getInstance()->prepare("UPDATE tl_iao_offer %s WHERE id=?")
                        ->set($set)
						->execute($intId);

        $objVersions->create();
	}
}
