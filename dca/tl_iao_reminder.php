<?php
/**
 * @copyright  Sven Rhinow 2011-2013
 * @author     sr-tag Sven Rhinow Webentwicklung <http://www.sr-tag.de>
 * @package    invoice_and_offer
 * @license    LGPL
 * @filesource
 */

namespace iao;

use Contao\Database as DB;

/**
 * Table tl_iao_reminder
 */
$GLOBALS['TL_DCA']['tl_iao_reminder'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'			=> 'Table',
		'ptable'				=> 'tl_iao_projects',
		'doNotCopyRecords'		=> true,
		'switchToEdit'			=> true,
		'enableVersioning'		=> false,
		'onload_callback'		=> array
		(
			array('iao\iaoDcaReminder', 'generateInvoicePDF'),
			array('iao\iaoDcaReminder', 'checkPermission'),
		),
		'onsubmit_callback'	=> array(
        	array('iao\iaoDcaReminder','setTextFinish')
		),
		'ondelete_callback'	=> array
		(
			array('iao\iaoDcaReminder', 'onDeleteReminder')
		),
		'sql' => array
		(
			'keys' => array
			(
				'id' => 'primary',
				'pid' => 'index'
			)
		)
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 1,
			'fields'                  => array('reminder_tstamp'),
			'flag'                    => 8,
			'panelLayout'             => 'filter;search,limit'
		),
		'label' => array
		(
			'fields'                  => array('title','invoice_id'),
			'format'                  => '%s (%s)',
			'label_callback'          => array('iao\iaoDcaReminder', 'listEntries'),
		),
		'global_operations' => array
		(
			'checkReminder' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_reminder']['checkReminder'],
				'href'                => 'key=checkReminder',
				'class'               => 'check_reminder',
				'attributes'          => 'onclick="Backend.getScrollOffset();"'
			),
			'all' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'                => 'act=select',
				'class'               => 'header_edit_all',
				'attributes'          => 'onclick="Backend.getScrollOffset();" accesskey="e"'
			)
		),
		'operations' => array
		(
			'edit' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_reminder']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif',
				'attributes'          => 'class="contextmenu"'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_reminder']['copy'],
				'href'                => 'act=copy',
				'icon'                => 'copy.gif'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_reminder']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"',
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_reminder']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			),
			'toggle' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_reminder']['toggle'],
				'icon'                => 'ok.gif',
				#'attributes'          => 'onclick="Backend.getScrollOffset(); return AjaxRequest.toggleVisibility(this, %s);"',
				'button_callback'     => array('iao\iaoDcaReminder', 'toggleIcon')
			),
			'pdf' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_reminder']['pdf'],
				'href'                => 'key=pdf',
				'icon'                => 'iconPDF.gif',
				'button_callback'     => array('iao\iaoDcaReminder', 'showPDFButton')
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'__selector__'                => array(),
		'default'                     => '{settings_legend},setting_id,pid;{invoice_legend},invoice_id,title,address_text,unpaid,reminder_tstamp,periode_date,step,tax,postage,sum,text,text_finish;{status_legend},published,status,paid_on_date;{notice_legend:hide},notice'
	),

	// Subpalettes
	'subpalettes' => array
	(

	),

	// Fields
	'fields' => array
	(
		'id' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL auto_increment"
		),
		'pid' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_reminder']['pid'],
			'foreignKey'              => 'tl_iao_projects.title',
			'filter'                  => true,
			'sorting'                 => true,
			'flag'                    => 11,
			'inputType'               => 'select',
			'eval'                    => array('tl_class'=>'w50','includeBlankOption'=>false, 'chosen'=>true),
			'sql'                     => "int(10) unsigned NOT NULL default '0'",
			'relation'                => array('type'=>'belongsTo', 'load'=>'eager')
		),
		'tstamp' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),	
		'setting_id' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_reminder']['setting_id'],
			'exclude'                 => true,
			'filter'                  => true,
			'sorting'                 => true,
			'flag'                    => 11,
			'inputType'               => 'select',
			'options_callback'        => array('iao\iaoDcaReminder', 'getSettingOptions'),
			'eval'                    => array('tl_class'=>'w50','includeBlankOption'=>false, 'chosen'=>true),
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'title' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_reminder']['title'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>false, 'maxlength'=>255),
			'sql'					  => "varchar(255) NOT NULL default ''"
		),
		'text' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_reminder']['text'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'textarea',
			'eval'                    => array('rte'=>'tinyMCE', 'helpwizard'=>true,'style'=>'height:60px;', 'tl_class'=>'clr'),
			'explanation'             => 'insertTags',
			'sql'					  => "mediumtext NULL"
		),
		'text_finish' => array
		(
			'label'						=> &$GLOBALS['TL_LANG']['tl_iao_reminder']['text_finish'],
			'exclude'					=> true,
			'eval'						=> array('tl_class'=>'clr'),
			'input_field_callback'		=> array('iao\iaoDcaReminder','getTextFinish'),
			'sql'					  => "mediumtext NULL"
		),
		'reminder_tstamp' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_reminder']['reminder_tstamp'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('doNotCopy'=>true,'rgxp'=>'datim', 'datepicker'=>$this->getDatePickerString(), 'tl_class'=>'w50 wizard'),
			'load_callback' => array
			(
				array('iao\iaoDcaReminder', 'generateReminderTstamp')
			),
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'periode_date' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_reminder']['periode_date'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'date', 'datepicker'=>$this->getDatePickerString(), 'tl_class'=>'w50 wizard'),
			'sql'					  => "int(10) unsigned NOT NULL default '0'"
		),
		'paid_on_date' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_reminder']['paid_on_date'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'date', 'datepicker'=>$this->getDatePickerString(), 'tl_class'=>'w50 wizard'),
			'sql'					  => "varchar(255) NOT NULL default ''"
		),
		'invoice_id' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_reminder']['invoice_id'],
			'filter'                  => true,
			'flag'                    => 1,
			'inputType'               => 'select',
			'options_callback'        => array('iao\iaoDcaReminder', 'getInvoices'),
                        'eval'			  => array('tl_class'=>'w50','includeBlankOption'=>true,'submitOnChange'=>true, 'chosen'=>true),
			'save_callback' => array
			(
				array('iao\iaoDcaReminder', 'fillFields')
			),
			'sql'					  => "int(10) unsigned NOT NULL default '0'"
		),
		'member' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_reminder']['member'],
			'filter'                  => true,
			'search'                  => true,
			'sorting'                 => true,
			'flag'                    => 11,
			'inputType'               => 'select',
			'options_callback'        => array('iao\iaoDcaReminder', 'getMemberOptions'),
			'eval'                    => array('tl_class'=>'w50','includeBlankOption'=>true,'submitOnChange'=>true, 'chosen'=>true),
			'save_callback' => array
			(
				array('iao\iaoDcaReminder', 'fillAdressText')
			),
			'sql'					  => "varbinary(128) NOT NULL default ''"
		),
		'address_text' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_reminder']['address_text'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'textarea',
			'eval'                    => array('rte'=>'tinyMCE','style'=>'height:60px;', 'tl_class'=>'clr'),
			'explanation'             => 'insertTags',
			'sql'					  => "mediumtext NULL"
		),
		'published' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_reminder']['published'],
			'exclude'                 => true,
			'filter'                  => true,
			'flag'                    => 1,
			'inputType'               => 'checkbox',
			'eval'                    => array('doNotCopy'=>true),
			'sql'					  => "char(1) NOT NULL default ''"
		),
		'status' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_reminder']['status'],
			'exclude'                 => true,
			'filter'                  => true,
			'flag'                    => 1,
			'inputType'               => 'select',
			'options'                 => &$GLOBALS['TL_LANG']['tl_iao_reminder']['status_options'],
                        'eval'			  => array('tl_class'=>'w50'),
                        'save_callback' => array
			(
				array('iao\iaoDcaReminder', 'updateStatus')
			),
			'sql'					  => "char(1) NOT NULL default ''"
		),
		'step' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_reminder']['step'],
			'exclude'                 => true,
			'filter'                  => true,
			'flag'                    => 1,
			'inputType'               => 'select',
			'options'                 => &$GLOBALS['TL_LANG']['tl_iao_reminder']['steps'],
			'eval'                    => array('tl_class'=>'w50','includeBlankOption'=>true,'submitOnChange'=>true),
			'save_callback' => array
			(
				array('iao\iaoDcaReminder', 'fillStepFields')
			),
			'sql'					  => "varchar(255) NOT NULL default ''"
		),
		'unpaid' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_reminder']['unpaid'],
			'exclude'                 => true,
			'flag'                    => 1,
			'inputType'               => 'text',
			'eval'                    => array('tl_class'=>'w50','rgxp'=>'digit', 'nospace'=>true),
			'sql'					  => "varchar(64) NOT NULL default '0'"
		),
		'tax' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_reminder']['tax'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>2, 'tl_class'=>'w50'),
			'sql'					  => "varchar(2) NOT NULL default '0'"
		),
		'tax_typ' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_reminder']['tax_typ'],
			'exclude'                 => true,
			'flag'                    => 1,
			'inputType'               => 'select',
			'options'                 => array('1'=>'Soll (Zins von Brutto)','2'=>'Ist (Zins von Netto)'),
			'eval'                    => array('tl_class'=>'w50'),
			'sql'					  => "varchar(25) NOT NULL default ''"
		),
		'sum' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_reminder']['sum'],
			'exclude'                 => true,
			'flag'                    => 1,
			'inputType'               => 'text',
			'eval'                    => array('tl_class'=>'w50','rgxp'=>'digit', 'nospace'=>true),
			'sql'					  => "varchar(64) NOT NULL default '0'"
		),
		'postage' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_reminder']['postage'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>25, 'tl_class'=>'w50'),
			'sql'					  => "varchar(25) NOT NULL default '0'"
		),
		'notice' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_reminder']['notice'],
			'exclude'                 => true,
			'search'		  => true,
			'filter'                  => false,
			'inputType'               => 'textarea',
			'eval'                    => array('mandatory'=>false, 'cols'=>'10','rows'=>'10','style'=>'height:100px','rte'=>false),
			'sql'					  => "mediumtext NULL"
		),
	)
);

