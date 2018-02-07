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
 * Class iao_invoice
 * Provide methods to handle invoice_and_offer-module.
 */
class iao_invoice extends Backend
{
	/**
	 * Export Invoices
	 */
	public function exportInvoices()
	{

		if ($this->Input->post('FORM_SUBMIT') == 'tl_iao_export')
		{
			$csv_export_dir = $this->Input->post('csv_export_dir', true);

			$this->import('Files');

			// Check the file names
			if (!$csv_export_dir || is_array($csv_export_dir))
			{
				$_SESSION['TL_ERROR'][] = $GLOBALS['TL_LANG']['ERR']['all_fields'];
				$this->reload();
			}

			// Skip invalid entries
			if (!is_dir(TL_ROOT . '/' . $csv_export_dir))
			{
				$_SESSION['TL_ERROR'][] = sprintf($GLOBALS['TL_LANG']['ERR']['importFolder'], $csv_export_dir);
				$this->reload();
			}

			// check if the directory writeable
			if (!is_writable(TL_ROOT . '/' . $csv_export_dir))
			{
				$_SESSION['TL_ERROR'][] = sprintf($GLOBALS['TL_LANG']['ERR']['PermissionDenied'],TL_ROOT . '/' . $csv_export_dir);
				$this->reload();
			}

			// get DB-Fields as arrays
			$this->import('Database');
			$invoice_fields = $this->Database->listFields('tl_iao_invoice');
			$invoice_items_fields = $this->Database->listFields('tl_iao_invoice_items');

			$invoice_export_csv = $this->Input->post('export_invoice_filename').'.csv';
			$invoice_items_export_csv = $this->Input->post('export_invoice_item_filename').'.csv';

			// work on tl_iao_invoice
			$dbObj = $this->Database->prepare('SELECT * FROM `tl_iao_invoice`')->execute();

			$isOneLine = true;
			$oneLine = array();
			$linesArr = array();

			while($dbObj->next())
			{
				$lineA  = array();

				foreach($invoice_fields as $i_field)
				{
					//exclude index Fields
					if($i_field['type']=='index') continue;

					if($isOneLine)  $oneLine[] = $i_field['name'];
					$lineA[] = $dbObj->$i_field['name'];

				}

				if($isOneLine) $linesArr[] = $oneLine;

				$linesArr[] = $lineA;
				$isOneLine = false;
			}

			//set handle from file
			$fp = $this->Files->fopen($csv_export_dir.'/'.$invoice_export_csv,'w');
			$seperators = array('comma'=>',','semicolon'=>';','tabulator'=>'\t','linebreak'=>'\n');

			foreach ($linesArr as $line)
			{
				fputcsv($fp,  $line, $seperators[$this->Input->post('separator')]);
			}

			$this->Files->fclose($fp);

			// work on tl_iao_invoice_items
			$dbObj = $this->Database->prepare('SELECT * FROM `tl_iao_invoice_items`')->execute();

			$isOneLine = true;
			$oneLine = array();
			$linesArr = array();

			while($dbObj->next())
			{
				$lineA  = array();

				foreach($invoice_items_fields as $i_field)
				{
					//exclude index Fields
					if($i_field['type']=='index') continue;

					if($isOneLine)  $oneLine[] = $i_field['name'];
					$lineA[] = $dbObj->$i_field['name'];

				}

				if($isOneLine) $linesArr[] = $oneLine;
				$linesArr[] = $lineA;
				$isOneLine = false;
			}

			//set handle from file
			$fp = $this->Files->fopen($csv_export_dir.'/'.$invoice_items_export_csv,'w');
			$seperators = array('comma'=>',','semicolon'=>';','tabulator'=>'\t','linebreak'=>'\n');

			foreach ($linesArr as $line)
			{
				fputcsv($fp,  $line, $seperators[$this->Input->post('separator')]);
			}

			$this->Files->fclose($fp);

			//after ready export
			$_SESSION['TL_ERROR'] = '';
			$_SESSION['TL_CONFIRM'][] = $GLOBALS['TL_LANG']['tl_iao_invoice']['Invoice_exported'];
			setcookie('BE_PAGE_OFFSET', 0, 0, '/');
			$this->redirect(str_replace('&key=exportInvoices', '', $this->Environment->request));
		}

		$objTree4Export = new FileTree($this->prepareForWidget($GLOBALS['TL_DCA']['tl_iao_invoice']['fields']['csv_export_dir'], 'csv_export_dir', null, 'csv_export_dir', 'tl_iao_invoice'));

		// Return the form
		return '<div id="tl_buttons">
				<a href="'.ampersand(str_replace('&key=exportInvoices', '', $this->Environment->request)).'" class="header_back" title="'.specialchars($GLOBALS['TL_LANG']['MSC']['backBT']).'" accesskey="b">'.$GLOBALS['TL_LANG']['MSC']['backBT'].'</a>
				</div>

				<h2 class="sub_headline">'.$GLOBALS['TL_LANG']['tl_iao_invoice']['exportInvoices'][1].'</h2>'.$this->getMessages().'
				<form action="'.ampersand($this->Environment->request, true).'" id="tl_iao_export" class="tl_form" method="post">
				<div class="tl_formbody_edit">
				<input type="hidden" name="FORM_SUBMIT" value="tl_iao_export" />
				<input type="hidden" name="REQUEST_TOKEN" value="'.REQUEST_TOKEN.'" />
				<fieldset class="tl_tbox block nolegend">
					<select name="separator" id="separator" class="tl_select" onfocus="Backend.getScrollOffset();">
					<option value="comma">'.$GLOBALS['TL_LANG']['MSC']['comma'].'</option>
					<option value="semicolon">'.$GLOBALS['TL_LANG']['MSC']['semicolon'].'</option>
					<option value="tabulator">'.$GLOBALS['TL_LANG']['MSC']['tabulator'].'</option>
					<option value="linebreak">'.$GLOBALS['TL_LANG']['MSC']['linebreak'].'</option>
					</select>'.(($GLOBALS['TL_LANG']['MSC']['separator'][1] != '') ? '<p class="tl_help tl_tip">'.$GLOBALS['TL_LANG']['MSC']['separator'][1].'</p>' : '').'
				</fieldset>

				<fieldset class="tl_tbox block nolegend">
					<div class="w50">
					<h3><label for="ctrl_invoice_filename">'.$GLOBALS['TL_LANG']['tl_iao_invoice']['export_invoice_filename'][0].'</label></h3>
					<input id="ctrl_invoice_filename" class="tl_text" type="text" name="export_invoice_filename" value="'.'tl_iao_invoice_'.date('Y-m-d').'" />'.
					(strlen($GLOBALS['TL_LANG']['tl_iao_invoice']['export_invoice_filename'][1]) ? '<p class="tl_help tl_tip">'.$GLOBALS['TL_LANG']['tl_iao_invoice']['export_invoice_filename'][1].'</p>' : '').'
					</div>
					<div class="w50">
					<h3><label for="ctrl_invoice_item_filename">'.$GLOBALS['TL_LANG']['tl_iao_invoice']['export_invoice_item_filename'][0].'</label></h3>
					<input id="ctrl_invoice_item_filename" class="tl_text"  type="text" name="export_invoice_item_filename" value="'.'tl_iao_invoice_items_'.date('Y-m-d').'" />'.
					(strlen($GLOBALS['TL_LANG']['tl_iao_invoice']['export_invoice_item_filename'][1]) ? '<p class="tl_help tl_tip">'.$GLOBALS['TL_LANG']['tl_iao_invoice']['export_invoice_item_filename'][1].'</p>' : '').'
					</div>
				</fieldset>
				<fieldset class="tl_tbox block nolegend">
					<div class="tl_tbox block">
					<h3><label for="csv_export_dir">'.$GLOBALS['TL_LANG']['tl_iao_invoice']['csv_export_dir'][0].'</label> <a href="contao/files.php" title="' . specialchars($GLOBALS['TL_LANG']['MSC']['fileManager']) . '" onclick="Backend.getScrollOffset(); Backend.openWindow(this, 750, 500); return false;">' . $this->generateImage('filemanager.gif', $GLOBALS['TL_LANG']['MSC']['fileManager'], 'style="vertical-align:text-bottom;"') . '</a></h3>'.$objTree4Export->generate().(strlen($GLOBALS['TL_LANG']['tl_theme']['source'][1]) ? '
					<p class="tl_help tl_tip">'.$GLOBALS['TL_LANG']['tl_iao_invoice']['csv_export_dir'][1].'</p>' : '').'
					</div>
				</fieldset>
				</div>
				<div class="tl_formbody_submit">
				<div class="tl_submit_container">
					<input type="submit" name="save" id="save" class="tl_submit" accesskey="s" value="'.specialchars($GLOBALS['TL_LANG']['tl_iao_invoice']['exportCSV'][0]).'" />
				</div>
				</div>
				</form>';
	}

