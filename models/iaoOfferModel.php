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
 * @method static iao\iaoOfferModel|null findById($id, $opt=array())
 * @method static iao\iaoOfferModel|null findByIdOrAlias($val, $opt=array())
 * @method static iao\iaoOfferModel|null findOneBy($col, $val, $opt=array())
 * @method static iao\iaoOfferModel|null findOneByTstamp($val, $opt=array())
 * @method static iao\iaoOfferModel|null findOneByTitle($val, $opt=array())

 *
 * @method static \Model\Collection|iao\iaoOfferModel[]|iao\iaoOfferModel|null findByTstamp($val, $opt=array())
 * @method static \Model\Collection|iao\iaoOfferModel[]|iao\iaoOfferModel|null findByTitle($val, $opt=array())
 * @method static \Model\Collection|iao\iaoOfferModel[]|iao\iaoOfferModel|null findBy($col, $val, $opt=array())
 * @method static \Model\Collection|iao\iaoOfferModel[]|iao\iaoOfferModel|null findAll($opt=array())
 *
 * @method static integer countById($id, $opt=array())
 *
 * @author Leo Feyer <https://github.com/leofeyer>
 */


class iaoOfferModel extends \Model
{
	/**
	 * Table name
	 * @var string
	 */
	protected static $strTable = 'tl_iao_offer';

}
