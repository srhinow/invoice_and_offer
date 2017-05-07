<?php

/**
 * PHP version 5
 * @copyright  Sven Rhinow Webentwicklung 2017 <http://www.sr-tag.de>
 * @author     Sven Rhinow
 * @package    invoice_and_agreement
 * @license	   LGPL
 * @filesource
 */


/**
 * Class ModuleMemberAgreements
 *
 * Frontend module "IAO MEMBER AGREEMENT LIST"
 */
class ModuleMemberAgreements extends Module
{
	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'iao_agreement_list';


	/**
	 * Target pages
	 * @var array
	 */
	protected $arrTargets = array();


	/**
	 * Display a wildcard in the back end
	 * @return string
	 */
	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			$objTemplate = new BackendTemplate('be_wildcard');

			$objTemplate->wildcard = '### IAO MEMBER AGREEMENT LIST ###';

			$objTemplate->title = $this->headline;
			$objTemplate->id = $this->id;
			$objTemplate->link = $this->name;
			$objTemplate->href = 'contao/main.php?do=modules&amp;act=edit&amp;id=' . $this->id;

			return $objTemplate->parse();
		}

		//wenn eine feste PDF zugewiesen wurde
		if(strlen(\Input::get('file')) > 0 )
		{

			$objPdf = 	\FilesModel::findByPath(\Input::get('file'));
			// print_r($objPdf);
			// exit();
			if($objPdf !== null && file_exists(TL_ROOT . '/' . \Input::get('file')))
			{
				header("Content-type: application/pdf");
				header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // Date in the past
				header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
	 			// header('Content-Length: '.strlen(TL_ROOT . '/' . $objPdf->path));
				header('Content-Disposition: inline; filename="'.$objPdf->name.'";');

				// The PDF source is in original.pdf
				readfile(TL_ROOT . '/' . $objPdf->path);
				exit();
		    }
		}

        // Fallback template
		if (strlen($this->fe_iao_template)) $this->strTemplate = $this->fe_iao_template;

		// Set the item from the auto_item parameter
		if ($GLOBALS['TL_CONFIG']['useAutoItem'] && \Input::get('auto_item'))
		{
			\Input::setGet('pid', \Input::get('auto_item'));
		}

		return parent::generate();
	}


	/**
	 * Generate module
	 */
	protected function compile()
	{

		// Get the front end user object
		$this->import('FrontendUser', 'User');
		$this->import('iao');
		$this->loadLanguageFile('tl_iao_agreement');

		//set settings
		$this->iao->setIAOSettings();

		$offset = 0;
		$limit = null;

		if(FE_USER_LOGGED_IN)
		{
			$userId = $this->User->id;

			//wenn eine PDF angefragt wird
			if(\Input::get('key') == 'pdf' && (int) \Input::get('id') > 0)
			{
				// ueberpruefen ob diese zum aktuellen Benutzer gehoert
				$testObj = IaoAgreementsModel::findOnePublishedByMember(\Input::get('id'), $userId);

				if($testObj !== NULL)
				{
					$this->iao->generateReminderPDF((int) \Input::get('id'), 'agreement');
				}
			}

			// Maximum number of items
			if ($this->fe_iao_numberOfItems > 0)
			{
				$limit = $this->fe_iao_numberOfItems;
			}

			// Get the total number of items
			$total = IaoAgreementsModel::countPublishedByMember($this->User->id, $this->agreement_status);

			if($total > 0)
			{
				// Split the results
				if ($this->perPage > 0 && (!isset($limit) || $this->fe_iao_numberOfItems > $this->perPage))
				{
					// Adjust the overall limit
					if (isset($limit))
					{
						$total = min($limit, $total);
					}

					// Get the current page
					$page = \Input::get('page')?: 1;

					// Do not index or cache the page if the page number is outside the range
					if ($page < 1 || $page > max(ceil($total/$this->perPage), 1))
					{
						global $objPage;
						$objPage->noSearch = 1;
						$objPage->cache = 0;

						// Send a 404 header
						header('HTTP/1.1 404 Not Found');
						return;
					}

					// Set limit and offset
					$limit = $this->perPage;
					$offset = (max($page, 1) - 1) * $this->perPage;

					// Overall limit
					if ($offset + $limit > $total)
					{
						$limit = $total - $offset;
					}

					// Add the pagination menu
					$objPagination = new Pagination($total, $this->perPage);
					$this->Template->pagination = $objPagination->generate("\n  ");
				}

				$itemObj = IaoAgreementsModel::findPublishedByMember($this->User->id, $this->agreement_status, $limit, $offset);

			    $itemsArray = array();
			    if($itemObj !== null) while($itemObj->next())
		    	{
		    		$invoiceObj = IaoInvoiceModel::findOneById($itemObj->invoice_id);

		    		// if($itemObj->status == 1) $status_class = 'danger';
		    		// elseif($itemObj->status == 2) $status_class = 'success';
		    		// elseif($itemObj->status == 3) $status_class = 'warning';
		    		// else $status_class = '';
		    		$agrFile = \FilesModel::findByPk($itemObj->agreement_pdf_file);
		    		$itemsArray[] = array
		    		(
		    			'title' => $itemObj->title,
		    			'status' => $itemObj->status,
		    			'status_class' => $status_class,
		    			'periode' => $itemObj->periode,
		    			'beginn_date' => date($GLOBALS['TL_CONFIG']['dateFormat'],$itemObj->beginn_date),
		    			'end_date' => date($GLOBALS['TL_CONFIG']['dateFormat'],$itemObj->end_date),
		    			'price' => $this->iao->getPriceStr($itemObj->price,'iao_currency_symbol'),
		    			'agreement_pdf_path' => \Environment::get('request').'?file='.$agrFile->path
	    			);
		    	}
	    	}

			$this->Template->headline = $this->headline;
			$this->Template->items = $itemsArray;
			$this->Template->messages = ($total > 0)? '' : $GLOBALS['TL_LANG']['tl_iao_agreement']['no_entries_msg'];
		}

	}

}
