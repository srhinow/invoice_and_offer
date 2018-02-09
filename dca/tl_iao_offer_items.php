<?php

/**
 * @copyright  Sven Rhinow 2011-2015
 * @author     sr-tag Sven Rhinow Webentwicklung <http://www.sr-tag.de>
 * @package    invoice_and_offer
 * @license    LGPL
 * @filesource
 */

/**
 * Load tl_content language file
 */
$this->loadLanguageFile('tl_content');


/**
 * Table tl_iao_offer_items
 */
$GLOBALS['TL_DCA']['tl_iao_offer_items'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'ptable'                      => 'tl_iao_offer',
		'enableVersioning'            => true,
		'onload_callback'		=> array(
			array('tl_iao_offer_items','setIaoSettings'),
			array('tl_iao_offer_items', 'checkPermission'),
		),
		'onsubmit_callback'	      => array
		(
			array('tl_iao_offer_items','saveAllPricesToParent'),
			array('tl_iao_offer_items','saveNettoAndBrutto')
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
			'mode'                    => 4,
			'fields'                  => array('sorting'),
			'flag'                    => 1,
			'headerFields'            => array('title', 'tstamp', 'price','member','price_netto','price_brutto'),
			'panelLayout'             => '',
			'child_record_callback'   => array('tl_iao_offer_items', 'listItems')
		),
		'label' => array
		(
			'fields'                  => array('headline'),
			'format'                  => '%s',
		),
		'global_operations' => array
		(
			'all' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'                => 'act=select',
				'class'               => 'header_edit_all',
				'attributes'          => 'onclick="Backend.getScrollOffset();" accesskey="e"'
			),
			'pdf' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_offer_items']['pdf'],
				'href'                => 'key=pdf&id='.$_GET['id'],
				'class'               => 'header_generate_pdf',
				'button_callback'     => array('tl_iao_offer_items', 'showPDFButton')
			)
		),
		'operations' => array
		(
			'edit' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_offer_items']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_offer_items']['copy'],
				'href'                => 'act=paste&amp;mode=copy',
				'icon'                => 'copy.gif'
			),
			'cut' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_offer_items']['cut'],
				'href'                => 'act=paste&amp;mode=cut',
				'icon'                => 'cut.gif'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_offer_items']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
			),
			'toggle' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_offer_items']['toggle'],
				'icon'                => 'visible.gif',
				'attributes'          => 'onclick="Backend.getScrollOffset(); return AjaxRequest.toggleVisibility(this, %s);"',
				'button_callback'     => array('tl_iao_offer_items', 'toggleIcon')
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_offer_items']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			),
			'postentemplate' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_offer_items']['postentemplate'],
				'href'                => 'key=addPostenTemplate',
				'icon'                => 'system/modules/invoice_and_offer/html/icons/posten_templates_16.png',
				'button_callback'     => array('tl_iao_offer_items', 'addPostenTemplate')
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'__selector__'                => array('type'),
		'default'                     => '{type_legend},type',
		'item'                        => '{type_legend},type;{templates_legend:hide},posten_template;{title_legend},headline,headline_to_pdf;{item_legend},text,price,vat,count,amountStr,operator,vat_incl;{publish_legend},published',
		'devider'                     => '{type_legend},type;{publish_legend},published'
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
			'foreignKey'              => 'tl_iao_invoice.title',
			'sql'                     => "int(10) unsigned NOT NULL default '0'",
			'relation'                => array('type'=>'belongsTo', 'load'=>'eager')
		),
		'tstamp' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),	
		'type' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_offer_items']['type'],
			'default'                 => 'item',
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'select',
			'options' 		  => &$GLOBALS['TL_LANG']['tl_iao_offer_items']['type_options'],
			'eval'                    => array( 'submitOnChange'=>true),
			'sql'					=> "varchar(32) NOT NULL default 'item'"
		),
		'headline' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_offer_items']['headline'],
			'exclude'                 => true,
			'search'                  => true,
			'sorting'                 => true,
			'flag'                    => 1,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'clr long'),
			'sql'					  => "varchar(255) NOT NULL default ''"
		),
		'headline_to_pdf' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_offer_items']['headline_to_pdf'],
			'exclude'                 => true,
			'filter'                  => true,
			'flag'                    => 2,
			'inputType'               => 'checkbox',
			'eval'                    => array('doNotCopy'=>true, 'tl_class'=>'w50'),
			'sql'					  => "char(1) NOT NULL default '1'"
		),
		'sorting' => array
		(
			'sql'					  => "int(10) unsigned NOT NULL default '0'"
		),
		'date' => array
		(
			'sql'					  => "int(10) unsigned NOT NULL default '0'"
		),
		'time' => array
		(
			'sql'					  => "int(10) unsigned NOT NULL default '0'"
		),
		'text' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_offer_items']['text'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'textarea',
			'eval'                    => array('rte'=>'tinyMCE', 'helpwizard'=>true,'style'=>'height:60px;', 'tl_class'=>'clr'),
			'sql'					  => "mediumtext NULL"
		),
		'count' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_offer_items']['count'],
			'exclude'                 => true,
			'flag'                    => 1,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50'),
			'sql'					  => "varchar(64) NOT NULL default '0'"
		),
		'amountStr' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_offer_items']['amountStr'],
			'exclude'                 => true,
			'filter'                  => true,
			'flag'                    => 1,
			'inputType'               => 'select',
			'options_callback'        => array('tl_iao_offer_items', 'getItemUnitsOptions'),
            'eval'                    => array('tl_class'=>'w50','submitOnChange'=>false),
            'sql'					  => "varchar(64) NOT NULL default ''"
		),
		'operator' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_offer_items']['operator'],
			'exclude'                 => true,
			'filter'                  => true,
			'flag'                    => 1,
			'inputType'               => 'select',
			'options'                 => &$GLOBALS['TL_LANG']['tl_iao_offer_items']['operators'],
			'eval'                    => array('tl_class'=>'w50'),
			'sql'					  => "char(1) NOT NULL default '+'"
		),
		'price' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_offer_items']['price'],
			'exclude'                 => true,
			'search'                  => true,
			'sorting'                 => true,
			'flag'                    => 1,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50'),
			'sql'					  => "varchar(64) NOT NULL default '0'"
		),
		'price_netto' => array
		(
			'sql'					  => "varchar(64) NOT NULL default '0'"
		),
		'price_brutto' => array
		(
			'sql'					  => "varchar(64) NOT NULL default '0'"
		),
		'vat' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_offer_items']['vat'],
			'exclude'                 => true,
			'filter'                  => true,
			'flag'                    => 1,
			'inputType'               => 'select',
			'options_callback'        => array('tl_iao_offer_items', 'getTaxRatesOptions'),
			'eval'                    => array('tl_class'=>'w50'),
			'sql'					  => "int(10) unsigned NOT NULL default '19'"
		),
		'vat_incl' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_offer_items']['vat_incl'],
			'exclude'                 => true,
			'filter'                  => true,
			'flag'                    => 1,
			'inputType'               => 'select',
			'options'                 => &$GLOBALS['TL_LANG']['tl_iao_offer_items']['vat_incl_percents'],
			'eval'                    => array('tl_class'=>'w50'),
			'sql'					  => "int(10) unsigned NOT NULL default '1'"
		),
		'posten_template' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_offer_items']['posten_template'],
			'exclude'                 => true,
			'filter'                  => true,
			'sorting'                 => true,
			'flag'                    => 11,
			'inputType'               => 'select',
			'options_callback'        => array('tl_iao_offer_items', 'getPostenTemplate'),
			'eval'                    => array('tl_class'=>'w50','includeBlankOption'=>true,'submitOnChange'=>true, 'chosen'=>true),
			'save_callback' => array
			(
				array('tl_iao_offer_items', 'fillPostenFields')
			),
			'sql'					=> "int(10) unsigned NOT NULL default '0'"
		),
		'published' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_offer_items']['published'],
			'exclude'                 => true,
			'filter'                  => true,
			'flag'                    => 2,
			'inputType'               => 'checkbox',
			'eval'                    => array('doNotCopy'=>true),
			'sql'					  => "char(1) NOT NULL default ''"
		),
		// -- Backport C2 SQL-Import
		'pagebreak_after' => array(
				'sql' 					=> "varchar(64) NOT NULL default '0'"
		),

		//--
	)
);


