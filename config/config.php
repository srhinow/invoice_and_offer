<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2010 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
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
 * PHP version 5
 * @copyright  sr-tag.de 2011
 * @author     Sven Rhinow 
 * @package    ClicknTalk
 * @license    LGPL 
 * @filesource
 */

/**
 * Add back end modules
 */
 
$GLOBALS['BE_MOD']['iao']['iao_offer'] = array
(
	'tables' => array('tl_iao_offer','tl_iao_offer_items'),
	'icon'   => 'system/modules/invoice_and_offer/html/icons/16-file-page.png',
	'stylesheet' => 'system/modules/invoice_and_offer/html/be.css',
	'importOffer'=> array('iao_offer', 'importOffer'),
	'exportOffer'=> array('iao_offer', 'exportOffer')	
);
$GLOBALS['BE_MOD']['iao']['iao_invoice'] = array
(
	'tables' => array('tl_iao_invoice','tl_iao_invoice_items'),
	'icon'   => 'system/modules/invoice_and_offer/html/icons/kontact_todo.png',
	'stylesheet' => 'system/modules/invoice_and_offer/html/be.css',
	'importInvoices'=> array('iao_invoice', 'importInvoices'),
	'exportInvoices'=> array('iao_invoice', 'exportInvoices')
);
$GLOBALS['BE_MOD']['iao']['iao_credit'] = array
(
	'tables' => array('tl_iao_credit','tl_iao_credit_items'),
	'icon'   => 'system/modules/invoice_and_offer/html/icons/16-tag-pencil.png',
	'stylesheet' => 'system/modules/invoice_and_offer/html/be.css'	
);
$GLOBALS['BE_MOD']['iao']['iao_reminder'] = array
(
	'tables' => array('tl_iao_reminder'),
// 	'callback' => 'ModuleArrears',
	'icon'   => 'system/modules/invoice_and_offer/html/icons/warning.png',
	'stylesheet' => 'system/modules/invoice_and_offer/html/be.css',
	'checkReminder'=> array('iao_reminder', 'checkReminder'),
);
$GLOBALS['BE_MOD']['iao']['iao_templates'] = array
(
	'tables' => array('tl_iao_templates'),
	'icon'   => 'system/modules/invoice_and_offer/html/icons/text_templates_16.png'
);
$GLOBALS['BE_MOD']['iao']['iao_posten_templates'] = array
(
	'tables' => array('tl_iao_posten_templates'),
	'icon'   => 'system/modules/invoice_and_offer/html/icons/posten_templates_16.png'
);
$GLOBALS['BE_MOD']['iao']['iao_customer'] = array
(
	'tables' => array('tl_member'),
	'callback' => 'ModuleCustomerMember',
	'icon'   => 'system/modules/invoice_and_offer/html/icons/users.png'
);
$GLOBALS['BE_MOD']['iao']['iao_settings'] = array
(
	'tables' => array('tl_iao_settings'),
	'icon'   => 'system/modules/invoice_and_offer/html/icons/process.png'
);

/**
 * Front end modules
 */
 
$GLOBALS['FE_MOD']['campain_layer'] = array('campain_layer' => 'ModuleCampainLayer');

/**
 * HOOKS
 */
// $GLOBALS['TL_HOOKS']['replaceInsertTags'][] = array('mpMembers', 'changeIAOTags');

?>