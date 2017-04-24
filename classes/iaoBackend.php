<?php

/**
 * Run in a custom namespace, so the class can be replaced
 */
namespace iao;

/**
 * Class iaoBackend
 *
 * Parent class for iaoBackend modules.
 * @copyright  Sven Rhinow 2011-2015
 * @author     sr-tag Sven Rhinow Webentwicklung <http://www.sr-tag.de>
 * @package    invoice_and_offer
 */
abstract class iaoBackend extends \iao\iao
{

	/**
	 * get options for tax rates
	 * @param object
	 * @throws Exception
	 */
	public function getTaxRatesOptions($dc)
	{
		$varValue= array();

		$all = $this->Database->prepare('SELECT `value`,`name` FROM `tl_iao_tax_rates`  ORDER BY `sorting` ASC')
				->execute();

		while($all->next())
		{
			$varValue[$all->value] = $all->name;
		}
		return $varValue;
	}

	/**
	 * get options for item units
	 * @param object
	 * @throws Exception
	 */
	public function getItemUnitsOptions($dc)
	{
		$varValue= array();

		$all = $this->Database->prepare('SELECT `value`,`name` FROM `tl_iao_item_units`  ORDER BY `sorting` ASC')
				->execute();

		while($all->next())
		{
			$varValue[$all->value] = $all->name;
		}
		return $varValue;
	}	

	/**
	 * get all members to valid groups
	 * @param object
	 * @throws Exception
	 */
	public function getMemberOptions($dc)
	{
		//fallback
		$setId = ($dc->activeRecord->setting_id)?:1;
		$settings = $this->getSettings($setId);
		$varValue= array();

		if(!$settings['iao_costumer_group'])  return $varValue;

		$member = $this->Database->prepare('SELECT `id`,`groups`,`firstname`,`lastname`,`company` FROM `tl_member` WHERE `iao_group`=?')
						->execute($settings['iao_costumer_group']);

		while($member->next())
		{
			$varValue[$member->id] =  $member->firstname.' '.$member->lastname.' ('.$member->company.')';
		}

		return $varValue;
	}

	/**
	 * get all settings
	 * @param object
	 * @throws Exception
	 */
	public function getSettingOptions($dc)
	{
		$varValue= array();

		$settings = $this->Database->prepare('SELECT `id`,`name` FROM `tl_iao_settings` ORDER BY `fallback` DESC, `name` DESC')
						 ->execute();
		while($settings->next())
		{
			$varValue[$settings->id] =  $settings->name;
		}

		return $varValue;
	}

	/**
	 * get all settings
	 * @param object
	 * @throws Exception
	 */
	public function getProjectOptions($dc)
	{
		$varValue= array();

		$settings = $this->Database->prepare('SELECT `id`,`name` FROM `tl_iao_projects`')->execute();

		while($settings->next())
		{
			$varValue[$settings->id] =  $settings->name;
		}

		return $varValue;
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
		$tax =  $settings['iao_reminder_'.$newStep.'_tax'];
		$postage =  $settings['iao_reminder_'.$newStep.'_postage'];
		$periode_date = $this->getPeriodeDate($reminderObj);

		$set = array
		(
			'title' => $GLOBALS['TL_LANG']['tl_iao_reminder']['steps'][$newStep].'::'.$invoiceID,
			'address_text' => $address_text,
			'member' =>  $objMember->id,
			'unpaid' => $newUnpaid,
			'step' => $newStep,
			'text' => $settings['iao_reminder_'.$newStep.'_text'],
			'periode_date' => $periode_date,
			'tax' => $tax,
			'postage' =>  $postage
		);

		$this->Database->prepare('UPDATE `tl_iao_reminder` %s WHERE `id`=?')
						->set($set)
						->execute($reminderObj->id);

		//set sum after other facts is saved
		$text_finish = $this->changeIAOTags($settings['iao_reminder_'.$newStep.'_text'],'reminder',$reminderObj->id);
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
	* if GET-Param projonly then fill member and address-field
	*/
	public function setMemmberfieldsFromProject($table, $id, $set, $obj)
	{
		if(\Input::get('onlyproj') == 1 && (int) $set['pid'] > 0)
		{
			$objProject = iaoProjectsModel::findProjectByIdOrAlias($set['pid']);

			if($objProject !== null)
			{
				$objMember = \MemberModel::findById($objProject->member);

				$text = '<p>'.$objMember->company.'<br />'.($objMember->gender!='' ? $GLOBALS['TL_LANG']['tl_iao_invoice']['gender'][$objMember->gender].' ':'').($objMember->title ? $objMember->title.' ':'').$objMember->firstname.' '.$objMember->lastname.'<br />'.$objMember->street.'</p>';
				$text .='<p>'.$objMember->postal.' '.$objMember->city.'</p>';

				$set = array
				(
					'member' => $objProject->member,
					'address_text' => $text
				);

				$this->Database->prepare('UPDATE '.$table.' %s WHERE `id`=?')
								->set($set)
								->limit(1)
								->execute($id);
			}
		}
	}


}
