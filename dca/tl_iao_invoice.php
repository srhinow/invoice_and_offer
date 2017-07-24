<?php

/**
 * @copyright  Sven Rhinow 2011-2015
 * @author     sr-tag Sven Rhinow Webentwicklung <http://www.sr-tag.de>
 * @package    invoice_and_offer
 * @license    LGPL
 * @filesource
 */

/**
 * Table tl_iao_invoice
 */
$GLOBALS['TL_DCA']['tl_iao_invoice'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'ptable'                      => 'tl_iao_projects',
		'ctable'                      => array('tl_iao_invoice_items'),
		'doNotCopyRecords'			  => true,
		'switchToEdit'                => true,
		'enableVersioning'            => false,
		'onload_callback' => array
		(
			array('tl_iao_invoice', 'generateInvoicePDF'),
			array('tl_iao_invoice', 'checkPermission'),
			array('tl_iao_invoice','upgradeInvoices')
		),
		'oncreate_callback' => array
		(
			array('tl_iao_invoice', 'preFillFields'),
			array('tl_iao_invoice', 'setMemmberfieldsFromProject'),
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
			'fields'                  => array('invoice_tstamp'),
			'flag'                    => 8,
			'panelLayout'             => 'filter;search,limit'
		),
		'label' => array
		(
			'fields'                  => array('title','invoice_id_str'),
			'format'                  => '%s (%s)',
			'label_callback'          => array('tl_iao_invoice', 'listEntries'),
		),
		'global_operations' => array
		(
			'importInvoices' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_invoice']['importInvoices'],
				'href'                => 'key=importInvoices',
				'class'               => 'global_import',
				'attributes'          => 'onclick="Backend.getScrollOffset();"'
			),
			'exportInvoices' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_invoice']['exportInvoices'],
				'href'                => 'key=exportInvoices',
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
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_invoice']['edit'],
				'href'                => 'table=tl_iao_invoice_items',
				'icon'                => 'edit.gif',
				'attributes'          => 'class="contextmenu"'
			),
			'editheader' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_invoice']['editheader'],
				'href'                => 'act=edit',
				'icon'                => 'header.gif',
				'button_callback'     => array('tl_iao_invoice', 'editHeader'),
				// 'attributes'          => 'class="edit-header"'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_invoice']['copy'],
				'href'                => 'act=copy',
				'icon'                => 'copy.gif'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_invoice']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"',
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_invoice']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			),
			'toggle' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_invoice']['toggle'],
				'icon'                => 'ok.gif',
				'button_callback'     => array('tl_iao_invoice', 'toggleIcon')
			),
			'pdf' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_invoice']['pdf'],
				'href'                => 'key=pdf',
				'icon'                => 'iconPDF.gif',
				'button_callback'     => array('tl_iao_invoice', 'showPDFButton')
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'__selector__'                => array('discount'),
		'default'                     => '{settings_legend},setting_id,pid;{title_legend},title;{invoice_id_legend:hide},invoice_id,invoice_id_str,invoice_tstamp,agreement_id,invoice_pdf_file,execute_date,expiry_date;{address_legend},member,address_text;{text_before_legend},before_template,before_text,beforetext_as_template;{text_after_legend},after_template,after_text,aftertext_as_template;{status_legend},published;{paid_legend},priceall_brutto,status,paid_on_dates,remaining;{extend_legend},noVat,discount;{notice_legend:hide},notice',
	),

	// Subpalettes
	'subpalettes' => array
	(
             'discount' => ('discount_title,discount_value,discount_operator')
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
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_invoice']['pid'],
			'foreignKey'              => 'tl_iao_projects.title',
			'filter'                  => true,
			'sorting'                 => true,
			'flag'                    => 11,
			'inputType'               => 'select',
			'eval'                    => array('tl_class'=>'w50','includeBlankOption'=>false, 'chosen'=>true),
			'sql'                     => "int(10) unsigned NOT NULL default '0'",
			'relation'                => array('type'=>'belongsTo', 'load'=>'eager')
		),
		'reminder_id' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
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
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_invoice']['setting_id'],
			'exclude'                 => true,
			'filter'                  => true,
			'sorting'                 => true,
			'flag'                    => 11,
			'inputType'               => 'select',
			'options_callback'        => array('tl_iao_invoice', 'getSettingOptions'),
			'eval'                    => array('tl_class'=>'w50','includeBlankOption'=>false, 'chosen'=>true),
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'title' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_invoice']['title'],
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>255,'tl_class'=>'long'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'invoice_tstamp' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_invoice']['invoice_date'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('doNotCopy'=>true,'rgxp'=>'datim', 'datepicker'=>$this->getDatePickerString(), 'tl_class'=>'w50 wizard'),
			'load_callback' => array
			(
				array('tl_iao_invoice', 'generateInvoiceTstamp')
			),
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'execute_date' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_invoice']['execute_date'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('doNotCopy'=>true,'rgxp'=>'date', 'datepicker'=>$this->getDatePickerString(), 'tl_class'=>'w50 wizard'),
			'load_callback' => array
			(
				array('tl_iao_invoice', 'generateExecuteDate')
			),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'expiry_date' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_invoice']['expiry_date'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('doNotCopy'=>true,'rgxp'=>'date', 'datepicker'=>$this->getDatePickerString(), 'tl_class'=>'w50 wizard'),
			'load_callback' => array
			(
				array('tl_iao_invoice', 'generateExpiryDate')
			),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'paid_on_date' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_invoice']['paid_on_date'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('doNotCopy'=>true,'rgxp'=>'date', 'datepicker'=>$this->getDatePickerString(), 'tl_class'=>'w50 wizard'),
			'sql'					  => "varchar(255) NOT NULL default ''"
		),
		'invoice_id' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_invoice']['invoice_id'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('doNotCopy'=>true, 'tl_class'=>'w50'),
			'save_callback' => array
			(
				array('tl_iao_invoice', 'setFieldInvoiceNumber')
			),
			'sql'					  => "int(10) unsigned NOT NULL default '0'"
		),
		'invoice_id_str' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_invoice']['invoice_id_str'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('doNotCopy'=>true, 'spaceToUnderscore'=>true, 'maxlength'=>128, 'tl_class'=>'w50'),
			'save_callback' => array
			(
				array('tl_iao_invoice', 'setFieldInvoiceNumberStr')
			),
			'sql'					  => "varchar(255) NOT NULL default ''"
		),
		'invoice_pdf_file' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_invoice']['invoice_pdf_file'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'fileTree',
			'eval'                    => array('fieldType'=>'radio', 'tl_class'=>'clr','extensions'=>'pdf','files'=>true, 'filesOnly'=>true, 'mandatory'=>false),
			'sql'					  => "varchar(255) NOT NULL default ''"
		),
		'member' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_invoice']['member'],
			'filter'                  => true,
			'search'                  => true,
			'sorting'                 => true,
			'flag'                    => 11,
			'inputType'               => 'select',
			'options_callback'        => array('tl_iao_invoice', 'getMemberOptions'),
			'eval'                    => array('tl_class'=>'w50','includeBlankOption'=>true,'submitOnChange'=>true, 'chosen'=>true),
			'save_callback' => array
			(
				array('tl_iao_invoice', 'fillAdressText')
			),
			'sql'					  => "varbinary(128) NOT NULL default ''"
		),
		'address_text' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_invoice']['address_text'],
			'search'                  => true,
			'inputType'               => 'textarea',
			'eval'                    => array('rte'=>'tinyMCE','style'=>'height:60px;', 'tl_class'=>'clr'),
			'explanation'             => 'insertTags',
			'sql'					  => "mediumtext NULL"
		),
		'before_template' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_invoice']['before_template'],
			'sorting'                 => true,
			'flag'                    => 11,
			'inputType'               => 'select',
			'options_callback'        => array('tl_iao_invoice', 'getBeforeTemplate'),
			'eval'                    => array('tl_class'=>'w50','includeBlankOption'=>true,'submitOnChange'=>true, 'chosen'=>true),
			'save_callback' => array
			(
				array('tl_iao_invoice', 'fillBeforeText')
			),
			'sql'					  => "int(10) unsigned NOT NULL default '0'"
		),
		'before_text' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_invoice']['before_text'],
			'search'                  => true,
			'inputType'               => 'textarea',
			'eval'                    => array('rte'=>'tinyMCE', 'helpwizard'=>true,'style'=>'height:60px;', 'tl_class'=>'clr'),
			'explanation'             => 'insertTags',
			'sql'					  => "text NULL"
		),
		'beforetext_as_template' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_invoice']['beforetext_as_template'],
			'filter'                  => true,
			'flag'                    => 1,
			'inputType'               => 'checkbox',
			'eval'                    => array('doNotCopy'=>true),
			'sql'					  => "char(1) NOT NULL default ''",
			'save_callback' => array
			(
				array('tl_iao_invoice', 'saveBeforeTextAsTemplate')
			),
		),
		'after_template' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_invoice']['after_template'],
			'sorting'                 => true,
			'flag'                    => 11,
			'inputType'               => 'select',
			'options_callback'        => array('tl_iao_invoice', 'getAfterTemplate'),
			'eval'                    => array('tl_class'=>'w50','includeBlankOption'=>true,'submitOnChange'=>true, 'chosen'=>true),
			'save_callback' => array
			(
				array('tl_iao_invoice', 'fillAfterText')
			),
			'sql'					  => "int(10) unsigned NOT NULL default '0'"
		),
		'after_text' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_invoice']['after_text'],
			'search'                  => true,
			'inputType'               => 'textarea',
			'eval'                    => array('rte'=>'tinyMCE', 'helpwizard'=>true,'style'=>'height:60px;', 'tl_class'=>'clr'),
			'explanation'             => 'insertTags',
			'sql'					  => "text NULL"
		),
		'aftertext_as_template' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_invoice']['aftertext_as_template'],
			'filter'                  => true,
			'flag'                    => 1,
			'inputType'               => 'checkbox',
			'eval'                    => array('doNotCopy'=>true),
			'sql'					  => "char(1) NOT NULL default ''",
			'save_callback' => array
			(
				array('tl_iao_invoice', 'saveAfterTextAsTemplate')
			),

		),
		'published' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_invoice']['published'],
			'filter'                  => true,
			'flag'                    => 1,
			'inputType'               => 'checkbox',
			'eval'                    => array('doNotCopy'=>true),
			'sql'					  => "char(1) NOT NULL default ''"
		),
		'status' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_iao_invoice']['status'],
			'exclude'               => true,
			'filter'                => true,
			'flag'                  => 1,
			'inputType'             => 'select',
			'options'				=>  &$GLOBALS['TL_LANG']['tl_iao_invoice']['status_options'],
            'eval'					=> array('doNotCopy'=>true),
			'save_callback' => array
			(
				array('tl_iao_invoice', 'updateStatus')
			),
			'sql'					=> "char(1) NOT NULL default ''"
		),
		'paid_on_dates' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_invoice']['paid_on_dates'],
			'exclude'                 => true,
			'inputType'               => 'multiColumnWizard',
			'eval' => array(
				// 'style'                 => 'width:100%;',
				'doNotCopy'=>true,
				'columnFields' => array
				(
					'paydate' => array
					(
						'label'             => $GLOBALS['TL_LANG']['tl_iao_invoice']['paydate'],
						'exclude'           => true,
						'inputType'         => 'text',
						'default'			=> '',
						'eval'              => array('rgxp'=>'datim', 'datepicker'=>$this->getDatePickerString(), 'tl_class'=>'wizard','style' => 'width:65%;'),
					),
					'payamount' => array
					(
						'label'             => $GLOBALS['TL_LANG']['tl_iao_invoice']['payamount'],
						'exclude'           => true,
						'search'            => true,
						'inputType'         => 'text',
						'eval'              => array('style' => 'width:80%'),
					),
					'paynotice' => array
					(
						'label'             => $GLOBALS['TL_LANG']['tl_iao_invoice']['paynotice'],
						'exclude'           => true,
						'search'            => true,
						'inputType'         => 'text',
						// 'eval'              => array('style' => 'width:60%;'),
					)
				)
			),
			'save_callback'			=> array
			(
				array('tl_iao_invoice', 'updateRemaining')
			),
			'sql'				=> "blob NULL"
		),
		'remaining' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_invoice']['remaining'],
			'filter'				=> true,
			'inputType'               => 'text',
			'eval'                    => array('readonly'=>true,'style'=>'border:0'),
			'load_callback'			=> array
			(
				array('tl_iao_invoice', 'priceFormat')
			),
			'sql'					=> "varchar(64) NOT NULL default '0'"
		),
		'priceall_brutto' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_invoice']['price_brutto'],
			'inputType'               => 'text',
			'eval'                    => array('readonly'=>true,'style'=>'border:0'),
			'load_callback'			=> array
			(
				array('tl_iao_invoice','getPriceallValue'),
				array('tl_iao_invoice', 'priceFormat')
			)
		),
		'noVat' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_invoice']['noVat'],
			'filter'                  => true,
			'flag'                    => 1,
			'inputType'               => 'checkbox',
			'eval'                    => array('doNotCopy'=>true),
			'sql'					  => "char(1) NOT NULL default ''"
		),
		'discount' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_invoice']['discount'],
			'filter'                  => true,
			'flag'                    => 1,
			'inputType'               => 'checkbox',
			'eval'                    => array('doNotCopy'=>true,'submitOnChange'=>true),
			'sql'					  => "char(1) NOT NULL default ''"
		),
		'discount_title' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_invoice']['discount_title'],
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>255,'tl_class'=>'w50'),
			'sql'					  => "varchar(64) NOT NULL default 'Skonto'"
		),
		'discount_value' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_invoice']['discount_value'],
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>255,'tl_class'=>'w50'),
			'sql'					  => "varchar(64) NOT NULL default '3'"
		),
		'discount_operator' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_invoice']['discount_operator'],
			'filter'                  => true,
			'flag'                    => 1,
			'inputType'               => 'select',
			'options'                 => &$GLOBALS['TL_LANG']['tl_iao_invoice']['discount_operators'],
            'eval'			  		  => array('tl_class'=>'w50'),
            'sql'					  => "char(1) NOT NULL default '%'"
		),
		'notice' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_invoice']['notice'],
			'search'		  => true,
			'filter'                  => false,
			'inputType'               => 'textarea',
			'eval'                    => array('mandatory'=>false, 'cols'=>'10','rows'=>'10','style'=>'height:100px','rte'=>false),
			'sql'					  => "text NULL"

		),
		'agreement_id' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_invoice']['agreement_id'],
			'exclude'                 => false,
			'filter'                  => true,
			'search'                  => true,
			'sorting'                 => false,
			'flag'                    => 11,
			'inputType'               => 'select',
			'options_callback'        => array('tl_iao_invoice', 'getAgreements'),
			'eval'                    => array('tl_class'=>'w50','includeBlankOption'=>true, 'chosen'=>true),
			'sql'					  => "int(10) unsigned NOT NULL default '0'"
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
 * Class tl_iao_invoice
 */
