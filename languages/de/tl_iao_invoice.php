<?php
/**
 * TL_ROOT/system/modules/invoice_and_offer/languages/de/tl_iao_invoice.php
 *
 * Contao extension: invoice_and_offer
 * Deutsch translation file
 *
 * Copyright : &copy; Sven Rhinow <sven@sr-tag.de>
 * License   : LGPL
 * Author    : Sven Rhinow, http://www.sr-tag.de/
 * Translator: Sven Rhinow (scuM666)
 *
 * This file was created automatically be the TYPOlight extension repository translation module.
 * Do not edit this file manually. Contact the author or translator for this module to establish
 * permanent text corrections which are update-safe.
 */

/**
* Header-Menue
*/
$GLOBALS['TL_LANG']['tl_iao_invoice']['importInvoices'] = array('Import','Rechnungen aus CSV-Dateien importieren');
$GLOBALS['TL_LANG']['tl_iao_invoice']['exportInvoices'] = array('Export','Rechnungen und deren Posten in CSV-Dateien exportieren.');

$GLOBALS['TL_LANG']['tl_iao_invoice']['setting_id']	=	array('Konfiguration','');
$GLOBALS['TL_LANG']['tl_iao_invoice']['pid']	=	array('Projekt','das entsprechende Projekt auswählen.');
$GLOBALS['TL_LANG']['tl_iao_invoice']['title'] = array('Bezeichnung','Bezeichnung des Elementes');
$GLOBALS['TL_LANG']['tl_iao_invoice']['alias'] = array('Alias','');
$GLOBALS['TL_LANG']['tl_iao_invoice']['member'] = array('Kunde','Adresse aus gespeicherten Kunden in nachstehendes Feld befüllen');
$GLOBALS['TL_LANG']['tl_iao_invoice']['address_text'] = array('Rechnungs-Adresse','Adresse die in der Rechnungs-PDF-Datei geschrieben wird.');
$GLOBALS['TL_LANG']['tl_iao_invoice']['before_text'] = array('Text vor den Posten','');
$GLOBALS['TL_LANG']['tl_iao_invoice']['before_template'] = array('Text-Template vor den Posten','');
$GLOBALS['TL_LANG']['tl_iao_invoice']['beforetext_as_template'] = array('als "Rechnung Text vor Positionen" speichern','');
$GLOBALS['TL_LANG']['tl_iao_invoice']['after_text'] = array('Text nach den Posten','');
$GLOBALS['TL_LANG']['tl_iao_invoice']['after_template'] = array('Text-Template nach den Posten','');
$GLOBALS['TL_LANG']['tl_iao_invoice']['aftertext_as_template'] = array('als "Rechnung Text nach Positionen" speichern','');
$GLOBALS['TL_LANG']['tl_iao_invoice']['published'] = array('veröffentlicht','');
$GLOBALS['TL_LANG']['tl_iao_invoice']['status'] = array('Status dieser Rechnung','');
$GLOBALS['TL_LANG']['tl_iao_invoice']['price_netto'] = array('Rechnung-Höhe (Netto)','');
$GLOBALS['TL_LANG']['tl_iao_invoice']['price_brutto'] = array('Rechnung-Höhe (Brutto)','');
$GLOBALS['TL_LANG']['tl_iao_invoice']['member'] = array('Kunde','');
$GLOBALS['TL_LANG']['tl_iao_invoice']['noVat'] = array('keine MwSt. ausweisen','z.B. Rechnung in nicht Bundesrepublik Deutschland');
$GLOBALS['TL_LANG']['tl_iao_invoice']['notice'] = array('Notiz','');
$GLOBALS['TL_LANG']['tl_iao_invoice']['discount'] = array('Rabatt/Skonto',' Rabatt/Skonto auf die Gesamtsumme');
$GLOBALS['TL_LANG']['tl_iao_invoice']['discount_title'] = array('Rabatt-Beschreibung','Text vor dem Rabattwert');
$GLOBALS['TL_LANG']['tl_iao_invoice']['discount_value'] = array('Rabatt-Wert','Wert als Zahl eingeben');
$GLOBALS['TL_LANG']['tl_iao_invoice']['discount_operator'] = array('Rabatt-Operator','Art der Rabattierung');
$GLOBALS['TL_LANG']['tl_iao_invoice']['invoice_date'] = array('Rechnungsdatum','wenn es leer bleibt dann wird das aktuelle Datum eingetragen. Unter normalen Umständen sollte dieses Feld leer bleiben. Es ist hauptsächlich für Importe gedacht.');
$GLOBALS['TL_LANG']['tl_iao_invoice']['invoice_tstamp'] = array('Rechnungsdatum als Timestamp','Wenn es leer bleibt dann wird der Timestamp vom Rechungsdatum eingetragen. Unter normalen Umständen sollte dieses Feld leer bleiben. Es ist hauptsächlich für Importe gedacht.');
$GLOBALS['TL_LANG']['tl_iao_invoice']['invoice_id'] = array('Rechnungs-ID','Dieses Feld wird hauptsächlich zum hochzählen der nächsten Rechung benötigt.');
$GLOBALS['TL_LANG']['tl_iao_invoice']['invoice_id_str'] = array('Rechnungs-ID-Name','Dieses Feld wird für den PDF-Namen und direkt auf der Rechnung ausgegeben.');
$GLOBALS['TL_LANG']['tl_iao_invoice']['execute_date'] = array('Ausgeführt am','Dieses Angabe wird vom Finanzamt vorgeschrieben um die Vorsteuer zu ziehen.');
$GLOBALS['TL_LANG']['tl_iao_invoice']['expiry_date'] = array('begleichen bis','Das Datum nachdem die Mahnungsstufen anfangen.');
$GLOBALS['TL_LANG']['tl_iao_invoice']['invoice_pdf_file'] = array('Rechnungsdatei','Wenn hier eine Datei angegeben wurde wird diese statt einer generierten ausgegeben. Unter normalen Umständen sollte dieses Feld leer bleiben. Es ist hauptsächlich für Importe gedacht.');
$GLOBALS['TL_LANG']['tl_iao_invoice']['paid_on_date'] = array('Bezahlt am','Das Datum an dem die Zahlung auf dem Konto eingegangen ist.');
$GLOBALS['TL_LANG']['tl_iao_invoice']['paid_on_dates'] = array('Zahlungen','');
$GLOBALS['TL_LANG']['tl_iao_invoice']['paydate'] = array('Datum','');
$GLOBALS['TL_LANG']['tl_iao_invoice']['payamount'] = array('Betrag (€)','');
$GLOBALS['TL_LANG']['tl_iao_invoice']['paynotice'] = array('Kommentar','');
$GLOBALS['TL_LANG']['tl_iao_invoice']['remaining'] = array('übrig','');
$GLOBALS['TL_LANG']['tl_iao_invoice']['agreement_id'] = array('Vertrag zuordnen','Falls diese Rechnung zu einem Vertrag gehört kann diese hier zugeordnet werden.');

