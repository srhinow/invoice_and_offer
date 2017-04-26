
<?php
/**
 * Run in a custom namespace, so the class can be replaced
 */
namespace iao;

/**
 * Reads and writes Templates Items
 *
 * @property integer $id
 * @property integer $tstamp
 * @property string  $title
 *
 * @method static iao\iaoTemplatesItemsModel|null findById($id, $opt=array())
 * @method static iao\iaoTemplatesItemsModel|null findByIdOrAlias($val, $opt=array())
 * @method static iao\iaoTemplatesItemsModel|null findByPk($id, $opt=array())
 * @method static iao\iaoTemplatesItemsModel|null findOneBy($col, $val, $opt=array())
 * @method static iao\iaoTemplatesItemsModel|null findOneByTstamp($val, $opt=array())
 * @method static iao\iaoTemplatesItemsModel|null findOneByTitle($val, $opt=array())

 *
 * @method static \Model\Collection|iao\iaoTemplatesItemsModel[]|iao\iaoTemplatesItemsModel|null findByTstamp($val, $opt=array())
 * @method static \Model\Collection|iao\iaoTemplatesItemsModel[]|iao\iaoTemplatesItemsModel|null findByTitle($val, $opt=array())
 * @method static \Model\Collection|iao\iaoTemplatesItemsModel[]|iao\iaoTemplatesItemsModel|null findBy($col, $val, $opt=array())
 * @method static \Model\Collection|iao\iaoTemplatesItemsModel[]|iao\iaoTemplatesItemsModel|null findAll($opt=array())
 *
 * @method static integer countById($id, $opt=array())
 *
 * @author Leo Feyer <https://github.com/leofeyer>
 */


class IaoTemplatesItemsModel extends \Model
{
	/**
	 * Table name
	 * @var string
	 */
	protected static $strTable = 'tl_iao_template_items';

}
