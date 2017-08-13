<?php

/**
 * @copyright  Sven Rhinow 2011-2017
 * @author     sr-tag Sven Rhinow Webentwicklung <http://www.sr-tag.de>
 * @package    invoice_and_offer
 * @license    LGPL
 * @filesource
 */

/**
 * Table tl_iao_settings
 */
$GLOBALS['TL_DCA']['tl_iao_settings'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'enableVersioning'            => true,
		'onload_callback'		=> array
		(
			array('tl_iao_settings', 'checkPermission'),
		),
		'sql' => array
		(
			'keys' => array
			(
				'id' => 'primary'
			)
		)
	),
	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 1,
			'fields'                  => array('name'),
			'flag'					  => 1,
			'panelLayout'             => 'filter;search,limit'
		),
		'label' => array
		(
			'fields'                  => array('name', 'fallback'),
			'format'                  => '%s <span style="color:#b3b3b3; padding-left:3px;">[%s]</span>',
			// 'label_callback'		  => array('tl_iso_config', 'addIcon')
		),
		'global_operations' => array
		(
			'back' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['MSC']['backBT'],
				'href'                => 'mod=&table=',
				'class'               => 'header_back',
				'attributes'          => 'onclick="Backend.getScrollOffset();"',
			),
			'all' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'                => 'act=select',
				'class'               => 'header_edit_all',
				'attributes'          => 'onclick="Backend.getScrollOffset();"',
			)
		),
		'operations' => array
		(
			'edit' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_settings']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif',
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_settings']['copy'],
				'href'                => 'act=copy',
				'icon'                => 'copy.gif',
				// 'button_callback'     => array('tl_iso_config', 'copyConfig'),
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_settings']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"',
				// 'button_callback'     => array('tl_iso_config', 'deleteConfig'),
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_settings']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif',
			)
		)
	),
	// Palettes
	'palettes' => array
	(
		'default' => '
		{name_legend},name,fallback;
		{member_legend},iao_tax,iao_costumer_group,iao_mailarticle;
		{currency_legend:hide},iao_currency,iao_currency_symbol;
		{pdf_legend},iao_pdf_margins,iao_pdf_css;

		{offer_legend:hide},iao_offer_mail_from,iao_offer_startnumber,iao_offer_number_format,iao_offer_expiry_date,iao_offer_pdf;
		{invoice_legend:hide},iao_invoice_mail_from,iao_invoice_startnumber,iao_invoice_number_format,iao_invoice_duration,iao_invoice_pdf;
		{credit_legend:hide},iao_credit_mail_from,iao_credit_startnumber,iao_credit_number_format,iao_credit_expiry_date,iao_credit_pdf;

		{agreements_legend:hide},iao_agreements_remind_before,iao_agreements_mail_from,iao_agreements_mail_to,iao_agreements_mail_subject,iao_agreements_mail_text;
		
		{reminder_legend},iao_reminder_1_duration,iao_reminder_1_tax,iao_reminder_1_postage,iao_reminder_1_text,iao_reminder_1_pdf,iao_reminder_2_duration,iao_reminder_2_tax,iao_reminder_2_postage,iao_reminder_2_text,iao_reminder_2_pdf,iao_reminder_3_duration,iao_reminder_3_tax,iao_reminder_3_postage,iao_reminder_3_text,iao_reminder_3_pdf,iao_reminder_4_duration,iao_reminder_4_tax,iao_reminder_4_postage,iao_reminder_4_text,iao_reminder_4_pdf
		'
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
		'tstamp' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'name' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['name'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'unique'=>true, 'maxlength'=>255, 'tl_class'=>'w50'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'fallback' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['fallback'],
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'checkbox',
			'eval'					  => array('doNotCopy'=>true, 'fallback'=>true, 'tl_class'=>'w50 m12'),
			'sql'                     => "char(1) NOT NULL default ''"
		),
		'iao_costumer_group' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_costumer_group'],
			'exclude'                 => true,
			'filter'                  => true,
			'sorting'                 => true,
			'inputType'               => 'radio',
			'foreignKey'              => 'tl_member_group.name',
			'eval'                    => array('mandatory'=>false, 'multiple'=>true),
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'iao_currency' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_currency'],
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true,'tl_class'=>'w50'),
			'sql'                     => "varchar(10) NOT NULL default ''"
		),
		'iao_currency_symbol' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_currencysymbol'],
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true,'tl_class'=>'w50'),
			'sql'                     => "varchar(10) NOT NULL default ''"
		),
		'iao_pdf_margins' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_pdf_margins'],
			'exclude'                 => true,
			'inputType'               => 'trbl',
			'options'                 => array('mm', 'cm'),
			'eval'                    => array('includeBlankOption'=>true, 'tl_class'=>'clr'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'iao_pdf_css' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_pdf_css'],
			'exclude'                 => true,
			'inputType'               => 'fileTree',
			'eval'                    => array('fieldType'=>'radio', 'files'=>true, 'filesOnly'=>true, 'mandatory'=>false,'extensions'=>'css'),
			'sql'                     => "binary(16) NULL"
		),
		'iao_invoice_mail_from' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_invoice_mail_from'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'rgxp'=>'email' ),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'iao_invoice_startnumber' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_invoice_startnumber'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true,'rgxp'=>'digit'),
			'sql'                     => "varchar(55) NOT NULL default ''"
		),
		'iao_invoice_number_format' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_invoice_number_format'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array(),
			'sql'                     => "varchar(55) NOT NULL default ''"
		),
		'iao_invoice_pdf' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_invoice_pdf'],
			'exclude'                 => true,
			'inputType'               => 'fileTree',
			'eval'                    => array('fieldType'=>'radio', 'files'=>true, 'filesOnly'=>true, 'mandatory'=>false,'extensions'=>'pdf'),
			'sql'                     => "binary(16) NULL"
		),
		'iao_invoice_duration' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_invoice_duration'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'default'		  => 14,
			'eval'                    => array('rgxp'=>'digit'),
			'sql'                     => "int(10) unsigned NOT NULL default '0'"

		),
		'iao_offer_mail_from' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_offer_mail_from'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'rgxp'=>'email' ),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'iao_offer_startnumber' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_offer_startnumber'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true,'rgxp'=>'digit'),
			'sql'                     => "varchar(55) NOT NULL default ''"
		),
		'iao_offer_number_format' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_offer_number_format'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array(),
			'sql'                     => "varchar(55) NOT NULL default ''"
		),
		'iao_offer_pdf' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_offer_pdf'],
			'exclude'                 => true,
			'inputType'               => 'fileTree',
			'eval'                    => array('fieldType'=>'radio', 'files'=>true, 'filesOnly'=>true, 'mandatory'=>false,'extensions'=>'pdf'),
			'sql'                     => "binary(16) NULL"
		),
		'iao_offer_expiry_date' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_offer_expiry_date'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array(),
			'sql'                     => "varchar(55) NOT NULL default ''"
		),
		'iao_credit_mail_from' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_credit_mail_from'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'rgxp'=>'email' ),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'iao_credit_startnumber' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_credit_startnumber'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true,'rgxp'=>'digit'),
			'sql'                     => "varchar(55) NOT NULL default ''"
		),
		'iao_credit_number_format' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_credit_number_format'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array(),
			'sql'                     => "varchar(55) NOT NULL default ''"
		),
		'iao_credit_pdf' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_credit_pdf'],
			'exclude'                 => true,
			'inputType'               => 'fileTree',
			'eval'                    => array('fieldType'=>'radio', 'files'=>true, 'filesOnly'=>true, 'mandatory'=>false,'extensions'=>'pdf'),
			'sql'                     => "binary(16) NULL"
		),
		'iao_credit_expiry_date' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_credit_expiry_date'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array(),
			'sql'                     => "varchar(55) NOT NULL default ''"
		),
		'iao_reminder_1_duration' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_reminder_1_duration'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array(),
			'sql'                     => "varchar(55) NOT NULL default ''"
		),
		'iao_reminder_1_tax' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_reminder_tax'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>2, 'tl_class'=>'w50'),
			'sql'                     => "varchar(55) NOT NULL default ''"
		),
		'iao_reminder_1_postage' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_reminder_postage'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>25, 'tl_class'=>'w50'),
			'sql'                     => "varchar(55) NOT NULL default ''"
		),
		'iao_reminder_1_text' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_reminder_1_text'],
			'exclude'                 => true,
			'inputType'               => 'textarea',
			'eval'                    => array('rte'=>'tinyMCE','style'=>'height:60px;', 'tl_class'=>'clr'),
			'explanation'             => 'insertTags',
			'sql'                     => "text NULL"
		),
		'iao_reminder_1_pdf' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_reminder_1_pdf'],
			'exclude'                 => true,
			'inputType'               => 'fileTree',
			'eval'                    => array('fieldType'=>'radio', 'files'=>true, 'filesOnly'=>true, 'mandatory'=>false,'extensions'=>'pdf'),
			'sql'                     => "binary(16) NULL"
		),
		'iao_reminder_2_duration' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_reminder_2_duration'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'default'		  => 7,
			'eval'                    => array('rgxp'=>'digit'),
			'sql'                     => "varchar(55) NOT NULL default ''"
		),
		'iao_reminder_2_tax' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_reminder_tax'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>2, 'tl_class'=>'w50'),
			'sql'                     => "varchar(55) NOT NULL default ''"
		),
		'iao_reminder_2_postage' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_reminder_postage'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>25, 'tl_class'=>'w50'),
			'sql'                     => "varchar(55) NOT NULL default ''"
		),
		'iao_reminder_2_text' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_reminder_2_text'],
			'exclude'                 => true,
			'inputType'               => 'textarea',
			'eval'                    => array('rte'=>'tinyMCE','style'=>'height:60px;', 'tl_class'=>'clr'),
			'explanation'             => 'insertTags',
			'sql'                     => "text NULL"
		),
		'iao_reminder_2_pdf' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_reminder_1_pdf'],
			'exclude'                 => true,
			'inputType'               => 'fileTree',
			'eval'                    => array('fieldType'=>'radio', 'files'=>true, 'filesOnly'=>true, 'mandatory'=>false,'extensions'=>'pdf'),
			'sql'                     => "binary(16) NULL"
		),
		'iao_reminder_3_duration' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_reminder_3_duration'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'default'		  => 7,
			'eval'                    => array('rgxp'=>'digit'),
			'sql'                     => "varchar(55) NOT NULL default ''"
		),
		'iao_reminder_3_tax' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_reminder_tax'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>2, 'tl_class'=>'w50'),
			'sql'                     => "varchar(55) NOT NULL default ''"
		),
		'iao_reminder_3_postage' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_reminder_postage'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>25, 'tl_class'=>'w50'),
			'sql'                     => "varchar(55) NOT NULL default ''"
		),
		'iao_reminder_3_text' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_reminder_3_text'],
			'exclude'                 => true,
			'inputType'               => 'textarea',
			'eval'                    => array('rte'=>'tinyMCE','style'=>'height:60px;', 'tl_class'=>'clr'),
			'explanation'             => 'insertTags',
			'sql'                     => "text NULL"
		),
		'iao_reminder_3_pdf' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_reminder_3_pdf'],
			'exclude'                 => true,
			'inputType'               => 'fileTree',
			'eval'                    => array('fieldType'=>'radio', 'files'=>true, 'filesOnly'=>true, 'mandatory'=>false,'extensions'=>'pdf'),
			'sql'                     => "binary(16) NULL"
		),
		'iao_reminder_4_duration' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_reminder_4_duration'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'default'		  => 7,
			'eval'                    => array('rgxp'=>'digit'),
			'sql'                     => "varchar(55) NOT NULL default ''"
		),
		'iao_reminder_4_tax' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_reminder_tax'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>2, 'tl_class'=>'w50'),
			'sql'                     => "varchar(55) NOT NULL default ''"
		),
		'iao_reminder_4_postage' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_reminder_postage'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>25, 'tl_class'=>'w50'),
			'sql'                     => "varchar(55) NOT NULL default ''"
		),
		'iao_reminder_4_text' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_reminder_4_text'],
			'exclude'                 => true,
			'inputType'               => 'textarea',
			'eval'                    => array('rte'=>'tinyMCE','style'=>'height:60px;', 'tl_class'=>'clr'),
			'explanation'             => 'insertTags',
			'sql'                     => "text NULL"
		),
		'iao_reminder_4_pdf' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_reminder_4_pdf'],
			'exclude'                 => true,
			'inputType'               => 'fileTree',
			'eval'                    => array('fieldType'=>'radio', 'files'=>true, 'filesOnly'=>true, 'mandatory'=>false,'extensions'=>'pdf'),
			'sql'                     => "binary(16) NULL"
		),
		'iao_agreements_remind_before' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_agreements_remind_before'],
			'exclude'                 => true,
			'default'		  		  => &$GLOBALS['TL_LANG']['tl_iao_settings']['remind_before_default'],
			'inputType'               => 'text',
			'sql'                     => "varchar(32) NOT NULL default ''"
		),
		'iao_agreements_mail_from' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_agreements_mail_from'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'rgxp'=>'email' ),
			'sql'                     => "varchar(32) NOT NULL default ''"
		),
		'iao_agreements_mail_to' => array
	    (
		    'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_agreements_mail_to'],
		    'exclude'                 => true,
		    'flag'                    => 11,
		    'inputType'               => 'text',
		    'eval'                    => array('mandatory'=>true, 'decodeEntities'=>true, 'maxlength'=>128, 'tl_class'=>'w50'),
		    'sql'                     => "varchar(32) NOT NULL default ''"
	    ),
	    'iao_agreements_mail_subject' => array
	    (
		    'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_agreements_mail_subject'],
		    'exclude'                 => true,
		    'flag'                    => 11,
		    'inputType'               => 'text',
		    'default'		  		=> &$GLOBALS['TL_LANG']['tl_iao_settings']['email_subject_default'],
		    'eval'                    => array('mandatory'=>false, 'maxlength'=>255, 'tl_class'=>'clr long'),
		    'sql'                     => "varchar(255) NOT NULL default ''"
	    ),
	    'iao_agreements_mail_text' => array
	    (
		    'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_agreements_mail_text'],
		    'exclude'                 => true,
		    'inputType'               => 'textarea',
		    'default'		  		=> &$GLOBALS['TL_LANG']['tl_iao_settings']['email_text_default'],
		    'eval'                    => array('mandatory'=>true, 'decodeEntities'=>true),
		     'sql'                     => "text NULL"
	    ),
	)
);


/**
 * Class tl_iao_settings
 */
class tl_iao_settings extends \iao\iaoBackend
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
	 * Check permissions to edit table tl_iao_settings
	 */
	public function checkPermission()
	{
		$this->checkIaoSettingsPermission('tl_iao_settings');
	}


	/**
	 * Return the link picker wizard
	 * @param object
	 * @return string
	 */
	public function pagePicker(DataContainer $dc)
	{
		$strField = 'ctrl_' . $dc->field . (($this->Input->get('act') == 'editAll') ? '_' . $dc->id : '');
		return ' ' . $this->generateImage('pickpage.gif', $GLOBALS['TL_LANG']['MSC']['pagepicker'], 'style="vertical-align:top; cursor:pointer;" onclick="Backend.pickPage(\'' . $strField . '\')"');
	}
}
