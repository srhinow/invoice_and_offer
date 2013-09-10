<?php

/**
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * @copyright  Sven Rhinow 2011-2013
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
		'dataContainer'               => 'File',
		'enableVersioning'            => true
	),

	// Palettes
	'palettes' => array
	(
		'default' => '{currency_legend:hide},iao_currency,iao_currency_symbol;{pdf_legend},iao_pdf_margins,iao_pdf_css;{standards_legend:hide},iao_tax,iao_costumer_group,iao_mailarticle;{offer_legend:hide},iao_offer_mail_from,iao_offer_startnumber,iao_offer_number_format,iao_offer_expiry_date,iao_offer_pdf;{invoice_legend:hide},iao_invoice_mail_from,iao_invoice_startnumber,iao_invoice_number_format,iao_invoice_duration,iao_invoice_pdf;{credit_legend:hide},iao_credit_mail_from,iao_credit_startnumber,iao_credit_number_format,iao_credit_expiry_date,iao_credit_pdf;{reminder_legend},iao_reminder_1_duration,iao_reminder_1_tax,iao_reminder_1_postage,iao_reminder_1_text,iao_reminder_1_pdf,iao_reminder_2_duration,iao_reminder_2_tax,iao_reminder_2_postage,iao_reminder_2_text,iao_reminder_2_pdf,iao_reminder_3_duration,iao_reminder_3_tax,iao_reminder_3_postage,iao_reminder_3_text,iao_reminder_3_pdf,iao_reminder_4_duration,iao_reminder_4_tax,iao_reminder_4_postage,iao_reminder_4_text,iao_reminder_4_pdf;{secure_legend:hide},iao_ssl'
	),

	// Subpalettes
	'subpalettes' => array
	(

	),

	// Fields
	'fields' => array
	(

		'iao_tax' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_tax'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true)
		),
		'iao_costumer_group' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_costumer_group'],
			'exclude'                 => true,
			'filter'                  => true,
			'sorting'                 => true,
			'inputType'               => 'radio',
			'foreignKey'              => 'tl_member_group.name',
			'eval'                    => array('mandatory'=>false, 'multiple'=>true)
		),
		'iao_currency' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_currency'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true)
		),
		'iao_currency_symbol' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_currencysymbol'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true)
		),
		'iao_pdf_margins' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_pdf_margins'],
			'exclude'                 => true,
			'inputType'               => 'trbl',
			'options'                 => array('mm', 'cm'),
			'eval'                    => array('includeBlankOption'=>true, 'tl_class'=>'clr')
		),
		'iao_pdf_css' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_pdf_css'],
			'exclude'                 => true,
			'inputType'               => 'fileTree',
			'eval'                    => array('fieldType'=>'radio', 'files'=>true, 'filesOnly'=>true, 'mandatory'=>false,'extensions'=>'css')
		),
		'iao_invoice_mail_from' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_invoice_mail_from'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'rgxp'=>'email' )
		),
		'iao_invoice_startnumber' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_invoice_startnumber'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true,'rgxp'=>'digit')
		),
		'iao_invoice_number_format' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_invoice_number_format'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array()
		),
		'iao_invoice_pdf' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_invoice_pdf'],
			'exclude'                 => true,
			'inputType'               => 'fileTree',
			'eval'                    => array('fieldType'=>'radio', 'files'=>true, 'filesOnly'=>true, 'mandatory'=>false,'extensions'=>'pdf')
		),
		'iao_invoice_duration' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_invoice_duration'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'default'		  => 14,
			'eval'                    => array('rgxp'=>'digit'),

		),
		'iao_offer_mail_from' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_offer_mail_from'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'rgxp'=>'email' )
		),
		'iao_offer_startnumber' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_offer_startnumber'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true,'rgxp'=>'digit')
		),
		'iao_offer_number_format' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_offer_number_format'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array()
		),
		'iao_offer_pdf' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_offer_pdf'],
			'exclude'                 => true,
			'inputType'               => 'fileTree',
			'eval'                    => array('fieldType'=>'radio', 'files'=>true, 'filesOnly'=>true, 'mandatory'=>false,'extensions'=>'pdf')
		),
		'iao_offer_expiry_date' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_offer_expiry_date'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array()
		),
		'iao_credit_mail_from' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_credit_mail_from'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'rgxp'=>'email' )
		),
		'iao_credit_startnumber' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_credit_startnumber'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true,'rgxp'=>'digit')
		),
		'iao_credit_number_format' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_credit_number_format'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array()
		),
		'iao_credit_pdf' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_credit_pdf'],
			'exclude'                 => true,
			'inputType'               => 'fileTree',
			'eval'                    => array('fieldType'=>'radio', 'files'=>true, 'filesOnly'=>true, 'mandatory'=>false,'extensions'=>'pdf')
		),
		'iao_credit_expiry_date' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_credit_expiry_date'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array()
		),
		'iao_ssl' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_ssl'],
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('submitOnChange'=>false)
		),
		'iao_reminder_1_duration' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_reminder_1_duration'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array()
		),
		'iao_reminder_1_tax' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_reminder_tax'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>2, 'tl_class'=>'w50')
		),
		'iao_reminder_1_postage' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_reminder_postage'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>25, 'tl_class'=>'w50')
		),
		'iao_reminder_1_text' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_reminder_1_text'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'textarea',
			'eval'                    => array('rte'=>'tinyMCE','style'=>'height:60px;', 'tl_class'=>'clr'),
			'explanation'             => 'insertTags'
		),
		'iao_reminder_1_pdf' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_reminder_1_pdf'],
			'exclude'                 => true,
			'inputType'               => 'fileTree',
			'eval'                    => array('fieldType'=>'radio', 'files'=>true, 'filesOnly'=>true, 'mandatory'=>false,'extensions'=>'pdf')
		),
		'iao_reminder_2_duration' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_reminder_2_duration'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'default'		  => 7,
			'eval'                    => array('rgxp'=>'digit')
		),
		'iao_reminder_2_tax' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_reminder_tax'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>2, 'tl_class'=>'w50')
		),
		'iao_reminder_2_postage' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_reminder_postage'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>25, 'tl_class'=>'w50')
		),
		'iao_reminder_2_text' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_reminder_2_text'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'textarea',
			'eval'                    => array('rte'=>'tinyMCE','style'=>'height:60px;', 'tl_class'=>'clr'),
			'explanation'             => 'insertTags'
		),
		'iao_reminder_2_pdf' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_reminder_1_pdf'],
			'exclude'                 => true,
			'inputType'               => 'fileTree',
			'eval'                    => array('fieldType'=>'radio', 'files'=>true, 'filesOnly'=>true, 'mandatory'=>false,'extensions'=>'pdf')
		),
		'iao_reminder_3_duration' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_reminder_3_duration'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'default'		  => 7,
			'eval'                    => array('rgxp'=>'digit')
		),
		'iao_reminder_3_tax' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_reminder_tax'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>2, 'tl_class'=>'w50')
		),
		'iao_reminder_3_postage' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_reminder_postage'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>25, 'tl_class'=>'w50')
		),
		'iao_reminder_3_text' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_reminder_3_text'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'textarea',
			'eval'                    => array('rte'=>'tinyMCE','style'=>'height:60px;', 'tl_class'=>'clr'),
			'explanation'             => 'insertTags'
		),
		'iao_reminder_3_pdf' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_reminder_3_pdf'],
			'exclude'                 => true,
			'inputType'               => 'fileTree',
			'eval'                    => array('fieldType'=>'radio', 'files'=>true, 'filesOnly'=>true, 'mandatory'=>false,'extensions'=>'pdf')
		),
		'iao_reminder_4_duration' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_reminder_4_duration'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'default'		  => 7,
			'eval'                    => array('rgxp'=>'digit')
		),
		'iao_reminder_4_tax' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_reminder_tax'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>2, 'tl_class'=>'w50')
		),
		'iao_reminder_4_postage' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_reminder_postage'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>25, 'tl_class'=>'w50')
		),
		'iao_reminder_4_text' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_reminder_4_text'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'textarea',
			'eval'                    => array('rte'=>'tinyMCE','style'=>'height:60px;', 'tl_class'=>'clr'),
			'explanation'             => 'insertTags'
		),
		'iao_reminder_4_pdf' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_settings']['iao_reminder_4_pdf'],
			'exclude'                 => true,
			'inputType'               => 'fileTree',
			'eval'                    => array('fieldType'=>'radio', 'files'=>true, 'filesOnly'=>true, 'mandatory'=>false,'extensions'=>'pdf')
		),
	)
);


/**
 * Class tl_iao_settings
 */
class tl_iao_settings extends Backend
{
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
