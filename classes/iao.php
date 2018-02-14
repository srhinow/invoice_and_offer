<?php
/**
 * Run in a custom namespace, so the class can be replaced
 */
namespace iao;

use Contao\Database as DB;

/**
 *
 * @copyright  Sven Rhinow 2011-2017
 * @author     sr-tag Sven Rhinow Webentwicklung <http://www.sr-tag.de>
 * @package    invoice_and_offer
 * @license    LGPL
 * @filesource
 */


/**
 * Class iao
 * Provide methods to handle invoice_and_offer-module.
 */
class iao extends \Backend
{
    /**
     * get current settings
     * @param integer
     */
    public function getSettings($id = '')
    {
        if($id)
        {
            $dbObj = DB::getInstance()->prepare('SELECT * FROM `tl_iao_settings` WHERE `id`=?')
                ->limit(1)
                ->execute($id);
        } else {
            $dbObj = DB::getInstance()->prepare('SELECT * FROM `tl_iao_settings` WHERE `fallback`=?')
                ->limit(1)
                ->execute(1);
        }

        return $dbObj->fetchAssoc();
    }
    /**
     * Get netto-price from brutto
     * @param float
     * @param integer
     * @return float
     */
    public function getNettoPrice($brutto, $vat)
    {
        return ($brutto * 100) / ($vat + 100);
    }

    /**
     * Get brutto-price from netto
     * @param float
     * @param integer
     * @return float
     */
    public function getBruttoPrice($netto,$vat)
    {
        return ($netto / 100) * ($vat + 100);
    }

    /**
     * get umastzsteuer-Betrag vom netto
     * @param float
     * @param integer
     * @return float
     */
    public function getUmstAmount($netto,$vat)
    {
        return ($netto * $vat) / 100;
    }

    /**
     * Get formatet price-string
     * @param float
     * @param string
     * @return string
     */
    public function getPriceStr($price, $currencyStr = 'iao_currency')
    {
        return number_format((float)$price, 2, ',', '.').' '.$GLOBALS['TL_CONFIG'][$currencyStr];
    }

    /**
     * replace ##-Placeholder
     * @param $text string
     * @param $dcObj object
     * @return $text string
     */
//    public function replacePlaceholder($text,$dcObj)
//    {
//        if(stristr($text,'##project##'))
//        {
//            $projObj = $this->Database->prepare('SELECT * FROM `tl_iao_projects` WHERE `id`=?')->limit(1)->execute($dcObj->activeRecord->pid);
//
//            if($projObj->numRows > 0) $text = str_replace('##project##', $projObj->title, $text);
//        }
//        $text = str_replace('##datum##', date('d.m.Y'), $text);
//
//        return $text;
//    }

    /**
     * change Contao-Placeholder with html-characters
     * @param string
     * @return string
     */
    public function changeTags($text)
    {
        // replace [&] etc.
        $text = \StringUtil::restoreBasicEntities($text);

        // replace Inserttags
        $text = $this->replaceInsertTags($text);

        return $text;
    }

