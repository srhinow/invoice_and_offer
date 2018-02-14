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
 * Table tl_iao_agreements
 */
$GLOBALS['TL_DCA']['tl_iao_agreements'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'ptable'                      => 'tl_iao_projects',
		'switchToEdit'                => true,
		'enableVersioning'            => false,
		'onload_callback' => array
		(
			array('\iao\iaoDcaAgreements','IAOSettings'),
			array('\iao\iaoDcaAgreements', 'checkPermission'),
		),
		'onsubmit_callback'	    => array
		(
		    array('\iao\iaoDcaAgreements','saveNettoAndBrutto')
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
			'mode'                    => 2,
			'fields'                  => array('end_date'),
			'flag'                    => 8,
			'panelLayout'             => 'filter;search,limit'
		),
		'label' => array
		(
			'fields'                  => array('title','beginn_date','end_date','price_brutto'),
			'format'                  => '%s (aktuelle Laufzeit: %s - %s)',
			'label_callback'          => array('\iao\iaoDcaAgreements', 'listEntries'),
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
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_agreements']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif',
				'attributes'          => 'class="contextmenu"'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_agreements']['copy'],
				'href'                => 'act=copy',
				'icon'                => 'copy.gif'
			),
			'invoice' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_agreements']['invoice'],
				'href'                => 'key=addInvoice',
				'icon'                => 'system/modules/invoice_and_offer/html/icons/kontact_todo.png',
				'button_callback'     => array('\iao\iaoDcaAgreements', 'addInvoice')
			),
			'pdf' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_agreements']['pdf'],
				'href'                => 'key=pdf',
				'icon'                => 'iconPDF.gif',
				'button_callback'     => array('\iao\iaoDcaAgreements', 'showPDF')
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_agreements']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"',
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'__selector__'                => array('sendEmail'),
		'default'                     => '{settings_legend},setting_id,pid;
										  {title_legend},title;
										  {agreement_legend:hide},agreement_pdf_file;
										  {address_legend},member,address_text;
										  {other_legend},price,vat,vat_incl,count,amountStr;
										  {status_legend},agreement_date,periode,beginn_date,end_date,status,terminated_date,new_generate;
										  {email_legend},sendEmail;
										  {invoice_generate_legend},before_template,after_template,posten_template;
										  {notice_legend:hide},notice'
	),
	// Subpalettes
	'subpalettes' => array
	(
             'sendEmail' => ('remind_before,email_from,email_to,email_subject,email_text')
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
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_agreements']['pid'],
			'foreignKey'              => 'tl_iao_projects.title',
			'filter'                  => true,
			'sorting'                 => true,
			'flag'                    => 11,
			'inputType'               => 'select',
			'eval'                    => array('tl_class'=>'w50','includeBlankOption'=>false, 'chosen'=>true),
			'sql'                     => "int(10) unsigned NOT NULL default '1'",
			'relation'                => array('type'=>'belongsTo', 'load'=>'eager')
		),
		'setting_id' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_agreements']['setting_id'],
			'exclude'                 => true,
			'filter'                  => true,
			'sorting'                 => true,
			'flag'                    => 11,
			'inputType'               => 'select',
			'options_callback'        => array('\iao\iaoDcaAgreements', 'getSettingOptions'),
			'eval'                    => array('tl_class'=>'w50','includeBlankOption'=>false, 'chosen'=>true),
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'tstamp' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'title' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_agreements']['title'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>false, 'maxlength'=>255,'tl_class'=>'long'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'agreement_date' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_agreements']['agreement_date'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'date', 'datepicker'=>$this->getDatePickerString(), 'tl_class'=>'w50 wizard'),
			'load_callback'			=> array (
				array('\iao\iaoDcaAgreements','getAgreementValue')
			),
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'periode' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_agreements']['periode'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>255,'tl_class'=>'w50'),
			'load_callback'			=> array (
				array('\iao\iaoDcaAgreements','getPeriodeValue')
			),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'beginn_date' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_agreements']['beginn_date'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'date', 'datepicker'=>$this->getDatePickerString(), 'tl_class'=>'w50 wizard'),
			'load_callback'				=> array
			(
				array('\iao\iaoDcaAgreements','getBeginnDateValue')
			),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'end_date' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_agreements']['end_date'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'date', 'datepicker'=>$this->getDatePickerString(), 'tl_class'=>'w50 wizard'),
			'load_callback'				=> array
			(
				array('\iao\iaoDcaAgreements','getEndDateValue')
			),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'new_generate' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_agreements']['new_generate'],
			'flag'                    => 1,
			'inputType'               => 'checkbox',
			'eval'                    => array('tl_class'=>'clr'),
			'save_callback'				=> array
			(
				array('\iao\iaoDcaAgreements','generateNewCycle')
			),
			'sql'                     => "char(1) NOT NULL default ''"
		),
		'terminated_date' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_agreements']['terminated_date'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'date', 'datepicker'=>$this->getDatePickerString(), 'tl_class'=>'w50 wizard'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'price' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_agreements']['price'],
			'exclude'                 => true,
			'search'                  => true,
			'sorting'                 => true,
			'flag'                    => 1,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'clr'),
			'sql'					  => "varchar(64) NOT NULL default '0'"
		),
		'price_netto' => array
		(
			'sql'					  => "varchar(64) NOT NULL default '0'"
		),
		'price_brutto' => array
		(
			'sql'					  => "varchar(64) NOT NULL default '0'"
		),
		'vat' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_agreements']['vat'],
			'filter'                  => true,
			'flag'                    => 1,
			'inputType'               => 'select',
			'options_callback'        => array('\iao\iaoDcaAgreements', 'getTaxRatesOptions'),
			'eval'                    => array('tl_class'=>'w50'),
			'sql'					  => "int(10) unsigned NOT NULL default '19'"
		),
		'vat_incl' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_agreements']['vat_incl'],
			'filter'                  => true,
			'flag'                    => 1,
			'inputType'               => 'select',
			'options'                 => &$GLOBALS['TL_LANG']['tl_iao_agreements']['vat_incl_percents'],
			'eval'                    => array('tl_class'=>'w50'),
			'sql'					  => "int(10) unsigned NOT NULL default '1'"
		),
		'count' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_agreements']['count'],
			'exclude'                 => true,
			'flag'                    => 1,
			'inputType'               => 'text',
			'default'				  => '1',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50'),
			'sql'					  => "varchar(64) NOT NULL default '0'"
		),
		'amountStr' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_agreements']['amountStr'],
			'exclude'                 => true,
			'filter'                  => true,
			'flag'                    => 1,
			'inputType'               => 'select',
			'options_callback'        => array('\iao\iaoDcaAgreements', 'getItemUnitsOptions'),
            'eval'                    => array('tl_class'=>'w50','submitOnChange'=>false),
			'sql'					  => "varchar(64) NOT NULL default ''"
		),
		'member' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_agreements']['member'],
			'exclude'                 => true,
			'filter'                  => true,
			'search'                  => true,
			'sorting'                 => true,
			'flag'                    => 11,
			'inputType'               => 'select',
			'options_callback'        => array('\iao\iaoDcaAgreements', 'getMemberOptions'),
			'eval'                    => array('tl_class'=>'w50','includeBlankOption'=>true,'submitOnChange'=>true, 'chosen'=>true),
			'save_callback' => array
			(
				array('\iao\iaoDcaAgreements', 'fillAdressText')
			),
			'sql'                     => "varbinary(128) NOT NULL default ''"
		),
		'address_text' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_agreements']['address_text'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'textarea',
			'eval'                    => array('rte'=>'tinyMCE','style'=>'height:60px;', 'tl_class'=>'clr'),
			'explanation'             => 'insertTags',
			'sql'                     => "mediumtext NULL"
		),
		'status' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_iao_agreements']['status'],
			'exclude'               => true,
			'filter'                => true,
			'flag'                  => 1,
			'inputType'             => 'select',
			'options'               => &$GLOBALS['TL_LANG']['tl_iao_agreements']['status_options'],
            'eval'			  		=> array('tl_class'=>'w50'),
            'sql'                     => "char(1) NOT NULL default ''"
		),
		'agreement_pdf_file' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_agreements']['agreement_pdf_file'],
			'exclude'                 => true,
			'inputType'               => 'fileTree',
			'eval'                    => array('fieldType'=>'radio', 'files'=>true, 'filesOnly'=>true, 'mandatory'=>false,'extensions'=>'pdf'),
			'sql'                     => "binary(16) NULL"
		),
		'sendEmail' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_agreements']['sendEmail'],
			'filter'                  => true,
			'flag'                    => 1,
			'inputType'               => 'checkbox',
			'eval'                    => array('doNotCopy'=>true,'submitOnChange'=>true),
			'sql'                     => "char(1) NOT NULL default ''"
		),
		'remind_before' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_agreements']['remind_before'],
			'exclude'                 => true,
			'default'                 => '-3 weeks',
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>255,'tl_class'=>'clr'),
			'sql'                     => "varchar(32) NOT NULL default ''"
		),
		'email_from' => array
	    (
		    'label'                   => &$GLOBALS['TL_LANG']['tl_iao_agreements']['email_from'],
		    'exclude'                 => true,
		    'inputType'               => 'text',
		    'eval'                    => array('mandatory'=>true, 'rgxp'=>'email', 'maxlength'=>32, 'decodeEntities'=>true, 'tl_class'=>'clr w50'),
		    'sql'                     => "varchar(32) NOT NULL default ''"
	    ),
	    'email_to' => array
	    (
		    'label'                   => &$GLOBALS['TL_LANG']['tl_iao_agreements']['email_to'],
		    'exclude'                 => true,
		    'flag'                    => 11,
		    'inputType'               => 'text',
		    'eval'                    => array('mandatory'=>true, 'decodeEntities'=>true, 'maxlength'=>128, 'tl_class'=>'w50'),
		    'sql'                     => "varchar(32) NOT NULL default ''"
	    ),
	    'email_subject' => array
	    (
		    'label'                   => &$GLOBALS['TL_LANG']['tl_iao_agreements']['email_subject'],
		    'exclude'                 => true,
		    'flag'                    => 11,
		    'inputType'               => 'text',
		    // 'default'		  		=> &$GLOBALS['TL_LANG']['tl_iao_agreements']['email_subject_default'],
		    'eval'                    => array('mandatory'=>false, 'maxlength'=>255, 'tl_class'=>'clr long'),
		    'sql'                     => "varchar(255) NOT NULL default ''"
	    ),
	    'email_text' => array
	    (
		    'label'                   => &$GLOBALS['TL_LANG']['tl_iao_agreements']['email_text'],
		    'exclude'                 => true,
		    'inputType'               => 'textarea',
		    'eval'                    => array('mandatory'=>true, 'decodeEntities'=>true),
		    'sql'                     => "text NULL"
	    ),
		'before_template' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_agreements']['before_template'],
			'inputType'               => 'select',
			'options_callback'        => array('\iao\iaoDcaAgreements', 'getBeforeTemplate'),
			'eval'                    => array('tl_class'=>'w50','includeBlankOption'=>true,'submitOnChange'=>false, 'chosen'=>true),
			'sql'					  => "int(10) unsigned NOT NULL default '0'"
		),
		'after_template' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_agreements']['after_template'],
			'inputType'               => 'select',
			'options_callback'        => array('\iao\iaoDcaAgreements', 'getAfterTemplate'),
			'eval'                    => array('tl_class'=>'w50','includeBlankOption'=>true, 'submitOnChange'=>false, 'chosen'=>true),
			'sql'					  => "int(10) unsigned NOT NULL default '0'"
		),
   		'posten_template' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_agreements']['posten_template'],
			'inputType'               => 'select',
			'options_callback'        => array('\iao\iaoDcaAgreements', 'getPostenTemplate'),
			'eval'                    => array('tl_class'=>'w50', 'includeBlankOption'=>true, 'submitOnChange'=>false, 'chosen'=>true),
			'sql'					  => "int(10) unsigned NOT NULL default '0'"
		),
		'notice' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_agreements']['notice'],
			'exclude'                 => true,
			'search'		  		=> true,
			'inputType'               => 'textarea',
			'eval'                    => array('mandatory'=>false, 'cols'=>'10','rows'=>'10','style'=>'height:100px','rte'=>false),
			'sql'                     => "text NULL"
		),
	)
);

