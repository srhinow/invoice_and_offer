<?php

/**
 * @copyright  Sven Rhinow 2014
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
 * Table tl_iao_invoice_items
 */
$GLOBALS['TL_DCA']['tl_iao_invoice_items'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'ptable'                      => 'tl_iao_invoice',
		'enableVersioning'            => true,
		'onload_callback'		=> array (
			array('tl_iao_invoice_items','IAOSettings')
		),
		'onsubmit_callback'	    => array (
		    array('tl_iao_invoice_items','saveAllPricesToParent'),
		    array('tl_iao_invoice_items','saveNettoAndBrutto'),
		    array('tl_iao_invoice_items','updateRemaining')
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
			'child_record_callback'   => array('tl_iao_invoice_items', 'listItems')
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
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_invoice_items']['pdf'],
				'href'                => 'key=pdf&id='.$_GET['id'],
				'class'               => 'header_generate_pdf',
				'button_callback'     => array('tl_iao_invoice_items', 'showPDFButton')
			)
		),
		'operations' => array
		(
			'edit' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_invoice_items']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_invoice_items']['copy'],
				'href'                => 'act=paste&amp;mode=copy',
				'icon'                => 'copy.gif'
			),
			'cut' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_invoice_items']['cut'],
				'href'                => 'act=paste&amp;mode=cut',
				'icon'                => 'cut.gif'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_invoice_items']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
			),
			'toggle' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_invoice_items']['toggle'],
				'icon'                => 'visible.gif',
				'attributes'          => 'onclick="Backend.getScrollOffset(); return AjaxRequest.toggleVisibility(this, %s);"',
				'button_callback'     => array('tl_iao_invoice_items', 'toggleIcon')
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_invoice_items']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			),
			'postentemplate' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_invoice_items']['postentemplate'],
				'href'                => 'key=addPostenTemplate',
				'icon'                => 'system/modules/invoice_and_offer/html/icons/posten_templates_16.png',
				'button_callback'     => array('tl_iao_invoice_items', 'addPostenTemplate')
			),
		)
	),

	// Palettes
	'palettes' => array
	(
		'__selector__'                => array('type'),
		'default'                     => '{type_legend},type',
		'item'                        => '{type_legend},type;{templates_legend:hide},posten_template;{title_legend},headline,headline_to_pdf;{item_legend},text,price,vat,count,amountStr,operator,vat_incl;{publish_legend},published;{pagebreake_legend:hidden},pagebreak_after',
		'devider'                     => '{type_legend},type;{publish_legend},published'
	),
	// Subpalettes
	'subpalettes' => array
	(

	),

	// Fields
	'fields' => array
	(
		'type' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_iao_invoice_items']['type'],
			'default'               => 'item',
			'exclude'               => true,
			'filter'                => true,
			'inputType'             => 'select',
			'options' 		  		=> array('item'=>'Eintrag','devider'=>'PDF-Trenner'),
			'eval'                  => array( 'submitOnChange'=>true)
		),
		'posten_template' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_invoice_items']['posten_template'],
			'filter'                  => true,
			'sorting'                 => true,
			'flag'                    => 11,
			'inputType'               => 'select',
			'options_callback'        => array('tl_iao_invoice_items', 'getPostenTemplate'),
			'eval'                    => array('tl_class'=>'w50','includeBlankOption'=>true,'submitOnChange'=>true, 'chosen'=>true),
			'save_callback' => array
			(
				array('tl_iao_invoice_items', 'fillPostenFields')
			)
		),
		'headline' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_invoice_items']['headline'],
			'search'                  => true,
			'sorting'                 => true,
			'flag'                    => 1,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'clr long')
		),
		'headline_to_pdf' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_invoice_items']['headline_to_pdf'],
			'default'				  => '1',
			'filter'                  => true,
			'flag'                    => 2,
			'inputType'               => 'checkbox',
			'eval'                    => array('tl_class'=>'w50')
		),
		'text' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_invoice_items']['text'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'textarea',
			'eval'                    => array('rte'=>'tinyMCE', 'helpwizard'=>true,'style'=>'height:60px;', 'tl_class'=>'clr'),
		),
		'price' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_invoice_items']['price'],
			'exclude'                 => true,
			'search'                  => true,
			'sorting'                 => true,
			'flag'                    => 1,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50')
		),
		'count' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_invoice_items']['count'],
			'exclude'                 => true,
			'flag'                    => 1,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50')
		),
		'amountStr' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_invoice_items']['amountStr'],
			'exclude'                 => true,
			'filter'                  => true,
			'flag'                    => 1,
			'inputType'               => 'select',
			'options_callback'        => array('tl_iao_invoice_items', 'getItemUnitsOptions'),
            'eval'                    => array('tl_class'=>'w50','submitOnChange'=>false)
		),
		'vat' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_invoice_items']['vat'],
			'filter'                  => true,
			'flag'                    => 1,
			'inputType'               => 'select',
			'options_callback'        => array('tl_iao_invoice_items', 'getTaxRatesOptions'),
			'eval'                    => array('tl_class'=>'w50')
		),
		'vat_incl' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_invoice_items']['vat_incl'],
			'filter'                  => true,
			'flag'                    => 1,
			'inputType'               => 'select',
			'options'                 => &$GLOBALS['TL_LANG']['tl_iao_invoice_items']['vat_incl_percents'],
			'eval'                    => array('tl_class'=>'w50')
		),
		'operator' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_invoice_items']['operator'],
			'filter'                  => true,
			'flag'                    => 1,
			'inputType'               => 'select',
			'options'                 => &$GLOBALS['TL_LANG']['tl_iao_invoice_items']['operators'],
			'eval'                    => array('tl_class'=>'w50')
		),
		'published' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_invoice_items']['published'],
			'exclude'                 => true,
			'filter'                  => true,
			'flag'                    => 2,
			'inputType'               => 'checkbox',
			'eval'                    => array('doNotCopy'=>true)
		),
		'pagebreak_after' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_invoice_items']['pagebreak_after'],
			'exclude'                 => true,
			'filter'                  => true,
			'flag'                    => 1,
			'inputType'               => 'checkbox',
			'eval'                    => array('doNotCopy'=>true)
		),
	)
);