/**
 * Class tl_iao_reminder
 */
class iaoDcaReminder extends \iao\iaoBackend
{

	protected $settings = array();
	
	/**
	 * Import the back end user object
	 */
	public function __construct()
	{
		parent::__construct();
		$this->import('BackendUser', 'User');
	}


	/**
	 * Check permissions to edit table tl_iao_reminder
	 */
	public function checkPermission()
	{
		$this->checkIaoModulePermission('tl_iao_reminder');
	}

	/**
	 * fill date-Field if this empty
	 * @param $varValue mixed
	 * @param $dc object
	 * @return integer
	 */
	public function  generateExecuteDate($varValue, \DataContainer $dc)
	{
		$altdate = ($dc->activeRecord->invoice_tstamp) ? $dc->activeRecord->invoice_tstamp : time();
		return ($varValue==0) ? $altdate : $varValue;
	}

	/**
	 * fill date-Field if this empty
	 * @param $varValue mixed
	 * @param $dc object
	 * @return integer
	 */
	public function  generateReminderTstamp($varValue, \DataContainer $dc)
	{
		return ($varValue == 0) ? time() : $varValue;
	}

	/**
	 * fill Adress-Text
     * @param $varValue integer
	 * @param $dc object
	 * @throws \Exception
     * @return integer
	 */
	public function fillFields($varValue, \DataContainer $dc)
	{
        $objDB = IaoReminderModel::findById($dc->id);
        if(!is_object($objDB)) throw new \Exception('Error in fillFields in tl_iao_reminder');

		if($varValue == $objDB->invoice_id) return $varValue;

		if(!$dc->activeRecord->step)
		{
			$this->fillReminderFields($varValue,$dc->activeRecord);
		}
	    return $varValue;
	}