/**
 * Class iaoDcaAgreements
 * @package iao
 */
class iaoDcaAgreements extends \iao\iaoBackend
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
	* get all default iao-Settings
	*/
	public function IAOSettings(\DataContainer $dc)
	{
	    $this->settings = $this->getSettings($GLOBALS['IAO']['default_settings_id']);
	}

	/**
	 * Check permissions to edit table tl_iao_agreements
	 */
	public function checkPermission()
	{
		$this->checkIaoModulePermission('tl_iao_agreements');
	}

    /**
    * List a particular record
    * @param array
    * @return string
    */
    public function listEntries($arrRow)
    {
		$return = '
		<div class="comment_wrap">
		<div class="cte_type agreement_status' . $arrRow['status'] . '"><strong>' . $arrRow['title'].'</strong></div>
		<div>Vertragszeit: '.date($GLOBALS['TL_CONFIG']['dateFormat'], $arrRow['beginn_date']).' - '.date($GLOBALS['TL_CONFIG']['dateFormat'], $arrRow['end_date']).'</div>';
		if($arrRow['status'] == 2) $return .= '<div>gekündigt am: '.date($GLOBALS['TL_CONFIG']['dateFormat'], $arrRow['terminated_date']).'</div>';
		if($arrRow['price'] != '') $return .= '<div>Betrag: '.$this->getPriceStr($arrRow['price_brutto']).'</div>';
		$return .= '</div>' . "\n    ";

		return $return;
    }

    /**
	 * fill date-Field if this empty
	 * @param mixed
	 * @param object
	 * @return integer
	 */
	public function  generateExecuteDate($varValue, \DataContainer $dc)
	{
		$altdate = ($dc->activeRecord->invoice_tstamp) ? $dc->activeRecord->invoice_tstamp : time();
		return ($varValue==0) ? $altdate : $varValue;
	}

	/**
	 * fill date-Field if this empty
	 * @param mixed
	 * @param object
	 * @return string
	 */
	public function  getPeriodeValue($varValue, \DataContainer $dc)
	{
		return ($varValue == '') ? '+1 year' : $varValue;
	}

	/**
     * fill Adress-Text
     * @param $intMember integer
     * @param $dc object
     * @return integer
	 */
	public function fillAdressText($intMember, \DataContainer $dc)
	{
		if(strip_tags($dc->activeRecord->address_text) == '')
		{
            $text = $this->getAdressText($intMember);

			DB::getInstance()->prepare('UPDATE `tl_iao_agreements` SET `address_text`=? WHERE `id`=?')
			->limit(1)
			->execute($text,$dc->id);
		}
		return $intMember;
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
		return ($this->User->isAdmin || count(preg_grep('/^tl_iao_agreements::/', $this->User->alexf)) > 0) ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.specialchars($title).'"'.$attributes.'>'.$this->generateImage($icon, $label).'</a> ' : '';
	}


	/**
	 * Generate a button and return it as string
	 * @param $row array
	 * @param $href string
	 * @param $label string
	 * @param $title string
	 * @param $icon string
     * @throws \Exception
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
			$beforeTemplObj = $this->getTemplateObject('tl_iao_templates',$row['before_template']);
			$afterTemplObj = $this->getTemplateObject('tl_iao_templates',$row['after_template']);
            $invoiceId = $this->generateInvoiceNumber(0,$this->settings);
            $invoiceIdStr = $this->generateInvoiceNumberStr($invoiceId, time(), $this->settings);

			//Insert Invoice-Entry
			$set = array
			(
				'pid' => $row['pid'],
				'tstamp' => time(),
				'invoice_tstamp' => time(),
				'invoice_id' => $invoiceId,
				'invoice_id_str' => $invoiceIdStr,
				'title' => $row['title'],
				'address_text' => $row['address_text'],
				'member' => $row['member'],
				'price_netto' => $row['price_netto'],
				'price_brutto' => $row['price_brutto'],
				'before_template' => $row['before_template'],
				'before_text' => $this->changeIAOTags($beforeTemplObj->text,'agreement',(object) $row),
				'after_template' => $row['after_template'],
				'after_text' => $this->changeIAOTags($afterTemplObj->text,'agreement',(object) $row),
				'agreement_id' => $row['id'],

		    );

			$result = DB::getInstance()->prepare('INSERT INTO `tl_iao_invoice` %s')
							->set($set)
							->execute();

			$newInvoiceID = (int) $result->insertId;

			//Insert Postions for this Entry
			if($newInvoiceID > 0)
			{
				//Posten-Template holen
				$postenTemplObj = $this->getTemplateObject('tl_iao_templates_items',$row['posten_template']);

				if($postenTemplObj->numRows > 0)
				{
					$headline = $this->changeIAOTags($postenTemplObj->headline,'agreement',(object) $row);
					$date = $postenTemplObj->date;
					$time = $postenTemplObj->time;
					$text = $this->changeIAOTags($postenTemplObj->text,'agreement',(object) $row);
				} else {
				    $headline = $text = '';
				    $time = $date = 0;
                }

				//Insert Invoice-Entry
				$postenset = array
				(
					'pid' => $newInvoiceID,
					'tstamp' => time(),
					'headline' => $headline,
					'headline_to_pdf' => '1',
					'date' => $date,
					'time' => $time,
					'text' => $text,
					'count' => $row['count'],
					'amountStr' => $row['amountStr'],
					'price' => $row['price'],
					'price_netto' => $row['price_netto'],
					'price_brutto' => $row['price_brutto'],
					'published' => '1',
					'vat' => $row['vat'],
					'vat_incl' => $row['vat_incl'],
					'posten_template' => $row['posten_template']
				);

				$newposten = DB::getInstance()->prepare('INSERT INTO `tl_iao_invoice_items` %s')
									->set($postenset)
									->execute();

                if($newposten->insertId < 1)
                {
                    throw new \Exception('Es konnte kein Rechnungs-Element angelegt werden.');
                }

                $redirectUrl = $this->addToUrl('do=iao_invoice&mode=2&table=tl_iao_invoice&s2e=1&id='.$newInvoiceID.'&act=edit');
                $redirectUrl = str_replace('key=addInvoice&amp;','', $redirectUrl);
				$this->redirect($redirectUrl);
			}

		}

		//Button erzeugen
		$link = (\Input::get('onlyproj') == 1) ? 'do=iao_agreements&amp;id='.$row['id'].'&amp;projId='.\Input::get('id') : 'do=iao_agreements&amp;id='.$row['id'].'';
		$link = $this->addToUrl($href.'&amp;'.$link);
		$link = str_replace('table=tl_iao_agreements&amp;','',$link);
		return '<a href="'.$link.'" title="'.specialchars($title).'">'.\Image::getHtml($icon, $label).'</a> ';
	}

	/**
	 * save the price_netto and price_brutto from actuell item
	 * @param object
	 * @return string
	 */
	public function saveNettoAndBrutto(\DataContainer $dc)
	{
		// Return if there is no active record (override all)
		if (!$dc->activeRecord)
		{
			return;
		}

	    $englprice = str_replace(',','.',$dc->activeRecord->price);

		$Netto = $nettoSum = $Brutto = $bruttoSum = 0;

		if($dc->activeRecord->vat_incl == 1)
		{
			$Netto = $englprice;
			$Brutto = $this->getBruttoPrice($englprice,$dc->activeRecord->vat);
		}
		else
		{
			$Netto = $this->getNettoPrice($englprice,$dc->activeRecord->vat);
			$Brutto = $englprice;
		}

	    $nettoSum = round($Netto,2) * $dc->activeRecord->count;
	    $bruttoSum = round($Brutto,2) * $dc->activeRecord->count;

		DB::getInstance()->prepare('UPDATE `tl_iao_agreements` SET `price_netto`=?, `price_brutto`=? WHERE `id`=?')
			->limit(1)
			->execute($nettoSum, $bruttoSum, $dc->id);
	}

	/**
	 * Return the "toggle visibility" button
	 * @param $row array
	 * @param $href string
	 * @param $label string
	 * @param $title string
	 * @param $icon string
	 * @param $attributes string
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

		return '<a href="'.$this->addToUrl($href).'" title="'.$GLOBALS['TL_LANG']['tl_iao_agreements']['toggle'].'"'.$attributes.'>'.$this->generateImage($icon, $label).'</a> ';
	}

	/**
	 * paid/not paid
	 * @param integer
	 * @param boolean
	 */
	public function toggleVisibility($intId, $blnVisible)
	{
		// Check permissions to edit
		$this->Input->setGet('id', $intId);
		$this->Input->setGet('act', 'toggle');

		// Check permissions to publish
		if (!$this->User->isAdmin && !$this->User->hasAccess('tl_iao_agreements::status', 'alexf'))
		{
			$this->log('Not enough permissions to publish/unpublish comment ID "'.$intId.'"', 'tl_iao_agreements toggleActivity', TL_ERROR);
			$this->redirect('contao/main.php?act=error');
		}

        $objVersions = new \Versions('tl_iao_agreements', $intId);
        $objVersions->initialize();

		// Trigger the save_callback
		if (is_array($GLOBALS['TL_DCA']['tl_iao_agreements']['fields']['status']['save_callback']))
		{
			foreach ($GLOBALS['TL_DCA']['tl_iao_agreements']['fields']['status']['save_callback'] as $callback)
			{
				$this->import($callback[0]);
				$blnVisible = $this->$callback[0]->$callback[1]($blnVisible, $this);
			}
		}

		$visibility = $blnVisible==1 ? '1' : '2';

		// Update the database
		DB::getInstance()->prepare("UPDATE tl_iao_agreements SET status=? WHERE id=?")
					   ->execute($visibility, $intId);

		//get reminder-Data
		$remindObj = IaoReminderModel::findById($intId);

		if(is_object($remindObj))
		{
			DB::getInstance()->prepare("UPDATE `tl_iao_invoice` SET `status`=?, `notice` = `notice`+?  WHERE id=?")
									->execute($visibility, $remindObj->notice, $remindObj->invoice_id);
		}

        $objVersions->create();
	}

    /**
     * @param $varValue
     * @param \DataContainer $dc
     * @return int
     */
	public function getAgreementValue($varValue, \DataContainer $dc)
	{
		return ($varValue == '0') ? time() : $varValue ;
	}

    /**
     * @param $varValue
     * @param \DataContainer $dc
     * @return int
     */
	public function getBeginnDateValue($varValue, \DataContainer $dc)
	{
		$agreement_date = ($dc->activeRecord->agreement_date) ? $dc->activeRecord->agreement_date : time() ;
		$beginn_date = ($varValue == '') ? $agreement_date : $varValue ;
		$end_date = $this->getEndDateValue($dc->activeRecord->end_date, $dc);

		$set = array
		(
			'beginn_date' => $beginn_date,
			'end_date' => $end_date
		);

		DB::getInstance()->prepare('UPDATE `tl_iao_agreements` %s WHERE `id`=?')
					->set($set)
					->execute($dc->id);

		return $beginn_date;
	}

    /**
     * @param $varValue
     * @param \DataContainer $dc
     * @return false|int
     */
	public function getEndDateValue($varValue, \DataContainer $dc)
	{
		if($varValue != '') return $varValue;

		$agreement_date = ($dc->activeRecord->agreement_date) ? $dc->activeRecord->agreement_date : time() ;
		$beginn_date = ($dc->activeRecord->beginn_date) ? $dc->activeRecord->beginn_date : $agreement_date;
		$periode = ($dc->activeRecord->periode) ? $dc->activeRecord->periode : $GLOBALS['IAO']['default_agreement_cycle'];

		// wenn der Wert nicht manuell verändert wurde die Periode berechnen
		return ($varValue == $dc->activeRecord->end_date) ? strtotime($periode.' -1 day', $beginn_date) : $varValue ;
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
	public function showPDF($row, $href, $label, $title, $icon)
	{
		if (!$this->User->isAdmin || strlen($row['agreement_pdf_file']) < 1 )
		{
			return '';
		}

		// Wenn keine PDF-Vorlage dann kein PDF-Link
	    $objPdf = 	\FilesModel::findByUuid($row['agreement_pdf_file']);
		if(strlen($objPdf->path) < 1 || !file_exists(TL_ROOT . '/' . $objPdf->path) ) return false;  // template file not found

		$pdfFile = TL_ROOT . '/' . $objPdf->path;

		if (\Input::get('key') == 'pdf' && \Input::get('id') == $row['id'])
		{

			if(!empty($row['agreement_pdf_file']) && file_exists($pdfFile))
			{
				header("Content-type: application/pdf");
				header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // Date in the past
				header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
	 			header('Content-Length: '.filesize($pdfFile));
				header('Content-Disposition: inline; filename="'.basename($pdfFile).'";');
			    ob_clean();
			    flush();
			    readfile($pdfFile);
				exit();
		    }
		}

		$button = (!empty($row['agreement_pdf_file']) && file_exists($pdfFile)) ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.specialchars($title).'">'.$this->generateImage($icon, $label).'</a> ' : '';
		return $button;
	}

    /**
     * @param $varValue
     * @param \DataContainer $dc
     * @return string
     */
	public function generateNewCycle($varValue, \DataContainer $dc)
	{
		if($varValue == 1)
		{
			$agreement = $dc->activeRecord->agreement_date;
			$beginn = $dc->activeRecord->beginn_date;
			$end = $dc->activeRecord->end_date;
			$periode = $dc->activeRecord->periode;
			$today = time();

			if($end && $beginn && ($today > $end))
			{
				$new_beginn = strtotime($periode, $beginn);
				$set = array
				(
					'beginn_date' => $new_beginn,
					'end_date' => strtotime($periode.' -1 day', $new_beginn),
					'new_generate' => ''
				);
				$this->Database->prepare('UPDATE `tl_iao_agreements` %s WHERE `id`=?')
							->set($set)
							->execute($dc->id);
			}
		}
		return '';
	}

	/**
	 * get all invoice-posten-templates
	 * @param object
	 * @throws Exception
	 */
	public function getPostenTemplate(\DataContainer $dc)
	{
		$varValue= array();

		$all = $this->Database->prepare('SELECT `id`,`headline` FROM `tl_iao_templates_items` WHERE `position`=?')
				->execute('invoice');

		while($all->next())
		{
			$varValue[$all->id] = $all->headline;
		}
		return $varValue;
	}

	/**
	 * get all invoice before template
	 * @param object
	 * @return array
	 */
	public function getBeforeTemplate(\DataContainer $dc)
	{
		$varValue= array();

		$all = DB::getInstance()->prepare('SELECT `id`,`title` FROM `tl_iao_templates` WHERE `position`=?')
				->execute('invoice_before_text');

		while($all->next())
		{
			$varValue[$all->id] = $all->title;
		}

	    return $varValue;
	}

	/**
	 * get all invoice after template
	 * @param object
	 * @return array
	 */
	public function getAfterTemplate(\DataContainer $dc)
	{
		$varValue= array();

		$all = DB::getInstance()->prepare('SELECT `id`,`title` FROM `tl_iao_templates` WHERE `position`=?')
				->execute('invoice_after_text');

		while($all->next())
		{
			$varValue[$all->id] = $all->title;
		}

	    return $varValue;
	}
}
