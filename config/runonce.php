<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2017 Sven Rhinow
 * @package invoice_and_offer
 */
class firstProject extends Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->import('Database');
	}

	public function run()
	{
		//Projekt anlegen wenn keins existiert
		$testProjObj = $this->Database->prepare('SELECT * FROM `tl_iao_projects`')->execute();
		if($testInvoicePidObj->numRows < 1)
		{
			$projSet = array('title'=>'--undefined');
			$this->Database->prepare('INSERT INTO `tl_iao_projects` %s')->set($projSet)->execute();
			$insertProjId = $this->Database->insert_id();
		}

		//Angebote mit default Projekt befüllen wenn keins zugewiesen
		$testOfferPidObj = $this->Database->prepare('SELECT * FROM `tl_iao_offer` WHERE `pid`=?')->execute('');
		if($testOfferPidObj->numRows > 0)
		{
			if( (int) $insertProjId > 0)
			{
				$set = array('pid' => $insertProjId);
				$this->Database->prepare('UPDATE `tl_iao_offer` %s WHERE `pid`=?')->set($set)->execute('');
			}
		}

		//Rechnungen mit default Projekt befüllen wenn keins zugewiesen
		$testInvoicePidObj = $this->Database->prepare('SELECT * FROM `tl_iao_invoice` WHERE `pid`=?')->execute('');
		if($testInvoicePidObj->numRows > 0)
		{
			if( (int) $insertProjId > 0)
			{
				$set = array('pid' => $insertProjId);
				$this->Database->prepare('UPDATE `tl_iao_invoice` %s WHERE `pid`=?')->set($set)->execute('');
			}
		}

		//Gutschriften mit default Projekt befüllen wenn keins zugewiesen
		$testCreditPidObj = $this->Database->prepare('SELECT * FROM `tl_iao_credit` WHERE `pid`=?')->execute('');
		if($testCreditPidObj->numRows > 0)
		{
			if( (int) $insertProjId > 0)
			{
				$set = array('pid' => $insertProjId);
				$this->Database->prepare('UPDATE `tl_iao_credit` %s WHERE `pid`=?')->set($set)->execute('');
			}
		}

		//Erinnerungen mit default Projekt befüllen wenn keins zugewiesen
		$testReminderPidObj = $this->Database->prepare('SELECT * FROM `tl_iao_reminder` WHERE `pid`=?')->execute('');
		if($testReminderPidObj->numRows > 0)
		{
			if( (int) $insertProjId > 0)
			{
				$set = array('pid' => $insertProjId);
				$this->Database->prepare('UPDATE `tl_iao_reminder` %s WHERE `pid`=?')->set($set)->execute('');
			}
		}

	}
}

$objRunOnce = new firstProject();
$objRunOnce->run();
