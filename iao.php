<?php

/**
 *
 * @copyright  Sven Rhinow 2011-2014
 * @author     sr-tag Sven Rhinow Webentwicklung <http://www.sr-tag.de>
 * @package    invoice_and_offer
 * @license    LGPL
 * @filesource
 */


/**
 * Class iao
 * Provide methods to handle invoice_and_offer-module.
 */
class iao extends Backend
{
	/**
	* set $GLOBAL['TL_CONFIG'] - invoice_and_offer - Settings
	* Kompatibilität zu älteren Versionen
	*/
	public function setIAOSettings($id = 1)
	{
		$this->import('Database');

		if( (int) $id > 0)
		{
			$dbObj = $this->Database->prepare('SELECT * FROM `tl_iao_settings` WHERE `id`=?')
							->limit(1)
							->execute($id);
		}
		else
		{
			$dbObj = $this->Database->prepare('SELECT * FROM `tl_iao_settings` WHERE `fallback`=?')
							->limit(1)
							->execute(1);
		}

		if($dbObj->numRows > 0)
		{
			//hole alle Feldbezeichnungen
			$fields = $this->Database->listFields('tl_iao_settings');

			// diese Felder nicht als $GLOBAL['TL_CONFIG'] - Eintrag setzen (bl = Blacklist)
			$bl_fields = array('id', 'tstamp', 'name', 'fallback');

			foreach($fields as $k => $field)
			{
				if(in_array($field['name'], $bl_fields)) continue;
				$GLOBALS['TL_CONFIG'][$field['name']] = $dbObj->$field['name'];
			}
		}
	}

	/**
	 * Get netto-price from brutto
	 * @param float
	 * @param integer
	 * @return float
	 */
	public function getNettoPrice($brutto,$vat)
	{
		return ($brutto * 100) / ($vat + 100);
	}

	/**
	 * Get brutto-price from netto
	 * @param float
	 * @param integer
	 * @return float
	 */
	public function getBruttoPrice($netto,$vat)
	{
		return ($netto / 100) * ($vat + 100);
	}

	public function getPriceStr($price,$currencyStr = 'iao_currency')
	{
		// if((float)$price < 0) return ;
		return number_format((float)$price,2,',','.').' '.$GLOBALS['TL_CONFIG'][$currencyStr];
	}

    /**
    * change Contao-Placeholder with html-characters
    * @param integer
    * @return integer
    */
    public function changeTags($text)
    {
		// replace [&] etc.
		$text = $this->restoreBasicEntities($text);

		// replace Inserttags
		$text = $this->replaceInsertTags($text);

		return $text;
	}

