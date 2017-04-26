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
 * @method static iao\iaoTemplatesModel|null findById($id, $opt=array())
 * @method static iao\iaoTemplatesModel|null findByIdOrAlias($val, $opt=array())
 * @method static iao\iaoTemplatesModel|null findOneBy($col, $val, $opt=array())
 * @method static iao\iaoTemplatesModel|null findOneByTstamp($val, $opt=array())
 * @method static iao\iaoTemplatesModel|null findOneByTitle($val, $opt=array())

 *
 * @method static \Model\Collection|iao\iaoTemplatesModel[]|iao\iaoTemplatesModel|null findByTstamp($val, $opt=array())
 * @method static \Model\Collection|iao\iaoTemplatesModel[]|iao\iaoTemplatesModel|null findByTitle($val, $opt=array())
 * @method static \Model\Collection|iao\iaoTemplatesModel[]|iao\iaoTemplatesModel|null findBy($col, $val, $opt=array())
 * @method static \Model\Collection|iao\iaoTemplatesModel[]|iao\iaoTemplatesModel|null findAll($opt=array())
 *
 * @method static integer countById($id, $opt=array())
 *
 * @author Leo Feyer <https://github.com/leofeyer>
 */


class iaoTemplatesModel extends \Model
{
	/**
	 * Table name
	 * @var string
	 */
	protected static $strTable = 'tl_iao_templates';

}