    /**
     * replace Insert-Tags from IAO - DB-Tables
     *
     * @param $strBuffer string
     * @param $sector string
     * @param $obj object
     * @return string
     */
    public function changeIAOTags($strBuffer,$sector,$obj)
    {
        $tags = preg_split('/\{\{([^\}]+)\}\}/', $strBuffer, -1, PREG_SPLIT_DELIM_CAPTURE);
        $strBuffer = '';
        $arrCache = array();

        for($_rit = 0; $_rit < count($tags); $_rit = $_rit + 2)
        {
            $strBuffer .= $tags[$_rit];
            $strTag = $tags[$_rit+1];

            // Skip empty tags
            if ($strTag == '')
            {
                continue;
            }

            // Load value from cache array
            if (isset($arrCache[$strTag]))
            {
                $strBuffer .= $arrCache[$strTag];
                continue;
            }


            $parts = trimsplit('::', $strTag);
            $parts[0] = strip_tags($parts[0]);
            $parts[1] = strip_tags($parts[1]);

            $arrCache[$strTag] = '';

            // Replace the tag
            switch (strtolower($parts[0]))
            {
                // get table - Data
                case 'member':
                    $objInfo = DB::getInstance()->prepare('SELECT `m`.* FROM `tl_member` `m` WHERE `m`.`id`=?')
                        ->limit(1)
                        ->execute($obj->member);

                    $objInfo->gender = ($objInfo->gender == 'male') ? $GLOBALS['TL_LANG']['tl_iao']['gender']['male'] : $GLOBALS['TL_LANG']['tl_iao']['gender']['female'];
                    $arrCache[$strTag] = $objInfo->{$parts[1]};

                    break;
                case 'invoice':
                    $invoiceId = false;
                    $sector = strtolower($sector);

                    //relative from this section
                    if($sector == 'invoice') $invoiceId = $obj->id;
                    elseif($sector == 'reminder') $invoiceId = $obj->invoice_id;

                    if($invoiceId) {
                        $objInfo = DB::getInstance()->prepare('SELECT `i`.* FROM `tl_iao_invoice` `i`  WHERE `i`.`id`=?')
                            ->limit(1)
                            ->execute($invoiceId);

                        $objInfo->expiry_date = date($GLOBALS['TL_CONFIG']['dateFormat'], $objInfo->expiry_date);
                        $objInfo->brutto = $this->getPriceStr($objInfo->price_brutto);
                        $objInfo->netto = $this->getPriceStr($objInfo->price_netto);

                        $arrCache[$strTag] = $objInfo->{$parts[1]};
                    }
                    break;
                case 'reminder':

                    $objInfo = DB::getInstance()->prepare('SELECT `r`.* FROM `tl_iao_reminder` `r`  WHERE `r`.`id`=?')
                        ->limit(1)
                        ->execute($obj->id);

                    $objInfo->periode_date = date($GLOBALS['TL_CONFIG']['dateFormat'],$objInfo->periode_date);
                    $objInfo->step = !strlen($objInfo->step) ? 1 : $objInfo->step;
                    $objInfo->postageStr = (((int)($objInfo->postage) <= 0)) ? '' : $this->getPriceStr($objInfo->postage);
                    $objInfo->taxStr = ((int)($objInfo->tax) > 0) ? $objInfo->tax.'%' : '';
                    $objInfo->sum = $this->getReminderSum($obj->id);
                    $objInfo->sumStr = $this->getPriceStr($objInfo->sum);

                    $arrCache[$strTag] = $objInfo->{$parts[1]};
                    break;

                case 'credit':

                    $objInfo = DB::getInstance()->prepare('SELECT `tl_iao_credit`.* FROM `tl_iao_credit` `c`  WHERE `c`.`id`=?')
                        ->limit(1)
                        ->execute($obj->id);

                    $arrCache[$strTag] = $objInfo->{$parts[1]};
                    break;

                case 'project':
                    // holt alle Projektdaten anhand der Eltern-ID (pid) aus den bereichen invoice_offer_credit etc. die ein Projekt zugeordnet sein können.
                    $objInfo = DB::getInstance()->prepare('SELECT * FROM `tl_iao_projects` WHERE `id`=?')
                        ->limit(1)
                        ->execute($obj->pid);

                    $arrCache[$strTag] = $objInfo->{$parts[1]};
                    break;

                case 'agreement':

                    $objInfo = DB::getInstance()->prepare('SELECT * FROM `tl_iao_agreements` WHERE `id`=?')
                        ->limit(1)
                        ->execute($obj->id);

                    if($parts[2] == 'date_format') $arrCache[$strTag] = date( $GLOBALS['TL_CONFIG']['dateFormat'], $objInfo->{$parts[1]});
                    else $arrCache[$strTag] = $objInfo->{$parts[1]};
                    break;

                case 'iao':
                    switch(strtolower($parts[1]))
                    {
                        case 'current_date':
                            $arrCache[$strTag] = date($GLOBALS['TL_CONFIG']['dateFormat']);
                            break;
                    }
                    break;
            }
            $strBuffer .= $arrCache[$strTag];
        }
        return $strBuffer;
    }