	/**
	 * replace Insert-Tags from IAO - DB-Tables
	 *
	 * @param string
	 * return
	 */
	public function changeIAOTags($strBuffer,$sector,$id)
	{
		$this->import('Database');

		$tags = preg_split('/\{\{([^\}]+)\}\}/', $strBuffer, -1, PREG_SPLIT_DELIM_CAPTURE);
		$strBuffer = '';
		$arrCache = array();

		for($_rit=0; $_rit<count($tags); $_rit=$_rit+2)
		{
			$strBuffer .= $tags[$_rit];
			$strTag = $tags[$_rit+1];

			// Skip empty tags
			if ($strTag == '')
			{
				continue;
			}

			// Load value from cache array
			if (isset($arrCache[$strTag]))
			{
				$strBuffer .= $arrCache[$strTag];
				continue;
			}

			$parts = trimsplit('::', $strTag);
			$parts[0] = strip_tags($parts[0]);
			$parts[1] = strip_tags($parts[1]);

			$arrCache[$strTag] = '';

			// Replace the tag
			switch (strtolower($parts[0]))
			{
				// get table - Data
				case 'member':

					//relative from this section
					switch(strtolower($sector))
					{
						case 'invoice':
							$this->infoObj = $this->Database->prepare('SELECT `m`.* FROM `tl_member` `m` LEFT JOIN `tl_iao_invoice` `i` ON `m`.`id` = `i`.`member` WHERE `i`.`id`=?')
															->limit(1)
															->execute($id);

							$this->infoObj->gender = ($this->infoObj->gender == 'male') ? $GLOBALS['TL_LANG']['tl_iao']['salution']['male'] : $GLOBALS['TL_LANG']['tl_iao']['salution']['female'];

							$arrCache[$strTag] = $this->infoObj->$parts[1];
						break;
						case 'offer':
							$this->infoObj = $this->Database->prepare('SELECT `m`.* FROM `tl_member` `m` LEFT JOIN `tl_iao_offer` `o` ON `m`.`id` = `o`.`member` WHERE `o`.`id`=?')
															->limit(1)
															->execute($id);

							$this->infoObj->gender = ($this->infoObj->gender == 'male') ? $GLOBALS['TL_LANG']['tl_iao']['salution']['male'] : $GLOBALS['TL_LANG']['tl_iao']['salution']['female'];

							$arrCache[$strTag] = $this->infoObj->$parts[1];
						break;
						case 'credit':
							$this->infoObj = $this->Database->prepare('SELECT `m`.* FROM `tl_member` `m` LEFT JOIN `tl_iao_credit` `c` ON `m`.`id` = `c`.`member` WHERE `c`.`id`=?')
															->limit(1)
															->execute($id);

							$this->infoObj->gender = ($this->infoObj->gender == 'male') ? $GLOBALS['TL_LANG']['tl_iao']['salution']['male'] : $GLOBALS['TL_LANG']['tl_iao']['salution']['female'];

							$arrCache[$strTag] = $this->infoObj->$parts[1];

						break;
						case 'reminder':
							$this->infoObj = $this->Database->prepare('SELECT `m`.* FROM `tl_member` `m` LEFT JOIN `tl_iao_reminder` `r` ON `m`.`id` = `r`.`member` WHERE `r`.`id`=?')
															->limit(1)
															->execute($id);

							$this->infoObj->gender = ($this->infoObj->gender == 'male') ? $GLOBALS['TL_LANG']['tl_iao']['salution']['male'] : $GLOBALS['TL_LANG']['tl_iao']['salution']['female'];
							$arrCache[$strTag] = $this->infoObj->$parts[1];
						break;
					  }
				break;
				case 'invoice':

					//relative from this section
					switch(strtolower($sector))
					{
						case 'invoice':
							$this->infoObj = $this->Database->prepare('SELECT `i`.* FROM `tl_iao_invoice` `i`  WHERE `i`.`id`=?')
															->limit(1)
															->execute($id);

							$this->infoObj->expiry_date = date($GLOBALS['TL_CONFIG']['dateFormat'],$this->infoObj->expiry_date);
							$this->infoObj->brutto = $this->getPriceStr($this->infoObj->price_brutto);
							$this->infoObj->netto = $this->getPriceStr($this->infoObj->price_netto);

							$arrCache[$strTag] = $this->infoObj->$parts[1];
						break;
						case 'reminder':
							$this->infoObj = $this->Database->prepare('SELECT `i`.* FROM `tl_iao_invoice` `i` LEFT JOIN `tl_iao_reminder` `r` ON `i`.`id` = `r`.`invoice_id` WHERE `r`.`id`=?')
															->limit(1)
															->execute($id);

							$this->infoObj->expiry_date = date($GLOBALS['TL_CONFIG']['dateFormat'],$this->infoObj->expiry_date);
							$this->infoObj->brutto = $this->getPriceStr($this->infoObj->price_brutto);
							$this->infoObj->netto = $this->getPriceStr($this->infoObj->price_netto);

							$arrCache[$strTag] = $this->infoObj->$parts[1];
						break;
					}
				break;
				case 'reminder':

					//relative from this section
					switch(strtolower($sector))
					{
						case 'reminder':
							$this->infoObj = $this->Database->prepare('SELECT `r`.* FROM `tl_iao_reminder` `r`  WHERE `r`.`id`=?')
															->limit(1)
															->execute($id);

							$this->infoObj->periode_date = date($GLOBALS['TL_CONFIG']['dateFormat'],$this->infoObj->periode_date);
							$step = !strlen($this->infoObj->step) ? 1 : $this->infoObj->step;

							$this->infoObj->postageStr = (((int)($this->infoObj->postage) <= 0)) ? '' : $this->getPriceStr($this->infoObj->postage);
							$this->infoObj->taxStr = ((int)($this->infoObj->tax) > 0) ? $this->infoObj->tax.'%' : '';

							$this->infoObj->sum = $this->getReminderSum($id);
							$this->infoObj->sumStr = $this->getPriceStr($this->infoObj->sum);

							$arrCache[$strTag] = $this->infoObj->$parts[1];
						break;
		          }
				break;
				case 'credit':
					//relative from this section
					switch(strtolower($sector))
					{
						case 'credit':
							$this->infoObj = $this->Database->prepare('SELECT `tl_iao_credit`.* FROM `tl_iao_credit` `c`  WHERE `c`.`id`=?')
															->limit(1)
															->execute($id);
							$arrCache[$strTag] = $this->infoObj->$parts[1];
						break;
					}
				break;
				case 'iao':
					switch(strtolower($parts[1]))
					{
						case 'current_date':
							$arrCache[$strTag] = date($GLOBALS['TL_CONFIG']['dateFormat']);
						break;
					}
				break;
			}
			$strBuffer .= $arrCache[$strTag];
		}
		return $strBuffer;
	}