    /**
	 * get all invoices
	 * @param object
     * @return array
	 */
	public function getInvoices(\DataContainer $dc)
	{
		$settings = $this->getSettings($dc->activeRecord->setting_id);
        $varValue= array();

		$all = DB::getInstance()->prepare('SELECT `i`.*, `m`.`company` FROM `tl_iao_invoice` as `i` LEFT JOIN `tl_member` as `m` ON `i`.`member` = `m`.`id` ORDER BY `invoice_id_str` DESC')
                    ->execute();

		while($all->next())
		{
			$varValue[$all->id] = $all->invoice_id_str.' :: '.\StringUtil::substr($all->title,20).' ('.number_format($all->price_brutto,2,',','.').' '.$settings['currency_symbol'].')';
		}

		return $varValue;
	}

	/**
	 * fill Text
     * @param $varValue integer
	 * @param $dc object
	 * @throws \Exception
     * @return integer
	 */
	public function fillStepFields($varValue, \DataContainer $dc)
	{
		$settings = $this->getSettings($dc->activeRecord->setting_id);

		if(!$varValue) return $varValue;

        $dbObj = IaoReminderModel::findById($dc->id);
        if(!is_object($dbObj)) throw new \Exception('fillStepFields() ist fehlgeschlagen.');

		if($varValue == $dbObj->step) return $varValue;

		$text = $settings['iao_reminder_'.$varValue.'_text'];
		$text_finish = $this->changeIAOTags($text,'reminder',$dbObj);

		$tax =  $settings['iao_reminder_'.$varValue.'_tax'];
		$postage =  $settings['iao_reminder_'.$varValue.'_postage'];
		$periode_date = $this->getPeriodeDate($dc->activeRecord);

		$set = [
			'tax' => $tax,
			'postage' => $postage,
			'text' =>  $text,
			'text_finish' => $text_finish,
			'periode_date' => $periode_date
        ];

	    DB::getInstance()->prepare('UPDATE `tl_iao_reminder` %s WHERE `id`=?')
										->set($set)
										->execute($dc->id);

		//update invoice-data with current reminder-step
        $set = ['reminder_id'=>$dc->id];

		DB::getInstance()->prepare('UPDATE `tl_iao_invoice` %s  WHERE `id`=?')
                        ->set($set)
						->execute($dc->activeRecord->invoice_id);

		return $varValue;
	}