    /**
     * @param string $table
     * @param $id
     * @return bool|DB\Result|\Database\Result|object
     */
    public function getTemplateObject($table='tl_iao_templates', $id)
    {
        if((int) $id > 0 && strlen($table) > 0)
        {
            //Posten-Template holen
            return DB::getInstance()->prepare('SELECT * FROM '.$table.' WHERE id=?')
                ->limit(1)
                ->execute($id);
        }
        return false;
    }
    /**
     * generiert für die jeweilige Mahnungs-Stufe eine PDF und gibt diese an den Browser
     * @param integer
     * @param string
     * @return mixed
     */
    public function generateReminderPDF($id, $type = '')
    {
        //wenn type oder id fehlen abbrechen
        if((int) $id < 1 || strlen($type) < 1) return;

        $dataObj = DB::getInstance()->prepare('SELECT * FROM `tl_iao_'.$type.'` WHERE `id`=?')->limit(1)->execute($id);
        if($dataObj->numRows < 1) return;
        $row = $dataObj->row();

        $settings = $this->getSettings($row['setting_id']);

        //template zuweisen
        $templateFile = ($type == 'reminder') ? $settings['iao_'.$type.'_'.$row['step'].'_pdf'] : $settings['iao_'.$type.'_pdf'];

        //wenn eine feste PDF zugewiesen wurde
        if(strlen($row[$type.'_pdf_file']) > 0 )
        {
            $objPdf = 	\FilesModel::findByPk($row[$type.'_pdf_file']);
            if(!empty($objPdf->path) && file_exists(TL_ROOT . '/' . $objPdf->path))
            {

                header("Content-type: application/pdf");
                header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // Date in the past
                header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
                header('Content-Length: '.strlen($row[$type.'_pdf_file']));
                header('Content-Disposition: inline; filename="'.basename($objPdf->path).'";');

                // The PDF source is in original.pdf
                readfile(TL_ROOT . '/' . $row[$type.'_pdf_file']);
                exit();
            }
        }

        // $invoiceObj = $this->Database->prepare('SELECT * FROM `tl_iao_invoice` WHERE `id`=?')->limit(1)->execute($row['invoice_id']);
        $invoiceObj = IaoInvoiceModel::findById($row['invoice_id']);
        $reminder_Str = $GLOBALS['TL_LANG']['tl_iao_reminder']['steps'][$row['step']].'-'.$invoiceObj->invoice_id_str.'-'.$row['id'];

        $pdfname = $GLOBALS['TL_LANG']['tl_iao']['types'][$type].'-'.$row[$type.'_id_str'];

        // Calculating dimensions
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
        require_once(dirname(__FILE__).'/iaoPDF.php');

        $objPdfTemplate = 	\FilesModel::findByUuid($templateFile);
        if(strlen($objPdfTemplate->path) < 1 || !file_exists(TL_ROOT . '/' . $objPdfTemplate->path) ) return;  // template file not found


        $pdf = new \iaoPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true);
        $pdf->setSourceFile( TL_ROOT . '/' .$objPdfTemplate->path);          // Set PDF template

        // Set document information
        $pdf->iaoSettings = $settings;
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
        $row['address_text'] = $this->changeIAOTags($row['address_text'], $type, $row['id']);
        $row['address_text'] = $this->changeTags($row['address_text']);
        $pdf->drawAddress($row['address_text']);

        //Mahnungsnummer
        $pdf->drawDocumentNumber($reminder_Str);

        //Datum
        $pdf->drawDate(date($GLOBALS['TL_CONFIG']['dateFormat'],$row[$type.'_tstamp']));

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

