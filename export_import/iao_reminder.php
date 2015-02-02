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
 * Class iao_reminder
 */
class iao_reminder extends \iao\iaoBackend
{
	/**
	 * check all Invoices of reminder
	 */
	public function checkReminder()
	{
		$this->import('Database');

		//get all invoices where is active, not paid and have not reminder
		$invoiceObj = $this->Database->prepare('SELECT * FROM `tl_iao_invoice` WHERE `status`=? AND `published`=? AND `expiry_date`<?')
										->execute(1,1,time());

		if($invoiceObj->numRows > 0)
		{
			while($invoiceObj->next())
			{

				if($invoiceObj->reminder_id == 0)
				{
					$set = array
					(
						'invoice_id' => $invoiceObj->id,
						'status' => $invoiceObj->status,
						'tstamp' => time()
					);
					$reminderID = $this->Database->prepare("INSERT INTO `tl_iao_reminder` %s")->set($set)->execute()->insertId;
				}
				else
				{
					$reminderID = $invoiceObj->reminder_id;
				}

				$reminderObj = $this->Database->prepare('SELECT * FROM `tl_iao_reminder` WHERE `id`=?')
											->limit(1)
						 					->execute($reminderID);

				// only the invoices in past
				if($reminderObj->periode_date > time()) continue;

				// drop all where step > 3. Mahnung
				if($reminderObj->step == 4) continue;

				// drop all where status = 2
				if($reminderObj->status == 2) continue;

				$this->fillReminderFields($invoiceObj->id, $reminderObj);

			}
		}

		$_SESSION['TL_ERROR'] = '';
		$_SESSION['TL_CONFIRM'][] = $GLOBALS['TL_LANG']['tl_iao_reminder']['Reminder_is_checked'];
		setcookie('BE_PAGE_OFFSET', 0, 0, '/');
		$this->redirect(str_replace('&key=checkReminder', '', $this->Environment->request));
	}
}
