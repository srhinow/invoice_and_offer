<?php
/**
 * Run in a custom namespace, so the class can be replaced
 */
namespace iao;

/**
 * Reads and writes Templates
 *
 * @property integer $id
 * @property integer $tstamp
 * @property string  $title
 *
 * @method static iaoTemplatesModel|null findById($id, $opt=array())
 * @method static iaoTemplatesModel|null findByIdOrAlias($val, $opt=array())
 * @method static iaoTemplatesModel|null findOneBy($col, $val, $opt=array())
 * @method static iaoTemplatesModel|null findOneByTstamp($val, $opt=array())
 * @method static iaoTemplatesModel|null findOneByTitle($val, $opt=array())

 *
 * @method static \Model\Collection|iaoTemplatesModel[]|iaoTemplatesModel|null findByTstamp($val, $opt=array())
 * @method static \Model\Collection|iaoTemplatesModel[]|iaoTemplatesModel|null findByTitle($val, $opt=array())
 * @method static \Model\Collection|iaoTemplatesModel[]|iaoTemplatesModel|null findBy($col, $val, $opt=array())
 * @method static \Model\Collection|iaoTemplatesModel[]|iaoTemplatesModel|null findAll($opt=array())
 *
 * @method static integer countById($id, $opt=array())
 *
 * @author Leo Feyer <https://github.com/leofeyer>
 */


class IaoTemplatesModel extends \Model
{
	/**
	 * Table name
	 * @var string
	 */
	protected static $strTable = 'tl_iao_templates';

}
