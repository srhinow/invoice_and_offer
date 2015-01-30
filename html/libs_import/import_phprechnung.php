<?php

/**
 *
 * PHP version 5
 * @filesource
 *
 * Class import_phprechnung
 *
 * Provide methods to handle invoice_and_offer-module.
 * @copyright  Sven Rhinow 2013
 * @author     sr-tag Sven Rhinow Webentwicklung <http://www.sr-tag.de>
 * @package    invoice_and_offer
 * @license    LGPL
 *
 */

class import_phprechnung extends Backend
{
	/**
	 * Extract the Entry files and write the data to the database
	 * @param array
	 * @param array
	 */
	public function extractInvoiceFiles($Files, $parentInstance)
	{
		$csv = null;
		$this->import('Files');
		$this->import('Database');
		$this->import('String');

		$seperators = array('comma'=>',','semicolon'=>';','tabulator'=>'\t','linebreak'=>'\n');

		// Lock the tables
		$arrLocks = array('tl_iao_invoice' => 'WRITE','tl_iao_invoice_items' => 'WRITE','tl_member'=>'READ');
		$this->Database->lockTables($arrLocks);

		/**
		*import Invoice-File
		*/
		$handle = $this->Files->fopen($Files['invoice'],'r');
		$counter = 0;

		while (($data = fgetcsv ($handle, 1000, ',')) !== FALSE )
		{
			$counter ++;
			if($counter == 1 && $this->Input->post('drop_first_row')==1) continue;

			//timestamp aus nem Datefield erstellen
			$invDateParts = explode('-',$data[2]);
			$invDate = (count($invDateParts)>0 && is_array($invDateParts)) ? mktime(0,0,0,$invDateParts[1],$invDateParts[2],$invDateParts[0]) : time();

			//PDF-Datei pruefen
			$pdf_dir = $this->Input->post('pdf_import_dir');
			$pdf_file_name = str_replace('-','',$data[2]).'-'.$data[0].'.pdf';
			$pdf_file_path = '';

			if(is_dir(TL_ROOT . '/' .$pdf_dir) && is_file(TL_ROOT . '/' .$pdf_dir.'/'.$pdf_file_name)) $pdf_file_path	= $pdf_dir.'/'.$pdf_file_name;

			//get member-id (customer) from myid
			$customer_id = '';
			if(strlen($data[1])>0)
			{
				$customerObj = $this->Database->prepare('SELECT `id` FROM `tl_member` WHERE `myid`=?')
							->execute($data[1]);
				if($customerObj->id) $customer_id = $customerObj->id;
			}

			$InvoiceSet = array
			(
				'tstamp'  =>  $invDate,
				'invoice_tstamp' => $invDate,
				'execute_date' => $invDate,
				'title' => 'PHPRechnung-'.$data[0],
				'alias' => standardize('PHPRechnung-'.$data[0]),
				'address_text' => $this->fillAdressText($customer_id),
				'invoice_id' => $data[0],
				'invoice_id_str' => str_replace('-','',$data[2]).'-'.$data[0],
				'invoice_pdf_file' =>  $pdf_file_path,
				'notice' => $data[21],
				'member' => $customer_id,
				'after_text' => $data[4],
				'price_netto' => $data[16],
				'price_brutto' => $parentInstance->getBruttoPrice($data[16],19),
				'published' => 1,
				'status' => 1
			);

			// Update the datatbase
			if($this->Input->post('drop_exist_entries')==1)  $this->Database->prepare('DELETE FROM `tl_iao_invoice` WHERE `invoice_id`=?')->execute($data[0]);
			$this->Database->prepare("INSERT INTO `tl_iao_invoice` %s")->set($InvoiceSet)->execute();
		}

		/**
		*import Invoice-Posten-File
		*/
		$handle = $this->Files->fopen($Files['invoice_items'],'r');
		$counter = 0;

		while (($data = fgetcsv ($handle, 1000, ',')) !== FALSE )
		{
			$counter ++;
			if($counter == 1 && $this->Input->post('drop_first_row')==1) continue;

			// get compare invoice
			$parentObj = $this->Database->prepare('SELECT * FROM `tl_iao_invoice` WHERE `invoice_id`=?')
						->limit(1)
						->execute($data[2]);

			//at the first cycle drop exisist entries from offer
			if($counter == 1 && $this->Input->post('drop_exist_entries')==1)  $this->Database->prepare('DELETE FROM `tl_iao_invoice_items` WHERE `pid`=?')->execute($parentObj->id);

			$vat = ($data[10]*100);

			// only safe when parent exist
			if($parentObj->numRows)
			{
				$InvoiceItemSet = array
				(
					'pid' => $parentObj->id,
					'author' => 1,
					'tstamp'  =>  $parentObj->tstamp,
					'headline' => $this->String->substr($data[4],20),
					'alias' => standardize($this->String->substr($data[4],20)),
					'text' => $data[4],
					'count' => $data[5],
					'price' => $data[6],
					'price_netto' => $parentInstance->getNettoPrice($data[6]*$data[5],$vat),
					'price_brutto' => $data[6]*$data[5],
					'vat' =>  $vat,
					'vat_incl' => 2,
					'published'=> 1
				);

				// Update the datatbase
				$this->Database->prepare("INSERT INTO tl_iao_invoice_items %s")->set($InvoiceItemSet)->execute();
			}

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
	 * @param array
	 */
	public function extractOfferFiles($Files, $parentInstance)
	{
		$csv = null;
		$this->import('Files');
		$this->import('Database');
		$this->import('String');

		$separators = array('comma'=>',','semicolon'=>';','tabulator'=>'\t','linebreak'=>'\n');

		// Lock the tables
		$arrLocks = array('tl_iao_offer' => 'WRITE','tl_iao_offer_items' => 'WRITE','tl_member'=>'READ');
		$this->Database->lockTables($arrLocks);

		/**
		*import Offer-File
		*/
		$handle = $this->Files->fopen($Files['offer'],'r');
		$counter = 0;

		while (($data = fgetcsv ($handle, 1000, $separators[$this->Input->post('separator')])) !== FALSE )
		{
			$counter ++;
			if($counter == 1 && $this->Input->post('drop_first_row')==1) continue;

			//timestamp aus nem Datefield erstellen
			$invDateParts = explode('-',$data[3]);
			$invDate = (count($invDateParts)>0 && is_array($invDateParts)) ? mktime(0,0,0,$invDateParts[1],$invDateParts[2],$invDateParts[0]) : time();

			//PDF-Datei pruefen
			$pdf_dir = $this->Input->post('pdf_import_dir');
			$pdf_file_name = str_replace('-','',$data[3]).'-'.$data[0].'.pdf';
			$pdf_file_path = '';
			if(is_dir(TL_ROOT . '/' .$pdf_dir) && is_file(TL_ROOT . '/' .$pdf_dir.'/'.$pdf_file_name)) $pdf_file_path	= $pdf_dir.'/'.$pdf_file_name;

			//get member-id (customer) from myid
			$customer_id = '';
			if(strlen($data[1])>0)
			{
				$customerObj = $this->Database->prepare('SELECT `id` FROM `tl_member` WHERE `myid`=?')
							->execute($data[1]);

				if($customerObj->id) $customer_id = $customerObj->id;
			}

			$OfferSet = array
			(
				'tstamp'  =>  $invDate,
				'offer_tstamp' => $invDate,
				'expiry_date' => $this->generateExpiryDate(),
				'title' => 'PHPRechnung-Angebot-'.$data[0],
				'alias' => standardize('PHPRechnung-Angebot-'.$data[0]),
				'address_text' => $this->fillAdressText($customer_id),
				'offer_id' => $data[0],
				'offer_id_str' => str_replace('-','',$data[3]).'-'.$data[0],
				'offer_pdf_file' =>  $pdf_file_path,
				'notice' => $data[23],
				'member' => $customer_id,
				'before_text' => $data[35],
				'after_text' => $data[5],
				'price_netto' => $data[18],
				'price_brutto' => $data[22],
				'published' => 1,
				'status' => 1
			);

			// Update the datatbase
			if($this->Input->post('drop_exist_entries')==1)  $this->Database->prepare('DELETE FROM `tl_iao_offer` WHERE `offer_id`=?')->execute($data[0]);
			$this->Database->prepare("INSERT INTO `tl_iao_offer` %s")->set($OfferSet)->execute();
		}

		/**
		*import Offer-Posten-File
		*/
		$handle = $this->Files->fopen($Files['offer_items'],'r');
		$counter = 0;


		while (($data = fgetcsv ($handle, 1000, $separators[$this->Input->post('separator')])) !== FALSE )
		{
    		$counter ++;
		    if($counter == 1 && $this->Input->post('drop_first_row')==1) continue;

			// get compare offer
			$parentObj = $this->Database->prepare('SELECT * FROM `tl_iao_offer` WHERE `offer_id`=?')
						->limit(1)
						->execute($data[1]);

			//at the first cycle drop exisist entries from offer
			if($counter == 1 && $this->Input->post('drop_exist_entries')==1)  $this->Database->prepare('DELETE FROM `tl_iao_offer_items` WHERE `pid`=?')->execute($parentObj->id);

			$vat = ($data[10]*100);
			$iao = new iao();

			// only safe when parent exist
			if($parentObj->numRows)
			{
				$OfferItemSet = array
				(
					'pid' => $parentObj->id,
					'author' => 1,
					'tstamp'  =>  $parentObj->tstamp,
					'headline' => $this->String->substr($data[4],40),
					'alias' => standardize($this->String->substr($data[4],40)),
					'text' => $data[4],
					'count' => $data[5],
					'price' => $data[6],
					'price_netto' => $iao->getNettoPrice($data[6]*$data[5],$vat),
					'price_brutto' => $data[6]*$data[5],
					'vat' =>  $vat,
					'vat_incl' => 2,
					'published'=> 1
				);

				// Update the datatbase
				$this->Database->prepare("INSERT INTO tl_iao_offer_items %s")->set($OfferItemSet)->execute();
			}

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

        /**
        * fill date-Field if this empty
        * @param mixed
        * @param object
        * @return date
        */
        public function  generateExpiryDate($varValue)
        {

			if($varValue==0)
			{
				$format = ($GLOBALS['TL_CONFIG']['iao_offer_expiry_date']) ? $GLOBALS['TL_CONFIG']['iao_offer_expiry_date'] : 'd:m+3:Y';
				$parts = explode(':',$format);

				$part['day'] =  substr($parts[0],1);
				$part['month'] =  substr($parts[1],1);
				$part['year'] =  substr($parts[2],1);

				$varValue = date('Y-m-d',mktime(0, 0, 0, date('n')+$part['month'],date('d')+$part['day'], date('Y')+$part['year']));
			}
			return  $varValue;
        }
}
