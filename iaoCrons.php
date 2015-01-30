<?
/**
 * PHP version 5
 * @package    invoice_and_offer
 * @license    LGPL
 * @filesource
 */
class iaoCrons extends Frontend
{

	public function sendAgreementRemindEmail()
	{

		$agrObj = $this->Database->prepare('SELECT * FROM `tl_iao_agreements` WHERE `sendEmail`=? AND `email_date`=?')
					->execute(1,'');

		if($agrObj->numRows > 0)
		{
			$today = time();
			while($agrObj->next())
			{
				$beforeTime = strtotime($agrObj->remind_before,$agrObj->end_date);

				if($today >= $beforeTime)
				{
					//send email
					$email = new Email();
					$email->from = $agrObj->email_from;
					$email->subject = $agrObj->email_subject;
					$email->text = $agrObj->email_text;
					if($email->sendTo($agrObj->email_to))
					{
						//set this item that reminder is allready send
						$set = array
						(
							'email_date' => $today
						);

						$this->Database->prepare('UPDATE `tl_iao_agreements` %s WHERE `id`=?')
							->set($set)
							->execute($agrObj->id);

						$this->log('Vertrag-Erinnerung von '.$agrObj->title.' gesendet','iaoCrons sendAgreementRemindEmail()','CRON');
					}
				}
			}
		}
	}
}
