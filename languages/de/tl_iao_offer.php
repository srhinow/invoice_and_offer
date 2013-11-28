<?php
/**
 * TL_ROOT/system/modules/invoice_and_offer/languages/de/tl_iao_offer.php
 *
 * Contao extension: invoice_and_offer
 * Deutsch translation file
 *
 * Copyright : &copy; Sven Rhinow <sven@sr-tag.de>
 * License   : LGPL
 * Author    : Sven Rhinow, http://www.sr-tag.de/
 * Translator: Sven Rhinow (ScuM666)
 *
 * This file was created automatically be the TYPOlight extension repository translation module.
 * Do not edit this file manually. Contact the author or translator for this module to establish
 * permanent text corrections which are update-safe.
 */

$GLOBALS['TL_LANG']['tl_iao_offer']['setting_id']	=	array('Konfiguration','');
$GLOBALS['TL_LANG']['tl_iao_offer']['title'] = array('Angebot-Titel','Diese Bezeichnung wird außschließlich zur besseren Übersicht im Backend angezeigt.');
$GLOBALS['TL_LANG']['tl_iao_offer']['alias'] = array('Alias','');
$GLOBALS['TL_LANG']['tl_iao_offer']['offer_id'] = array('Angebots-ID','Dieses Feld wird hauptsächlich zum hochzählen des nächsten Angebots benötigt.');
$GLOBALS['TL_LANG']['tl_iao_offer']['offer_id_str'] = array('Rechnungs-ID-Name','Dieses Feld wird für den PDF-Namen und direkt auf dem Angebot ausgegeben.');
$GLOBALS['TL_LANG']['tl_iao_offer']['address_text'] = array('Angebots-Adresse','Adresse die in der Angebot-PDF-Datei geschrieben wird.');
$GLOBALS['TL_LANG']['tl_iao_offer']['before_text'] = array('Text vor den Posten','');
$GLOBALS['TL_LANG']['tl_iao_offer']['after_text'] = array('Text nach den Posten','');
$GLOBALS['TL_LANG']['tl_iao_offer']['published'] = array('veröffnentlicht/ versendet.','');
$GLOBALS['TL_LANG']['tl_iao_offer']['status'] = array('Status des Angebotes','');
$GLOBALS['TL_LANG']['tl_iao_offer']['price_netto'] = array('Angebot-Höhe (Netto)','');
$GLOBALS['TL_LANG']['tl_iao_offer']['price_brutto'] = array('Angebot-Höhe (Brutto)','');
$GLOBALS['TL_LANG']['tl_iao_offer']['member'] = array('Kunde','');
$GLOBALS['TL_LANG']['tl_iao_offer']['noVat'] = array('keine MwSt. ausweisen','z.B. Rechnung in nicht Bundesrepublik Deutschland');
$GLOBALS['TL_LANG']['tl_iao_offer']['offer_date'] = array('Angebotsdatum','wenn es leer bleibt dann wird das aktuelle Datum eingetragen. Unter normalen Umständen sollte dieses Feld leer bleiben. Es ist hauptsächlich für Importe gedacht.');
$GLOBALS['TL_LANG']['tl_iao_offer']['offer_tstamp'] = array('Angebotsdatum','Wenn es leer bleibt, dann wird das aktuelle Datum eingetragen.');
$GLOBALS['TL_LANG']['tl_iao_offer']['offer_id'] = array('Angebots-ID','Dieses Feld wird hauptsächlich zum hochzählen des nächsten Angebots benötigt.');
$GLOBALS['TL_LANG']['tl_iao_offer']['offer_id_str'] = array('Angebots-ID-Name','Dieses Feld wird für den PDF-Namen und direkt auf dem Angebot ausgegeben.');
$GLOBALS['TL_LANG']['tl_iao_offer']['expiry_date'] = array('Gültig bis','Dieses Angebot ist bis zu diesem Datum gültig.');
$GLOBALS['TL_LANG']['tl_iao_offer']['offer_pdf_file'] = array('Angebotdatei','Wenn hier eine Datei angegeben wurde wird diese statt einer generierten ausgegeben. Unter normalen Umständen sollte dieses Feld leer bleiben. Es ist hauptsächlich für Importe gedacht.');
$GLOBALS['TL_LANG']['tl_iao_offer']['before_template'] = array('Text-Template vor den Posten','');
$GLOBALS['TL_LANG']['tl_iao_offer']['after_template'] = array('Text-Template nach den Posten','');
$GLOBALS['TL_LANG']['tl_iao_offer']['notice'] = array('Notiz','');
$GLOBALS['TL_LANG']['tl_iao_offer']['csv_source'] = array('CSV der Angebote','z.B. tl_iao_offer_YYYY-MM-DD.csv');
$GLOBALS['TL_LANG']['tl_iao_offer']['csv_posten_source'] = array('CSV der Angebot-Posten','z.B. tl_iao_offer_items_YYYY-MM-DD.csv');
$GLOBALS['TL_LANG']['tl_iao_offer']['pdf_import_dir'] = array('Verzeichnis der Angebote-PDF-Dateien','Geben Sie hier das Verzeichnis an in dem die Angebote liegen die beim Import verknüpft werden sollen.');
$GLOBALS['TL_LANG']['tl_iao_offer']['drop_first_row'] = array('erste Zeile überspringen', 'Wenn z.B. die Spaltennamen in der ersten Spalte steht müssen diese beim Import übersprungen werden.');
$GLOBALS['TL_LANG']['tl_iao_offer']['drop_exist_entries'] = array('existierende Einträge in der Datenbank-Tabelle löschen', 'Alle bereits existierenden Einträge werden vor dem Import entfernt.');
$GLOBALS['TL_LANG']['tl_iao_offer']['importCSV'] = array('Import starten','');
$GLOBALS['TL_LANG']['tl_iao_offer']['csv_export_dir'] = array('Export-Ziel-Verzeichnis','Wählen Sie das Verzeichnis, in welchem die Dateien exportiert werden sollen. Beachten Sie das es Schreibrechte besitzt.');
$GLOBALS['TL_LANG']['tl_iao_offer']['export_offer_filename'] = array('Dateiname der Angebote','OHNE ENDUNG .csv');
$GLOBALS['TL_LANG']['tl_iao_offer']['export_offer_item_filename'] = array('Dateiname der Angebotposten','OHNE ENDUNG .csv');
$GLOBALS['TL_LANG']['tl_iao_offer']['exportCSV'] = array('Export starten','');

