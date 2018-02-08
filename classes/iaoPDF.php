<?php
/**
 *
 * @copyright  Sven Rhinow 2011-2014
 * @author     sr-tag Sven Rhinow Webentwicklung <http://www.sr-tag.de>
 * @package    invoice_and_offer
 * @license    LGPL
 * @filesource
 */

/**
 * Run in a custom namespace, so the class can be replaced
 */
namespace iao;

// Include library
use setasign\Fpdi\TcpdfFpdi;

require_once(TL_ROOT . '/system/config/tcpdf.php');

class iaoPDF extends TcpdfFpdi
{

	/**
	 * Actual num_pages
	 * @var integer
	 */
	var $num_pages;

	/**
	 * Actual current_page
	 * @var integer
	 */
	var $current_page = 1;

	//-- loads automatically the next side of PDF template
	public function AddPage($orientation='', $format='', $keepmargins=false, $tocpage=false)
	{
		parent::AddPage($orientation, $format, $keepmargins, $tocpage);

		$this->useTemplate( $this->importPage( $this->current_page ) );
		if($this->current_page < $this->num_pages) $this->current_page++;
	}

	//-- store the number of pages found
	function setSourceFile($filename)
	{

		$this->num_pages = parent::setSourceFile($filename);
		return $this->num_pages;
	}

	public function drawAddress($text)
	{
		$y = $this->getY();
		$this->SetFont('helvetica', '', 10);
		$this->SetFillColor(255, 255, 255);
		// $this->SetXY(34, 84.5);
		if($y == 0) $y = 34;
		$this->writeHTMLCell(120, 0, '', 53, $text, 0, 0, 1, true, 'L', true);
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
		$this->SetFont('helvetica', '', 9);
		$y = $this->getY();
		$this->writeHTMLCell(185, '', 13, $y+15, $text, 0, 1, false, false, 'J', true);
	}

	public function drawTextAfter($text)
	{
		$this->SetFont('helvetica', '', 9);
		$y = $this->getY();
		$this->writeHTMLCell(185, '', 13, $y+5, $text, 0, 1,false, true, 'L', true);
	}