    /**
    * get the sum incl. tax and postage
    * @param object
    * @return integer
    */
	public function getReminderSum($reminderId)
	{
		if($reminderId)
		{
			$this->reminderObj = $this->Database->prepare('SELECT `r`.*, `i`.`price_netto` `netto`, `i`.`price_brutto` `brutto` FROM `tl_iao_reminder` `r` LEFT JOIN `tl_iao_invoice` `i` ON `r`.`invoice_id` = `i`.`id`  WHERE `r`.`id`=?')
												->limit(1)
												->execute($reminderId);

			$step = !strlen($this->reminderObj->step) ? 1 : $this->reminderObj->step;
			$postage = (float) $this->reminderObj->postage;
			$tax = (float) $this->reminderObj->tax;
			$price = ($this->reminderObj->tax_typ == 1) ? $this->reminderObj->brutto : $this->reminderObj->netto;
			$unpaid = ((float)($this->reminderObj->unpaid) > 0) ? (float)$this->reminderObj->unpaid : (float)$price;
			$sum = $unpaid;

			if((float) $tax > 0) $sum = (($sum * (100+$tax))/100);
			if((float) $postage > 0) $sum += $postage;

			return $sum;
		}
    }

	/**
	 * get the next periode-date
	 * @param object
	 * @return integer
	 */
	public function  getPeriodeDate($reminderObj)
	{
		$lastReminderObj = $this->Database->prepare('SELECT * FROM `tl_iao_reminder` WHERE `invoice_id`=? AND `id`!=? ORDER BY `id` DESC')
											->limit(1)
											->execute($reminderObj->invoice_id,$reminderObj->id);

		$lastPeriodeDate = ($lastReminderObj->periode_date) ? $lastReminderObj->periode_date : time();
		$time = ($reminderObj->periode_date == 0) ? $lastPeriodeDate : $reminderObj->periode_date;
		$step = (!strlen($reminderObj->step)) ? 1 : $reminderObj->step;
		$dur = (int) ($GLOBALS['TL_CONFIG']['iao_reminder_'.$step.'_duration']) > 0 ? (int) $GLOBALS['TL_CONFIG']['iao_reminder_'.$step.'_duration'] : 14;
		$nextDate = ($this->noWE($time,$dur) > time()) ? $this->noWE($time,$dur) : $this->noWE(time(),$dur);

        return $nextDate;
    }

	/**
	 * set monday if date on weekend
	 * @param integer
	 * @param integer
	 * @return integer
	 */
	public function noWE($time,$dur)
	{
		//auf Sonabend prüfen wenn ja dann auf Montag setzen
		if(date('N',$time+($dur * 24 * 60 * 60)) == 6)  $dur = $dur+2;

		//auf Sontag prüfen wenn ja dann auf Montag setzen
		if(date('N',$time+($dur * 24 * 60 * 60)) == 7)  $dur = $dur+1;

		$nextDate = $time+($dur * 24 * 60 * 60);

		return	$nextDate;
    }