class tl_iao_invoice extends \iao\iaoBackend
{

	protected $settings = array();

	/**
	 * Import the back end user object
	 */
	public function __construct()
	{
		parent::__construct();
		$this->import('BackendUser', 'User');
		$this->import('iao');
	}


	/**
	 * Check permissions to edit table tl_iao_invoice
	 */
	public function checkPermission()
	{
		$this->checkIaoModulePermission('tl_iao_invoice');
	}

	/**
	* prefill eny Fields by new dataset
	*/
	public function preFillFields($table, $id, $set, $obj)
	{

		$objProject = IaoProjectsModel::findProjectByIdOrAlias($set['pid']);
		$settingId = ($objProject !== null && $objProject->setting_id != 0) ? $objProject->setting_id : 1;
		$settings = $this->getSettings($settingId);
		$invoiceId = $this->generateInvoiceNumber(0, $settings);
		$invoiceIdStr = $this->generateInvoiceNumberStr('', $invoiceId, time(), $settings);
		$set = array
		(
			'invoice_id' => $invoiceId,
			'invoice_id_str' => $invoiceIdStr
		);

		$this->Database->prepare('UPDATE '.$table.' %s WHERE `id`=?')
						->set($set)
						->limit(1)
						->execute($id);
	}

	/**
	 * fill date-Field if this empty
	 * @param mixed
	 * @param object
	 * @return date
	 */
	public function  generateExecuteDate($varValue, DataContainer $dc)
	{
		$altdate = ($dc->activeRecord->invoice_tstamp) ? $dc->activeRecord->invoice_tstamp : time();
		return ($varValue==0) ? $altdate : $varValue;
	}

