<?php
/**
 * TL_ROOT/system/modules/invoice_and_offer/languages/de/tl_iao_agreements.php
 *
 * Contao extension: invoice_and_offer
 * Deutsch translation file
 *
 * @copyright  Sven Rhinow 2014
 * @author     sr-tag Sven Rhinow Webentwicklung <http://www.sr-tag.de>
 * @package    invoice_and_offer
 *
 */

$GLOBALS['TL_LANG']['tl_iao_agreements']['new'] = array('Neuer Vertrag','Einen neuen Vertrag anlegen');
$GLOBALS['TL_LANG']['tl_iao_agreements']['edit'] = array('Vertrag bearbeiten','Vertrag ID %s bearbeiten');
$GLOBALS['TL_LANG']['tl_iao_agreements']['copy'] = array('Vertrag duplizieren','Vertrag ID %s duplizieren');
$GLOBALS['TL_LANG']['tl_iao_agreements']['delete'] = array('Vertrag löschen','Vertrag ID %s löschen');
$GLOBALS['TL_LANG']['tl_iao_agreements']['deleteConfirm'] = 'Soll die Vertrag ID %s wirklich gelöscht werden?!';
$GLOBALS['TL_LANG']['tl_iao_agreements']['show'] = array('Details anzeigen','Details der Vertrag ID %s anzeigen');

$GLOBALS['TL_LANG']['tl_iao_agreements']['title'] = array('Bezeichnung','Bezeichnung des Elementes');
$GLOBALS['TL_LANG']['tl_iao_agreements']['agreement_pdf_file'] = array('Vertrag','Vertrag als PDF-Datei zuweisen.');
$GLOBALS['TL_LANG']['tl_iao_agreements']['member'] = array('Kunde','Adresse aus gespeicherten Kunden in nachstehendes Feld befüllen');
$GLOBALS['TL_LANG']['tl_iao_agreements']['address_text'] = array('Mahnungs-Adresse','Adresse die in der Mahnungs-PDF-Datei geschrieben wird.');
$GLOBALS['TL_LANG']['tl_iao_agreements']['published'] = array('veröffnentlicht/ versendet.','');
$GLOBALS['TL_LANG']['tl_iao_agreements']['status'] = array('Status dieses Vertrages','');
$GLOBALS['TL_LANG']['tl_iao_agreements']['periode'] = array('Periode','geben Sie die Periode in Form von strtotime ein z.B. +1 year = 1 Jahr weiter, +2 months = weitere 2 Monate');
$GLOBALS['TL_LANG']['tl_iao_agreements']['agreement_date'] = array('Vertrag seit','');
$GLOBALS['TL_LANG']['tl_iao_agreements']['beginn_date'] = array('Zyklusbeginn','');
$GLOBALS['TL_LANG']['tl_iao_agreements']['end_date'] = array('Zyklusende','');
$GLOBALS['TL_LANG']['tl_iao_agreements']['terminated_date'] = array('gekündigt zum','');
$GLOBALS['TL_LANG']['tl_iao_agreements']['new_generate'] = array('den neuen Zyklus setzen','');
$GLOBALS['TL_LANG']['tl_iao_agreements']['sendEmail'] = array('Email-Erinnerung einrichten','');
$GLOBALS['TL_LANG']['tl_iao_agreements']['remind_before'] = array('erinnern vor Ablauf des Vertrags-Zyklus','Die Angaben im strtotime-Format z.B. -3 weeks');
$GLOBALS['TL_LANG']['tl_iao_agreements']['email_from'] = array('Email-Sender','');
$GLOBALS['TL_LANG']['tl_iao_agreements']['email_to'] = array('Email-Empfänger','');
$GLOBALS['TL_LANG']['tl_iao_agreements']['email_subject'] = array('Email-Betreff','');
$GLOBALS['TL_LANG']['tl_iao_agreements']['email_text'] = array('Email-Text','');
$GLOBALS['TL_LANG']['tl_iao_agreements']['notice'] = array('Notiz','');
$GLOBALS['TL_LANG']['tl_iao_agreements']['price'] = array('Preis (&euro;)','den Bruttopreis für die Listenansicht');

$GLOBALS['TL_LANG']['tl_iao_agreements']['execute_date'] = array('Ausgeführt am','Dieses Angabe wird vom Finanzamt vorgeschrieben um die Vorsteuer zu ziehen.');
$GLOBALS['TL_LANG']['tl_iao_agreements']['expiry_date'] = array('Begleichen bis','Das Datum nachdem die Mahnungsstufen anfangen.');
$GLOBALS['TL_LANG']['tl_iao_agreements']['invoice_pdf_file'] = array('Mahnungsdatei','Wenn hier eine Datei angegeben wurde wird diese statt einer generierten ausgegeben. Unter normalen Umständen sollte dieses Feld leer bleiben. Es ist hauptsächlich für Importe gedacht.');
$GLOBALS['TL_LANG']['tl_iao_agreements']['paid_on_date'] = array('Bezahlt am','Das Datum an dem die Zahlung auf dem Konto eingegangen ist.');

$GLOBALS['TL_LANG']['tl_iao_agreements']['toggle'] = 'Vertrag als aktiv/ nicht aktiv markieren';

/**
 * Legend
 */
$GLOBALS['TL_LANG']['tl_iao_agreements']['address_legend'] = 'Adress-Angaben';
$GLOBALS['TL_LANG']['tl_iao_agreements']['status_legend'] = 'Status-Einstellungen';
$GLOBALS['TL_LANG']['tl_iao_agreements']['email_legend'] = 'Email-Einstellungen';
$GLOBALS['TL_LANG']['tl_iao_agreements']['other_legend'] = 'weitere Einstellungen';
$GLOBALS['TL_LANG']['tl_iao_agreements']['notice_legend'] = 'Notiz anlegen';

/**
 * Select-fiels options
 */
$GLOBALS['TL_LANG']['tl_iao_agreements']['status_options'] = array('1'=>'aktiv','2'=>'gekündigt');
