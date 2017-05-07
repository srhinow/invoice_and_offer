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
	'iaoHooks'                   => 'system/modules/invoice_and_offer/classes/iaoHooks.php',
	'iao\iaoBackend'             => 'system/modules/invoice_and_offer/classes/iaoBackend.php',
	'iao\iao'                    => 'system/modules/invoice_and_offer/classes/iao.php',

	// Html
	'import_phprechnung'         => 'system/modules/invoice_and_offer/html/libs_import/import_phprechnung.php',
	'import_invoiceandoffer'     => 'system/modules/invoice_and_offer/html/libs_import/import_invoiceandoffer.php',

	// Models
	'iao\IaoOfferModel'          => 'system/modules/invoice_and_offer/models/IaoOfferModel.php',
	'iao\IaoInvoiceItemsModel'   => 'system/modules/invoice_and_offer/models/IaoInvoiceItemsModel.php',
	'iao\IaoSettingsModel'       => 'system/modules/invoice_and_offer/models/IaoSettingsModel.php',
	'iao\IaoAgreementsModel'     => 'system/modules/invoice_and_offer/models/IaoAgreementsModel.php',
	'iao\IaoInvoiceModel'        => 'system/modules/invoice_and_offer/models/IaoInvoiceModel.php',
	'iao\IaoTemplatesModel'      => 'system/modules/invoice_and_offer/models/IaoTemplatesModel.php',
	'iao\IaoCreditModel'         => 'system/modules/invoice_and_offer/models/IaoCreditModel.php',
	'iao\IaoCreditItemsModel'    => 'system/modules/invoice_and_offer/models/IaoCreditItemsModel.php',
	'iao\IaoReminderModel'       => 'system/modules/invoice_and_offer/models/IaoReminderModel.php',
	'iao\IaoTemplatesItemsModel' => 'system/modules/invoice_and_offer/models/IaoTemplatesItemsModel.php',
	'iao\IaoProjectsModel'       => 'system/modules/invoice_and_offer/models/IaoProjectsModel.php',
	'iao\IaoOfferItemsModel'     => 'system/modules/invoice_and_offer/models/IaoOfferItemsModel.php',

	// Modules
	'ModuleCustomerMember'       => 'system/modules/invoice_and_offer/modules/be/ModuleCustomerMember.php',
	'ModuleIAOSetup'             => 'system/modules/invoice_and_offer/modules/be/ModuleIAOSetup.php',
	'ModuleMemberReminder'       => 'system/modules/invoice_and_offer/modules/fe/ModuleMemberReminder.php',
	'ModulePublicProjectDetails' => 'system/modules/invoice_and_offer/modules/fe/ModulePublicProjectDetails.php',
	'ModuleMemberOffers'         => 'system/modules/invoice_and_offer/modules/fe/ModuleMemberOffers.php',
	'ModulePublicProjectList'    => 'system/modules/invoice_and_offer/modules/fe/ModulePublicProjectList.php',
	'ModuleMemberAgreements'     => 'system/modules/invoice_and_offer/modules/fe/ModuleMemberAgreements.php',
	'ModuleMemberInvoices'       => 'system/modules/invoice_and_offer/modules/fe/ModuleMemberInvoices.php',
	'ModuleMemberCredits'        => 'system/modules/invoice_and_offer/modules/fe/ModuleMemberCredits.php',

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
	'iao_credit_list'            => 'system/modules/invoice_and_offer/templates',
	'iao_public_project_list'    => 'system/modules/invoice_and_offer/templates',
	'iao_offer_list'             => 'system/modules/invoice_and_offer/templates',
	'iao_reminder_list'          => 'system/modules/invoice_and_offer/templates',
	'iao_agreement_list'         => 'system/modules/invoice_and_offer/templates',
));