	/**
	 * fill date-Field if this empty
	 * @param mixed
	 * @param object
	 * @return date
	 */
	public function  generateExpiryDate($varValue, DataContainer $dc)
	{
		$settings = $this->getSettings($dc->activeRecord->setting_id);

		if(!$varValue)
		{
			$dur = (int) ($settings['iao_invoice_duration']) ? $settings['iao_invoice_duration'] : 14;
			$invoiceTstamp = ($dc->activeRecord->invoice_tstamp) ? $dc->activeRecord->invoice_tstamp : time();

			//auf Sonabend prüfen wenn ja dann auf Montag setzen
			if(date('N',$invoiceTstamp+($dur * 24 * 60 * 60)) == 6)  $dur = $dur+2;

			//auf Sontag prüfen wenn ja dann auf Montag setzen
			if(date('N',$invoiceTstamp+($dur * 24 * 60 * 60)) == 7)  $dur = $dur+1;

			$varValue = $invoiceTstamp+($dur * 24 * 60 * 60);

	    }
		return $varValue;

	}

	/**
	 * fill date-Field if this empty
	 * @param mixed
	 * @param object
	 * @return date
	 */
	public function  generateInvoiceTstamp($varValue, DataContainer $dc)
	{
		return ((int)$varValue == 0) ? time() : $varValue;
	}

