<?php

/**
 * PHP version 5
 * @copyright  Sven Rhinow Webentwicklung 2017 <http://www.sr-tag.de>
 * @author     Sven Rhinow
 * @package    invoice_and_offer
 * @license	   LGPL
 * @filesource
 */


/**
 * Class ModuleMemberOffers
 *
 * Frontend module "IAO MEMBER OFFER LIST"
 */
class ModuleMemberOffers extends Module
{
	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'iao_offer_list';


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

			$objTemplate->wildcard = '### IAO MEMBER OFFER LIST ###';

			$objTemplate->title = $this->headline;
			$objTemplate->id = $this->id;
			$objTemplate->link = $this->name;
			$objTemplate->href = 'contao/main.php?do=modules&amp;act=edit&amp;id=' . $this->id;

			return $objTemplate->parse();
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
		$this->loadLanguageFile('tl_iao_offer');

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
				$testObj = IaoOfferModel::findOnePublishedByMember(\Input::get('id'), $userId);

				if($testObj !== NULL)
				{
					$this->iao->generatePDF((int) \Input::get('id'), 'offer');
				}

			}

			// Maximum number of items
			if ($this->fe_iao_numberOfItems > 0)
			{
				$limit = $this->fe_iao_numberOfItems;
			}

			// Get the total number of items
			$total = IaoOfferModel::countPublishedByMember($this->User->id);

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

				$itemObj = IaoOfferModel::findPublishedByMember($this->User->id, $this->status, $limit, $offset);

			    $itemsArray = array();
			    while($itemObj->next())
		    	{

		    		if($itemObj->status == 1) $status_class = 'danger';
		    		elseif($itemObj->status == 2) $status_class = 'success';
		    		elseif($itemObj->status == 3) $status_class = 'warning';
		    		else $status_class = '';

		    		$itemsArray[] = array
		    		(
		    			'title' => $itemObj->title,
		    			'invoice_id_str' => $itemObj->offer_id_str,
		    			'status' => $itemObj->status,
		    			'status_class' => $status_class,
		    			'date' => date($GLOBALS['TL_CONFIG']['dateFormat'],$itemObj->offer_tstamp),
		    			'price' => $this->iao->getPriceStr($itemObj->price_brutto,'iao_currency_symbol'),
		    			'expiry' => date($GLOBALS['TL_CONFIG']['dateFormat'],$itemObj->expiry_date),
		    			'file_path' => \Environment::get('request').'?key=pdf&id='.$itemObj->id
	    			);
		    	}
	    	}

			$this->Template->headline = $this->headline;
			$this->Template->items = $itemsArray;
			$this->Template->messages = ($total > 0)? '' : $GLOBALS['TL_LANG']['tl_iao_offer']['no_entries_msg'];
		}

	}

}
