<?php
/**
 * TL_ROOT/system/modules/invoice_and_offer/languages/de/tl_iao_templates_items.php
 *
 * Contao extension: invoice_and_offer
 * Deutsch translation file
 *
 * @copyright  Sven Rhinow 2014
 * @author     sr-tag Sven Rhinow Webentwicklung <http://www.sr-tag.de>
 * @package    invoice_and_offer
 *
 */

$GLOBALS['TL_LANG']['tl_iao_templates_items']['title'] = array('Bezeichnung','Bezeichnung der Vorlage');
$GLOBALS['TL_LANG']['tl_iao_templates_items']['text'] = array('Vorlagen-Text','');
$GLOBALS['TL_LANG']['tl_iao_templates_items']['position'] = array('Position','');
$GLOBALS['TL_LANG']['tl_iao_templates_items']['headline'] = array('Bezeichnung','Posten-Bezeichnung');
$GLOBALS['TL_LANG']['tl_iao_templates_items']['headline_to_pdf'] = array('Bezeichnung in PDF aufnhemen','wenn die Bezeichnung in der PDF-Datei vor dem Text aufgenommen werden soll.');
$GLOBALS['TL_LANG']['tl_iao_templates_items']['text'] = array('Beschreibung','hier wird die Beschreibung zu dem Posten eingegeben.');
$GLOBALS['TL_LANG']['tl_iao_templates_items']['price'] = array('Preis','geben Sie hier den Preis an.');
$GLOBALS['TL_LANG']['tl_iao_templates_items']['vat_incl'] = array('Preis-Angabe mit oder ohne MwSt.','(brutto / netto)');
$GLOBALS['TL_LANG']['tl_iao_templates_items']['count'] = array('Anzahl','die Anzahl wird mit dem Preis multipliziert');
$GLOBALS['TL_LANG']['tl_iao_templates_items']['amountStr'] = array('Art der Anzahl','');
$GLOBALS['TL_LANG']['tl_iao_templates_items']['operator'] = array('Zahlungsart','soll dieser Posten hinzugefügt oder abgezogen werden?');
$GLOBALS['TL_LANG']['tl_iao_templates_items']['vat'] = array('MwSt.','Art der MwSt. zu diesem Posten.');
$GLOBALS['TL_LANG']['tl_iao_templates_items']['new'] = array('Neue Posten-Vorlage','Eine neue Vorlage anlegen');
$GLOBALS['TL_LANG']['tl_iao_templates_items']['edit'] = array('Posten-Vorlage bearbeiten','Vorlage ID %s bearbeiten');
$GLOBALS['TL_LANG']['tl_iao_templates_items']['copy'] = array('Posten-Vorlage duplizieren','Vorlage ID %s duplizieren');
$GLOBALS['TL_LANG']['tl_iao_templates_items']['delete'] = array('posten-Vorlage löschen','Vorlage ID %s löschen');

$GLOBALS['TL_LANG']['tl_iao_templates_items']['title_legend'] = 'Grundeinstellungen';
$GLOBALS['TL_LANG']['tl_iao_templates_items']['item_legend'] = 'Posten-Daten';
$GLOBALS['TL_LANG']['tl_iao_templates_items']['publish_legend'] = 'Veröffentlichung';

$GLOBALS['TL_LANG']['tl_iao_templates_items']['amountStr_options'] = array('piece'=>'Stück','flaterate'=>'Pauschale', 'days'=>'Tag(e)','hour'=>'Stunde(n)', 'minutes'=>'Minute(n)','year'=>'Jahr(e)');
$GLOBALS['TL_LANG']['tl_iao_templates_items']['vat_incl_percents'] = array(1 => 'netto', 2 => 'brutto');
$GLOBALS['TL_LANG']['tl_iao_templates_items']['vat_options'] = array(19 => '19% MwSt.', 7 => '7% MwSt.', 0=>'ohne MwSt.');
$GLOBALS['TL_LANG']['tl_iao_templates_items']['operators'] = array('+' => '+ (addieren)', '-' => '- (subtrahieren)');
$GLOBALS['TL_LANG']['tl_iao_templates_items']['type_options'] = array('item'=>'Eintrag','devider'=>'PDF-Trenner');
