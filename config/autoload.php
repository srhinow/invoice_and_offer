<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2015 Leo Feyer
 *
 * @license LGPL-3.0+
 */


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Classes
	'iaoCrons'               => 'system/modules/invoice_and_offer/classes/iaoCrons.php',
	'iaoPDF'                 => 'system/modules/invoice_and_offer/classes/iaoPDF.php',
	'iao'                    => 'system/modules/invoice_and_offer/classes/iao.php',

	// Html
	'import_phprechnung'     => 'system/modules/invoice_and_offer/html/libs_import/import_phprechnung.php',
	'import_invoiceandoffer' => 'system/modules/invoice_and_offer/html/libs_import/import_invoiceandoffer.php',

	// Modules
	'ModuleCustomerMember'   => 'system/modules/invoice_and_offer/modules/ModuleCustomerMember.php',
	'ModuleMemberInvoices'   => 'system/modules/invoice_and_offer/modules/ModuleMemberInvoices.php',
	'ModuleIAOSetup'         => 'system/modules/invoice_and_offer/modules/ModuleIAOSetup.php',

	// Export_import
	'iao_invoice'            => 'system/modules/invoice_and_offer/export_import/iao_invoice.php',
	'iao_reminder'           => 'system/modules/invoice_and_offer/export_import/iao_reminder.php',
	'iao_offer'              => 'system/modules/invoice_and_offer/export_import/iao_offer.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'iao_invoice_list' => 'system/modules/invoice_and_offer/templates',
	'be_iao_setup'     => 'system/modules/invoice_and_offer/templates',
));
