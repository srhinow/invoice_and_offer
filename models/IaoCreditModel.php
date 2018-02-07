<?php
/**
 * Run in a custom namespace, so the class can be replaced
 */
namespace iao;

/**
 * Reads and writes Credits
 *
 * @property integer $id
 * @property integer $tstamp
 * @property string  $title
 *
 * @method static IaoCreditModel|null findById($id, $opt=array())
 * @method static IaoCreditModel|null findByIdOrAlias($val, $opt=array())
 * @method static IaoCreditModel|null findOneBy($col, $val, $opt=array())
 * @method static IaoCreditModel|null findOneByTstamp($val, $opt=array())
 * @method static IaoCreditModel|null findOneByTitle($val, $opt=array())

 *
 * @method static \Model\Collection|IaoCreditModel[]|IaoCreditModel|null findByTstamp($val, $opt=array())
 * @method static \Model\Collection|IaoCreditModel[]|IaoCreditModel|null findByTitle($val, $opt=array())
 * @method static \Model\Collection|IaoCreditModel[]|IaoCreditModel|null findBy($col, $val, $opt=array())
 * @method static \Model\Collection|IaoCreditModel[]|IaoCreditModel|null findAll($opt=array())
 *
 * @method static integer countById($id, $opt=array())
 *
 * @author Leo Feyer <https://github.com/leofeyer>
 */


class IaoCreditModel extends \Model
{
	/**
	 * Table name
	 * @var string
	 */
	protected static $strTable = 'tl_iao_credit';

	/**
	 * Find published credit by their parent ID
	 *
	 * @param integer $id    		An invoice-ID
	 * @param integer $memberId    	An User-ID from actual FrontendUser
	 * @param integer $intLimit    	An optional limit
	 * @param integer $intOffset   	An optional offset
	 * @param array   $arrOptions  	An optional options array
	 *
	 * @return IaoCreditModel[]|IaoCreditModel|null A collection of models or null if there are no news
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
	 * Find published credit by their parent ID
	 *
	 * @param integer $memberId    	An User-ID from actual FrontendUser
	 * @param string  $status		optional filter
	 * @param integer $intLimit    	An optional limit
	 * @param integer $intOffset   	An optional offset
	 * @param array   $arrOptions  	An optional options array
	 *
	 * @return IaoCreditModel[]IaoCreditModel|null A collection of models or null if there are no news
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
			$arrOptions['order']  = "$t.credit_tstamp DESC";
		}

		$arrOptions['limit']  = $intLimit;
		$arrOptions['offset'] = $intOffset;

		return static::findBy($arrColumns, null, $arrOptions);
	}

	/**
	 * Count published credit by their member (Frontend-User) ID
	 *
	 * @param integer $pid    		An Project-ID from actual FrontendUser
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
	 * Find published credit by their parent (project) ID
	 *
	 * @param integer $pid    		An Project-ID from actual FrontendUser
	 * @param string  $status		optional filter
	 * @param integer $intLimit    	An optional limit
	 * @param integer $intOffset   	An optional offset
	 * @param array   $arrOptions  	An optional options array
	 *
	 * @return IaoCreditModel[]|IaoCreditModel|null A collection of models or null if there are no news
	 */
	public static function findPublishedByPid($pid, $status='', $intLimit=0, $intOffset=0, array $arrOptions=array())
	{
		if (empty($arrPids))
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
			$arrOptions['order']  = "$t.invoice_tstamp DESC";
		}

		$arrOptions['limit']  = $intLimit;
		$arrOptions['offset'] = $intOffset;

		return static::findBy($arrColumns, null, $arrOptions);
	}

	/**
	 * Count published credit by their parent (project) ID
	 *
	 * @param integer $pid    		An Project-ID from actual FrontendUser
	 * @param string  $status		optional filter
	 * @param array   $arrOptions  	An optional options array
	 *
	 * @return integer The number of news items
	 */
	public static function countPublishedByPid($pid, $status='', array $arrOptions=array())
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
