<?php
/**
 * TL_ROOT/system/modules/invoice_and_offer/languages/de/tl_iao_reminder.php
 *
 * Contao extension: invoice_and_offer
 * Deutsch translation file
 *
 * @copyright  Sven Rhinow 2014
 * @author     sr-tag Sven Rhinow Webentwicklung <http://www.sr-tag.de>
 * @package    invoice_and_offer
 *
 */

$GLOBALS['TL_LANG']['tl_iao_reminder']['title'] = array('Bezeichnung','Bezeichnung des Elementes');
$GLOBALS['TL_LANG']['tl_iao_reminder']['alias'] = array('Alias','');
$GLOBALS['TL_LANG']['tl_iao_reminder']['member'] = array('Kunde','Adresse aus gespeicherten Kunden in nachstehendes Feld befüllen');
$GLOBALS['TL_LANG']['tl_iao_reminder']['address_text'] = array('Mahnungs-Adresse','Adresse die in der Mahnungs-PDF-Datei geschrieben wird.');
$GLOBALS['TL_LANG']['tl_iao_reminder']['text'] = array('Mahnungs-Text','');
$GLOBALS['TL_LANG']['tl_iao_reminder']['text_finish'] = array('Mahnungs-Text (Vorschau)','');
$GLOBALS['TL_LANG']['tl_iao_reminder']['published'] = array('veröffnentlicht/ versendet.','');
$GLOBALS['TL_LANG']['tl_iao_reminder']['status'] = array('Status dieser Mahnung','');
$GLOBALS['TL_LANG']['tl_iao_reminder']['new'] = array('Neue Erinnerung','Eine neue Erinnerung anlegen');
$GLOBALS['TL_LANG']['tl_iao_reminder']['checkReminder'] = array('Erinnnerungen aktualisieren','Nach neuen Erinnerungen durchsuchen und anlegen.');
$GLOBALS['TL_LANG']['tl_iao_reminder']['edit'] = array('Mahnung bearbeiten','Mahnung ID %s bearbeiten');
$GLOBALS['TL_LANG']['tl_iao_reminder']['copy'] = array('Mahnung duplizieren','Mahnung ID %s duplizieren');
$GLOBALS['TL_LANG']['tl_iao_reminder']['delete'] = array('Mahnung löschen','Mahnung ID %s löschen');
$GLOBALS['TL_LANG']['tl_iao_reminder']['deleteConfirm'] = 'Soll die Mahnung ID %s wirklich gelöscht werden?!';
$GLOBALS['TL_LANG']['tl_iao_reminder']['show'] = array('Details anzeigen','Details der Mahnung ID %s anzeigen');
$GLOBALS['TL_LANG']['tl_iao_reminder']['invoice_id'] = array('Rechnung','wählen Sie hier die Rechnung aus welche im Verzug ist.');
$GLOBALS['TL_LANG']['tl_iao_reminder']['sum'] = array('Mahnung-Höhe (&euro;)','');
$GLOBALS['TL_LANG']['tl_iao_reminder']['member'] = array('Kunde','');
$GLOBALS['TL_LANG']['tl_iao_reminder']['periode_date'] = array('zu zahlen bis','');
$GLOBALS['TL_LANG']['tl_iao_reminder']['notice'] = array('Notiz','');
$GLOBALS['TL_LANG']['tl_iao_reminder']['step'] = array('Mahnungs-Schritt','');
$GLOBALS['TL_LANG']['tl_iao_reminder']['unpaid'] = array('Schuld (&euro;)','Die Eingabe muss mit dem Dezimal-Trennzeichen . angelegt werden.');
$GLOBALS['TL_LANG']['tl_iao_reminder']['tax'] = array('Zins','optional');
$GLOBALS['TL_LANG']['tl_iao_reminder']['postage'] = array('Versand/Porto (&euro;)','optional');
$GLOBALS['TL_LANG']['tl_iao_reminder']['reminder_id_str'] = array('Mahnungs-ID-Name','Dieses Feld wird für den PDF-Namen und direkt auf der Mahnung ausgegeben.');
$GLOBALS['TL_LANG']['tl_iao_reminder']['execute_date'] = array('Ausgeführt am','Dieses Angabe wird vom Finanzamt vorgeschrieben um die Vorsteuer zu ziehen.');
$GLOBALS['TL_LANG']['tl_iao_reminder']['expiry_date'] = array('Begleichen bis','Das Datum nachdem die Mahnungsstufen anfangen.');
$GLOBALS['TL_LANG']['tl_iao_reminder']['invoice_pdf_file'] = array('Mahnungsdatei','Wenn hier eine Datei angegeben wurde wird diese statt einer generierten ausgegeben. Unter normalen Umständen sollte dieses Feld leer bleiben. Es ist hauptsächlich für Importe gedacht.');
$GLOBALS['TL_LANG']['tl_iao_reminder']['paid_on_date'] = array('Bezahlt am','Das Datum an dem die Zahlung auf dem Konto eingegangen ist.');
$GLOBALS['TL_LANG']['tl_iao_reminder']['before_template'] = array('Text-Template vor den Posten','');
$GLOBALS['TL_LANG']['tl_iao_reminder']['after_template'] = array('Text-Template nach den Posten','');

$GLOBALS['TL_LANG']['tl_iao_reminder']['toggle'] = 'Mahnung als bezahlt/ nicht bezahlt markieren';
$GLOBALS['TL_LANG']['tl_iao_reminder']['gender']['male'] = 'Herr';
$GLOBALS['TL_LANG']['tl_iao_reminder']['gender']['female'] = 'Frau';
$GLOBALS['TL_LANG']['tl_iao_reminder']['Reminder_is_checked'] = 'Die Erinnerungen wurden erfolgreich aktualisiert.';
$GLOBALS['TL_LANG']['tl_iao_reminder']['to_much_steps'] = 'Es gibt keine weitere Mahnstufe für die Rechnung ';

/**
 * Legend
 */
$GLOBALS['TL_LANG']['tl_iao_reminder']['invoice_legend'] = 'erweiterte Mahnungs-Einstellungen';
$GLOBALS['TL_LANG']['tl_iao_reminder']['address_legend'] = 'Adress-Angaben';
$GLOBALS['TL_LANG']['tl_iao_reminder']['text_legend'] = 'Mahnungs-Texte';
$GLOBALS['TL_LANG']['tl_iao_reminder']['status_legend'] = 'Status-Einstellungen';
$GLOBALS['TL_LANG']['tl_iao_reminder']['notice_legend'] = 'Notiz anlegen';

/**
 * Select-fiels options
 */
$GLOBALS['TL_LANG']['tl_iao_reminder']['steps'] = array('1'=>'Erinnerung', '2'=>'1. Mahnung','3'=>'2. Mahnung','4'=>'3. Mahnung');
$GLOBALS['TL_LANG']['tl_iao_reminder']['status_options'] = array('1'=>'nicht bezahlt','2'=>'bezahlt','3'=>'ruht (keine Mahnungen)');
