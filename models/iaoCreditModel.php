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
 * @method static iao\iaoCreditModel|null findById($id, $opt=array())
 * @method static iao\iaoCreditModel|null findByIdOrAlias($val, $opt=array())
 * @method static iao\iaoCreditModel|null findOneBy($col, $val, $opt=array())
 * @method static iao\iaoCreditModel|null findOneByTstamp($val, $opt=array())
 * @method static iao\iaoCreditModel|null findOneByTitle($val, $opt=array())

 *
 * @method static \Model\Collection|iao\iaoCreditModel[]|iao\iaoCreditModel|null findByTstamp($val, $opt=array())
 * @method static \Model\Collection|iao\iaoCreditModel[]|iao\iaoCreditModel|null findByTitle($val, $opt=array())
 * @method static \Model\Collection|iao\iaoCreditModel[]|iao\iaoCreditModel|null findBy($col, $val, $opt=array())
 * @method static \Model\Collection|iao\iaoCreditModel[]|iao\iaoCreditModel|null findAll($opt=array())
 *
 * @method static integer countById($id, $opt=array())
 *
 * @author Leo Feyer <https://github.com/leofeyer>
 */


class iaoCreditModel extends \Model
{
	/**
	 * Table name
	 * @var string
	 */
	protected static $strTable = 'tl_iao_credit';

}
