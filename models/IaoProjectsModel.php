<?php
/**
 * Run in a custom namespace, so the class can be replaced
 */
namespace iao;

/**
 * for Contao Open Source CMS
 *
 * Copyright (c) 2016 Sven Rhinow
 *
 * @package invoice_and_offer
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


class IaoProjectsModel extends \Model
{
	/**
	 * Table name
	 * @var string
	 */
	protected static $strTable = 'tl_iao_projects';

	/**
	 * Find published news items by their parent ID and ID or alias
	 *
	 * @param mixed $varId      The numeric ID or alias name
	 * @param array $arrOptions An optional options array
	 *
	 * @return \Model|null The NewsModel or null if there are no news
	 */
	public static function findProjectByIdOrAlias($varId, array $arrOptions=array())
	{
		$t = static::$strTable;

		return static::findOneBy('id', $varId, $arrOptions);
	}

	/**
	 * Find bbk-items for pagination-list
	 *
	 * @param array   $filter     where-options
	 * @param array   $arrOptions An optional options array
	 *
	 * @return \Model\Collection|null A collection of models or null if there are no news
	 */
	public static function findProjects($intLimit=0, $intOffset=0, array $filter=array(), array $arrOptions=array())
	{
		$t = static::$strTable;
		$arrColumns = (count($filter) > 0)? $filter : null;

		if (!isset($arrOptions['order']))
		{
			$arrOptions['order'] = "$t.id DESC";
		}

		$arrOptions['limit']  = $intLimit;
		$arrOptions['offset'] = $intOffset;


		return static::findBy($arrColumns, null, $arrOptions);
	}
	
	/**
	 * Count all project items
	 *
	 * @param array   $filter     where-options
	 * @param array   $arrOptions An optional options array
	 *
	 * @return \Model\Collection|null A collection of models or null if there are no news
	 */
	public static function countEntries(array $filter=array(), array $arrOptions=array())
	{
		$t = static::$strTable;
		$arrColumns = (count($filter) > 0)? $filter : null;

		return static::countBy($arrColumns, null, $arrOptions);
	}
}
