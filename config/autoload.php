<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2014 Leo Feyer
 *
 * @package Invoice_and_offer
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	'iao_invoice'            => 'system/modules/invoice_and_offer/iao_invoice.php',
	'iaoCrons'               => 'system/modules/invoice_and_offer/iaoCrons.php',
	// Html
	'import_phprechnung'     => 'system/modules/invoice_and_offer/html/libs_import/import_phprechnung.php',
	'import_invoiceandoffer' => 'system/modules/invoice_and_offer/html/libs_import/import_invoiceandoffer.php',
	'iao_reminder'           => 'system/modules/invoice_and_offer/iao_reminder.php',
	'ModuleCustomerMember'   => 'system/modules/invoice_and_offer/ModuleCustomerMember.php',
	'iaoPDF'                 => 'system/modules/invoice_and_offer/iaoPDF.php',
	'ModuleMemberInvoices'   => 'system/modules/invoice_and_offer/ModuleMemberInvoices.php',
	'ModuleIAOSetup'         => 'system/modules/invoice_and_offer/ModuleIAOSetup.php',
	'iao_offer'              => 'system/modules/invoice_and_offer/iao_offer.php',
	'iao'                    => 'system/modules/invoice_and_offer/iao.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'iao_invoice_list' => 'system/modules/invoice_and_offer/templates',
	'be_iao_setup'     => 'system/modules/invoice_and_offer/templates',
));
