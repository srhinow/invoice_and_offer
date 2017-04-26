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
 * @method static iao\iaoSettingsModel|null findById($id, $opt=array())
 * @method static iao\iaoSettingsModel|null findByIdOrAlias($val, $opt=array())
 * @method static iao\iaoSettingsModel|null findOneBy($col, $val, $opt=array())
 * @method static iao\iaoSettingsModel|null findOneByTstamp($val, $opt=array())
 * @method static iao\iaoSettingsModel|null findOneByTitle($val, $opt=array())

 *
 * @method static \Model\Collection|iao\iaoSettingsModel[]|iao\iaoSettingsModel|null findByTstamp($val, $opt=array())
 * @method static \Model\Collection|iao\iaoSettingsModel[]|iao\iaoSettingsModel|null findByTitle($val, $opt=array())
 * @method static \Model\Collection|iao\iaoSettingsModel[]|iao\iaoSettingsModel|null findBy($col, $val, $opt=array())
 * @method static \Model\Collection|iao\iaoSettingsModel[]|iao\iaoSettingsModel|null findAll($opt=array())
 *
 * @method static integer countById($id, $opt=array())
 *
 * @author Leo Feyer <https://github.com/leofeyer>
 */


class iaoSettingsModel extends \Model
{
	/**
	 * Table name
	 * @var string
	 */
	protected static $strTable = 'tl_iao_settings';

}