    /**
     * @param \DataContainer $dc
     * @return string
     * @throws \Exception
     */
	public function getTextFinish(\DataContainer $dc)
	{
        $obj = IaoReminderModel::findById($dc->id);
        if(!is_object($obj)) throw new \Exception('getTextFinish() ist fehlgeschlagen.');

        if(!$obj->text_finish)
        {
			$text_finish = $this->changeIAOTags($obj->text,'reminder',$obj);

        }
        else $text_finish =  $obj->text_finish;

		return '<h3><label for="ctrl_text_finish">'.$GLOBALS['TL_LANG']['tl_iao_reminder']['text_finish'][0].'</label></h3><div id="ctrl_text_finish" class="preview" style="border:1px solid #ddd; padding:5px;">'.$text_finish.'</div>';
	}

    /**
     * @param \DataContainer $dc
     * @throws \Exception
     */
	public function setTextFinish(\DataContainer $dc)
	{
			$objReminder = IaoReminderModel::findById($dc->id);
            if(!is_object($objReminder)) throw new \Exception('setTextFinish() ist fehlgeschlagen.');

			$text_finish = $this->changeIAOTags($objReminder->text,'reminder',$objReminder);
			$text_finish = $this->changeTags($text_finish);

			$set = ['text_finish' => $text_finish];

			$this->Database->prepare('UPDATE `tl_iao_reminder` %s WHERE `id`=?')
							->set($set)
							->execute($dc->id);
	}

    /**
     * fill Adress-Text
     * @param $intMember int
     * @param \DataContainer $dc
     * @return mixed
     */
    public function fillAdressText($intMember, \DataContainer $dc)
    {
        if(trim(strip_tags($dc->activeRecord->address_text)) == '')
        {
            $text = $this->getAdressText($intMember);

            DB::getInstance()->prepare('UPDATE `tl_iao_reminder` SET `address_text`=? WHERE `id`=?')
                ->limit(1)
                ->execute($text, $dc->id);
        }
        return $intMember;
    }
	/**
	 * Return the edit header button
	 * @param array
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @return string
	 */
	public function editHeader($row, $href, $label, $title, $icon, $attributes)
	{
		return ($this->User->isAdmin || count(preg_grep('/^tl_iao_reminder::/', $this->User->alexf)) > 0) ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.specialchars($title).'"'.$attributes.'>'.$this->generateImage($icon, $label).'</a> ' : '';
	}

	/**
	* wenn GET-Parameter passen dann wird eine PDF erzeugt
	*
	*/
	public function generateInvoicePDF(\DataContainer $dc)
	{	    if(\Input::get('key') == 'pdf' && (int) \Input::get('id') > 0) $this->generateReminderPDF((int) \Input::get('id'), 'reminder');
	}

