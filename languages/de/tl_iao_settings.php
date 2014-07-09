<?php
/**
 * TL_ROOT/system/modules/invoice_and_offer/languages/de/tl_iao_settings.php
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
 * Fields
 */
$GLOBALS['TL_LANG']['tl_iao_settings']['name'][0]                         = 'Name der Konfiguration';
$GLOBALS['TL_LANG']['tl_iao_settings']['name'][1]                         = 'Geben Sie einen eindeutigen Namen ein.';
$GLOBALS['TL_LANG']['tl_iao_settings']['fallback'][0]                     = 'Standard-Konfiguration';
$GLOBALS['TL_LANG']['tl_iao_settings']['fallback'][1]                     = 'Verwendet dies als Standardkonfiguration für die Anzeige im Backend.';

$GLOBALS['TL_LANG']['tl_iao_settings']['iao_tax']= array('Standard-Steuersatz', 'Wird für die Berechnung der Standardwerte benötigt. Wirkt sich auch auf Verpackungskosten etc aus.');
$GLOBALS['TL_LANG']['tl_iao_settings']['iao_costumer_group']= array('Kunden-Gruppe', 'Diese Gruppen werden automatisch bei fehlender Angabe der Firma gesetzt.');
$GLOBALS['TL_LANG']['tl_iao_settings']['iao_currency']= array('Währungkürzel', 'Bitte das offizielle Währungskennzeichen dieses Shops eingeben.');
$GLOBALS['TL_LANG']['tl_iao_settings']['iao_currencysymbol']= array('Währungssymbol', 'Bitte das Währungssymbol der Shopwährung.');
$GLOBALS['TL_LANG']['tl_iao_settings']['iao_pdf_margins']= array('Randabstände', 'Geben Sie hier die Abstände in folgender Reihenfolge ein. (oben,rechts,unten,links, Maßeinheit)');
$GLOBALS['TL_LANG']['tl_iao_settings']['iao_pdf_css']= array('CSS-Datei für die PDF-Darstellung', '');
$GLOBALS['TL_LANG']['tl_iao_settings']['iao_invoice_mail_from']= array('Rechnung-Absender-Mailadresse', 'in der form foo@bar.de');
$GLOBALS['TL_LANG']['tl_iao_settings']['iao_invoice_startnumber']= array('Rechnung-Startnummer', 'ab welcher Nummer soll hochgezählt werden.');
$GLOBALS['TL_LANG']['tl_iao_settings']['iao_invoice_pdf_template']= array('Rechnung-PDF-Vorlage', 'eine PDF-Vorlage sollte 2 Seiten beinhalten die erste für die Startseite und die zweite für alle weiteren.');
$GLOBALS['TL_LANG']['tl_iao_settings']['iao_invoice_number_format']= array('Rechnung-Nummer-Formatierung', 'die Platzhalter  {date} für aktuelles Datum  und {nr} für die Rechnungs-ID können angegeben werden.');
$GLOBALS['TL_LANG']['tl_iao_settings']['iao_invoice_duration']= array('Begleichungsdauer', 'strtotime Format von PHP z.B. +3 months, +14 days, +1 year');
$GLOBALS['TL_LANG']['tl_iao_settings']['iao_offer_mail_from']= array('Angebot-Absender-Mailadresse', 'in der form foo@bar.de');
$GLOBALS['TL_LANG']['tl_iao_settings']['iao_offer_startnumber']= array('Angebot-Startnummer', 'ab welcher Nummer soll hochgezählt werden.');
$GLOBALS['TL_LANG']['tl_iao_settings']['iao_offer_pdf_template']= array('Angebot-PDF-Vorlage', 'eine PDF-Vorlage sollte 2 Seiten beinhalten die erste für die Startseite und die zweite für alle weiteren.');
$GLOBALS['TL_LANG']['tl_iao_settings']['iao_offer_number_format']= array('Angebot-Nummer-Formatierung', 'die Platzhalter  {date} für aktuelles Datum  und {nr} für die Angebot-ID können angegeben werden.');
$GLOBALS['TL_LANG']['tl_iao_settings']['iao_offer_expiry_date']= array('Angebot gültig bis', 'strtotime Format von PHP z.B. +3 months, +14 days, +1 year');
$GLOBALS['TL_LANG']['tl_iao_settings']['iao_credit_mail_from']= array('Gutschrift-Absender-Mailadresse', 'in der form foo@bar.de');
$GLOBALS['TL_LANG']['tl_iao_settings']['iao_credit_startnumber']= array('Gutschrift-Startnummer', 'ab welcher Nummer soll hochgezählt werden.');
$GLOBALS['TL_LANG']['tl_iao_settings']['iao_credit_pdf']= array('Gutschrift-PDF-Vorlage', 'eine PDF-Vorlage sollte 2 Seiten beinhalten die erste für die Startseite und die zweite für alle weiteren.');
$GLOBALS['TL_LANG']['tl_iao_settings']['iao_credit_number_format']= array('Gutschrift-Nummer-Formatierung', 'die Platzhalter  {date} für aktuelles Datum  und {nr} für die Gutschrift-ID können angegeben werden.');
$GLOBALS['TL_LANG']['tl_iao_settings']['iao_credit_expiry_date']= array('Gutschrift gültig bis', 'strtotime Format von PHP z.B. +3 months, +14 days, +1 year');
$GLOBALS['TL_LANG']['tl_iao_settings']['iao_reminder_tax']= array('Mahnungs-Zins (%)', '');
$GLOBALS['TL_LANG']['tl_iao_settings']['iao_reminder_postage']= array('Portokosten (&euro;)', 'mit Punkt getrennt (englisch)');
$GLOBALS['TL_LANG']['tl_iao_settings']['iao_reminder_1_duration']= array('Erinnerungs-Zeitraum', 'Status 4');
$GLOBALS['TL_LANG']['tl_iao_settings']['iao_reminder_1_text']= array('Erinnerungs-Text', 'Platzhalter: alle Contao-Inserttags http://de.contaowiki.org/Insert-Tags , Rechnungsdatum = {{invoice::date}} , Rechnungsnummer = {{invoice::invoice_id_str}}, Frist-Datum = {{iao::period-date}}');
$GLOBALS['TL_LANG']['tl_iao_settings']['iao_reminder_1_pdf']= array('Erinnerungs-PDF-Vorlage', '');
$GLOBALS['TL_LANG']['tl_iao_settings']['iao_reminder_2_duration']= array('1. Mahnung-Zeitraum', '');
$GLOBALS['TL_LANG']['tl_iao_settings']['iao_reminder_2_text']= array('1. Mahnung-Text', 'Platzhalter: alle Contao-Inserttags http://de.contaowiki.org/Insert-Tags , Rechnungsdatum = {{invoice::date}} , Rechnungsnummer = {{invoice::invoice_id_str}}, Frist-Datum = {{iao::period-date}}');
$GLOBALS['TL_LANG']['tl_iao_settings']['iao_reminder_2_pdf']= array('1. Mahnung-PDF-Vorlage', '');
$GLOBALS['TL_LANG']['tl_iao_settings']['iao_reminder_3_duration']= array('2. Mahnung-Zeitraum', '');
$GLOBALS['TL_LANG']['tl_iao_settings']['iao_reminder_3_text']= array('2. Mahnung-Text', 'Platzhalter: alle Contao-Inserttags http://de.contaowiki.org/Insert-Tags , Rechnungsdatum = {{invoice::date}} , Rechnungsnummer = {{invoice::invoice_id_str}}, Frist-Datum = {{iao::period-date}}');
$GLOBALS['TL_LANG']['tl_iao_settings']['iao_reminder_3_pdf']= array('2. Mahnung-PDF-Vorlage', '');
$GLOBALS['TL_LANG']['tl_iao_settings']['iao_reminder_4_duration']= array('3. Mahnung-Zeitraum', '');
$GLOBALS['TL_LANG']['tl_iao_settings']['iao_reminder_4_text']= array('3. Mahnung-Text', 'Platzhalter: alle Contao-Inserttags http://de.contaowiki.org/Insert-Tags , Rechnungsdatum = {{invoice::date}} , Rechnungsnummer = {{invoice::invoice_id_str}}, Frist-Datum = {{iao::period-date}}');
$GLOBALS['TL_LANG']['tl_iao_settings']['iao_reminder_4_pdf']= array('3. Mahnung-PDF-Vorlage', '');

