<?php

/**
 * Contao Open Source CMS
 * 
 * Copyright (C) 2005-2012 Leo Feyer
 * 
 * @package Invoice_and_offer
 * @link    http://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	'iao_invoice'            => 'system/modules/invoice_and_offer/iao_invoice.php',
	// Html
	'import_phprechnung'     => 'system/modules/invoice_and_offer/html/libs_import/import_phprechnung.php',
	'import_invoiceandoffer' => 'system/modules/invoice_and_offer/html/libs_import/import_invoiceandoffer.php',
	'iao_reminder'           => 'system/modules/invoice_and_offer/iao_reminder.php',
	'ModuleCustomerMember'   => 'system/modules/invoice_and_offer/ModuleCustomerMember.php',
	'iaoPDF'                 => 'system/modules/invoice_and_offer/iaoPDF.php',
	'iao_offer'              => 'system/modules/invoice_and_offer/iao_offer.php',
	'iao'                    => 'system/modules/invoice_and_offer/iao.php',
));