	/**
	 * fill Adress-Text
	 * @param object
	 * @throws Exception
	 */
	public function fillAdressText($varValue, DataContainer $dc)
	{
		if(trim(strip_tags($dc->activeRecord->address_text)) == '')
		{
			if(strlen($varValue) <= 0) return $varValue;

			$objMember = \MemberModel::findById($varValue);

			$text = '<p>'.$objMember->company.'<br />'.($objMember->gender!='' ? $GLOBALS['TL_LANG']['tl_iao_invoice']['gender'][$objMember->gender].' ':'').($objMember->title ? $objMember->title.' ':'').$objMember->firstname.' '.$objMember->lastname.'<br />'.$objMember->street.'</p>';
			$text .='<p>'.$objMember->postal.' '.$objMember->city.'</p>';

			$this->Database->prepare('UPDATE `tl_iao_invoice` SET `address_text`=? WHERE `id`=?')
			->limit(1)
			->execute($text, $dc->id);
		}
		return $varValue;
	}

	/**
	 * fill Text before
	 * @param object
	 * @throws Exception
	 */
	public function fillBeforeText($varValue, DataContainer $dc)
	{

		if(strip_tags($dc->activeRecord->before_text)=='')
		{
			if(strlen($varValue)<=0) return $varValue;

			$objTemplate = $this->Database->prepare('SELECT * FROM `tl_iao_templates` WHERE `id`=?')
			->limit(1)
			->execute($varValue);

			$objTemplate->text = $this->changeIAOTags($objTemplate->text,'invoice',$dc->id);

			$text = $this->replacePlaceholder($objTemplate->text, $dc);

			$this->Database->prepare('UPDATE `tl_iao_invoice` SET `before_text`=? WHERE `id`=?')
			->limit(1)
			->execute($text, $dc->id);
		}

		return $varValue;
	}

