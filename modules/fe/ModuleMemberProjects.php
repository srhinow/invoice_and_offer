<?php

/**
 * PHP version 5
 * @copyright  Sven Rhinow Webentwicklung 2014 <http://www.sr-tag.de>
 * @author     Sven Rhinow
 * @package    invoice_and_offer
 * @license	   LGPL
 * @filesource
 */


/**
 * Class ModulePublicProjectList
 *
 * Frontend module "invoice_and_offer"
 */
class ModuleMemberProjects extends Module
{
	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'iao_project_list';


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

			$objTemplate->wildcard = '### IAO MEMBER PROJECT LIST ###';

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
		$this->loadLanguageFile('tl_iao_projects');

		//set settings
		$this->iao->setIAOSettings();

		$offset = 0;
		$limit = null;

		if(FE_USER_LOGGED_IN)
		{
			$userId = $this->User->id;

			// Maximum number of items
			if ($this->fe_iao_numberOfItems > 0)
			{
				$limit = $this->fe_iao_numberOfItems;
			}

		    $searchWhereArr[] = "`member` = ".$userId;

			// Get the total number of items
			$intTotal = IaoProjectsModel::countEntries($searchWhereArr);

			// Filter anwenden um die Gesamtanzahl zuermitteln
			if((int) $intTotal > 0)
			{
				$total = $intTotal - $offset;

				// Split the results
				if ($this->perPage > 0 && (!isset($limit) || $this->numberOfItems > $this->perPage))
				{

					// Adjust the overall limit
					if (isset($limit))
					{
						$total = min($limit, $total);
					}

					// Get the current page
					$id = 'page_n' . $this->id;
					$page = \Input::get($id) ?: 1;

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

				// Get the items
				$itemsObj = IaoProjectsModel::findProjects((int) $limit, $offset, $searchWhereArr, array('order' => "id DESC") );


			    $itemsArray = array();
			    $count = -1;

			    while($itemsObj->next())
		    	{
					//row - Class
					$class = 'row_' . ++$count . (($count == 0) ? ' row_first' : '') . (($count >= ($limit - 1)) ? ' row_last' : '') . ((($count % 2) == 0) ? ' even' : ' odd');

					// Add the article image as enclosure
					$image = '';

					if ($itemsObj->singleSRC !== null)
					{
						$objFile = \FilesModel::findByUuid($itemsObj->singleSRC);

						if ($objFile !== null)
						{
							$image = $objFile->path;
						}
					}

		    		$itemsArray[] = array(
		    			'title' => $itemsObj->reference_title,
		    			'customer' => $itemsObj->reference_customer,
		    			'todo' => $itemsObj->reference_todo,
					);
		    	}
	    	}

			$this->Template->headline = $this->headline;
			$this->Template->items = $itemsArray;
			$this->Template->messages = ''; // Backwards compatibility
		}
	}

}