    /**
     * generiert von den verschiedenen Bereiche (offer,invoice,credit) eine PDF und gibt diese an den Browser
     * @param integer
     * @param string
     * @return mixed
     */
    public function generatePDF($id, $type = '')
    {
        //wenn type oder id fehlen abbrechen
        if((int) $id < 1 || strlen($type) < 1) return;

        $dataObj = $this->Database->prepare('SELECT * FROM `tl_iao_'.$type.'` WHERE `id`=?')->limit(1)->execute($id);
        if($dataObj->numRows < 1) return;
        $row = $dataObj->row();

        $settings = $this->getSettings($row['setting_id']);

        //template zuweisen
        $templateFile = ($type == 'reminder') ? $settings['iao_'.$type.'_'.$row['step'].'_pdf'] : $settings['iao_'.$type.'_pdf'];

        //wenn eine feste PDF zugewiesen wurde
        if(strlen($row[$type.'_pdf_file']) > 0 )
        {
            $objPdf = 	\FilesModel::findByPk($row[$type.'_pdf_file']);
            if(!empty($objPdf->path) && file_exists(TL_ROOT . '/' . $objPdf->path))
            {

                header("Content-type: application/pdf");
                header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // Date in the past
                header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
                header('Content-Length: '.strlen($row[$type.'_pdf_file']));
                header('Content-Disposition: inline; filename="'.basename($objPdf->path).'";');

                // The PDF source is in original.pdf
                readfile(TL_ROOT . '/' . $row[$type.'_pdf_file']);
                exit();
            }
        }

        $pdfname = $GLOBALS['TL_LANG']['tl_iao']['types'][$type].'-'.$row[$type.'_id_str'];

        // Calculating dimensions
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
        require_once(dirname(__FILE__).'/iaoPDF.php');

        $objPdfTemplate = 	\FilesModel::findByUuid($templateFile);
        if(strlen($objPdfTemplate->path) < 1 || !file_exists(TL_ROOT . '/' . $objPdfTemplate->path) ) return;  // template file not found


        $pdf = new \iaoPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true);
        $pdf->setSourceFile( TL_ROOT . '/' .$objPdfTemplate->path);          // Set PDF template

        // Set document information
        $pdf->iaoSettings = $settings;
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle($pdfname);
        $pdf->SetSubject($pdfname);
        $pdf->SetKeywords($pdfname);

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
        $row['address_text'] = $this->changeIAOTags($row['address_text'], $type, $row['id']);
        $row['address_text'] = $this->changeTags($row['address_text']);
        $pdf->drawAddress($row['address_text']);

        //Rechnungsnummer
        $pdf->drawDocumentNumber($row[$type.'_id_str']);

        //Datum
        $pdf->drawDate(date($GLOBALS['TL_CONFIG']['dateFormat'],$row[$type.'_tstamp']));

        //ausgeführt am
        if($row['execute_date'])
        {
            $newdate= $row['execute_date'];
            $pdf->drawInvoiceExecuteDate(date($GLOBALS['TL_CONFIG']['dateFormat'],$newdate));
        }

        //gueltig bis
        if($row['expiry_date'])
        {
            $newdate= $row['expiry_date'];
            $pdf->drawInvoiceDurationDate(date($GLOBALS['TL_CONFIG']['dateFormat'],$newdate));
        }

        //Text vor der Posten-Tabelle
        if(strip_tags($row['before_text']))
        {
            $row['before_text'] = $this->changeIAOTags($row['before_text'], $type, $row['id']);
            $row['before_text'] = $this->changeTags($row['before_text']);
            $pdf->drawTextBefore($row['before_text']);
        }

        //Posten-Tabelle
        $header = array('Menge','Beschreibung','Einzelpreis','Gesamt');
        $fields = $this->getPosten($row['id'], $type);

        $pdf->drawPostenTable($header, $fields, $row['noVat']);

        //Text nach der Posten-Tabelle
        if(strip_tags($row['after_text']))
        {
            $row['after_text'] = $this->changeIAOTags($row['after_text'], $type, $row['id']);
            $row['after_text'] = $this->changeTags($row['after_text']);
            $pdf->drawTextAfter($row['after_text']);
        }

        // Close and output PDF document
        $pdf->lastPage();
        $pdf->Output($pdfname. '.pdf', 'D');