$GLOBALS['TL_LANG']['tl_iao_invoice']['csv_source'] = array('CSV der Rechnungen','z.B. tl_iao_invoice_YYYY-MM-DD.csv');
$GLOBALS['TL_LANG']['tl_iao_invoice']['csv_posten_source'] = array('CSV der Rechnungsposten','z.B. tl_iao_invoice_items_YYYY-MM-DD.csv');
$GLOBALS['TL_LANG']['tl_iao_invoice']['pdf_import_dir'] = array('Verzeichnis der Rechnungs-PDF-Dateien','Geben Sie hier das Verzeichnis an in dem die Rechnungen liegen die beim Import verknüpft werden sollen.');
$GLOBALS['TL_LANG']['tl_iao_invoice']['drop_first_row'] = array('erste Zeile überspringen', 'Wenn z.B. die Spaltennamen in der ersten Spalte steht müssen diese beim Import übersprungen werden.');
$GLOBALS['TL_LANG']['tl_iao_invoice']['drop_exist_entries'] = array('existierende Einträge in der Datenbank-Tabelle löschen', 'Alle bereits existierenden Einträge werden vor dem Import entfernt.');
$GLOBALS['TL_LANG']['tl_iao_invoice']['importCSV'] = array('Import starten','');
$GLOBALS['TL_LANG']['tl_iao_invoice']['csv_export_dir'] = array('Export-Ziel-Verzeichnis','Wählen Sie das Verzeichnis, in welchem die Dateien exportiert werden sollen. Beachten Sie das es Schreibrechte besitzt.');
$GLOBALS['TL_LANG']['tl_iao_invoice']['export_invoice_filename'] = array('Dateiname der Rechnungen','OHNE ENDUNG .csv');
$GLOBALS['TL_LANG']['tl_iao_invoice']['export_invoice_item_filename'] = array('Dateiname der Rechnungsposten','OHNE ENDUNG .csv');
$GLOBALS['TL_LANG']['tl_iao_invoice']['exportCSV'] = array('Export starten','');

$GLOBALS['TL_LANG']['tl_iao_invoice']['toggle'] = 'Rechnung als bezahlt/ nicht bezahlt markieren';
$GLOBALS['TL_LANG']['tl_iao_invoice']['gender']['male'] = 'Herr';
$GLOBALS['TL_LANG']['tl_iao_invoice']['gender']['female'] = 'Frau';

