<?php
/**
 * Run in a custom namespace, so the class can be replaced
 */
namespace iao;

/**
 * Reads and writes Invoices
 *
 * @property integer $id
 * @property integer $tstamp
 * @property string  $title
 *
 * @method static iao\iaoInvoiceModel|null findById($id, $opt=array())
 * @method static iao\iaoInvoiceModel|null findByIdOrAlias($val, $opt=array())
 * @method static iao\iaoInvoiceModel|null findOneBy($col, $val, $opt=array())
 * @method static iao\iaoInvoiceModel|null findOneByTstamp($val, $opt=array())
 * @method static iao\iaoInvoiceModel|null findOneByTitle($val, $opt=array())

 *
 * @method static \Model\Collection|iao\iaoInvoiceModel[]|iao\iaoInvoiceModel|null findByTstamp($val, $opt=array())
 * @method static \Model\Collection|iao\iaoInvoiceModel[]|iao\iaoInvoiceModel|null findByTitle($val, $opt=array())
 * @method static \Model\Collection|iao\iaoInvoiceModel[]|iao\iaoInvoiceModel|null findBy($col, $val, $opt=array())
 * @method static \Model\Collection|iao\iaoInvoiceModel[]|iao\iaoInvoiceModel|null findAll($opt=array())
 *
 * @method static integer countById($id, $opt=array())
 *
 * @author Leo Feyer <https://github.com/leofeyer>
 */


class iaoInvoiceModel extends \Model
{
	/**
	 * Table name
	 * @var string
	 */
	protected static $strTable = 'tl_iao_invoice';

}
