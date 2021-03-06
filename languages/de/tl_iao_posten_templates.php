<?php
/**
 * TL_ROOT/system/modules/invoice_and_offer/languages/de/modules.php 
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
 
 $GLOBALS['TL_LANG']['tl_iao_posten_templates']['title'] = array('Bezeichnung','Bezeichnung der Vorlage');
 $GLOBALS['TL_LANG']['tl_iao_posten_templates']['text'] = array('Vorlagen-Text',''); 
 $GLOBALS['TL_LANG']['tl_iao_posten_templates']['position'] = array('Position',''); 
 $GLOBALS['TL_LANG']['tl_iao_posten_templates']['headline'] = array('Bezeichnung','Posten-Bezeichnung');
 $GLOBALS['TL_LANG']['tl_iao_posten_templates']['headline_to_pdf'] = array('Bezeichnung in PDF aufnhemen','wenn die Bezeichnung in der PDF-Datei vor dem Text aufgenommen werden soll.'); 
 $GLOBALS['TL_LANG']['tl_iao_posten_templates']['text'] = array('Beschreibung','hier wird die Beschreibung zu dem Posten eingegeben.');
 $GLOBALS['TL_LANG']['tl_iao_posten_templates']['price'] = array('Preis','geben Sie hier den Preis an.');
 $GLOBALS['TL_LANG']['tl_iao_posten_templates']['vat_incl'] = array('Preis-Angabe mit oder ohne MwSt.','(brutto / netto)');
 $GLOBALS['TL_LANG']['tl_iao_posten_templates']['count'] = array('Anzahl','die Anzahl wird mit dem Preis multipliziert');
 $GLOBALS['TL_LANG']['tl_iao_posten_templates']['amountStr'] = array('Art der Anzahl','');
 $GLOBALS['TL_LANG']['tl_iao_posten_templates']['operator'] = array('Zahlungsart','soll dieser Posten hinzugefügt oder abgezogen werden?'); 
 $GLOBALS['TL_LANG']['tl_iao_posten_templates']['vat'] = array('MwSt.','Art der MwSt. zu diesem Posten.');  
  
 $GLOBALS['TL_LANG']['tl_iao_posten_templates']['new'] = array('Neue Posten-Vorlage','Eine neue Vorlage anlegen');   
 $GLOBALS['TL_LANG']['tl_iao_posten_templates']['edit'] = array('Posten-Vorlage bearbeiten','Vorlage ID %s bearbeiten');
 $GLOBALS['TL_LANG']['tl_iao_posten_templates']['copy'] = array('Posten-Vorlage duplizieren','Vorlage ID %s duplizieren');
 $GLOBALS['TL_LANG']['tl_iao_posten_templates']['delete'] = array('posten-Vorlage löschen','Vorlage ID %s löschen');
   
 $GLOBALS['TL_LANG']['tl_iao_posten_templates']['title_legend'] = 'Grundeinstellungen';
 $GLOBALS['TL_LANG']['tl_iao_posten_templates']['item_legend'] = 'Posten-Daten';
 $GLOBALS['TL_LANG']['tl_iao_posten_templates']['publish_legend'] = 'Veröffentlichung';
 
  $GLOBALS['TL_LANG']['tl_iao_posten_templates']['amountStr_options'] = array('piece'=>'Stück','flaterate'=>'Pauschale', 'days'=>'Tag(e)','hour'=>'Stunde(n)', 'minutes'=>'Minute(n)','year'=>'Jahr(e)');
 $GLOBALS['TL_LANG']['tl_iao_posten_templates']['vat_incl_percents'] = array(1 => 'netto', 2 => 'brutto');
 $GLOBALS['TL_LANG']['tl_iao_posten_templates']['vat_options'] = array(19 => '19% MwSt.', 7 => '7% MwSt.', 0=>'ohne MwSt.');  
 $GLOBALS['TL_LANG']['tl_iao_posten_templates']['operators'] = array('+' => '+ (addieren)', '-' => '- (subtrahieren)');
 $GLOBALS['TL_LANG']['tl_iao_posten_templates']['type_options'] = array('item'=>'Eintrag','devider'=>'PDF-Trenner');
 ?>