	/**
	 * get the Reminder-Status (Recall = 1, first reminder = 2, second reminder = 3 third reminder = 4)
	 * @param integer
	 * @return integer
	 */
	public function getReminderStatus($invoiceId = 0)
	{
		if($invoiceId == 0) return false;

		$status = 1; //erinnerung
		$this->import('Database');

		$statusObj = $this->Database->prepare('SELECT count(*) as c FROM `tl_iao_reminder` WHERE `invoice_id`=? AND `published`=1 ORDER BY `id` DESC')
									->execute($invoiceId);

		if($statusObj->numRows > 0) return  $statusObj->c;
    }

	/**
	 * fill Reminderfields
	 * @param integer
	 * @return integer
	 */
	public function fillReminderFields($invoiceID = 0, $reminderObj)
	{

		$objMember = $this->Database->prepare('SELECT `m`.*,`i`.`price_brutto`,`i`.`address_text`,`i`.`invoice_id_str` FROM `tl_iao_invoice` as `i` LEFT JOIN `tl_member` as `m` ON `i`.member = `m`.`id` WHERE `i`.`id`=?')
									->limit(1)
									->execute($invoiceID);

		if(!empty($objMember->address_text))
		{
			$address_text = $objMember->address_text;
		}
		else
		{
			$address_text = '<p>'.$objMember->company.'<br />'.($objMember->gender!='' ? $GLOBALS['TL_LANG']['tl_iao_reminder']['gender'][$objMember->gender].' ':'').($objMember->title ? $objMember->title.' ':'').$objMember->firstname.' '.$objMember->lastname.'<br />'.$objMember->street.'</p>';
			$address_text .='<p>'.$objMember->postal.' '.$objMember->city.'</p>';
		}

		$testStepObj = $this->Database->prepare('SELECT `step`,`sum` FROM `tl_iao_reminder` WHERE `invoice_id`=? AND `id`!=? ORDER BY `id` DESC')
										->limit(1)
										->execute($invoiceID,$reminderObj->id);

		$newStep = ($testStepObj->numRows > 0) ? $testStepObj->step +1 : 1;

		//set an error if newStep > 4
		if($newStep > 4)
		{
			$_SESSION['TL_ERROR'][] = $GLOBALS['TL_LANG']['tl_iao_reminder']['to_much_steps'].$objMember->invoice_id_str;
			$_SESSION['TL_CONFIRM'] = '';
			setcookie('BE_PAGE_OFFSET', 0, 0, '/');
			$this->redirect(str_replace('&act=create', '', $this->Environment->request));
		}

		$newUnpaid = (($testStepObj->numRows > 0) && ((int) $testStepObj->sum > 0)) ? $testStepObj->sum : $objMember->price_brutto;
		$tax =  $GLOBALS['TL_CONFIG']['iao_reminder_'.$newStep.'_tax'];
		$postage =  $GLOBALS['TL_CONFIG']['iao_reminder_'.$newStep.'_postage'];
		$periode_date = $this->getPeriodeDate($reminderObj);

		$set = array
		(
			'title' => $GLOBALS['TL_LANG']['tl_iao_reminder']['steps'][$newStep].'::'.$invoiceID,
			'address_text' => $address_text,
			'member' =>  $objMember->id,
			'unpaid' => $newUnpaid,
			'step' => $newStep,
			'text' => $GLOBALS['TL_CONFIG']['iao_reminder_'.$newStep.'_text'],
			'periode_date' => $periode_date,
			'tax' => $tax,
			'postage' =>  $postage
		);

		$this->Database->prepare('UPDATE `tl_iao_reminder` %s WHERE `id`=?')
						->set($set)
						->execute($reminderObj->id);

		//set sum after other facts is saved
		$text_finish = $this->changeIAOTags($GLOBALS['TL_CONFIG']['iao_reminder_'.$newStep.'_text'],'reminder',$reminderObj->id);
		$text_finish = $this->changeTags($text_finish);

		$set = array
		(
	    	'sum' => $this->getReminderSum($reminderObj->id),
	    	'text_finish' => $text_finish
		);

		$this->Database->prepare('UPDATE `tl_iao_reminder` %s WHERE `id`=?')
						->set($set)
						->execute($reminderObj->id);

		//update invoice-data with current reminder-step
		$this->Database->prepare('UPDATE `tl_iao_invoice` SET `reminder_id` = ?  WHERE `id`=?')
						->execute($reminderObj->id, $invoiceID);
	}

}