        // Stop script execution
        exit();
    }

    public function getPosten($id, $type='')
    {
        $posten = array();

        //wenn type oder id fehlen abbrechen
        if((int) $id < 1 || strlen($type) < 1) return $posten;

        //hole zum jeweiligen Modul gehoerende Sprachdatei
        $this->loadLanguageFile('tl_iao_'.$type.'_items');

        //hole alle zum Elternelemente gehoerende Eintraege
        $resultObj = $this->Database->prepare('SELECT * FROM `tl_iao_'.$type.'_items` WHERE `pid`=? AND `published`= ? ORDER BY `sorting`')
            ->execute($id,1);

        // wenn keine vorhanden dann leeres array zurueck
        if($resultObj->numRows <= 0) return $posten;

        while($resultObj->next())
        {
            //zum rechnen evtl vorhandenes deutsches format in english umwandeln
            $resultObj->price = str_replace(',','.',$resultObj->price);

            //$einzelpreis = ($resultObj->vat_incl == 1) ? $this->getBruttoPrice($resultObj->price,$resultObj->vat) : $resultObj->price;

            //Ueberschrift zum Postenausgabetext hinzufuegen
            if($resultObj->headline_to_pdf == 1) $resultObj->text = substr_replace($resultObj->text, '<p><strong>'.$resultObj->headline.'</strong><br>', 0, 3);
            $resultObj->text = $this->changeTags($resultObj->text);

            // get units from DB-Table
            $unitObj = $this->Database->prepare('SELECT * FROM `tl_iao_item_units` WHERE `value`=?')
                ->limit(1)
                ->execute($resultObj->amountStr);

            $formatCount = stripos($resultObj->count, '.') ? number_format($resultObj->count,1,',','.') : $resultObj->count;

            $posten['fields'][] = array
            (
                $formatCount.' '.(((float)$resultObj->count <= 1) ? $unitObj->singular : $unitObj->majority),
                $resultObj->text,
                number_format($resultObj->price,2,',','.'),
                number_format(($resultObj->price * $resultObj->count),2,',','.')
            );

            $posten['pagebreak_after'][] = $resultObj->pagebreak_after;
            $posten['type'][] = $resultObj->type;

            $posten['discount'] = false;

            //aktuell berechnete netto-summe
            $netto = $resultObj->price * $resultObj->count;

            if($resultObj->operator == '-')
            {
                $posten['summe']['price'] -= $resultObj->price;
                $posten['summe']['netto'] -= $netto;
            }
            else
            {
                $posten['summe']['price'] += $resultObj->price;
                $posten['summe']['netto'] += $netto;
            }

            $parentObj = $this->Database->prepare('SELECT * FROM `tl_iao_'.$type.'` WHERE `id`=?')
                ->limit(1)
                ->execute($id);

            if($parentObj->noVat != 1)
            {
                $posten['summe']['mwst'][$resultObj->vat] += $this->getUmstAmount($netto,$resultObj->vat);
            }
        }

        $posten['summe']['netto_format'] =  number_format($posten['summe']['netto'],2,',','.');
        $posten['summe']['brutto'] = $this->getBruttoPrice($posten['summe']['netto'],$resultObj->vat);
        $posten['summe']['brutto_format'] =  number_format($posten['summe']['brutto'],2,',','.');

        return $posten;
    }

    /**
     * get the sum incl. tax and postage
     * @param object
     * @return integer
     */
    public function getReminderSum($reminderId)
    {
        if($reminderId)
        {
            $this->reminderObj = $this->Database->prepare('SELECT `r`.*, `i`.`price_netto` `netto`, `i`.`price_brutto` `brutto` FROM `tl_iao_reminder` `r` LEFT JOIN `tl_iao_invoice` `i` ON `r`.`invoice_id` = `i`.`id`  WHERE `r`.`id`=?')
                ->limit(1)
                ->execute($reminderId);

            $step = !strlen($this->reminderObj->step) ? 1 : $this->reminderObj->step;
            $postage = (float) $this->reminderObj->postage;
            $tax = (float) $this->reminderObj->tax;
            $price = ($this->reminderObj->tax_typ == 1) ? $this->reminderObj->brutto : $this->reminderObj->netto;
            $unpaid = ((float)($this->reminderObj->unpaid) > 0) ? (float)$this->reminderObj->unpaid : (float)$price;
            $sum = $unpaid;

            if((float) $tax > 0) $sum = (($sum * (100+$tax))/100);
            if((float) $postage > 0) $sum += $postage;

            return $sum;
        }
    }

    /**
     * set monday if date on weekend
     * @param integer
     * @param integer
     * @return integer
     */
    public function noWE($time,$dur)
    {
        //auf Sonabend prüfen wenn ja dann auf Montag setzen
        if(date('N',$time+($dur * 24 * 60 * 60)) == 6)  $dur = $dur+2;

        //auf Sontag prüfen wenn ja dann auf Montag setzen
        if(date('N',$time+($dur * 24 * 60 * 60)) == 7)  $dur = $dur+1;

        $nextDate = $time+($dur * 24 * 60 * 60);

        return	$nextDate;
    }


    /**
     * get the Reminder-Status (Recall = 1, first reminder = 2, second reminder = 3 third reminder = 4)
     * @param integer
     * @return integer
     */
    public function getReminderStatus($invoiceId = 0)
    {
        if($invoiceId == 0) return false;

        $status = 1; //erinnerung
        $this->import('Database');

        $statusObj = $this->Database->prepare('SELECT count(*) as c FROM `tl_iao_reminder` WHERE `invoice_id`=? AND `published`=1 ORDER BY `id` DESC')
            ->execute($invoiceId);

        if($statusObj->numRows > 0) return  $statusObj->c;
    }

    /**
     * fill Reminderfields
     * @param integer
     * @return integer
     */
    public function fillReminderFields($invoiceID = 0, $reminderObj)
    {

        $objMember = $this->Database->prepare('SELECT `m`.*,`i`.`price_brutto`,`i`.`address_text`,`i`.`invoice_id_str` FROM `tl_iao_invoice` as `i` LEFT JOIN `tl_member` as `m` ON `i`.member = `m`.`id` WHERE `i`.`id`=?')
            ->limit(1)
            ->execute($invoiceID);

        if(!empty($objMember->address_text))
        {
            $address_text = $objMember->address_text;
        }
        else
        {
            $address_text = '<p>'.$objMember->company.'<br />'.($objMember->gender!='' ? $GLOBALS['TL_LANG']['tl_iao_reminder']['gender'][$objMember->gender].' ':'').($objMember->title ? $objMember->title.' ':'').$objMember->firstname.' '.$objMember->lastname.'<br />'.$objMember->street.'</p>';
            $address_text .='<p>'.$objMember->postal.' '.$objMember->city.'</p>';
        }

        $testStepObj = $this->Database->prepare('SELECT `step`,`sum` FROM `tl_iao_reminder` WHERE `invoice_id`=? AND `id`!=? ORDER BY `id` DESC')
            ->limit(1)
            ->execute($invoiceID,$reminderObj->id);

        $newStep = ($testStepObj->numRows > 0) ? $testStepObj->step +1 : 1;

        //set an error if newStep > 4
        if($newStep > 4)
        {
            $_SESSION['TL_ERROR'][] = $GLOBALS['TL_LANG']['tl_iao_reminder']['to_much_steps'].$objMember->invoice_id_str;
            $_SESSION['TL_CONFIRM'] = '';
            setcookie('BE_PAGE_OFFSET', 0, 0, '/');
            $this->redirect(str_replace('&act=create', '', $this->Environment->request));
        }

        $newUnpaid = (($testStepObj->numRows > 0) && ((int) $testStepObj->sum > 0)) ? $testStepObj->sum : $objMember->price_brutto;
        $tax =  $GLOBALS['TL_CONFIG']['iao_reminder_'.$newStep.'_tax'];
        $postage =  $GLOBALS['TL_CONFIG']['iao_reminder_'.$newStep.'_postage'];
        $periode_date = $this->getPeriodeDate($reminderObj);

        $set = array
        (
            'title' => $GLOBALS['TL_LANG']['tl_iao_reminder']['steps'][$newStep].'::'.$invoiceID,
            'address_text' => $address_text,
            'member' =>  $objMember->id,
            'unpaid' => $newUnpaid,
            'step' => $newStep,
            'text' => $GLOBALS['TL_CONFIG']['iao_reminder_'.$newStep.'_text'],
            'periode_date' => $periode_date,
            'tax' => $tax,
            'postage' =>  $postage
        );

        $this->Database->prepare('UPDATE `tl_iao_reminder` %s WHERE `id`=?')
            ->set($set)
            ->execute($reminderObj->id);

        //set sum after other facts is saved
        $text_finish = $this->changeIAOTags($GLOBALS['TL_CONFIG']['iao_reminder_'.$newStep.'_text'],'reminder',$reminderObj->id);
        $text_finish = $this->changeTags($text_finish);

        $set = array
        (
            'sum' => $this->getReminderSum($reminderObj->id),
            'text_finish' => $text_finish
        );

        $this->Database->prepare('UPDATE `tl_iao_reminder` %s WHERE `id`=?')
            ->set($set)
            ->execute($reminderObj->id);

        //update invoice-data with current reminder-step
        $this->Database->prepare('UPDATE `tl_iao_invoice` SET `reminder_id` = ?  WHERE `id`=?')
            ->execute($reminderObj->id, $invoiceID);
    }

}