/**
* Class tl_iao_offer_items
*/
class tl_iao_offer_items extends \iao\iaoBackend
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
	* add all iao-Settings in array
	*/
	public function setIaoSettings()
	{
		$id = \Input::get('id');
		if($id)
		{
			$dbObj = $this->Database->prepare('SELECT  * FROM `tl_iao_offer` WHERE `id`=?')
							->limit(1)
							->execute($id);

			$this->settings = ($dbObj->numRows > 0) ? $this->getSettings($dbObj->setting_id) : array();		
		}
	}

	public function showPDFButton($href, $label, $title, $class)
	{
	    $objPdfTemplate = 	\FilesModel::findByUuid($this->settings['iao_offer_pdf']);			

		if(strlen($objPdfTemplate->path) < 1 || !file_exists(TL_ROOT . '/' . $objPdfTemplate->path) ) return;  // template file not found

		return '&nbsp; :: &nbsp;<a href="contao/main.php?do=iao_offer&table=tl_iao_offer&'.$href.'" title="'.specialchars($title).'" class="'.$class.'">'.$label.'</a> ';
	}



	/**
	 * Check permissions to edit table tl_iao_offer_items
	 */
	public function checkPermission()
	{
		$this->checkIaoModulePermission('tl_iao_offer_items');
	}

	/**
	 * Add the type of input field
	 * @param array
	 * @return string
	 */
	public function listItems($arrRow)
	{
		if($arrRow['type']=='devider')
		{
			return '<div class="pdf-devider"><span>PDF-Trenner</span></div>';
		}
		else
		{
			$time = time();
			$key = ($arrRow['published']) ? ' published' : ' unpublished';
			$vat = ($arrRow['vat_incl']==1) ? 'netto' : 'brutto';
			$pagebreak = ($arrRow['pagebreak_after']==1) ? ' pagebreak' : '';

			return '<div class="cte_type' . $key . $pagebreak . '">
			<strong>' . $arrRow['headline'] . '</strong>
		 	<br />Netto: '.number_format($arrRow['price_netto'],2,',','.') .$GLOBALS['TL_CONFIG']['iao_currency_symbol'].'
		 	<br />Brutto: ' . number_format($arrRow['price_brutto'],2,',','.') .$GLOBALS['TL_CONFIG']['iao_currency_symbol']. ' (inkl. '.$arrRow['vat'].'% MwSt.)
		 	<br />'.$arrRow['text'].'
		 	</div>' . "\n";
		}
	}

	/**
	 * save the price from all items in parent_table
	 * @param mixed
	 * @param object
	 * @return string
	 */
	public function saveAllPricesToParent(DataContainer $dc)
	{
		// Return if there is no active record (override all)
		if (!$dc->activeRecord)
		{
			return;
		}

		$itemObj = $this->Database->prepare('SELECT `price`,`count`,`vat`,`vat_incl` FROM `tl_iao_offer_items` WHERE `pid`=? AND published =?')
						->execute($dc->activeRecord->pid,1);

		if($itemObj->numRows > 0)
		{
			$allNetto = 0;
			$allBrutto = 0;

			while($itemObj->next())
			{
				$englprice = str_replace(',','.',$itemObj->price);
				$priceSum = $englprice * $itemObj->count;

				if($itemObj->vat_incl == 1)
				{
					$allNetto += $priceSum;
					$allBrutto += $this->getBruttoPrice($priceSum,$itemObj->vat);
				}
				else
				{
					$allNetto += $this->getNettoPrice($priceSum,$itemObj->vat);
					$allBrutto += $priceSum;
				}

				$this->Database->prepare('UPDATE `tl_iao_offer` SET `price_netto`=?, `price_brutto`=? WHERE `id`=?')
						->limit(1)
						->execute($allNetto, $allBrutto, $dc->activeRecord->pid);
			}
		}
	}

	/**
	 * save the price_netto and price_brutto from actuell item
	 * @param mixed
	 * @param object
	 * @return string
	 */
	public function saveNettoAndBrutto(DataContainer $dc)
	{
		// Return if there is no active record (override all)
		if (!$dc->activeRecord)
		{
			return;
		}

		$englprice = str_replace(',','.',$dc->activeRecord->price);
		$priceSum = $englprice * $dc->activeRecord->count;

		$Netto = 0;
		$Brutto = 0;

		if($dc->activeRecord->vat_incl == 1)
		{
			$Netto = $priceSum;
			$Brutto = $this->getBruttoPrice($priceSum,$dc->activeRecord->vat);
		}
		else
		{
			$Netto = $this->getNettoPrice($priceSum,$dc->activeRecord->vat);
			$Brutto = $priceSum;
		}

		$this->Database->prepare('UPDATE `tl_iao_offer_items` SET `price_netto`=?, `price_brutto`=? WHERE `id`=?')
				->limit(1)
				->execute($Netto, $Brutto, $dc->id);
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
		if (strlen(\Input::get('tid')))
		{
			$this->toggleVisibility(\Input::get('tid'), (\Input::get('state') == 1));
			$this->redirect($this->getReferer());
		}

		// Check permissions AFTER checking the tid, so hacking attempts are logged
		if (!$this->User->isAdmin && !$this->User->hasAccess('tl_iao_offer_items::published', 'alexf'))
		{
			return '';
		}

		$href .= '&amp;tid='.$row['id'].'&amp;state='.($row['published'] ? '' : 1);

		if (!$row['published'])
		{
			$icon = 'invisible.gif';
		}

		return '<a href="'.$this->addToUrl($href).'" title="'.specialchars($title).'"'.$attributes.'>'.$this->generateImage($icon, $label).'</a> ';
	}

	/**
	 * Disable/enable a user group
	 * @param integer
	 * @param boolean
	 */
	public function toggleVisibility($intId, $blnVisible)
	{
		// Check permissions to edit
		$this->Input->setGet('id', $intId);
		$this->Input->setGet('act', 'toggle');
		$this->checkPermission();

		// Check permissions to publish
		if (!$this->User->isAdmin && !$this->User->hasAccess('tl_iao_offer_items::published', 'alexf'))
		{
			$this->log('Not enough permissions to publish/unpublish event ID "'.$intId.'"', 'tl_iao_offer_items toggleVisibility', TL_ERROR);
			$this->redirect('contao/main.php?act=error');
		}

		$this->createInitialVersion('tl_iao_offer_items', $intId);

		// Trigger the save_callback
		if (is_array($GLOBALS['TL_DCA']['tl_iao_offer_items']['fields']['published']['save_callback']))
		{
			foreach ($GLOBALS['TL_DCA']['tl_iao_offer_items']['fields']['published']['save_callback'] as $callback)
			{
				$this->import($callback[0]);
				$blnVisible = $this->$callback[0]->$callback[1]($blnVisible, $this);
			}
		}

		// Update the database
		$this->Database->prepare("UPDATE tl_iao_offer_items SET tstamp=". time() .", published='" . ($blnVisible ? 1 : '') . "' WHERE id=?")
				->execute($intId);

		$this->createNewVersion('tl_iao_offer_items', $intId);

		// Update the RSS feed (for some reason it does not work without sleep(1))
		sleep(1);

	}

	/**
	 * Generate a button to put a posten-template for offer
	 * @param array
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @return string
	 */
	public function addPostenTemplate($row, $href, $label, $title, $icon, $attributes)
	{
		if (!$this->User->isAdmin)
		{
			return '';
		}

		if (\Input::get('key') == 'addPostenTemplate' && \Input::get('ptid') == $row['id'])
		{
			$result = $this->Database->prepare('SELECT * FROM `tl_iao_offer_items` WHERE `id`=?')
							->limit(1)
							->execute($row['id']);

			//Insert Invoice-Entry
			$postenset = array
			(
				'tstamp' => time(),
				'headline' => $result->headline,
				'headline_to_pdf' => $result->headline_to_pdf,
				'sorting' => $result->sorting,
				'date' => $result->date,
				'time' => $result->time,
				'text' => $result->text,
				'count' => $result->count,
				'amountStr' => $result->amountStr,
				'operator' => $result->operator,
				'price' => $result->price,
				'price_netto' => $result->price_netto,
				'price_brutto' => $result->price_brutto,
				'published' => $result->published,
				'vat' => $result->vat,
				'vat_incl' => $result->vat_incl,
				'position' => 'offer',
			);

			$newposten = $this->Database->prepare('INSERT INTO `tl_iao_templates_items` %s')
							->set($postenset)
							->execute();

			$newPostenID = $newposten->insertId;
            $redirectUrl = $this->addToUrl('do=iao_setup&mod=iao_templates_items&table=tl_iao_templates_items&act=edit&id='.$newPostenID);
			$this->redirect($redirectUrl);
		}

		$href.='&amp;ptid='.$row['id'];
		return '<a href="'.$this->addToUrl($href).'" title="'.specialchars($title).'"'.$attributes.'>'.$this->generateImage($icon, $label).'</a> ';
	}

	/**
	 * get all offer-posten-templates
	 * @param object
	 * @throws Exception
	 */
	public function getPostenTemplate(DataContainer $dc)
	{
		$varValue= array();

		$all = $this->Database->prepare('SELECT `id`,`headline` FROM `tl_iao_templates_items` WHERE `position`=?')
					->execute('offer');

		while($all->next())
		{
			$varValue[$all->id] = $all->headline;
		}

		return $varValue;
	}

	/**
	 * fill Text before
	 * @param object
	 * @throws Exception
	 */
	public function fillPostenFields($varValue, DataContainer $dc)
	{

		if(strlen($varValue)<=0) return $varValue;

		$result = $this->Database->prepare('SELECT * FROM `tl_iao_templates_items` WHERE `id`=?')
						->limit(1)
						->execute($varValue);

		//Insert Invoice-Entry
		$postenset = array
		(
			'tstamp' => time(),
			'headline' => $result->headline,
			'headline_to_pdf' => $result->headline_to_pdf,
			'sorting' => $result->sorting,
			'date' => $result->date,
			'time' => $result->time,
			'text' => $result->text,
			'count' => $result->count,
			'amountStr' => $result->amountStr,
			'operator' => $result->operator,
			'price' => $result->price,
			'price_netto' => $result->price_netto,
			'price_brutto' => $result->price_brutto,
			'published' => $result->published,
			'vat' => $result->vat,
			'vat_incl' => $result->vat_incl,
		);

		$this->Database->prepare('UPDATE `tl_iao_offer_items` %s WHERE `id`=?')
				->set($postenset)
				->execute($dc->id);

		$this->reload();

		return $varValue;
	}

}
