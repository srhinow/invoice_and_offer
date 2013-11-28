<?php
/**
 * TL_ROOT/system/modules/invoice_and_offer/languages/de/tl_iao_credit.php
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

$GLOBALS['TL_LANG']['tl_iao_credit']['setting_id']	=	array('Konfiguration','');
$GLOBALS['TL_LANG']['tl_iao_credit']['title']	=	array('Bezeichnung','Bezeichnung des Elementes');
$GLOBALS['TL_LANG']['tl_iao_credit']['alias']	=	array('Alias','');

$GLOBALS['TL_LANG']['tl_iao_credit']['member']	=	array('Kunde','Adresse aus gespeicherten Kunden in nachstehendes Feld befüllen');
$GLOBALS['TL_LANG']['tl_iao_credit']['address_text']	=	array('Gutschrift-Adresse','Adresse die in der Gutschrift-PDF-Datei geschrieben wird.');
$GLOBALS['TL_LANG']['tl_iao_credit']['before_text']	=	array('Text vor den Posten','');
$GLOBALS['TL_LANG']['tl_iao_credit']['before_template']	=	array('Text-Template vor den Posten','');
$GLOBALS['TL_LANG']['tl_iao_credit']['after_text']	=	array('Text nach den Posten','');
$GLOBALS['TL_LANG']['tl_iao_credit']['after_template']	=	array('Text-Template nach den Posten','');
$GLOBALS['TL_LANG']['tl_iao_credit']['published']	=	array('veröffnentlicht/ versendet.','');
$GLOBALS['TL_LANG']['tl_iao_credit']['status']	=	array('Status dieser Gutschrift','');
$GLOBALS['TL_LANG']['tl_iao_credit']['noVat']	=	array('keine MwSt. ausweisen','z.B. Gutschrift in nicht Bundesrepublik Deutschland');
$GLOBALS['TL_LANG']['tl_iao_credit']['price_netto']	=	array('Gutschrift-Höhe (Netto)','');
$GLOBALS['TL_LANG']['tl_iao_credit']['price_brutto']	=	array('Gutschrift-Höhe (Brutto)','');
$GLOBALS['TL_LANG']['tl_iao_credit']['member']	=	array('Kunde','');
$GLOBALS['TL_LANG']['tl_iao_credit']['notice']	=	array('Notiz','Diese Notizen werden ausschließlich im Backend verwendet.');

$GLOBALS['TL_LANG']['tl_iao_credit']['credit_date']	=	array('Gutschriftdatum','wenn es leer bleibt dann wird das aktuelle Datum eingetragen. Unter normalen Umständen sollte dieses Feld leer bleiben. Es ist hauptsächlich für Importe gedacht.');
$GLOBALS['TL_LANG']['tl_iao_credit']['credit_tstamp']	=	array('Gutschriftdatum als Timestamp','Wenn es leer bleibt dann wird der Timestamp vom Gutschriftdatum eingetragen. Unter normalen Umständen sollte dieses Feld leer bleiben. Es ist hauptsächlich für Importe gedacht.');
$GLOBALS['TL_LANG']['tl_iao_credit']['credit_id']	=	array('Gutschrift-ID','Dieses Feld wird hauptsächlich zum hochzählen der nächsten Gutschrift benötigt.');
$GLOBALS['TL_LANG']['tl_iao_credit']['credit_id_str']	=	array('Gutschrift-ID-Name','Dieses Feld wird für den PDF-Namen und direkt auf der Gutschrift ausgegeben.');
$GLOBALS['TL_LANG']['tl_iao_credit']['expiry_date']	=	array('Gültig bis','Diese Gutschrift ist bis zu diesem Datum gültig.');
$GLOBALS['TL_LANG']['tl_iao_credit']['credit_pdf_file']	=	array('Gutschriftdatei','Wenn hier eine Datei angegeben wurde wird diese statt einer generierten ausgegeben. Unter normalen Umständen sollte dieses Feld leer bleiben. Es ist hauptsächlich für Importe gedacht.');

$GLOBALS['TL_LANG']['tl_iao_credit']['toggle']	=	'Gutschrift als akzeptiert/ nicht akzeptiert markieren';
$GLOBALS['TL_LANG']['tl_iao_credit']['gender']['male']	=	'Herr';
$GLOBALS['TL_LANG']['tl_iao_credit']['gender']['female']	=	'Frau';

/**
 * Buttons
 */
$GLOBALS['TL_LANG']['tl_iao_credit']['new']	=	array('Neue Gutschrift','Eine neue Gutschrift anlegen');
$GLOBALS['TL_LANG']['tl_iao_credit']['edit']	=	array('Gutschrift bearbeiten','Gutschrift ID %s bearbeiten');
$GLOBALS['TL_LANG']['tl_iao_credit']['copy']	=	array('Gutschrift duplizieren','Gutschrift ID %s duplizieren');
$GLOBALS['TL_LANG']['tl_iao_credit']['delete']	=	array('Gutschrift löschen','Gutschrift ID %s löschen');
$GLOBALS['TL_LANG']['tl_iao_credit']['deleteConfirm']	=	'Soll die Gutschrift ID %s wirklich gelöscht werden?!';
$GLOBALS['TL_LANG']['tl_iao_credit']['show']	=	array('Details anzeigen','Details der Gutschrift ID %s anzeigen');
$GLOBALS['TL_LANG']['tl_iao_credit']['pdf']	=	array('PDF generieren','eine PDF zu dieser Gutschrift generieren');

/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_iao_credit']['settings_legend']	=	'Konfiguration-Zuweisung';
$GLOBALS['TL_LANG']['tl_iao_credit']['credit_id_legend']	=	'Gutschrift-Einstellungen';
$GLOBALS['TL_LANG']['tl_iao_credit']['address_legend']	=	'Adress-Angaben';
$GLOBALS['TL_LANG']['tl_iao_credit']['text_legend']	=	'Gutschrift-Texte';
$GLOBALS['TL_LANG']['tl_iao_credit']['extend_legend']	=	'weitere Einstellungen';
$GLOBALS['TL_LANG']['tl_iao_credit']['status_legend']	=	'Status-Einstellungen';
$GLOBALS['TL_LANG']['tl_iao_credit']['notice_legend']	=	'Notiz anlegen';
