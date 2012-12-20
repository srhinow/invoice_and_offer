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
 * Class iao_reminder
 *
 * Provide methods to handle invoice_and_offer-module.
 * @copyright  Sven Rhinow 2012
 * @author     sr-tag Sven Rhinow Webentwicklung <http://www.sr-tag.de>
 * @package    invoice_and_offer
 * @license    LGPL
 */
class iao_reminder extends Backend
{
	/**
	 * check all Invoices of reminder
	 */
	public function checkReminder()
	{		
	    $this->import('Database');
	    $this->import('iao');
	    
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
		  
		  $this->iao->fillReminderFields($invoiceObj->id, $reminderObj); 
		   
               }
            }
	    $_SESSION['TL_ERROR'] = '';
	    $_SESSION['TL_CONFIRM'][] = $GLOBALS['TL_LANG']['tl_iao_reminder']['Reminder_is_checked']; 	    
	    setcookie('BE_PAGE_OFFSET', 0, 0, '/');		
	    $this->redirect(str_replace('&key=checkReminder', '', $this->Environment->request));
	
	}
}
