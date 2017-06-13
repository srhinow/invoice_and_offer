<?php
/**
 * Run in a custom namespace, so the class can be replaced
 */
namespace iao;

/**
 * Reads and writes Credit Items
 *
 * @property integer $id
 * @property integer $tstamp
 * @property string  $title
 *
 * @method static iao\iaoCreditItemsModel|null findById($id, $opt=array())
 * @method static iao\iaoCreditItemsModel|null findByIdOrAlias($val, $opt=array())
 * @method static iao\iaoCreditItemsModel|null findByPk($id, $opt=array())
 * @method static iao\iaoCreditItemsModel|null findOneBy($col, $val, $opt=array())
 * @method static iao\iaoCreditItemsModel|null findOneByTstamp($val, $opt=array())
 * @method static iao\iaoCreditItemsModel|null findOneByTitle($val, $opt=array())

 *
 * @method static \Model\Collection|iao\iaoCreditItemsModel[]|iao\iaoCreditItemsModel|null findByTstamp($val, $opt=array())
 * @method static \Model\Collection|iao\iaoCreditItemsModel[]|iao\iaoCreditItemsModel|null findByTitle($val, $opt=array())
 * @method static \Model\Collection|iao\iaoCreditItemsModel[]|iao\iaoCreditItemsModel|null findBy($col, $val, $opt=array())
 * @method static \Model\Collection|iao\iaoCreditItemsModel[]|iao\iaoCreditItemsModel|null findAll($opt=array())
 *
 * @method static integer countById($id, $opt=array())
 *
 * @author Leo Feyer <https://github.com/leofeyer>
 */


class IaoCreditItemsModel extends \Model
{
	/**
	 * Table name
	 * @var string
	 */
	protected static $strTable = 'tl_iao_credit_items';

}