/**
 * Buttons
 */
$GLOBALS['TL_LANG']['tl_iao_settings']['new'][0]                          = 'Neue Konfiguration';
$GLOBALS['TL_LANG']['tl_iao_settings']['new'][1]                          = 'Eine neue Konfiguration erstellen.';
$GLOBALS['TL_LANG']['tl_iao_settings']['edit'][0]                         = 'Konfiguration bearbeiten';
$GLOBALS['TL_LANG']['tl_iao_settings']['edit'][1]                         = 'Konfiguration ID %s bearbeiten.';
$GLOBALS['TL_LANG']['tl_iao_settings']['copy'][0]                         = 'Konfiguration duplizieren';
$GLOBALS['TL_LANG']['tl_iao_settings']['copy'][1]                         = 'Konfiguration ID %s duplizieren.';
$GLOBALS['TL_LANG']['tl_iao_settings']['delete'][0]                       = 'Konfiguration löschen';
$GLOBALS['TL_LANG']['tl_iao_settings']['delete'][1]                       = 'Konfiguration ID %s löschen.  Dies löscht nicht die zugeordneten Dateien sondern lediglich die Grundkonfiguration.';
$GLOBALS['TL_LANG']['tl_iao_settings']['show'][0]                         = 'Konfigurationsdetails anzeigen';
$GLOBALS['TL_LANG']['tl_iao_settings']['show'][1]                         = 'Details für Konfiguration ID %s anzeigen.';

/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_iao_settings']['name_legend']                     = 'Name';
$GLOBALS['TL_LANG']['tl_iao_settings']['currency_legend'] = 'Währungs-Einstellungen';
$GLOBALS['TL_LANG']['tl_iao_settings']['standards_legend'] = 'Standard-Einstellungen';
$GLOBALS['TL_LANG']['tl_iao_settings']['customermails_legend'] = 'Kunden-Maileinstellungen';
$GLOBALS['TL_LANG']['tl_iao_settings']['secure_legend'] = 'Sicherheitseinstellungen';
$GLOBALS['TL_LANG']['tl_iao_settings']['pdf_legend'] = 'PDF-Einstellungen';
$GLOBALS['TL_LANG']['tl_iao_settings']['invoice_legend'] = 'Rechnung-Einstellungen';
$GLOBALS['TL_LANG']['tl_iao_settings']['offer_legend'] = 'Angebot-Einstellungen';
$GLOBALS['TL_LANG']['tl_iao_settings']['credit_legend'] = 'Gutschrift-Einstellungen';
$GLOBALS['TL_LANG']['tl_iao_settings']['reminder_1_legend'] = 'Erinnerung-Einstellungen';
$GLOBALS['TL_LANG']['tl_iao_settings']['reminder_2_legend'] = '1. Mahnung-Einstellungen';
$GLOBALS['TL_LANG']['tl_iao_settings']['reminder_3_legend'] = '2. Mahnung-Einstellungen';
$GLOBALS['TL_LANG']['tl_iao_settings']['reminder_4_legend'] = '3. Mahnung-Einstellungen';
