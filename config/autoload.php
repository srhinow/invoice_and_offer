<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2017 Leo Feyer
 *
 * @license LGPL-3.0+
 */


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'iao',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Classes
	'iaoCrons'                   => 'system/modules/invoice_and_offer/classes/iaoCrons.php',
	'iao\iaoPDF'                 => 'system/modules/invoice_and_offer/classes/iaoPDF.php',
	'iao\iaoBackend'             => 'system/modules/invoice_and_offer/classes/iaoBackend.php',
	'iao'                        => 'system/modules/invoice_and_offer/classes/iao.php',

	// Html
	'import_phprechnung'         => 'system/modules/invoice_and_offer/html/libs_import/import_phprechnung.php',
	'import_invoiceandoffer'     => 'system/modules/invoice_and_offer/html/libs_import/import_invoiceandoffer.php',

	// Models
	'iaoProjectsModel'           => 'system/modules/invoice_and_offer/models/iaoProjectsModel.php',

	// Modules
	'ModuleCustomerMember'       => 'system/modules/invoice_and_offer/modules/be/ModuleCustomerMember.php',
	'ModuleIAOSetup'             => 'system/modules/invoice_and_offer/modules/be/ModuleIAOSetup.php',
	'ModulePublicProjectDetails' => 'system/modules/invoice_and_offer/modules/fe/ModulePublicProjectDetails.php',
	'ModulePublicProjectList'    => 'system/modules/invoice_and_offer/modules/fe/ModulePublicProjectList.php',
	'ModuleMemberInvoices'       => 'system/modules/invoice_and_offer/modules/fe/ModuleMemberInvoices.php',

	// Export_import
	'iao_invoice'                => 'system/modules/invoice_and_offer/export_import/iao_invoice.php',
	'iao_reminder'               => 'system/modules/invoice_and_offer/export_import/iao_reminder.php',
	'iao_offer'                  => 'system/modules/invoice_and_offer/export_import/iao_offer.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'iao_public_project_details' => 'system/modules/invoice_and_offer/templates',
	'iao_invoice_list'           => 'system/modules/invoice_and_offer/templates',
	'be_iao_setup'               => 'system/modules/invoice_and_offer/templates',
	'iao_public_project_list'    => 'system/modules/invoice_and_offer/templates',
));