	/**
	 * fill Text after
	 * @param object
	 * @throws Exception
	 */
	public function fillAfterText($varValue, DataContainer $dc)
	{

		if(strip_tags($dc->activeRecord->after_text)=='')
		{
		    if(strlen($varValue)<=0) return $varValue;

		    $objTemplate = $this->Database->prepare('SELECT `text` FROM `tl_iao_templates` WHERE `id`=?')
							->limit(1)
							->execute($varValue);

			$objTemplate->text = $this->changeIAOTags($objTemplate->text,'invoice',$dc->id);

			$this->Database->prepare('UPDATE `tl_iao_invoice` SET `after_text`=? WHERE `id`=?')
					->limit(1)
					->execute($objTemplate->text,$dc->id);
		}
		return $varValue;
	}

	public function saveBeforeTextAsTemplate($varValue, DataContainer $dc)
	{
		$text = strip_tags($dc->activeRecord->before_text);

		if($varValue == 1 && $text != '')
		{
			$set = array(
				'title' => \String::substr($text,50),
				'text' => $dc->activeRecord->before_text,
				'position' => 'invoice_before_text'
			);

			// Wenn vorher ein Template ausgewaehlt wurde wird es aktualisiert
			if((int) $dc->activeRecord->before_template > 0)
			{
				//pruefen ob es diesen Datensatz als Vorlage noch gibt
				$existObj = $this->Database->prepare('SELECT * FROM `tl_iao_templates` WHERE id=?')->limit(1)->execute( (int) $dc->activeRecord->before_template);

				if($existObj->numRows > 0)
				{
					$this->Database->prepare('UPDATE `tl_iao_templates` %s WHERE id=?')->set($set)->execute( (int) $dc->activeRecord->before_template);
				}
				else 
				{
					$this->Database->prepare('INSERT INTO `tl_iao_templates` %s')->set($set)->execute();
				}

			// Wenn kein Template angelegt wurde, wird ein neues angelegt
			} else {
				$this->Database->prepare('INSERT INTO `tl_iao_templates` %s')->set($set)->execute();
			}

		}
		return '';
	}

