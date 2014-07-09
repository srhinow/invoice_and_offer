<?php

/**
 * PHP version 5
 * @copyright  Sven Rhinow 2014
 * @author     sr-tag Sven Rhinow Webentwicklung <http://www.sr-tag.de>
 * @package    invoice_and_offer
 * @license	   LGPL
 * @filesource
 */


/**
 * Class ModuleBBKReservationForm
 *
 * Front end module "BBK"
 */
class ModuleMemberInvoices extends Module
{
	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'iao_invoice_list';


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

			$objTemplate->wildcard = '### IAO MEMBER INVOICES LIST ###';

			$objTemplate->title = $this->headline;
			$objTemplate->id = $this->id;
			$objTemplate->link = $this->name;
			$objTemplate->href = 'typolight/main.php?do=modules&amp;act=edit&amp;id=' . $this->id;

			return $objTemplate->parse();
		}

        // Fallback template
		// if (strlen($this->fe_iao_template)) $this->strTemplate = $this->fe_iao_template;

		// Set the item from the auto_item parameter
		if ($GLOBALS['TL_CONFIG']['useAutoItem'] && isset($_GET['auto_item']))
		{
			$this->Input->setGet('iao', $this->Input->get('auto_item'));
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
		$this->loadLanguageFile('tl_iao_invoice');
		
		//set settings
		$this->iao->setIAOSettings();

		$offset = 0;
		$limit = null;

		if(FE_USER_LOGGED_IN)
		{

			$userId = ($this->User->id) ? $this->User->id : '';
	
			// Maximum number of items
			if ($this->fe_iao_numberOfItems > 0)
			{
				$limit = $this->fe_iao_numberOfItems;
			}

			// get library-name
			if((int)$this->User->id > 0)
			{
				// Get the total number of items
				$objTotal = $this->Database->prepare("SELECT COUNT(*) AS total FROM tl_iao_invoice WHERE `member`=? AND `published`=?")
											->execute($this->User->id,1);
				$total = $objTotal->total;

				// Split the results
				if ($this->perPage > 0 && (!isset($limit) || $this->fe_iao_numberOfItems > $this->perPage))
				{
					// Adjust the overall limit
					if (isset($limit))
					{
						$total = min($limit, $total);
					}

					// Get the current page
					$page = $this->Input->get('page') ? $this->Input->get('page') : 1;

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

			    $itemObjStmt = $this->Database->prepare('SELECT * FROM `tl_iao_invoice` WHERE `member`=? AND `published`=? ORDER BY `invoice_tstamp` DESC');

				// Limit the result
				if (isset($limit))
				{
					$itemObjStmt->limit($limit, $offset);
				}

				$itemObj = $itemObjStmt ->execute((int)$this->User->id,1);

			    $itemsArray = array();
			    while($itemObj->next())
		    	{
		    		$itemsArray[] = array(
		    			'title' => $itemObj->title,
		    			'status' => 'status'.$itemObj->status,
		    			'date' => date($GLOBALS['TL_CONFIG']['dateFormat'],$itemObj->invoice_tstamp),
		    			'price' => $this->iao->getPriceStr($itemObj->price_brutto,'iao_currency_symbol'),
		    			'remaining' => $this->iao->getPriceStr($itemObj->remaining,'iao_currency_symbol'),
		    			'file' => ''
	    			);
		    	}
			}

			$this->Template->headline = $this->headline;
			$this->Template->items = $itemsArray;
			$this->Template->messages = ''; // Backwards compatibility
		}

	}

}
