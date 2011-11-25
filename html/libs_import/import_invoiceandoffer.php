<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2011 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  Leo Feyer 2005-2011
 * @author     Leo Feyer <http://www.contao.org>
 * @package    Backend
 * @license    LGPL
 * @filesource
 */


/**
 * Class iao
 *
 * Provide methods to handle invoice_and_offer-module.
 * @copyright  Sven Rhinow 2011
 * @author     sr-tag Sven Rhinow Webentwicklung <http://www.sr-tag.de>
 * @package    invoice_and_offer
 * @license    LGPL
 */
class import_invoiceandoffer extends Backend
{
	/**
	 * Extract the Entry files and write the data to the database
	 * @param array
	 * @param instance
	 */
	public function extractInvoiceFiles($Files, $parentInstance)
	{
		$csv = null;
		$this->import('Files');
		$this->import('Database');
		$this->import('String');
						      			
		$seperators = array('comma'=>',','semicolon'=>';','tabulator'=>'\t','linebreak'=>'\n');
		
		// Lock the tables
		$arrLocks = array('tl_iao_invoice' => 'WRITE','tl_iao_invoice_items' => 'WRITE');
		$this->Database->lockTables($arrLocks);
		
		//get DB-Fields as arrays		
		$invoice_fields = $this->Database->listFields('tl_iao_invoice');
		$invoice_items_fields = $this->Database->listFields('tl_iao_invoice_items');		
		
		/**
		*import Invoice-File
		*/
		$handle = $this->Files->fopen($Files['invoice'],'r');
		$counter = 0;
		$csvhead = array();
		$InvoiceSet = '';
		
		while (($data = fgetcsv ($handle, 1000, $seperators[$this->Input->post('separator')])) !== FALSE ) 
		{	
	              $counter ++;
		      if($counter == 1 && $this->Input->post('drop_first_row')==1)
		      {
			  $csvhead = $data;
			  continue; 		      		       
		      }
		      foreach($csvhead AS $headk => $headv) $headfields[$headv]=$headk;
		      
		      $lineA  = array();
		      foreach($invoice_fields as  $i_field)
		      {
		          
		          //exclude index Fields
			  if($i_field['type']=='index') continue;
		          $actkey = $headfields[$i_field['name']];
		          
		          $lineA[$i_field['name']] =  $data[$actkey];		          		          
		          
		      }
		      $InvoiceSet = $lineA;

		      //PDF-Datei pruefen   
		      $pdf_dir = $this->Input->post('pdf_import_dir');
		      $pdf_file_name = $OfferSet['invoice_id_str'].'.pdf';
		      $OfferSet['invoice_pdf_file'] = (is_dir(TL_ROOT . '/' .$pdf_dir) && is_file(TL_ROOT . '/' .$pdf_dir.'/'.$pdf_file_name)) ? $pdf_file_path = $pdf_dir.'/'.$pdf_file_name : ''; 
		      
  
		      // Update the datatbase
		      if($this->Input->post('drop_exist_entries')==1)  $this->Database->prepare('DELETE FROM `tl_iao_invoice` WHERE `id`=?')->execute($InvoiceSet['id']);
 		      $this->Database->prepare("INSERT INTO `tl_iao_invoice` %s")->set($InvoiceSet)->execute();		     		         
		}

		/**
		*import Invoice-Posten-File
		*/
		$handle = $this->Files->fopen($Files['invoice_items'],'r');
		$counter = 0;
		$csvhead = array();
		$InvoiceItemSet = '';
		
		while (($data = fgetcsv ($handle, 1000, $seperators[$this->Input->post('separator')])) !== FALSE ) 
		{
	              $counter ++;
		      if($counter == 1 && $this->Input->post('drop_first_row')==1)		      
		      {
			  $csvhead = $data;
			  continue; 		      		       
		      }		      
		      foreach($csvhead AS $headk => $headv) $headfields[$headv]=$headk; 		      
		      	      		
		      $lineA  = array();
		      foreach($invoice_items_fields as  $ii_field)
		      {
		          
		          //exclude index Fields
			  if($ii_field['type']=='index') continue;
		          $actkey = $headfields[$ii_field['name']];
		          
		          $lineA[$ii_field['name']] =  $data[$actkey];		          		          
		          
		      }
		      $InvoiceItemSet = $lineA;
		      
		      // get compare invoice		
/*                      $parentObj = $this->Database->prepare('SELECT * FROM `tl_iao_invoice` WHERE `invoice_id`=?')
						  ->limit(1)
						  ->execute($InvoiceSet['invoice_id']);*/
                    
		      // Update the datatbase
		      if($this->Input->post('drop_exist_entries')==1)  $this->Database->prepare('DELETE FROM `tl_iao_invoice_items` WHERE `id`=?')->execute($InvoiceItemSet['id']);
		      $this->Database->prepare("INSERT INTO `tl_iao_invoice_items` %s")->set($InvoiceItemSet)->execute();		      		      			      		

		}
		// Unlock the tables
		$this->Database->unlockTables();
		
		// Notify the user
		$FilesStr = implode(', ',$Files);
		$_SESSION['TL_ERROR'] = '';
		$_SESSION['TL_CONFIRM'][] = sprintf($GLOBALS['TL_LANG']['tl_iao_invoice']['Invoice_imported'], $FilesStr);


		// Redirect
		setcookie('BE_PAGE_OFFSET', 0, 0, '/');		
		$this->redirect(str_replace('&key=importInvoices', '', $this->Environment->request));
	}
	
