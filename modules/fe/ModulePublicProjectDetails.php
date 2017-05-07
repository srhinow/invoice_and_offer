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
 * Class ModulePublicProjectDetails
 *
 * Frontend module "invoice_and_offer"
 */
class ModulePublicProjectDetails extends Module
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'iao_public_project_details';


	/**
	 * Display a wildcard in the back end
	 * @return string
	 */
	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			$objTemplate = new \BackendTemplate('be_wildcard');

			$objTemplate->wildcard = '### IAO PUBLIC PROJECT DETAILS ###';
			$objTemplate->title = $this->headline;
			$objTemplate->id = $this->id;
			$objTemplate->link = $this->name;
			$objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

			return $objTemplate->parse();
		}

		// Set the item from the auto_item parameter
		if (!isset($_GET['project']) && $GLOBALS['TL_CONFIG']['useAutoItem'] && isset($_GET['auto_item']))
		{
			\Input::setGet('project', \Input::get('auto_item'));
		}

		// Do not index or cache the page if no news item has been specified
		if (!\Input::get('project'))
		{
			global $objPage;
			$objPage->noSearch = 1;
			$objPage->cache = 0;
			return '';
		}

		return parent::generate();
	}


	/**
	 * Generate the module
	 */
	protected function compile()
	{
		global $objPage;

	    $conditions['finished'] = 1;
	    $conditions['in_reference'] = 1;

		// Get the total number of items
		$objProject = IaoProjectsModel::findProjectByIdOrAlias(\Input::get('project'));

		// falsche Abfragen verhindern
		$falseCondition = false;
		foreach($conditions as $con => $val)
		{
			if($objProject->$con != $val) $falseCondition = true;
		}

		if ($objProject === null || $falseCondition)
		{
			// Do not index or cache the page
			$objPage->noSearch = 1;
			$objPage->cache = 0;

			// Send a 404 header
			header('HTTP/1.1 404 Not Found');
			$this->Template->articles = '<p class="error">' . sprintf($GLOBALS['TL_LANG']['MSC']['invalidPage'], \Input::get('items')) . '</p>';
			return;
		}

		$projectData = $objProject->row();

		// Website
		$projectData['url'] = (substr($projectData['url'],0,4) != 'http') ? 'http://'.$projectData['url'] : $projectData['url'];

		// Add the article image as enclosure
		$image = '';

		if ($projectData['singleSRC'] !== null)
		{
			$objFile = \FilesModel::findByUuid($projectData['singleSRC']);

			if ($objFile !== null)
			{
				$projectData['image'] = $objFile->path;
			}
		}

		$this->Template->data = $projectData;
		$this->Template->referer = 'javascript:history.go(-1)';
		$this->Template->back = $GLOBALS['TL_LANG']['MSC']['goBack'];
	}
}
