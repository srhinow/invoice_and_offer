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
 * @method static iao\iaoInvoiceItemsModel|null findById($id, $opt=array())
 * @method static iao\iaoInvoiceItemsModel|null findByIdOrAlias($val, $opt=array())
 * @method static iao\iaoInvoiceItemsModel|null findByPk($id, $opt=array())
 * @method static iao\iaoInvoiceItemsModel|null findOneBy($col, $val, $opt=array())
 * @method static iao\iaoInvoiceItemsModel|null findOneByTstamp($val, $opt=array())
 * @method static iao\iaoInvoiceItemsModel|null findOneByTitle($val, $opt=array())

 *
 * @method static \Model\Collection|iao\iaoInvoiceItemsModel[]|iao\iaoInvoiceItemsModel|null findByTstamp($val, $opt=array())
 * @method static \Model\Collection|iao\iaoInvoiceItemsModel[]|iao\iaoInvoiceItemsModel|null findByTitle($val, $opt=array())
 * @method static \Model\Collection|iao\iaoInvoiceItemsModel[]|iao\iaoInvoiceItemsModel|null findBy($col, $val, $opt=array())
 * @method static \Model\Collection|iao\iaoInvoiceItemsModel[]|iao\iaoInvoiceItemsModel|null findAll($opt=array())
 *
 * @method static integer countById($id, $opt=array())
 *
 * @author Leo Feyer <https://github.com/leofeyer>
 */


class iaoInvoiceItemsModel extends \Model
{
	/**
	 * Table name
	 * @var string
	 */
	protected static $strTable = 'tl_iao_invoice_items';

}