$GLOBALS['TL_LANG']['tl_iao_offer']['toggle'] = 'Angebot als angenommen/ nicht angenommen markieren';
$GLOBALS['TL_LANG']['tl_iao_offer']['gender']['male'] = 'Herr';
$GLOBALS['TL_LANG']['tl_iao_offer']['gender']['female'] = 'Frau';

/**
 * Buttons
 */
$GLOBALS['TL_LANG']['tl_iao_offer']['new'] = array('Neues Angebot','Ein neues Angebot anlegen');
$GLOBALS['TL_LANG']['tl_iao_offer']['edit'] = array('Angebot bearbeiten','Angebot ID %s bearbeiten');
$GLOBALS['TL_LANG']['tl_iao_offer']['copy'] = array('Angebot duplizieren','Angebot ID %s duplizieren');
$GLOBALS['TL_LANG']['tl_iao_offer']['delete'] = array('Angebot löschen','Angebot ID %s löschen');
$GLOBALS['TL_LANG']['tl_iao_offer']['deleteConfirm'] = 'Soll das Angebot ID %s wirklich gelöscht werden?!';
$GLOBALS['TL_LANG']['tl_iao_offer']['show'] = array('Details anzeigen','Details des Angebots ID %s anzeigen');
$GLOBALS['TL_LANG']['tl_iao_offer']['invoice'] = array('dieses Angebot als Rechnung übernehmen','Angebot ID %s als Rechnung anlegen');
$GLOBALS['TL_LANG']['tl_iao_offer']['importOffer'] = array('Import','Angebote aus CSV-Dateien importieren');
$GLOBALS['TL_LANG']['tl_iao_offer']['exportOffer'] = array('Export','Angebote und deren Posten in CSV-Dateien exportieren.');
$GLOBALS['TL_LANG']['tl_iao_offer']['pdf'] = array('PDF generieren','eine PDF zu diesem Angebot generieren');

/**
 * Legend
 */
$GLOBALS['TL_LANG']['tl_iao_offer']['settings_legend']	=	'Konfiguration-Zuweisung';
$GLOBALS['TL_LANG']['tl_iao_offer']['title_legend'] = 'Titel Einstellung';
$GLOBALS['TL_LANG']['tl_iao_offer']['offer_id_legend'] = 'erweiterte Angebots-Einstellungen';
$GLOBALS['TL_LANG']['tl_iao_offer']['address_legend'] = 'Adress-Angaben';
$GLOBALS['TL_LANG']['tl_iao_offer']['text_legend'] = 'Angebot-Texte';
$GLOBALS['TL_LANG']['tl_iao_offer']['status_legend'] = 'Status-Einstellungen';
$GLOBALS['TL_LANG']['tl_iao_offer']['extend_legend'] = 'weitere Einstellungen';
$GLOBALS['TL_LANG']['tl_iao_offer']['notice_legend'] = 'Notiz anlegen';

/**
 * Import / Export-Libs
 */
$GLOBALS['TL_LANG']['tl_iao_offer']['importlib'] = array('Import-Bibliothek auswählen','wählen Sie die Bibliothek die beim Import die Daten korrekt importiert.');
$GLOBALS['TL_LANG']['tl_iao_offer']['importlib_invoiceandoffer'] = 'Invoice and Offer';
$GLOBALS['TL_LANG']['tl_iao_offer']['importlib_phprechnung'] = 'PHPRechnung';

/**
 * Notify
 */
$GLOBALS['TL_LANG']['tl_iao_offer']['Offer_imported'] = 'Es wurden die Angebot-Datensätze aus %s erfogreich importiert';
$GLOBALS['TL_LANG']['tl_iao_offer']['Offer_exported'] = 'Es wurden die Angebot-Datensätze erfogreich exportiert';

/**
 * Select-fiels options
 */
$GLOBALS['TL_LANG']['tl_iao_offer']['status_options'] = array('1'=>'nicht angenommen','2'=>'angenommen');