	/**
	 * Generate a "PDF" button and return it as string
	 * @param array
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @return string
	 */
	public function showPDF($row, $href, $label, $title, $icon)
	{
		$settings = $this->getSettings($row['setting_id']);

		// wenn kein Admin dann kein PDF-Link	
		if (!$this->User->isAdmin)
		{
			return false;
		}

		// Wenn keine PDF-Vorlage dann kein PDF-Link
	    $objPdfTemplate = 	\FilesModel::findByUuid($settings['iao_invoice_pdf']);			

		if(strlen($objPdfTemplate->path) < 1 || !file_exists(TL_ROOT . '/' . $objPdfTemplate->path) ) return false;  // template file not found

		if (\Input::get('key') == 'pdf' && \Input::get('id') == $row['id'])
		{
			$step = $row['step'];
			$pdfFile = TL_ROOT . '/' . $settings['iao_reminder_'.$step.'_pdf'];

			if(!file_exists($pdfFile)) return false;  // template file not found

            $invoiceObj = IaoInvoiceModel::findById($row['invoice_id']);

            $reminder_Str = $GLOBALS['TL_LANG']['tl_iao_reminder']['steps'][$row['step']].'-'.$invoiceObj->invoice_id_str.'-'.$row['id'];

			//-- Calculating dimensions
			$margins = unserialize($settings['iao_pdf_margins']);         // Margins as an array
			switch( $margins['unit'] )
			{
				case 'cm':      $factor = 10.0;   break;
				default:        $factor = 1.0;
			}

			$dim['top']    = !is_numeric($margins['top'])   ? PDF_MARGIN_TOP    : $margins['top'] * $factor;
			$dim['right']  = !is_numeric($margins['right']) ? PDF_MARGIN_RIGHT  : $margins['right'] * $factor;
			$dim['bottom'] = !is_numeric($margins['top'])   ? PDF_MARGIN_BOTTOM : $margins['bottom'] * $factor;
			$dim['left']   = !is_numeric($margins['left'])  ? PDF_MARGIN_LEFT   : $margins['left'] * $factor;

			// TCPDF configuration
			$l['a_meta_dir'] = 'ltr';
			$l['a_meta_charset'] = $GLOBALS['TL_CONFIG']['characterSet'];
			$l['a_meta_language'] = $GLOBALS['TL_LANGUAGE'];
			$l['w_page'] = 'page';

			// Create new PDF document with FPDI extension
			require_once(IAO_PDFCLASS_FILE);
			
			$pdf = new iaoPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true);
			$pdf->setSourceFile($pdfFile);          // Set PDF template

			// Set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetTitle($reminder_Str);
			$pdf->SetSubject($reminder_Str);
			$pdf->SetKeywords($reminder_Str);

			$pdf->SetDisplayMode('fullwidth', 'OneColumn', 'UseNone');
			$pdf->SetHeaderData();

			// Remove default header/footer
			$pdf->setPrintHeader(false);

			// Set margins
			$pdf->SetMargins($dim['left'], $dim['top'], $dim['right']);

			// Set auto page breaks
			$pdf->SetAutoPageBreak(true, $dim['bottom']);

			// Set image scale factor
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

			// Set some language-dependent strings
			$pdf->setLanguageArray($l);

			// Initialize document and add a page
			$pdf->AddPage();

		    // Include CSS (TCPDF 5.1.000 an newer)
		    $file = \FilesModel::findByUuid($settings['iao_pdf_css']);

		    if(strlen($file->path) > 0 && file_exists(TL_ROOT . '/' . $file->path) )
		    {
				$styles = "<style>\n" . file_get_contents(TL_ROOT . '/' . $file->path) . "\n</style>\n";
				$pdf->writeHTML($styles, true, false, true, false, '');
			}

			// write the address-data
			$pdf->drawAddress($styles.$this->changeTags($row['address_text']));

			//Mahnungsnummer
			$pdf->drawDocumentNumber($reminder_Str);

			//Datum
			$pdf->drawDate(date($GLOBALS['TL_CONFIG']['dateFormat'],$row['tstamp']));

			//ausgeführt am
			$newdate= $row['periode_date'];
			$pdf->drawInvoiceDurationDate(date($GLOBALS['TL_CONFIG']['dateFormat'],$newdate));


			//Text
			if(strip_tags($row['text_finish']))
			{
				$pdf->drawTextBefore($row['text_finish']);
			}

			// Close and output PDF document
			$pdf->lastPage();
			$pdf->Output($reminder_Str. '.pdf', 'D');

			// Stop script execution
			exit();
		}
		return '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.specialchars($title).'">'.$this->generateImage($icon, $label).'</a> ';

	}

	/**
	 * Generate a "PDF" button and return it as string
	 * @param array
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @return string
	 */
	public function showPDFButton($row, $href, $label, $title, $icon)
	{
		$settings = $this->getSettings($row['setting_id']);

		// wenn kein Admin dann kein PDF-Link
		if (!$this->User->isAdmin)	return false;

		$href = 'contao/main.php?do=iao_reminder&amp;key=pdf&amp;id='.$row['id'];
		return '<a href="'.$href.'" title="'.specialchars($title).'">'.$this->generateImage($icon, $label).'</a> ';
	}

	/**
	 * Autogenerate an article alias if it has not been set yet
	 * @param mixed
	 * @param object
	 * @return string
	 */
	public function generateReminderNumber($varValue, \DataContainer $dc)
	{
		$autoNr = false;
		$varValue = (int) $varValue;
        $settings = $this->getSettings($dc->activeRecord->setting_id);


        // Generate invoice_id if there is none
		if($varValue == 0)
		{
			$autoNr = true;
			$objNr = $this->Database->prepare("SELECT `invoice_id` FROM `tl_iao_reminder` ORDER BY `invoice_id` DESC")
									->limit(1)
									->execute();


			if($objNr->numRows < 1 || $objNr->invoice_id == 0)  $varValue = $settings['iao_invoice_startnumber'];
			else  $varValue =  $objNr->invoice_id +1;

		}
		else
		{
			$objNr = $this->Database->prepare("SELECT `invoice_id` FROM `tl_iao_reminder` WHERE `id`=? OR `invoice_id`=?")
									->limit(1)
									->execute($dc->id,$varValue);

			// Check whether the InvoiceNumber exists
			if ($objNr->numRows > 1 )
			{
				if (!$autoNr)
				{
					throw new \Exception(sprintf($GLOBALS['TL_LANG']['ERR']['aliasExists'], $varValue));
				}

				$varValue .= '-' . $dc->id;
			}
		}
	    return $varValue;
	}

    /**
     * List a particular record
     * @param array
     * @return string
     */
    public function listEntries($arrRow)
    {
        $settings = $this->getSettings($arrRow['setting_id']);

        $result = DB::getInstance()->prepare("SELECT `r`.periode_date,`i`.`invoice_id_str`, `i`.`title` `invoicetitle`, `m`.`firstname`, `m`.`lastname`, `m`.`company`
		FROM `tl_iao_reminder` `r`
		LEFT JOIN `tl_member` `m` ON  `r`.`member` = `m`.`id`
		LEFT JOIN `tl_iao_invoice` `i` ON  `r`.`invoice_id` = `i`.`id`
		WHERE `r`.`id`=?")
						->limit(1)
						->execute($arrRow['id']);

		$row = $result->fetchAssoc();

		return '
		<div class="comment_wrap">
		<div class="cte_type status' . $arrRow['status'] . '"><strong>' . $arrRow['title'] . '</strong> '.$row['invoice_id_str'].'</div>
		<div>Rechnungs-Title: <strong>'.$row['invoicetitle'].'</strong></div>
		<div>'.$GLOBALS['TL_LANG']['tl_iao_reminder']['sum'][0].': <strong>'.number_format($arrRow['sum'],2,',','.').' '.$settings['currency_symbol'].'</strong></div>
		<div>'.$GLOBALS['TL_LANG']['tl_iao_reminder']['member'][0].': '.$row['firstname'].' '.$row['lastname'].' ('.$row['company'].')</div>
		<div>'.$GLOBALS['TL_LANG']['tl_iao_reminder']['periode_date'][0].': '.date($GLOBALS['TL_CONFIG']['dateFormat'],$row['periode_date']).'</div>
		'.(($arrRow['notice'])?"<div>".$GLOBALS['TL_LANG']['tl_iao_reminder']['notice'][0].":".$arrRow['notice']."</div>": '').'
		</div>' . "\n    ";
    }

	/**
	 * Return the "toggle visibility" button
	 * @param array
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @return string
	 */
	public function toggleIcon($row, $href, $label, $title, $icon, $attributes)
	{
		$this->import('BackendUser', 'User');

		if (strlen(\Input::get('tid')))
		{
			$this->toggleVisibility(\Input::get('tid'), (\Input::get('state')));
			$this->redirect($this->getReferer());

		}

		$href .= '&amp;tid='.$row['id'].'&amp;state='.($row['status']==1 ? 2 : 1);

		if ($row['status']==2)
		{
				$icon = 'logout.gif';
		}

		return '<a href="'.$this->addToUrl($href).'" title="'.$GLOBALS['TL_LANG']['tl_iao_reminder']['toggle'].'"'.$attributes.'>'.$this->generateImage($icon, $label).'</a> ';
	}

	/**
	 * paid/not paid
	 * @param integer
	 * @param boolean
	 */
	public function toggleVisibility($intId, $blnVisible)
	{
		// Check permissions to edit
		$this->Input->setGet('id', $intId);
		$this->Input->setGet('act', 'toggle');

		// Check permissions to publish
		if (!$this->User->isAdmin && !$this->User->hasAccess('tl_iao_reminder::status', 'alexf'))
		{
			$this->log('Not enough permissions to publish/unpublish comment ID "'.$intId.'"', 'tl_iao_reminder toggleActivity', TL_ERROR);
			$this->redirect('contao/main.php?act=error');
		}

		$this->createInitialVersion('tl_iao_reminder', $intId);

		// Trigger the save_callback
		if (is_array($GLOBALS['TL_DCA']['tl_iao_reminder']['fields']['status']['save_callback']))
		{
			foreach ($GLOBALS['TL_DCA']['tl_iao_reminder']['fields']['status']['save_callback'] as $callback)
			{
				$this->import($callback[0]);
				$blnVisible = $this->$callback[0]->$callback[1]($blnVisible, $this);
			}
		}

		$visibility = $blnVisible==1 ? '1' : '2';

		// Update the database
		$this->Database->prepare("UPDATE tl_iao_reminder SET status=? WHERE id=?")
					   ->execute($visibility, $intId);

		//get reminder-Data
		$remindObj = $this->Database->prepare('SELECT * FROM `tl_iao_reminder` WHERE `id`=?')
									->limit(1)
									->execute($intId);

		if($remindObj->numRows)
		{
			$dbObj = $this->Database->prepare("UPDATE `tl_iao_invoice` SET `status`=?, `notice` = `notice`+?  WHERE id=?")
									->execute($visibility, $remindObj->notice, $remindObj->invoice_id);
		}

		$this->createNewVersion('tl_iao_reminder', $intId);
	}

	/**
	* ondelete_callback
	* @var object
	*/
	public function onDeleteReminder(DataContainer $dc)
	{
		$invoiceID = $dc->activeRecord->invoice_id;

		if($invoiceID)
		{
			$otherReminderObj = $this->Database->prepare('SELECT `id` FROM `tl_iao_reminder` WHERE `invoice_id`=? AND `id`!=? ORDER BY `step` DESC')
												->limit(1)
												->execute($invoiceID, $dc->id);

			$newReminderID = ($otherReminderObj->numRows > 0) ? $otherReminderObj->id : 0;

			$this->Database->prepare('UPDATE `tl_iao_invoice` SET `reminder_id`=? WHERE `id`=?')
							->execute($newReminderID, $invoiceID);
	     }
	 }

	/**
	 * ondelete_callback
	 * @var object
	 */
	public function changeStatusReminder(DataContainer $dc)
	{
		$state = \Input::get('state');
		$reminderID = \Input::get('id');
		$invoiceID = $dc->activeRecord->invoice_id;

		if($state == 2)
		{
			if($invoiceID)
			{
				$this->Database->prepare('UPDATE `tl_iao_invoice` SET `reminder_id`=?, `paid_on_date`=?, `status`=? WHERE `id`=?')
								->execute($reminderID, time(), 2, $invoiceID);
			}
		}
		elseif($state == 1)
		{
			if($invoiceID)
			{
				$this->Database->prepare('UPDATE `tl_iao_invoice` SET `reminder_id`=?, `paid_on_date`=?,`status`=?  WHERE `id`=?')
								->execute('', '', 1, $invoiceID);
			}
		}
	}

	/**
	 * status save_callback
	 * @var string
	 * @var object
	 */
	public function updateStatus($varValue, DataContainer $dc)
	{
		$varValue = (int) $varValue;

		// UPDATE invoice when reminder is market as paid
		if($varValue == 2 && $dc->activeRecord->invoice_id > 0)
		{
			$set = array
			(
				'status' => $varValue,
				'paid_on_date' => $dc->activeRecord->paid_on_date
			);

			$this->Database->prepare("UPDATE `tl_iao_invoice` %s  WHERE `id`=?")
							->set($set)
							->limit(1)
							->execute($dc->activeRecord->invoice_id);
	    }

	    return $varValue;
	 }
}
