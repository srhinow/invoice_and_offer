<?php
/**
 * Run in a custom namespace, so the class can be replaced
 */
namespace iao;

/**
 * Reads and writes Offer Items
 *
 * @property integer $id
 * @property integer $tstamp
 * @property string  $title
 *
 * @method static iaoOfferItemsModel|null findById($id, $opt=array())
 * @method static iaoOfferItemsModel|null findByIdOrAlias($val, $opt=array())
 * @method static iaoOfferItemsModel|null findByPk($id, $opt=array())
 * @method static iaoOfferItemsModel|null findOneBy($col, $val, $opt=array())
 * @method static iaoOfferItemsModel|null findOneByTstamp($val, $opt=array())
 * @method static iaoOfferItemsModel|null findOneByTitle($val, $opt=array())

 *
 * @method static \Model\Collection|iaoOfferItemsModel[]|iaoOfferItemsModel|null findByTstamp($val, $opt=array())
 * @method static \Model\Collection|iaoOfferItemsModel[]|iaoOfferItemsModel|null findByTitle($val, $opt=array())
 * @method static \Model\Collection|iaoOfferItemsModel[]|iaoOfferItemsModel|null findBy($col, $val, $opt=array())
 * @method static \Model\Collection|iaoOfferItemsModel[]|iaoOfferItemsModel|null findAll($opt=array())
 *
 * @method static integer countById($id, $opt=array())
 *
 * @author Leo Feyer <https://github.com/leofeyer>
 */


class IaoOfferItemsModel extends \Model
{
	/**
	 * Table name
	 * @var string
	 */
	protected static $strTable = 'tl_iao_offer_items';

}