	public function saveAfterTextAsTemplate($varValue, DataContainer $dc)
	{
		$text = strip_tags($dc->activeRecord->after_text);

		if($varValue == 1 && $text != '')
		{
			$set = array(
				'title' => \String::substr($text,50),
				'text' => $dc->activeRecord->after_text,
				'position' => 'invoice_after_text'
			);

			// Wenn vorher ein Template ausgewaehlt wurde wird es aktualisiert
			if((int) $dc->activeRecord->after_template > 0)
			{
				//pruefen ob es diesen Datensatz als Vorlage noch gibt
				$existObj = $this->Database->prepare('SELECT * FROM `tl_iao_templates` WHERE id=?')->limit(1)->execute( (int) $dc->activeRecord->after_template);

				if($existObj->numRows > 0)
				{
					$this->Database->prepare('UPDATE `tl_iao_templates` %s WHERE id=?')->set($set)->execute( (int) $dc->activeRecord->after_template);
				}
				else 
				{
					$this->Database->prepare('INSERT INTO `tl_iao_templates` %s')->set($set)->execute();
				}

			// Wenn kein Template angelegt wurde, wird ein neues angelegt
			} else {
				$this->Database->prepare('INSERT INTO `tl_iao_templates` %s')->set($set)->execute();
			}
		}
		return '';
	}


	/**
	 * get all Agreements to valid groups
	 * @param object
	 * @throws Exception
	 */
	public function getAgreements(DataContainer $dc)
	{
		$varValue= array();

		$agrObj = $this->Database->prepare('SELECT * FROM `tl_iao_agreements` WHERE `status`=?')
					->execute('1');

		while($agrObj->next())
		{
			$varValue[$agrObj->id] =  $agrObj->title.' ('.$agrObj->price.' &euro;)';
		}
	    return $varValue;
	}

