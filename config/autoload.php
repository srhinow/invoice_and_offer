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
	// Export_import
	'iao_offer'                  => 'system/modules/invoice_and_offer/export_import/iao_offer.php',
	'iao_invoice'                => 'system/modules/invoice_and_offer/export_import/iao_invoice.php',
	'iao_reminder'               => 'system/modules/invoice_and_offer/export_import/iao_reminder.php',

	// Models
	'iao\iaoOfferModel'          => 'system/modules/invoice_and_offer/models/iaoOfferModel.php',
	'iao\iaoInvoiceModel'        => 'system/modules/invoice_and_offer/models/iaoInvoiceModel.php',
	'iao\iaoProjectsModel'       => 'system/modules/invoice_and_offer/models/iaoProjectsModel.php',
	'iao\iaoTemplatesModel'      => 'system/modules/invoice_and_offer/models/iaoTemplatesModel.php',
	'iao\iaoCreditItemsModel'    => 'system/modules/invoice_and_offer/models/iaoCreditItemsModel.php',
	'iao\iaoSettingsModel'       => 'system/modules/invoice_and_offer/models/iaoSettingsModel.php',
	'iao\iaoOfferItemsModel'     => 'system/modules/invoice_and_offer/models/iaoOfferItemsModel.php',
	'iao\IaoTemplatesItemsModel' => 'system/modules/invoice_and_offer/models/IaoTemplatesItemsModel.php',
	'iao\iaoCreditModel'         => 'system/modules/invoice_and_offer/models/iaoCreditModel.php',

	// Classes
	'iaoCrons'                   => 'system/modules/invoice_and_offer/classes/iaoCrons.php',
	'iao\iao'                    => 'system/modules/invoice_and_offer/classes/iao.php',
	'iao\iaoPDF'                 => 'system/modules/invoice_and_offer/classes/iaoPDF.php',
	'iao\iaoBackend'             => 'system/modules/invoice_and_offer/classes/iaoBackend.php',

	// Modules
	'ModuleMemberInvoices'       => 'system/modules/invoice_and_offer/modules/fe/ModuleMemberInvoices.php',
	'ModulePublicProjectList'    => 'system/modules/invoice_and_offer/modules/fe/ModulePublicProjectList.php',
	'ModulePublicProjectDetails' => 'system/modules/invoice_and_offer/modules/fe/ModulePublicProjectDetails.php',
	'ModuleIAOSetup'             => 'system/modules/invoice_and_offer/modules/be/ModuleIAOSetup.php',
	'ModuleCustomerMember'       => 'system/modules/invoice_and_offer/modules/be/ModuleCustomerMember.php',

	// Html
	'import_invoiceandoffer'     => 'system/modules/invoice_and_offer/html/libs_import/import_invoiceandoffer.php',
	'import_phprechnung'         => 'system/modules/invoice_and_offer/html/libs_import/import_phprechnung.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'iao_public_project_list'    => 'system/modules/invoice_and_offer/templates',
	'iao_public_project_details' => 'system/modules/invoice_and_offer/templates',
	'be_iao_setup'               => 'system/modules/invoice_and_offer/templates',
	'iao_invoice_list'           => 'system/modules/invoice_and_offer/templates',
));
