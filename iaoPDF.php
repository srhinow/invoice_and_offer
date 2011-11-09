<?php

// Include library
require_once(TL_ROOT . '/system/config/tcpdf.php');
require_once(TL_ROOT . '/plugins/tcpdf/tcpdf.php');
require_once(TL_ROOT . '/plugins/fpdi/fpdi.php');                    // FPDI plugin
require_once(TL_ROOT . '/system/modules/pdf-template/tplpdf.php');
		         
class iaoPDF extends TPLPDF
{
   public function drawAddress($text)
   {
	$y = $this->getY();
	$this->SetFont('helvetica', '', 10);
	$this->SetFillColor(255, 255, 255);
	$this->writeHTMLCell(120, '', '', $y+2, $text, 0, 0, 1, true, 'L', true);
   }
   
   public function drawDocumentNumber($nr)
   {
	$this->SetFont('helvetica', '', 8);
	$this->SetXY(34, 84.5);
	$this->Cell(60,0,$nr);   
   }
   
   public function drawDate($date)
   {
	$this->SetFont('helvetica', '', 8);
	$this->SetXY(34, 89);
	$this->Cell(60,0,$date);
   }
   
   public function drawExecuteDate($date)
   {
	$this->SetFont('helvetica', '', 8);
	$this->SetXY(101, 89);
	$this->Cell(60,0,$date);
   }   
   
   public function drawExpiryDate($date)
   {
	$this->SetFont('helvetica', '', 8);
	$this->SetXY(95, 89);
	$this->Cell(60,0,$date);
   } 
   public function drawInvoiceExecuteDate($date)
   {
	$this->SetFont('helvetica', '', 8);
	$this->SetXY(102, 84.5);
	$this->Cell(60,0,$date);
   }   
   public function drawInvoiceDurationDate($date)
   {
	$this->SetFont('helvetica', '', 8);
	$this->SetXY(102, 89);
	$this->Cell(60,0,$date);
   }       
   public function drawTextBefore($text)
   {
	$this->SetFont('helvetica', '', 10);
	$y = $this->getY();
	$this->writeHTMLCell(185, '', 13, $y+15, $text, 0, 1, false, false, 'J', true);   
   }
   
   public function drawTextAfter($text)
   {
	$this->SetFont('helvetica', '', 10);
	$y = $this->getY();
	$this->writeHTMLCell(185, '', 13, $y+5, $text, 0, 1,false, true, 'L', true);       
   }
         // Page footer
	public function Footer() {
	    // Position at 15 mm from bottom
	    $this->SetY(-42);
	    // Set font
	    $this->SetFont('helvetica', 'I', 8);
	    // Page number
	    $this->Cell(0, 10, 'Seite '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
	}  
   public function drawPostenTable($header,$data)
   {
        if(count($data['fields'])>0)
        {
	    $this->SetFont('helvetica', '', 10);
	    // Header
	    $w = array(20, 105, 25, 30);
	    $align = array('left','left','right','right');
	    
	    $num_headers = count($header);
	    $header_td = '';
	    $header_tr = '';
	    
	    for($i = 0; $i < $num_headers; ++$i) {
		 $header_td .= '<td style="width:'.$w[$i].'mm; text-align:'.$align[$i].';"><b>'.$header[$i].'</b></td>';
	    }
	    $header_tr = '<tr>'.$header_td.'</tr>';
    
	    // Data
	    $fill = 0;
	    $posten_td = '';
	    $posten_tr = '';
	    
	    foreach($data['fields'] as $row) {
		$posten_td = '<td style="width:'.$w[0].'mm; text-align:'.$align[0].';border:5pt solid white;">'.$row[0].'</td>'.
			     '<td style="width:'.$w[1].'mm; text-align:'.$align[1].';border:5pt solid white;">'.$row[1].'</td>'.
			     '<td style="width:'.$w[2].'mm; text-align:'.$align[2].';border:5pt solid white;">'.$row[2].' '.$GLOBALS['TL_CONFIG']['iao_currency'].'</td>'.
			     '<td style="width:'.$w[3].'mm; text-align:'.$align[3].';border:5pt solid white;">'.$row[3].' '.$GLOBALS['TL_CONFIG']['iao_currency'].'</td>';
	       $posten_tr .= '<tr>'.$posten_td.'</tr>';
	    }
	    $postenTable = '<table style="width:210mm; border-bottom:1px solid black;" cellpadding="3" cellspacing="3">'.$header_tr.$posten_tr.'</table>';
	    $y = $this->getY();
	    $this->writeHTMLCell(185, '', 13, $y+8, $postenTable, 0, 1,false, true, 'L', true);  
	    
	    //Summe
	    $summe_tr = '<tr>
	    <td style="text-align:right; width:'.($w[0]+$w[1]+$w[2]+3).'mm;">
	    Nettobetrag '.$data['vat'].'%:<br />
	    MwSt. '.$data['vat'].'%:<br />
	    <b>Gesamt '.$GLOBALS['TL_CONFIG']['iao_currency_symbol'].':</b><br />
	    <div style="border-bottom:1px solid black; font-size:1px; line-height:1px;"></div>
	    </td>
	    <td style="text-align:right;width:'.$w[4].'mm; ">
	    '.$data['summe']['netto'].' '.$GLOBALS['TL_CONFIG']['iao_currency'].'<br />
	    '.$data['summe']['mwst'].' '.$GLOBALS['TL_CONFIG']['iao_currency'].'<br />
	    <b>'.$data['summe']['brutto'].' '.$GLOBALS['TL_CONFIG']['iao_currency'].'</b><br />
	    <div style="border-bottom:1px solid black; font-size:1px; line-height:1px;"></div>
	    </td></tr>';
	    $summeTable = '<table style="width:210mm; border-bottom:1px solid black;" cellpadding="0" cellspacing="0">'.$summe_tr.'</table>';
	    
	    $y = $this->getY();
	    $this->writeHTMLCell(184, '', 13, $y+3, $summeTable, 0, 1,false, true, 'L', true); 
	}         
        
   }
}