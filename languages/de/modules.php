<?php
/**
 * TL_ROOT/system/modules/invoice_and_offer/languages/de/modules.php
 *
 * Contao extension: invoice_and_offer
 * Deutsch translation file
 *
 * @copyright  Sven Rhinow 2014
 * @author     sr-tag Sven Rhinow Webentwicklung <http://www.sr-tag.de>
 * @package    invoice_and_offer
 *
 */

/**
 * Back end modules
 */
 $GLOBALS['TL_LANG']['MOD']['iao']  = 'Rechnungen & Angebote';
 $GLOBALS['TL_LANG']['MOD']['iao_offer']	= array('Angebote', 'Verwalten Sie hier Ihre Angebote.');
 $GLOBALS['TL_LANG']['MOD']['iao_invoice']	= array('Rechnungen', 'Verwalten Sie hier Ihre Rechnungen.');
 $GLOBALS['TL_LANG']['MOD']['iao_reminder']	= array('Rückstände', 'Verwalten Sie hier Ihre Rückstände.');
 $GLOBALS['TL_LANG']['MOD']['iao_credit']	= array('Gutschriften', 'Verwalten Sie hier Ihre Gutschriften.');
 $GLOBALS['TL_LANG']['MOD']['iao_agreements']	= array('Verträge', 'Verwalten Sie hier Ihre Service-Verträge und ale zeitlich wiederkehrenden Rechnungsstellungen.');
 $GLOBALS['TL_LANG']['MOD']['iao_templates']	= array('Vorlagen (Text)', 'Verwalten Sie die Vorlagen für die Standarttexte vor und nach den Posten von Rechnungen, Angebote und Gutschriften.');
 $GLOBALS['TL_LANG']['MOD']['iao_templates_items']	= array('Vorlagen (Posten)', 'Verwalten Sie die Vorlagen für die Posten von Rechnungen, Angebote und Gutschriften.');
 $GLOBALS['TL_LANG']['MOD']['iao_customer']	= array('Kunden', 'Verwalten Sie ihre Kundendaten.');
 $GLOBALS['TL_LANG']['MOD']['iao_settings']	= array('Einstellungen', 'Verwalten Sie die allgemeinen Einstellungen zu den Angebote, Rechnungen und Gutschriften.');
 $GLOBALS['TL_LANG']['MOD']['iao_setup']	= array('Einstellungen', 'Verwalten Sie alle Einstellungen.');

/**
 * settings Modules
 */
$GLOBALS['TL_LANG']['IAO']['config_module']             = 'Rechnungen & Angebote Konfiguration (Version: %s)';

$GLOBALS['TL_LANG']['IMD']['config']                       = 'Einstellungen';
$GLOBALS['TL_LANG']['IMD']['iao_settings'][0]              = 'Konfigurationen';
$GLOBALS['TL_LANG']['IMD']['iao_settings'][1]              = 'Verwalten Sie die grundlegenden Einstellungen und weisen eine Stadard-Einstellung zu. Sie können mehrere Konfiguration anlegen und so z.B. Angebote,Rechnungen etc. für verschiedene Firmen mit den jeweiligen PDF-Vorlagen verwalten.';
$GLOBALS['TL_LANG']['IMD']['iao_tax_rates'][0]             = 'Steuersätze';
$GLOBALS['TL_LANG']['IMD']['iao_tax_rates'][1]             = 'Steuersätze definieren die Gebühren welche zum Preis hinzugerechnet werden sollen.';
$GLOBALS['TL_LANG']['IMD']['iao_item_units'][0]            = 'Einheiten';
$GLOBALS['TL_LANG']['IMD']['iao_item_units'][1]            = 'Einheiten für die Menge der Posten verwalten. z.B. Stunden, Tage, Pauschale.';

$GLOBALS['TL_LANG']['IMD']['templates']                    = 'Vorlagen';
$GLOBALS['TL_LANG']['IMD']['iao_templates'][0]             = 'Vorlagen (Rechnungen, Angebote,Gutscheine)';
$GLOBALS['TL_LANG']['IMD']['iao_templates'][1]             = 'Damit Sie schnell immer wiederkehrende Texte in Rechnungen, Angebote oder Gutscheine befüllen können, haben Sie hier die Möglichkeit diese als Vorlage hier zu verwalten.';
$GLOBALS['TL_LANG']['IMD']['iao_templates_items'][0]       = 'Posten-Vorlagen (Rechnungen, Angebote,Gutscheine)';
$GLOBALS['TL_LANG']['IMD']['iao_templates_items'][1]       = 'Hier erstellen Sie die Vorlagen für die einzelnen Posten einer Rechnung, Angebotes oder Gutschrift';


/**
 * Front end modules
 */
$GLOBALS['TL_LANG']['FMD']['iao_fe']      = 'Angebote &amp; Rechnungen';
$GLOBALS['TL_LANG']['FMD']['fe_iao_invoice'] = array('Liste der Rechnungen', 'Eine Liste aller Rechnungen zu dem angemeldeten Mitglied.');
$GLOBALS['TL_LANG']['FMD']['fe_iao_offer'] = array('Liste der Angebote','Eine Liste aller Angebote zu dem angemeldeten Mitglied.');
$GLOBALS['TL_LANG']['FMD']['fe_iao_credit'] = array('Liste der Gutschriften','Eine Liste aller Gutschriften zu dem angemeldeten Mitglied.');
$GLOBALS['TL_LANG']['FMD']['fe_iao_reminder'] = array('Liste der Mahnungen','Eine Liste aller Mahnungen zu dem angemeldeten Mitglied.');
$GLOBALS['TL_LANG']['FMD']['fe_iao_agreements'] = array('Liste der Verträge','Eine Liste aller Verträge zu dem angemeldeten Mitglied.');