	/**
	 * get all invoice before template
	 * @param object
	 * @throws Exception
	 */
	public function getBeforeTemplate(DataContainer $dc)
	{
		$varValue= array();

		$all = $this->Database->prepare('SELECT `id`,`title` FROM `tl_iao_templates` WHERE `position`=?')
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
	 * @throws Exception
	 */
	public function getAfterTemplate(DataContainer $dc)
	{
		$varValue= array();

		$all = $this->Database->prepare('SELECT `id`,`title` FROM `tl_iao_templates` WHERE `position`=?')
				->execute('invoice_after_text');

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
		return ($this->User->isAdmin || count(preg_grep('/^tl_iao_invoice::/', $this->User->alexf)) > 0) ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.specialchars($title).'"'.$attributes.'>'.$this->generateImage($icon, $label).'</a> ' : '';
	}

	/**
	* wenn GET-Parameter passen dann wird eine PDF erzeugt
	*
	*/
	public function generateInvoicePDF(DataContainer $dc)
	{
		if(\Input::get('key') == 'pdf' && (int) \Input::get('id') > 0) $this->generatePDF((int) \Input::get('id'), 'invoice');
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

		// wenn kein Admin dann kein PDF-Link
		if (!$this->User->isAdmin)	return;

		// Wenn keine PDF-Vorlage dann kein PDF-Link
	    $objPdfTemplate = 	\FilesModel::findByUuid($settings['iao_invoice_pdf']);
		if(strlen($objPdfTemplate->path) < 1 || !file_exists(TL_ROOT . '/' . $objPdfTemplate->path) ) return;  // template file not found

		$href = 'contao/main.php?do=iao_invoice&amp;key=pdf&amp;id='.$row['id'];
		return '<a href="'.$href.'" title="'.specialchars($title).'">'.$this->generateImage($icon, $label).'</a> ';
	}

	/**
	* fill field invoice_id_str if it's empty
	* @param string
	* @param object
	* @return string
	*/
	public function setFieldInvoiceNumberStr($varValue, DataContainer $dc)
	{
		$settings = $this->getSettings($dc->activeRecord->setting_id);
		$tstamp = ($dc->activeRecord->date) ?: time();

		return $this->generateInvoiceNumberStr($varValue, $dc->activeRecord->invoice_id, $tstamp, $settings);
	}

	/**
	 * generate a Invoice-number-string if not set
	 * @param string
	 * @param integer
	 * @param integer
	 * @param array
	 * @return string
	 */
	public function generateInvoiceNumberStr($varValue, $invoiceId, $tstamp, $settings)
	{

		if(strlen($varValue) < 1)
		{
			$format = $settings['iao_invoice_number_format'];
			$format =  str_replace('{date}',date('Ymd',$tstamp),$format);
			$format =  str_replace('{nr}',$invoiceId, $format);
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
	public function setFieldInvoiceNumber($varValue, DataContainer $dc)
	{
		$settings = $this->getSettings($dc->activeRecord->setting_id);
		return $this->generateInvoiceNumber($varValue, $settings);
	}
	
	/**
	 * generate a invoice-number if not set
	 * @param integer
	 * @param array
	 * @return string
	 */
	public function generateInvoiceNumber($varValue, $settings)
	{
		$autoNr = false;
		$varValue = (int) $varValue;

		// Generate invoice_id if there is none
		if($varValue == 0)
		{
			$autoNr = true;
			$objNr = $this->Database->prepare("SELECT `invoice_id` FROM `tl_iao_invoice` ORDER BY `invoice_id` DESC")
									->limit(1)
									->execute();

			if($objNr->numRows < 1 || $objNr->invoice_id == 0)  $varValue = $settings['iao_invoice_startnumber'];
			else  $varValue =  $objNr->invoice_id +1;
	    }
	    else
	    {
			$objNr = $this->Database->prepare("SELECT `invoice_id` FROM `tl_iao_invoice` WHERE `id`=? OR `invoice_id`=?")
									->limit(1)
									->execute($dc->id, $varValue);

			// Check whether the InvoiceNumber exists
			if ($objNr->numRows > 1 )
			{
				if (!$autoNr)
				{
					throw new Exception(sprintf($GLOBALS['TL_LANG']['ERR']['aliasExists'], $varValue));
				}

				$varValue .= '-' . $dc->id;
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
		$settings = $this->getSettings($arrRow['setting_id']);

		$result = $this->Database->prepare("SELECT `firstname`,`lastname`,`company` FROM `tl_member`  WHERE id=?")
					->limit(1)
					->execute($arrRow['member']);
		$row = $result->fetchAssoc();

		return '
		<div class="comment_wrap">
		<div class="cte_type status' . $arrRow['status'] . '"><strong>' . $arrRow['title'] . '</strong> '.$arrRow['invoice_id_str'].'</div>
		<div>'.$GLOBALS['TL_LANG']['tl_iao_invoice']['price_brutto'][0].': <strong>'.number_format($arrRow['price_brutto'],2,',','.').' '.$settings['iao_currency_symbol'].'</strong></div>
		<div>'.$GLOBALS['TL_LANG']['tl_iao_invoice']['remaining'][0].': <strong>'.number_format($arrRow['remaining'],2,',','.').' '.$settings['iao_currency_symbol'].'</strong></div>
		<div>'.$GLOBALS['TL_LANG']['tl_iao_invoice']['member'][0].': '.$row['firstname'].' '.$row['lastname'].' ('.$row['company'].')</div>
		'.(($arrRow['notice'])?"<div>".$GLOBALS['TL_LANG']['tl_iao_invoice']['notice'][0].":".$arrRow['notice']."</div>": '').'
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

		return '<a href="'.$this->addToUrl($href).'" title="'.$GLOBALS['TL_LANG']['tl_iao_invoice']['toggle'].'"'.$attributes.'>'.$this->generateImage($icon, $label).'</a> ';
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
		if (!$this->User->isAdmin && !$this->User->hasAccess('tl_iao_invoice::status', 'alexf'))
		{
			$this->log('Not enough permissions to publish/unpublish comment ID "'.$intId.'"', 'tl_iao_invoice toggleActivity', TL_ERROR);
			$this->redirect('contao/main.php?act=error');
		}

		$this->createInitialVersion('tl_iao_invoice', $intId);

		// Trigger the save_callback
		if (is_array($GLOBALS['TL_DCA']['tl_iao_invoice']['fields']['status']['save_callback']))
		{
			foreach ($GLOBALS['TL_DCA']['tl_iao_invoice']['fields']['status']['save_callback'] as $callback)
			{
				$this->import($callback[0]);
				$blnVisible = $this->$callback[0]->$callback[1]($blnVisible, $this);
			}
		}

		// Update the database
		$this->Database->prepare("UPDATE tl_iao_invoice SET status='" . ($blnVisible==1 ? '1' : '2') . "' WHERE id=?")
					   ->execute($intId);

		$this->createNewVersion('tl_iao_invoice', $intId);
	}

	public function updateStatus($varValue, DataContainer $dc)
	{
		if($varValue == 2)
	    {
			$set = array
			(
				'status' => $varValue,
				'paid_on_date' => $dc->activeRecord->paid_on_date
			);

			$this->Database->prepare('UPDATE `tl_iao_reminder` %s WHERE `invoice_id`=?')
							->set($set)
							->execute($dc->id);
	    }
	    return $varValue;
	}

	/**
	* zur Aktualisierung der Datensätze aus älterer Modul-Versionen
	*/
	public function upgradeInvoices(DataContainer $dc)
	{
		// $allInvObj = $this->Database->prepare('SELECT * FROM `tl_iao_invoice` WHERE `remaining`=? AND `paid_on_dates`=?')
		$allInvObj = $this->Database->prepare('SELECT * FROM `tl_iao_invoice` WHERE `remaining`=? AND `paid_on_dates` IS NULL')
									->execute(0, '');

		if($allInvObj->numRows > 0)
		{

			while($allInvObj->next())
			{

				$paidArr = array();

				switch($allInvObj->status)
				{
					case '1': // noch offen
					case '3': // ruht
						$set = array (
							'remaining' => $allInvObj->price_brutto
						);

						$this->Database->prepare('UPDATE `tl_iao_invoice` %s WHERE `id`=?')
							->set($set)
							->execute($allInvObj->id);
					break;
					case '2': //bezahlt
						$paidArr[] = array (
							'paydate'=>$allInvObj->paid_on_date,
							'payamount'=> $allInvObj->price_brutto, 
							'paynotice'=>''
						);

						$set = array (
							'remaining' => 0,
							'paid_on_dates' => serialize($paidArr)
						);

						$this->Database->prepare('UPDATE `tl_iao_invoice` %s WHERE `id`=?')
							->set($set)
							->execute($allInvObj->id);
					break;
				}


				$paid_on_date = ($allInvObj->price_brutto == $already) ? $lastPayDate : $allInvObj->paid_on_date;

			}
		}
	}

	public function priceFormat($varValue, DataContainer $dc)
	{
		return $this->getPriceStr($varValue);
	}

	public function getPriceallValue($varValue, DataContainer $dc)
	{
		return $dc->activeRecord->price_brutto;
	}

	/**
	* calculate and update fields
	*/
	public function updateRemaining($varValue, DataContainer $dc)
	{
		$paidsArr = unserialize($varValue);
		$already = 0;
		$lastPayDate = '';

		if(is_array($paidsArr) && ($paidsArr[0]['payamount'] != ''))
		{
			foreach($paidsArr as $k => $a)
			{
				$already += $a['payamount'];
				$lastPayDate = $a['paydate'];
			}
		}

		$dif = $dc->activeRecord->price_brutto - $already;
		$status = ($dc->activeRecord->price_brutto == $already && $dc->activeRecord->price_brutto > 0) ? 2 : $dc->activeRecord->status;
		$paid_on_date = ($dc->activeRecord->price_brutto == $already) ? $lastPayDate : $dc->activeRecord->paid_on_date;

		$set = array
		(
			'remaining' => $dif,
			'status' => $status,
			'paid_on_date' => $paid_on_date
		);
		$this->Database->prepare('UPDATE `tl_iao_invoice` %s WHERE `id`=?')
					->set($set)
					->execute($dc->id);

		return $varValue;
	}

}
