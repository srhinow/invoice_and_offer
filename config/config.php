<?php

/**
 * PHP version 5
 * @copyright  Sven Rhinow 2014
 * @author     sr-tag Sven Rhinow Webentwicklung <http://www.sr-tag.de>
 * @package    invoice_and_offer
 * @license    LGPL
 * @filesource
 */

/**
 * invoice_and_offer Version
 */
@define('IAO_VERSION', '1.1');
@define('IAO_BUILD', '3');
@define('IAO_PATH', '/system/modules/invoice_and_offer');
/**
 * back-end modules
 */

$GLOBALS['BE_MOD']['iao'] = array
(
	'iao_offer' => array
	(
		'tables' => array('tl_iao_offer','tl_iao_offer_items'),
		'icon'   => 'system/modules/invoice_and_offer/html/icons/16-file-page.png',
		'stylesheet' => 'system/modules/invoice_and_offer/html/be.css',
		'importOffer'=> array('iao_offer', 'importOffer'),
		'exportOffer'=> array('iao_offer', 'exportOffer')
	),
	'iao_invoice' => array
	(
		'tables' => array('tl_iao_invoice','tl_iao_invoice_items'),
		'icon'   => 'system/modules/invoice_and_offer/html/icons/kontact_todo.png',
		'stylesheet' => 'system/modules/invoice_and_offer/html/be.css',
		'importInvoices'=> array('iao_invoice', 'importInvoices'),
		'exportInvoices'=> array('iao_invoice', 'exportInvoices')
	),
	'iao_credit' => array
	(
		'tables' => array('tl_iao_credit','tl_iao_credit_items'),
		'icon'   => 'system/modules/invoice_and_offer/html/icons/16-tag-pencil.png',
		'stylesheet' => 'system/modules/invoice_and_offer/html/be.css'
	),
	'iao_reminder' => array
	(
		'tables' => array('tl_iao_reminder'),
		'icon'   => 'system/modules/invoice_and_offer/html/icons/warning.png',
		'stylesheet' => 'system/modules/invoice_and_offer/html/be.css',
		'checkReminder'=> array('iao_reminder', 'checkReminder'),
	),
	'iao_agreements' => array
	(
		'tables' => array('tl_iao_agreements'),
		'icon'   => 'system/modules/invoice_and_offer/html/icons/clock_history_frame.png',
		'stylesheet' => 'system/modules/invoice_and_offer/html/be.css',
	),
	'iao_customer' => array
	(
		'tables'	=> array('tl_member'),
		'callback'	=> 'ModuleCustomerMember',
		'icon'		=> 'system/modules/invoice_and_offer/html/icons/users.png'
	),
	'iao_setup' => array
	(
		'callback'	=> 'ModuleIAOSetup',
		'tables'	=> array(),
		'icon'		=> 'system/modules/invoice_and_offer/html/icons/process.png',
	)
);

$GLOBALS['IAO']['default_agreement_cycle'] = '+1 year';

/**
 * Setup Modules
 */
$GLOBALS['IAO_MOD'] = array
(
	'config' => array
	(
		'iao_settings' => array
		(
			'tables'					=> array('tl_iao_settings'),
			'icon'						=> 'system/modules/invoice_and_offer/html/icons/construction.png',
		),
		'iao_tax_rates' => array
		(
			'tables'					=> array('tl_iao_tax_rates'),
			'icon'						=> 'system/modules/invoice_and_offer/html/icons/calculator.png',
		),
		'iao_item_units' => array
		(
			'tables'					=> array('tl_iao_item_units'),
			'icon'						=> 'system/modules/invoice_and_offer/html/icons/category.png',
		),
	),
	'templates' => array
	(
		'iao_templates' => array
		(
			'tables' => array('tl_iao_templates'),
			'icon'   => 'system/modules/invoice_and_offer/html/icons/text_templates_16.png'
		),
		'iao_templates_items' => array
		(
			'tables' => array('tl_iao_templates_items'),
			'icon'   => 'system/modules/invoice_and_offer/html/icons/templates_items_16.png'
		)
	)
);

// Enable tables in iao_setup
if ($_GET['do'] == 'iao_setup')
{
	foreach ($GLOBALS['IAO_MOD'] as $strGroup=>$arrModules)
	{
		foreach ($arrModules as $strModule => $arrConfig)
		{
			if (is_array($arrConfig['tables']))
			{

				$GLOBALS['BE_MOD']['iao']['iao_setup']['tables'] = array_merge($GLOBALS['BE_MOD']['iao']['iao_setup']['tables'], $arrConfig['tables']);

			}
		}
	}
}

/**
 * Frontend modules
 */
$GLOBALS['FE_MOD']['iao_fe'] = array
(
	'fe_iao_invoice' => 'ModuleMemberInvoices',
	'fe_iao_offer' => 'ModuleMemberOffer',
	'fe_iao_credit' => 'ModuleMemberCredit',
	'fe_iao_reminder' => 'ModuleMemberReminder',
	'fe_iao_agreements' => 'ModuleMemberAgreements'
);

/**
 * HOOKS
 */
// $GLOBALS['TL_HOOKS']['replaceInsertTags'][] = array('mpMembers', 'changeIAOTags');

/**
 * Cron jobs
 */
$GLOBALS['TL_CRON']['daily'][] = array('iaoCrons', 'sendAgreementRemindEmail');

/**
 * Permissions are access settings for user and groups (fields in tl_user and tl_user_group)
 */
$GLOBALS['TL_PERMISSIONS'][] = 'iao_modules';
