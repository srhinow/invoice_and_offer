<?php
/**
 * Run in a custom namespace, so the class can be replaced
 */
namespace iao;

/**
 * Reads and writes Invoice Items
 *
 * @property integer $id
 * @property integer $tstamp
 * @property string  $title
 *
 * @method static iaoInvoiceItemsModel|null findById($id, $opt=array())
 * @method static iaoInvoiceItemsModel|null findByIdOrAlias($val, $opt=array())
 * @method static iaoInvoiceItemsModel|null findByPk($id, $opt=array())
 * @method static iaoInvoiceItemsModel|null findOneBy($col, $val, $opt=array())
 * @method static iaoInvoiceItemsModel|null findOneByTstamp($val, $opt=array())
 * @method static iaoInvoiceItemsModel|null findOneByTitle($val, $opt=array())

 *
 * @method static \Model\Collection|iaoInvoiceItemsModel[]|iaoInvoiceItemsModel|null findByTstamp($val, $opt=array())
 * @method static \Model\Collection|iaoInvoiceItemsModel[]|iaoInvoiceItemsModel|null findByTitle($val, $opt=array())
 * @method static \Model\Collection|iaoInvoiceItemsModel[]|iaoInvoiceItemsModel|null findBy($col, $val, $opt=array())
 * @method static \Model\Collection|iaoInvoiceItemsModel[]|iaoInvoiceItemsModel|null findAll($opt=array())
 *
 * @method static integer countById($id, $opt=array())
 *
 * @author Leo Feyer <https://github.com/leofeyer>
 */


class IaoInvoiceItemsModel extends \Model
{
	/**
	 * Table name
	 * @var string
	 */
	protected static $strTable = 'tl_iao_invoice_items';

}