/**
* Buttons
*/
$GLOBALS['TL_LANG']['tl_iao_invoice']['new'] = array('Neue Rechnung','Eine neue Rechnung anlegen');
$GLOBALS['TL_LANG']['tl_iao_invoice']['edit'] = array('Rechnung bearbeiten','Rechnung ID %s bearbeiten');
$GLOBALS['TL_LANG']['tl_iao_invoice']['copy'] = array('Rechnung duplizieren','Rechnung ID %s duplizieren');
$GLOBALS['TL_LANG']['tl_iao_invoice']['delete'] = array('Rechnung löschen','Rechnung ID %s löschen');
$GLOBALS['TL_LANG']['tl_iao_invoice']['deleteConfirm'] = 'Soll die Rechnung ID %s wirklich gelöscht werden?!';
$GLOBALS['TL_LANG']['tl_iao_invoice']['show'] = array('Details anzeigen','Details der Rechnung ID %s anzeigen');

/**
 * Legend
 */
$GLOBALS['TL_LANG']['tl_iao_invoice']['settings_legend']	=	'Konfiguration-Zuweisung';
$GLOBALS['TL_LANG']['tl_iao_invoice']['title_legend'] = 'Titel Einstellung';
$GLOBALS['TL_LANG']['tl_iao_invoice']['invoice_id_legend'] = 'erweiterte Rechnungs-Einstellungen';
$GLOBALS['TL_LANG']['tl_iao_invoice']['address_legend'] = 'Adress-Angaben';
$GLOBALS['TL_LANG']['tl_iao_invoice']['text_before_legend'] = 'Text vor den Rechnungsposten';
$GLOBALS['TL_LANG']['tl_iao_invoice']['text_after_legend'] = 'Text nach den Rechnungsposten';
$GLOBALS['TL_LANG']['tl_iao_invoice']['status_legend'] = 'Status-Einstellungen';
$GLOBALS['TL_LANG']['tl_iao_invoice']['paid_legend'] = 'Bezahlungen';
$GLOBALS['TL_LANG']['tl_iao_invoice']['extend_legend'] = 'weitere Einstellungen';
$GLOBALS['TL_LANG']['tl_iao_invoice']['notice_legend'] = 'Notiz anlegen';

/**
 * Import / Export-Libs
 */
$GLOBALS['TL_LANG']['tl_iao_invoice']['importlib'] = array('Import-Bibliothek auswählen','wählen Sie die Bibliothek die beim Import die Daten korrekt importiert.');
$GLOBALS['TL_LANG']['tl_iao_invoice']['importlib_invoiceandoffer'] = 'Invoice and Offer';
$GLOBALS['TL_LANG']['tl_iao_invoice']['importlib_phprechnung'] = 'PHPRechnung';

/**
 * Notify
 */
$GLOBALS['TL_LANG']['tl_iao_invoice']['Invoice_imported'] = 'Es wurden die Datensätze aus %s erfogreich importiert';
$GLOBALS['TL_LANG']['tl_iao_invoice']['Invoice_exported'] = 'Es wurden die Datensätze erfogreich exportiert';

/**
 * Select-fiels options
 */
$GLOBALS['TL_LANG']['tl_iao_invoice']['status_options'] = array('1'=>'nicht bezahlt','2'=>'bezahlt','3'=>'ruht (keine Mahnungen)','4'=>'Teil-/Ratenzahlung');
$GLOBALS['TL_LANG']['tl_iao_invoice']['discount_operators'] = array('%'=>'% (Prozentwert Rabatt von der Summe)','-'=>'- (verminderter Wert von die Summe)','+'=>'+ (erhöhender Wert auf die Summe)');

/**
* Frontend-Templates
*/
$GLOBALS['TL_LANG']['tl_iao_invoice']['fe_table_head']['title'] = 'Titel/ Rechnungsnr.:';
$GLOBALS['TL_LANG']['tl_iao_invoice']['fe_table_head']['date'] = 'erstellt am:';
$GLOBALS['TL_LANG']['tl_iao_invoice']['fe_table_head']['price'] = 'Betrag:';
$GLOBALS['TL_LANG']['tl_iao_invoice']['fe_table_head']['remaining'] = 'offen:';
$GLOBALS['TL_LANG']['tl_iao_invoice']['fe_table_head']['file'] = 'PDF:';


// Meldungen
$GLOBALS['TL_LANG']['tl_iao_invoice']['no_entries_msg'] = 'Es sind keine Einträge für diesen Bereich vorhanden.';