/**
 * Class tl_iao_invoice_items
 */
class tl_iao_invoice_items extends Backend
{

	/**
	 * Import the back end user object
	 */
	public function __construct()
	{
		parent::__construct();
		$this->import('BackendUser', 'User');
	}

	/**
	* add all iao-Settings in $GLOBALS['TL_CONFIG']
	*/
	public function IAOSettings(DataContainer $dc)
	{
		if($dc->id)
		{
			$dbObj = $this->Database->prepare('SELECT `p`.* FROM `tl_iao_invoice` `p` LEFT JOIN `tl_iao_invoice_items` `i` ON `p`.`id`= `i`.`pid` WHERE `i`.`id`=?')
							->limit(1)
							->execute($dc->id);

			$setting_id = ($dbObj->numRows > 0) ? $dbObj->setting_id : '';

			$this->import('iao');
			$this->iao->setIAOSettings($setting_id);
		}
	}

 	public function showPDFButton($href, $label, $title, $class)
	{
		return '&nbsp; :: &nbsp;<a href="contao/main.php?do=iao_invoice&table=tl_iao_invoice&'.$href.'" title="'.specialchars($title).'" class="'.$class.'">'.$label.'</a> ';
	}

	/**
	 * Check permissions to edit table tl_iao_invoice_items
	 */
	public function checkPermission()
	{
		// HOOK: comments extension required
		if (!in_array('comments', $this->Config->getActiveModules()))
		{
			$key = array_search('allowComments', $GLOBALS['TL_DCA']['tl_iao_invoice_items']['list']['sorting']['headerFields']);
			unset($GLOBALS['TL_DCA']['tl_iao_invoice_items']['list']['sorting']['headerFields'][$key]);
		}

		if ($this->User->isAdmin)
		{
			return;
		}

		// Set root IDs
		if (!is_array($this->User->calendars) || count($this->User->calendars) < 1)
		{
			$root = array(0);
		}
		else
		{
			$root = $this->User->calendars;
		}

		$id = strlen($this->Input->get('id')) ? $this->Input->get('id') : CURRENT_ID;

		// Check current action
		switch ($this->Input->get('act'))
		{
			case 'paste':
				// Allow
			break;

			case 'create':
				if (!strlen($this->Input->get('pid')) || !in_array($this->Input->get('pid'), $root))
				{
					$this->log('Not enough permissions to create events in calendar ID "'.$this->Input->get('pid').'"', 'tl_iao_invoice_items checkPermission', TL_ERROR);
					$this->redirect('contao/main.php?act=error');
				}
			break;

			case 'cut':
			case 'copy':
				if (!in_array($this->Input->get('pid'), $root))
				{
					$this->log('Not enough permissions to '.$this->Input->get('act').' event ID "'.$id.'" to calendar ID "'.$this->Input->get('pid').'"', 'tl_iao_invoice_items checkPermission', TL_ERROR);
					$this->redirect('contao/main.php?act=error');
				}
				// NO BREAK STATEMENT HERE

			case 'edit':
			case 'show':
			case 'delete':
			case 'toggle':
				$objCalendar = $this->Database->prepare("SELECT pid FROM tl_iao_invoice_items WHERE id=?")
											  ->limit(1)
											  ->execute($id);

				if ($objCalendar->numRows < 1)
				{
					$this->log('Invalid event ID "'.$id.'"', 'tl_iao_invoice_items checkPermission', TL_ERROR);
					$this->redirect('contao/main.php?act=error');
				}

				if (!in_array($objCalendar->pid, $root))
				{
					$this->log('Not enough permissions to '.$this->Input->get('act').' event ID "'.$id.'" of calendar ID "'.$objCalendar->pid.'"', 'tl_iao_invoice_items checkPermission', TL_ERROR);
					$this->redirect('contao/main.php?act=error');
				}
			break;

			case 'select':
			case 'editAll':
			case 'deleteAll':
			case 'overrideAll':
			case 'cutAll':
			case 'copyAll':
				if (!in_array($id, $root))
				{
					$this->log('Not enough permissions to access calendar ID "'.$id.'"', 'tl_iao_invoice_items checkPermission', TL_ERROR);
					$this->redirect('contao/main.php?act=error');
				}

				$objCalendar = $this->Database->prepare("SELECT id FROM tl_iao_invoice_items WHERE pid=?")
											  ->execute($id);

				if ($objCalendar->numRows < 1)
				{
					$this->log('Invalid calendar ID "'.$id.'"', 'tl_iao_invoice_items checkPermission', TL_ERROR);
					$this->redirect('contao/main.php?act=error');
				}

				$session = $this->Session->getData();
				$session['CURRENT']['IDS'] = array_intersect($session['CURRENT']['IDS'], $objCalendar->fetchEach('id'));
				$this->Session->setData($session);
			break;

			default:
				if (strlen($this->Input->get('act')))
				{
					$this->log('Invalid command "'.$this->Input->get('act').'"', 'tl_iao_invoice_items checkPermission', TL_ERROR);
					$this->redirect('contao/main.php?act=error');
				}
				elseif (!in_array($id, $root))
				{
					$this->log('Not enough permissions to access calendar ID "'.$id.'"', 'tl_iao_invoice_items checkPermission', TL_ERROR);
					$this->redirect('contao/main.php?act=error');
				}
			break;
		}
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

		$itemObj = $this->Database->prepare('SELECT `price`,`count`,`vat`,`vat_incl`,`operator` FROM `tl_iao_invoice_items` WHERE `pid`=? AND published =?')
									->execute($dc->activeRecord->pid,1);


		if($itemObj->numRows > 0)
		{
			$allNetto = 0;
			$allBrutto = 0;

			while($itemObj->next())
			{
				$englprice = str_replace(',','.',$itemObj->price);
				$priceSum = $englprice * $itemObj->count;

				//if MwSt inclusive
				if($itemObj->vat_incl == 1)
				{
					$Netto = $priceSum;
					$Brutto = $this->getBruttoPrice($priceSum,$itemObj->vat);
				}
				else
				{
					$Netto = $this->getNettoPrice($priceSum,$itemObj->vat);
					$Brutto = $priceSum;
				}
				
				//which operator is set?
				if($itemObj->operator == '-')
				{
					$allNetto -= $Netto;
					$allBrutto -= $Brutto;

		    	}
				else
				{
					$allNetto += $Netto;
					$allBrutto += $Brutto;
				}

		    	$this->Database->prepare('UPDATE `tl_iao_invoice` SET `price_netto`=?, `price_brutto`=? WHERE `id`=?')
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

		//von den Haupteinstellungen holen ob diese MwSt befreit ist, dann Brutto und Netto gleich setzen.
		$invoiceObj = $this->Database->prepare('SELECT * FROM `tl_iao_invoice` WHERE `id`=?')
					 ->limit(1)
					 ->execute($dc->activeRecord->pid);

	    $englprice = str_replace(',','.',$dc->activeRecord->price);

		$Netto = $nettoSum = $Brutto = $bruttoSum = 0;

		if($dc->activeRecord->vat_incl == 1)
		{
			$Netto = $englprice;
			$Brutto = $this->getBruttoPrice($englprice,$dc->activeRecord->vat);
		}
		else
		{
			$Netto = $this->getNettoPrice($englprice,$dc->activeRecord->vat);
			$Brutto = $englprice;
		}

		if($invoiceObj->noVat)
		{
			$Netto = $englprice;
			$Brutto = $englprice;
	    }

	    $nettoSum = round($Netto,2) * $dc->activeRecord->count;
	    $bruttoSum = round($Brutto,2) * $dc->activeRecord->count;

		$this->Database->prepare('UPDATE `tl_iao_invoice_items` SET `price_netto`=?, `price_brutto`=? WHERE `id`=?')
			->limit(1)
			->execute($nettoSum, $bruttoSum, $dc->id);
	}

	/**
	 * Get netto-price from brutto
	 * @param float
	 * @param integer
	 * @return float
	 */
	public function getNettoPrice($brutto,$vat)
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
	 * Return the link picker wizard
	 * @param object
	 * @return string
	 */
	public function pagePicker(DataContainer $dc)
	{
		$strField = 'ctrl_' . $dc->field . (($this->Input->get('act') == 'editAll') ? '_' . $dc->id : '');
		return ' ' . $this->generateImage('pickpage.gif', $GLOBALS['TL_LANG']['MSC']['pagepicker'], 'style="vertical-align:top; cursor:pointer;" onclick="Backend.pickPage(\'' . $strField . '\')"');
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
		if (strlen($this->Input->get('tid')))
		{
			$this->toggleVisibility($this->Input->get('tid'), ($this->Input->get('state') == 1));
			$this->redirect($this->getReferer());
		}

		// Check permissions AFTER checking the tid, so hacking attempts are logged
		if (!$this->User->isAdmin && !$this->User->hasAccess('tl_iao_invoice_items::published', 'alexf'))
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
		if (!$this->User->isAdmin && !$this->User->hasAccess('tl_iao_invoice_items::published', 'alexf'))
		{
			$this->log('Not enough permissions to publish/unpublish event ID "'.$intId.'"', 'tl_iao_invoice_items toggleVisibility', TL_ERROR);
			$this->redirect('contao/main.php?act=error');
		}

		$this->createInitialVersion('tl_iao_invoice_items', $intId);

		// Trigger the save_callback
		if (is_array($GLOBALS['TL_DCA']['tl_iao_invoice_items']['fields']['published']['save_callback']))
		{
			foreach ($GLOBALS['TL_DCA']['tl_iao_invoice_items']['fields']['published']['save_callback'] as $callback)
			{
				$this->import($callback[0]);
				$blnVisible = $this->$callback[0]->$callback[1]($blnVisible, $this);
			}
		}

		// Update the database
		$this->Database->prepare("UPDATE tl_iao_invoice_items SET tstamp=". time() .", published='" . ($blnVisible ? 1 : '') . "' WHERE id=?")
						->execute($intId);

		$this->createNewVersion('tl_iao_invoice_items', $intId);

		// Update the RSS feed (for some reason it does not work without sleep(1))
		sleep(1);
	}

	/**
	 * Generate a button to put a posten-template for invoices
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

		if ($this->Input->get('key') == 'addPostenTemplate' && $this->Input->get('ptid') == $row['id'])
		{
			$result = $this->Database->prepare('SELECT * FROM `tl_iao_invoice_items` WHERE `id`=?')
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
				'price' => $result->price,
				'amountStr' => $result->amountStr,
				'operator' => $result->operator,
				'price_netto' => $result->price_netto,
				'price_brutto' => $result->price_brutto,
				'published' => $result->published,
				'vat' => $result->vat,
				'vat_incl' => $result->vat_incl,
				'position' => 'invoice',
			);

			$newposten = $this->Database->prepare('INSERT INTO `tl_iao_templates_items` %s')
							->set($postenset)
							->execute();

			$newPostenID = $newposten->insertId;

			$this->redirect('contao/main.php?do=iao_setup&mod=iao_templates_items&table=tl_iao_templates_items&act=edit&id='.$newPostenID);
		}

		$href.='&amp;ptid='.$row['id'];

		return '<a href="'.$this->addToUrl($href).'" title="'.specialchars($title).'"'.$attributes.'>'.$this->generateImage($icon, $label).'</a> ';
	}

	/**
	 * get all invoice-posten-templates
	 * @param object
	 * @throws Exception
	 */
	public function getPostenTemplate(DataContainer $dc)
	{
		$varValue= array();

		$all = $this->Database->prepare('SELECT `id`,`headline` FROM `tl_iao_templates_items` WHERE `position`=?')
				->execute('invoice');

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
			'sorting' => $result->sorting,
			'date' => $result->date,
			'time' => $result->time,
			'text' => $result->text,
			'count' => $result->count,
			'price' => $result->price,
			'price_netto' => $result->price_netto,
			'price_brutto' => $result->price_brutto,
			'published' => $result->published,
			'vat' => $result->vat,
			'vat_incl' => $result->vat_incl
		);

		$this->Database->prepare('UPDATE `tl_iao_invoice_items` %s WHERE `id`=?')
				->set($postenset)
				->execute($dc->id);

		$this->reload();

		return $varValue;
	}

	/**
	 * get options for tax rates
	 * @param object
	 * @throws Exception
	 */
	public function getTaxRatesOptions(DataContainer $dc)
	{
		$varValue= array();

		$all = $this->Database->prepare('SELECT `value`,`name` FROM `tl_iao_tax_rates`  ORDER BY `sorting` ASC')
				->execute();

		while($all->next())
		{
			$varValue[$all->value] = $all->name;
		}
		return $varValue;
	}

	/**
	 * get options for item units
	 * @param object
	 * @throws Exception
	 */
	public function getItemUnitsOptions(DataContainer $dc)
	{
		$varValue= array();

		$all = $this->Database->prepare('SELECT `value`,`name` FROM `tl_iao_item_units`  ORDER BY `sorting` ASC')
				->execute();

		while($all->next())
		{
			$varValue[$all->value] = $all->name;
		}
		return $varValue;
	}

	/**
	* calculate and update fields
	*/
	public function updateRemaining(DataContainer $dc)
	{

		$itemObj =	$this->Database->prepare('SELECT SUM(`price_netto`) as `brutto_sum` FROM `tl_iao_invoice_items` WHERE `pid`=? AND `published`=?')
									->execute($dc->activeRecord->pid, 1);

		$sumObj = $itemObj->fetchRow();

		if($itemObj->numRows > 0)
		{
			$parentObj = $this->Database->prepare('SELECT `paid_on_dates` FROM `tl_iao_invoice` WHERE `id`=?')
										->limit(1)
										->execute($dc->activeRecord->pid);

			$paidsArr = unserialize($parentObj->fetchRow());
			$already = 0;
			$lastPayDate = '';

			if(is_array($paidsArr) && ($paidsArr[0]['payamount'] != ''))
			{
				foreach($paidsArr as $k => $a)
				{
					$already += $a['payamount'];
					$lastPayDate = $a['paydate'];
				}
			}

			$dif = $dc->activeRecord->price_brutto - $already;
			$status = ($dc->activeRecord->price_brutto == $already && $dc->activeRecord->price_brutto > 0) ? 2 : $dc->activeRecord->status;
			$paid_on_date = ($dc->activeRecord->price_brutto == $already) ? $lastPayDate : $dc->activeRecord->paid_on_date;

			$set = array(
				'remaining' => $dif,
				'status' => $status,
				'paid_on_date' => $paid_on_date
			);
			$this->Database->prepare('UPDATE `tl_iao_invoice` %s WHERE `id`=?')
						->set($set)
						->execute($dc->id);
		}
	}

}