	/**
	 * Extract the Entry files and write the data to the database
	 * @param array
	 * @param instance
	 */
	public function extractOfferFiles($Files, $parentInstance)
	{
		$csv = null;
		$this->import('Files');
		$this->import('Database');
		$this->import('String');
						      			
		$seperators = array('comma'=>',','semicolon'=>';','tabulator'=>'\t','linebreak'=>'\n');
		
		// Lock the tables
		$arrLocks = array('tl_iao_offer' => 'WRITE','tl_iao_offer_items' => 'WRITE');
		$this->Database->lockTables($arrLocks);
		
		//get DB-Fields as arrays		
		$invoice_fields = $this->Database->listFields('tl_iao_offer');
		$invoice_items_fields = $this->Database->listFields('tl_iao_offer_items');		
		
		/**
		*import Invoice-File
		*/
		$handle = $this->Files->fopen($Files['offer'],'r');
		$counter = 0;
		$csvhead = array();
		$OfferSet = '';
		
		while (($data = fgetcsv ($handle, 1000, $seperators[$this->Input->post('separator')])) !== FALSE ) 
		{	
	              $counter ++;
		      if($counter == 1 && $this->Input->post('drop_first_row')==1)
		      {
			  $csvhead = $data;
			  continue; 		      		       
		      }
		      foreach($csvhead AS $headk => $headv) $headfields[$headv]=$headk;
		      
		      $lineA  = array();
		      foreach($invoice_fields as  $i_field)
		      {
		          
		          //exclude index Fields
			  if($i_field['type']=='index') continue;
		          $actkey = $headfields[$i_field['name']];
		          
		          $lineA[$i_field['name']] =  $data[$actkey];		          		          
		          
		      }
		      $OfferSet = $lineA;

		      //PDF-Datei pruefen   
		      $pdf_dir = $this->Input->post('pdf_import_dir');
		      $pdf_file_name = $OfferSet['offer_id_str'].'.pdf';
		      $OfferSet['offer_pdf_file'] = (is_dir(TL_ROOT . '/' .$pdf_dir) && is_file(TL_ROOT . '/' .$pdf_dir.'/'.$pdf_file_name)) ? $pdf_file_path = $pdf_dir.'/'.$pdf_file_name : ''; 
		      
  
		      // Update the datatbase
		      if($this->Input->post('drop_exist_entries')==1)  $this->Database->prepare('DELETE FROM `tl_iao_offer` WHERE `id`=?')->execute($OfferSet['id']);
 		      $this->Database->prepare("INSERT INTO `tl_iao_offer` %s")->set($OfferSet)->execute();		     		         
		}

		/**
		*import Offer-Posten-File
		*/
		$handle = $this->Files->fopen($Files['offer_items'],'r');
		$counter = 0;
		$csvhead = array();
		$OfferItemSet = '';
		
		while (($data = fgetcsv ($handle, 1000, $seperators[$this->Input->post('separator')])) !== FALSE ) 
		{
	              $counter ++;
		      if($counter == 1 && $this->Input->post('drop_first_row')==1)		      
		      {
			  $csvhead = $data;
			  continue; 		      		       
		      }		      
		      foreach($csvhead AS $headk => $headv) $headfields[$headv]=$headk; 		      
		      	      		
		      $lineA  = array();
		      foreach($invoice_items_fields as  $ii_field)
		      {
		          
		          //exclude index Fields
			  if($ii_field['type']=='index') continue;
		          $actkey = $headfields[$ii_field['name']];
		          
		          $lineA[$ii_field['name']] =  $data[$actkey];		          		          
		          
		      }
		      $OfferItemSet = $lineA;
		      
		      // get compare invoice		
/*                      $parentObj = $this->Database->prepare('SELECT * FROM `tl_iao_invoice` WHERE `invoice_id`=?')
						  ->limit(1)
						  ->execute($InvoiceSet['invoice_id']);*/
                    
		      // Update the datatbase
		      if($this->Input->post('drop_exist_entries')==1)  $this->Database->prepare('DELETE FROM `tl_iao_offer_items` WHERE `id`=?')->execute($OfferItemSet['id']);
		      $this->Database->prepare("INSERT INTO `tl_iao_offer_items` %s")->set($OfferItemSet)->execute();		      		      			      		

		}
		// Unlock the tables
		$this->Database->unlockTables();
		
		// Notify the user
		$FilesStr = implode(', ',$Files);
		$_SESSION['TL_ERROR'] = '';
		$_SESSION['TL_CONFIRM'][] = sprintf($GLOBALS['TL_LANG']['tl_iao_offer']['Offer_imported'], $FilesStr);


		// Redirect
		setcookie('BE_PAGE_OFFSET', 0, 0, '/');		
		$this->redirect(str_replace('&key=importOffer', '', $this->Environment->request));
	}
	
	public function fillAdressText($varValue)
	{		    
		if(strlen($varValue)<=0) return $varValue;
		 
		$objMember = $this->Database->prepare('SELECT * FROM `tl_member` WHERE `id`=?')
					    ->limit(1)
					    ->execute($varValue);
					    
		$text = '<p>'.$objMember->company.'<br />'.($objMember->gender!='' ? $GLOBALS['TL_LANG']['tl_iao_invoice']['gender'][$objMember->gender].' ':'').($objMember->title ? $objMember->title.' ':'').$objMember->firstname.' '.$objMember->lastname.'<br />'.$objMember->street.'</p>';
		$text .='<p>'.$objMember->postal.' '.$objMember->city.'</p>';			    		    
		    
		return $text;
	}
}