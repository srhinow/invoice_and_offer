<?php
/**
 * TL_ROOT/system/modules/invoice_and_offer/languages/de/tl_iao_offer_items.php
 *
 * Contao extension: invoice_and_offer
 * Deutsch translation file
 *
 * @copyright  Sven Rhinow 2014
 * @author     sr-tag Sven Rhinow Webentwicklung <http://www.sr-tag.de>
 * @package    invoice_and_offer
 *
 */

$GLOBALS['TL_LANG']['tl_iao_offer_items']['posten_template'] = array('Template','Posten-Template');
$GLOBALS['TL_LANG']['tl_iao_offer_items']['headline'] = array('Bezeichnung','Posten-Bezeichnung');
$GLOBALS['TL_LANG']['tl_iao_offer_items']['type'] = array('Inhaltstyp','neuer Eintrag oder PDF-Seitentrenner');
$GLOBALS['TL_LANG']['tl_iao_offer_items']['headline_to_pdf'] = array('Bezeichnung in PDF aufnhemen','wenn die Bezeichnung in der PDF-Datei vor dem Text aufgenommen werden soll.');
$GLOBALS['TL_LANG']['tl_iao_offer_items']['alias'] = array('Alias','');
$GLOBALS['TL_LANG']['tl_iao_offer_items']['author'] = array('Posten-Ersteller','');
$GLOBALS['TL_LANG']['tl_iao_offer_items']['text'] = array('Beschreibung','hier wird die Beschreibung zu dem Posten eingegeben.');
$GLOBALS['TL_LANG']['tl_iao_offer_items']['price'] = array('Preis','geben Sie hier den Preis an.');
$GLOBALS['TL_LANG']['tl_iao_offer_items']['vat_incl'] = array('Preis-Angabe mit oder ohne MwSt.','(brutto / netto)');
$GLOBALS['TL_LANG']['tl_iao_offer_items']['count'] = array('Anzahl','die Anzahl wird mit dem Preis multipliziert');
$GLOBALS['TL_LANG']['tl_iao_offer_items']['amountStr'] = array('Art der Anzahl','');
$GLOBALS['TL_LANG']['tl_iao_offer_items']['vat'] = array('MwSt.','Art der MwSt. zu diesem Posten.');
$GLOBALS['TL_LANG']['tl_iao_offer_items']['operator'] = array('Zahlungsart','soll dieser Posten hinzugefügt oder abgezogen werden?');
$GLOBALS['TL_LANG']['tl_iao_offer_items']['pagebreak_after'] = array('Seitenumbruch nach diesem Posten','Seitenumbruch nach diesem Posten erzwingen.');

/**
 * Global Operation
 */
$GLOBALS['TL_LANG']['tl_iao_offer_items']['new'] = array('Neuer Posten','Ein neuen Posten anlegen');
$GLOBALS['TL_LANG']['tl_iao_offer_items']['pdf'] = array('PDF generieren','eine PDF zu dieses Angebotes generieren');

/**
 * Operations
 */
$GLOBALS['TL_LANG']['tl_iao_offer_items']['edit'] = array('Posten bearbeiten','Element ID %s bearbeiten');
$GLOBALS['TL_LANG']['tl_iao_offer_items']['copy'] = array('Posten duplizieren','Element ID %s duplizieren');
$GLOBALS['TL_LANG']['tl_iao_offer_items']['delete'] = array('Posten löschen','Element ID %s löschen');
$GLOBALS['TL_LANG']['tl_iao_offer_items']['deleteConfirm'] = 'Soll der Posten ID %s wirklich gelöscht werden?!';
$GLOBALS['TL_LANG']['tl_iao_offer_items']['show'] = array('Details anzeigen','Details des Postens ID %s anzeigen');
$GLOBALS['TL_LANG']['tl_iao_offer_items']['postentemplate'] = array('diesen Posten als Vorlage speichern','Posten ID %s als Vorlage speichern');
$GLOBALS['TL_LANG']['tl_iao_offer_items']['tstamp'] = array('Letzte Änderung','');
$GLOBALS['TL_LANG']['tl_iao_offer_items']['published'] = array('veröffentlicht','');

$GLOBALS['TL_LANG']['tl_iao_offer_items']['templates_legend'] = 'Template-Auswahl';
$GLOBALS['TL_LANG']['tl_iao_offer_items']['title_legend'] = 'Grundeinstellungen';
$GLOBALS['TL_LANG']['tl_iao_offer_items']['item_legend'] = 'Posten-Daten';
$GLOBALS['TL_LANG']['tl_iao_offer_items']['publish_legend'] = 'Veröffentlichung';
$GLOBALS['TL_LANG']['tl_iao_offer_items']['type_legend'] = 'Elementtyp-Einstellung';

$GLOBALS['TL_LANG']['tl_iao_offer_items']['vat_incl_percents'] = array(1 => 'netto', 2 => 'brutto');
$GLOBALS['TL_LANG']['tl_iao_offer_items']['operators'] = array('+' => '+ (addieren)', '-' => '- (subtrahieren)');
$GLOBALS['TL_LANG']['tl_iao_offer_items']['type_options'] = array('item'=>'Eintrag','devider'=>'PDF-Trenner');
