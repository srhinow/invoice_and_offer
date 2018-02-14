<?php
/**
 * Run in a custom namespace, so the class can be replaced
 */
namespace iao;

/**
 * Reads and writes Offers
 *
 * @property integer $id
 * @property integer $tstamp
 * @property string  $title
 *
 * @method static IaoReminderModel|null findById($id, $opt=array())
 * @method static IaoReminderModel|null findByIdOrAlias($val, $opt=array())
 * @method static IaoReminderModel|null findOneBy($col, $val, $opt=array())
 * @method static IaoReminderModel|null findOneByTstamp($val, $opt=array())
 * @method static IaoReminderModel|null findOneByTitle($val, $opt=array())

 *
 * @method static \Model\Collection|IaoReminderModel[]|IaoReminderModel|null findByTstamp($val, $opt=array())
 * @method static \Model\Collection|IaoReminderModel[]|IaoReminderModel|null findByTitle($val, $opt=array())
 * @method static \Model\Collection|IaoReminderModel[]|IaoReminderModel|null findBy($col, $val, $opt=array())
 * @method static \Model\Collection|IaoReminderModel[]|IaoReminderModel|null findAll($opt=array())
 *
 * @method static integer countById($id, $opt=array())
 *
 * @author Leo Feyer <https://github.com/leofeyer>
 */


class IaoReminderModel extends \Model
{
	/**
	 * Table name
	 * @var string
	 */
	protected static $strTable = 'tl_iao_reminder';

	/**
	 * Find published reminder by their parent ID
	 *
	 * @param integer $id    		An invoice-ID
	 * @param integer $memberId    	An User-ID from actual FrontendUser
	 * @param integer $intLimit    	An optional limit
	 * @param integer $intOffset   	An optional offset
	 * @param array   $arrOptions  	An optional options array
	 *
	 * @return iaoInvoiceModel[]|iaoInvoiceModel|null A collection of models or null if there are no news
	 */
	public static function findOnePublishedByMember($id, $memberId, array $arrOptions=array())
	{
		if (empty($id) || empty($memberId))
		{
			return null;
		}

		$t = static::$strTable;

		// Rechnnung nach  aktuellem Mitglied filtern
		$arrColumns = array("$t.id=".$id);

		// Rechnnung nach  aktuellem Mitglied filtern
		$arrColumns[] = "$t.member=".$memberId;

		// veroeffentlicht
		$arrColumns[] = "$t.published='1'";

		return static::findOneBy($arrColumns, null, $arrOptions);
	}

	/**
	 * Find published reminder by their parent ID
	 *
	 * @param integer $memberId    	An User-ID from actual FrontendUser
	 * @param string  $status		optional filter
	 * @param integer $intLimit    	An optional limit
	 * @param integer $intOffset   	An optional offset
	 * @param array   $arrOptions  	An optional options array
	 *
	 * @return null A collection of models or null if there are no news
	 */
	public static function findPublishedByMember($memberId, $status='', $intLimit=0, $intOffset=0, array $arrOptions=array())
	{
		if (empty($memberId))
		{
			return null;
		}

		$t = static::$strTable;

		// Rechnnung nach  aktuellem Mitglied filtern
		$arrColumns = array("$t.member=".$memberId);

		// veroeffentlicht
		$arrColumns[] = "$t.published='1'";
		
		// falls angegeben nach Status der Rechnung filtern
		if ($status != '')
		{
			$arrColumns[] = "$t.status=".$status;
		}

		if (!isset($arrOptions['order']))
		{
			$arrOptions['order']  = "$t.tstamp DESC";
		}

		$arrOptions['limit']  = $intLimit;
		$arrOptions['offset'] = $intOffset;

		return static::findBy($arrColumns, null, $arrOptions);
	}

	/**
	 * Count published reminder by their member (Frontend-User) ID
	 *
	 * @param integer $memberId    		An Project-ID from actual FrontendUser
	 * @param string  $status		optional filter
	 * @param array   $arrOptions  	An optional options array
	 *
	 * @return integer The number of Invoice items
	 */
	public static function countPublishedByMember($memberId, $status='', array $arrOptions=array())
	{
		if (empty($memberId))
		{
			return null;
		}

		$t = static::$strTable;

		// Rechnnung nach  aktuellem Mitglied filtern
		$arrColumns = array("$t.member=".$memberId);

		// veroeffentlicht
		$arrColumns[] = "$t.published='1'";


		//falls angegeben nach Status der Rechnung filtern
		if ($status != '')
		{
			$arrColumns[] = "$t.status=".$status;
		}

		return static::countBy($arrColumns, null, $arrOptions);
	}

	/**
	 * Find published reminder by their parent (project) ID
	 *
	 * @param integer $pid    		An Project-ID from actual FrontendUser
	 * @param string  $status		optional filter
	 * @param integer $intLimit    	An optional limit
	 * @param integer $intOffset   	An optional offset
	 * @param array   $arrOptions  	An optional options array
	 *
	 * @return \Model\Collection|\NewsModel[]|\NewsModel|null A collection of models or null if there are no news
	 */
	public static function findPublishedByPid($pid, $status='', $intLimit=0, $intOffset=0, array $arrOptions=array())
	{
		if (empty($pid))
		{
			return null;
		}

		$t = static::$strTable;

		// nach Project filtern
		$arrColumns = array("$t.pid =" . $pid );

		// veroeffentlicht
		$arrColumns[] = "$t.published='1'";

		//falls angegeben nach Status der Rechnung filtern
		if ($status != '')
		{
			$arrColumns[] = "$t.status=".$status;
		}

		if (!isset($arrOptions['order']))
		{
			$arrOptions['order']  = "$t.tstamp DESC";
		}

		$arrOptions['limit']  = $intLimit;
		$arrOptions['offset'] = $intOffset;

		return static::findBy($arrColumns, null, $arrOptions);
	}

	/**
	 * Count published reminder by their parent (project) ID
	 *
	 * @param integer $pid    		An Project-ID from actual FrontendUser
	 * @param string  $status		optional filter
	 * @param array   $arrOptions  	An optional options array
	 *
	 * @return integer The number of news items
	 */
	public static function countPublishedByPid($pid , $status='', array $arrOptions=array())
	{
		if (empty($pid))
		{
			return null;
		}

		$t = static::$strTable;

		// nach Project filtern
		$arrColumns = array("$t.pid =" . $pid );

		// veroeffentlicht
		$arrColumns[] = "$t.published='1'";

		//falls angegeben nach Status der Rechnung filtern
		if ($status != '')
		{
			$arrColumns[] = "$t.status=".$status;
		}

		return static::countBy($arrColumns, null, $arrOptions);
	}

}