	/**
	 * Import invoices
	 */
	public function importInvoices()
	{
		if ($this->Input->post('FORM_SUBMIT') == 'tl_iao_import')
		{
			$csv_source = $this->Input->post('csv_source', true);
			$csv_posten_source = $this->Input->post('csv_posten_source', true);

			// Check the invoice file names
			if (!$csv_source)
			{
				$_SESSION['TL_ERROR'][] = $GLOBALS['TL_LANG']['ERR']['all_fields'];
				$this->reload();
			}

			// Check the posten file names
			if (!$csv_posten_source)
			{
				$_SESSION['TL_ERROR'][] = $GLOBALS['TL_LANG']['ERR']['all_fields'];
				$this->reload();
			}

			// Skip invalid invoice-entries
			if (is_dir(TL_ROOT . '/' . $csv_source))
			{
				$_SESSION['TL_ERROR'][] = sprintf($GLOBALS['TL_LANG']['ERR']['importFolder'], basename($csv_source));
				exit;
			}

			// Skip invalid posten-entries
			if (is_dir(TL_ROOT . '/' . $csv_posten_source))
			{
				$_SESSION['TL_ERROR'][] = sprintf($GLOBALS['TL_LANG']['ERR']['importFolder'], basename($csv_posten_source));
				exit;
			}

			$objInvoiceFile = new File($csv_source);

			// Skip anything but .cto files
			if ($objInvoiceFile->extension != 'csv')
			{
				$_SESSION['TL_ERROR'][] = sprintf($GLOBALS['TL_LANG']['ERR']['filetype'], $objInvoiceFile->extension);
				$this->reload();
			}

			$objPostenFile = new File($csv_posten_source);

			// Skip anything but .cto files
			if ($objInvoiceFile->extension != 'csv')
			{
				$_SESSION['TL_ERROR'][] = sprintf($GLOBALS['TL_LANG']['ERR']['filetype'], $objPostenFile->extension);
				$this->reload();
			}

			$csv_files = array
			(
				'invoice'=>$csv_source,
				'invoice_items'=>$csv_posten_source
			);

			// get right libraries
			$lib = $this->Input->post('import_lib');
			$import_path =  TL_ROOT.'/system/modules/invoice_and_offer/html/libs_import/import_'.$lib.'.php';

			if(is_file($import_path))
			{
				include_once($import_path);
				$ClassName = 'import_'.$lib;
				$importlib = new $ClassName();
				return $importlib->extractInvoiceFiles($csv_files, $this);
			}
			else
			{
				$_SESSION['TL_ERROR'][] = sprintf('lib %s gibt es nicht', $import_path);
				$this->reload();
			}

		}

		$objTree4PDF = new FileTree($this->prepareForWidget($GLOBALS['TL_DCA']['tl_iao_invoice']['fields']['pdf_import_dir'], 'pdf_import_dir', null, 'pdf_import_dir', 'tl_iao_invoice'));
		$objTree4Source = new FileTree($this->prepareForWidget($GLOBALS['TL_DCA']['tl_iao_invoice']['fields']['csv_source'], 'csv_source', null, 'csv_source', 'tl_iao_invoice'));
		$objTree4Posten = new FileTree($this->prepareForWidget($GLOBALS['TL_DCA']['tl_iao_invoice']['fields']['csv_posten_source'], 'csv_posten_source', null, 'csv_posten_source', 'tl_iao_invoice'));

		// Return the form
		return '
			<div id="tl_buttons">
			<a href="'.ampersand(str_replace('&key=importInvoices', '', $this->Environment->request)).'" class="header_back" title="'.specialchars($GLOBALS['TL_LANG']['MSC']['backBT']).'" accesskey="b">'.$GLOBALS['TL_LANG']['MSC']['backBT'].'</a>
			</div>

			<h2 class="sub_headline">'.$GLOBALS['TL_LANG']['tl_iao_invoice']['importInvoices'][1].'</h2>'.$this->getMessages().'

			<form action="'.ampersand($this->Environment->request, true).'" id="tl_iao_import" class="tl_form" method="post">

			<div class="tl_formbody_edit">
			<input type="hidden" name="FORM_SUBMIT" value="tl_iao_import" />
			<input type="hidden" name="REQUEST_TOKEN" value="'.REQUEST_TOKEN.'">
			 <fieldset class="tl_tbox block nolegend">
			<div class="w50">
			<h3><label for="import_lib">'.$GLOBALS['TL_LANG']['tl_iao_invoice']['importlib'][0].'</label></h3>
			<select name="import_lib" id="import_lib" class="tl_select" onfocus="Backend.getScrollOffset();">
				<option value="invoiceandoffer">'.$GLOBALS['TL_LANG']['tl_iao_invoice']['importlib_invoiceandoffer'].'</option>
				<option value="phprechnung">'.$GLOBALS['TL_LANG']['tl_iao_invoice']['importlib_phprechnung'].'</option>
			</select>'.(($GLOBALS['TL_LANG']['MSC']['separator'][1] != '') ? '
			<p class="tl_help tl_tip">'.$GLOBALS['TL_LANG']['tl_iao_invoice']['importlib'][1].'</p>' : '').'
			</div>
			</fieldset>

			<fieldset class="tl_tbox block nolegend">
			<div class="w50">
			<h3><label for="separator">'.$GLOBALS['TL_LANG']['MSC']['separator'][0].'</label></h3>
			<select name="separator" id="separator" class="tl_select" onfocus="Backend.getScrollOffset();">
				<option value="comma">'.$GLOBALS['TL_LANG']['MSC']['comma'].'</option>
				<option value="semicolon">'.$GLOBALS['TL_LANG']['MSC']['semicolon'].'</option>
				<option value="tabulator">'.$GLOBALS['TL_LANG']['MSC']['tabulator'].'</option>
				<option value="linebreak">'.$GLOBALS['TL_LANG']['MSC']['linebreak'].'</option>
			</select>'.(($GLOBALS['TL_LANG']['MSC']['separator'][1] != '') ? '
			<p class="tl_help tl_tip">'.$GLOBALS['TL_LANG']['MSC']['separator'][1].'</p>' : '').'
			</div>
			<div class="w50">
				 <h3><label for="drop_first_row">'.$GLOBALS['TL_LANG']['tl_iao_invoice']['drop_first_row'][0].'</label></h3>
				 <input type="checkbox" name="drop_first_row" value="1" id="drop_first_row" checked />'.(($GLOBALS['TL_LANG']['tl_iao_invoice']['drop_first_row'][1] != '') ? '
			<p class="tl_help tl_tip">'.$GLOBALS['TL_LANG']['tl_iao_invoice']['drop_first_row'][1].'</p>' : '').'
			</div>
			</fieldset>

			<fieldset class="tl_tbox block nolegend">
			<div class="clr">
			  <h3><label for="csv_source">'.$GLOBALS['TL_LANG']['tl_iao_invoice']['csv_source'][0].'</label> <a href="contao/files.php" title="' . specialchars($GLOBALS['TL_LANG']['MSC']['fileManager']) . '" onclick="Backend.getScrollOffset(); Backend.openWindow(this, 750, 500); return false;">' . $this->generateImage('filemanager.gif', $GLOBALS['TL_LANG']['MSC']['fileManager'], 'style="vertical-align:text-bottom;"') . '</a></h3>'.$objTree4Source->generate().(strlen($GLOBALS['TL_LANG']['tl_iao_invoice']['csv_source'][1]) ? '
			  <p class="tl_help tl_tip">'.$GLOBALS['TL_LANG']['tl_iao_invoice']['csv_source'][1].'</p>' : '').'
			</div>
			<div class="clr">
			  <h3><label for="csv_posten_source">'.$GLOBALS['TL_LANG']['tl_iao_invoice']['csv_posten_source'][0].'</label> <a href="contao/files.php" title="' . specialchars($GLOBALS['TL_LANG']['MSC']['fileManager']) . '" onclick="Backend.getScrollOffset(); Backend.openWindow(this, 750, 500); return false;">' . $this->generateImage('filemanager.gif', $GLOBALS['TL_LANG']['MSC']['fileManager'], 'style="vertical-align:text-bottom;"') . '</a></h3>'.$objTree4Posten->generate().(strlen($GLOBALS['TL_LANG']['tl_iao_invoice']['csv_posten_source'][1]) ? '
			  <p class="tl_help tl_tip">'.$GLOBALS['TL_LANG']['tl_iao_invoice']['csv_posten_source'][1].'</p>' : '').'
			</div>
			<div class="clr">
			  <h3><label for="pdf_import_dir">'.$GLOBALS['TL_LANG']['tl_iao_invoice']['pdf_import_dir'][0].'</label> <a href="contao/files.php" title="' . specialchars($GLOBALS['TL_LANG']['MSC']['fileManager']) . '" onclick="Backend.getScrollOffset(); Backend.openWindow(this, 750, 500); return false;">' . $this->generateImage('filemanager.gif', $GLOBALS['TL_LANG']['MSC']['fileManager'], 'style="vertical-align:text-bottom;"') . '</a></h3>'.$objTree4PDF->generate().(strlen($GLOBALS['TL_LANG']['tl_iao_invoice']['pdf_import_dir'][1]) ? '
			  <p class="tl_help tl_tip">'.$GLOBALS['TL_LANG']['tl_iao_invoice']['pdf_import_dir'][1].'</p>' : '').'
			</div>
				</fieldset>

			<fieldset class="tl_tbox block nolegend">
			<div class="clr">
				 <input type="checkbox" name="drop_exist_entries" value="1" id="drop_exist_entries" checked /> <label for="drop_exist_entries">'.$GLOBALS['TL_LANG']['tl_iao_invoice']['drop_exist_entries'][0].'</label>'.(($GLOBALS['TL_LANG']['tl_iao_invoice']['drop_exist_entries'][1] != '') ? '
			<p class="tl_help tl_tip">'.$GLOBALS['TL_LANG']['tl_iao_invoice']['drop_exist_entries'][1].'</p>' : '').'
			</div>
			</fieldset>

			</div>

			<div class="tl_formbody_submit">

			<div class="tl_submit_container">
			  <input type="submit" name="save" id="save" class="tl_submit" accesskey="s" value="'.specialchars($GLOBALS['TL_LANG']['tl_iao_invoice']['importCSV'][0]).'" />
			</div>

			</div>
			</form>';
	}

}