	// Page footer
	public function Footer()
	{
		// Position at 15 mm from bottom
		$this->SetY(-42);

		// Set font
		$this->SetFont('helvetica', 'I', 8);

		// Page number
		$this->Cell(0, 10, 'Seite '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
	}

	public function drawPostenTable($header, $data, $noVat)
	{
		if(count($data['fields'])>0)
		{
			$this->SetFont('helvetica', '', 9);

			// Header
			$w = array(25, 100, 25, 30);
			$align = array('left','left','right','right');

			$num_headers = count($header);
			$header_td = '';
			$header_tr = '';

			for($i = 0; $i < $num_headers; ++$i)
			{
				$header_td .= '<td style="width:'.$w[$i].'mm; text-align:'.$align[$i].';"><b>'.$header[$i].'</b></td>';
			}
			$header_tr = '<tr>'.$header_td.'</tr>';

			// Data
			$fill = 0;
			$posten_td = '';
			$posten_tr = '';
			$postenTable = '';

			foreach($data['fields'] as $k => $row)
			{

				if($data['type'][$k] == 'devider')
				{
					$postenTable = '<table class="posten-table" style="width:210mm; border-bottom:1px solid #000;" cellpadding="3" cellspacing="3">'.$header_tr.$posten_tr.'</table>';
					$y = $this->getY();
					$this->writeHTMLCell(185, '', 13, $y+8, $postenTable, 0, 1,false, true, 'L', true);
					$posten_td = '';
					$posten_tr = '';
					$pagebreak = true;
					$this->AddPage();
				}
				else
				{
					$pagebreak = false;
					$posten_td =	'<td style="width:'.$w[0].'mm; text-align:'.$align[0].';border:5pt solid white;">'.$row[0].'</td>'.
									'<td style="width:'.$w[1].'mm; text-align:'.$align[1].';border:5pt solid white;">'.$row[1].'</td>'.
				 					'<td style="width:'.$w[2].'mm; text-align:'.$align[2].';border:5pt solid white;">'.$row[2].' '.$this->iaoSettings['iao_currency'].'</td>'.
				 					'<td style="width:'.$w[3].'mm; text-align:'.$align[3].';border:5pt solid white;">'.$row[3].' '.$this->iaoSettings['iao_currency'].'</td>';
		   			$posten_tr .= '<tr>'.$posten_td.'</tr>';

					if($data['pagebreak_after'][$k] == 1)
					{
						$postenTable = '<table class="postentable" style="width:210mm; border-bottom:1px solid #000;" cellpadding="3" cellspacing="3">'.$header_tr.$posten_tr.'</table>';
						$y = $this->getY();
						$this->writeHTMLCell(185, '', 13, $y+8, $postenTable, 0, 1,false, true, 'L', true);
						$posten_td = '';
						$posten_tr = '';
						$pagebreak = true;
						$this->AddPage();
					}
				}
			}

			if(!$pagebreak)
			{
				$postenTable = '<table class="postentable" style="width:210mm; border-bottom:1px solid #000;" cellpadding="3" cellspacing="3">'.$header_tr.$posten_tr.'</table>';
				$y = $this->getY();
				$this->writeHTMLCell(185, '', 13, $y+8, $postenTable, 0, 1,false, true, 'L', true);
			}

			//Summe
			$summe_tr = '<tr>
							<td style="text-align:right; width:'.($w[0]+$w[1]+$w[2]+3).'mm;">
							Nettobetrag:<br />';

			if($noVat != 1)
			{	
				reset($data['summe']['mwst']);

				foreach($data['summe']['mwst'] as $k => $v)
				{
					 $summe_tr .= 'MwSt. '.$k.'%:<br />';
				}
			}else $summe_tr .= 'ohne Mehrwertsteuer<br />';

			$summe_tr .= '<b>Gesamt '.$this->iaoSettings['iao_currency_symbol'].':</b>';

			if($data['discount'])
			{
				$summe_tr .= '<br>'.$data['discount']['discount_title'].':';
			}

			$summe_tr .= '</td><td style="text-align:right;width:'.$w[4].'mm; ">'.$data['summe']['netto_format'].' '.$this->iaoSettings['iao_currency'].'<br />';
	
			if($noVat != 1)
			{	
				reset($data['summe']['mwst']);

				foreach($data['summe']['mwst'] as $k => $v)
				{

				    if((int) $k != 0) $summe_tr .= number_format($v,2,',','.').' '.$this->iaoSettings['iao_currency'].'<br />';
				}
			}else $summe_tr .= '&nbsp;<br>';
	
			$summe_tr .= '<b>'.$data['summe']['brutto_format'].' '.$this->iaoSettings['iao_currency'].'</b>';

			if($data['discount'])
			{
				switch($data['discount']['discount_operator'])
				{
					case '-':
						$discount_val = $data['summe']['brutto'] - $data['discount']['discount_value'];
					break;
					case '+':
						$discount_val = $data['summe']['brutto'] + $data['discount']['discount_value'];
					break;
					case '%':
					default:
						$discount_val = $data['summe']['brutto'] - (($data['summe']['brutto']  * $data['discount']['discount_value'])/100);
				}

				$summe_tr .= '<br>'.number_format($discount_val,2,',','.').' '.$this->iaoSettings['iao_currency'];
			}

			$summe_tr .= '</td></tr>';

			$summeTable = '<table style="width:210mm;" cellpadding="0" cellspacing="0">'.$summe_tr.'</table>
							<div style="border-bottom:1px solid black; border-top:1px solid black; font-size:1px; line-height:1px;"></div>';

			$y = $this->getY();
			$this->writeHTMLCell(184, '', 13, $y+3, $summeTable, 0, 1,false, true, 'L', true);
		}

	}
}
