<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2011 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  Leo Feyer 2005-2011
 * @author     Leo Feyer <http://www.contao.org>
 * @license    LGPL
 * @filesource
 *
 * @copyright  Sven Rhinow 2011
 * @author     sr-tag Sven Rhinow Webentwicklung <http://www.sr-tag.de>
 * @package    offer_and_offer
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
		'onsubmit_callback'	      => array(
		    array('tl_iao_offer_items','saveAllPricesToParent'),
		    array('tl_iao_offer_items','saveNettoAndBrutto')
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
			#'panelLayout'             => 'filter;sort,search,limit',
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
				'button_callback'     => array('tl_iao_offer_items', 'showPDF')
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
		'__selector__'                => array(),
		'default'                     => '{templates_legend:hide},posten_template;{title_legend},headline,alias,author;{item_legend},text,price,count,vat,vat_incl;{publish_legend},published;pagebreak_after'
	),

	// Subpalettes
	'subpalettes' => array
	(

	),

	// Fields
	'fields' => array
	(
		'posten_template' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_offer_items']['posten_template'],
			'exclude'                 => true,
			'filter'                  => true,
			'sorting'                 => true,
			'flag'                    => 11,
			'inputType'               => 'select',
			'options_callback'        => array('tl_iao_offer_items', 'getPostenTemplate'),
			'eval'                    => array('tl_class'=>'w50','includeBlankOption'=>true,'submitOnChange'=>true),
			'save_callback' => array
			(
				array('tl_iao_offer_items', 'fillPostenFields')
			)			
		),
		'headline' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_offer_items']['headline'],
			'exclude'                 => true,
			'search'                  => true,
			'sorting'                 => true,
			'flag'                    => 1,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>255)
		),
		'alias' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_offer_items']['alias'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'alnum', 'unique'=>true, 'spaceToUnderscore'=>true, 'maxlength'=>128, 'tl_class'=>'w50'),
			'save_callback' => array
			(
				array('tl_iao_offer_items', 'generateAlias')
			)
		),
		'author' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_offer_items']['author'],
			'default'                 => $this->User->id,
			'exclude'                 => true,
			'filter'                  => true,
			'sorting'                 => true,
			'flag'                    => 1,
			'inputType'               => 'select',
			'foreignKey'              => 'tl_user.name',
			'eval'                    => array('doNotCopy'=>true, 'mandatory'=>true, 'includeBlankOption'=>true, 'tl_class'=>'w50')
		),
		'text' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_offer_items']['text'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'textarea',
			'eval'                    => array('rte'=>'tinyMCE', 'helpwizard'=>true,'style'=>'height:60px;', 'tl_class'=>'clr'),
		),
		'price' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_offer_items']['price'],
			'exclude'                 => true,
			'search'                  => true,
			'sorting'                 => true,
			'flag'                    => 1,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50')
		),
		'count' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_offer_items']['count'],
			'exclude'                 => true,
			'flag'                    => 1,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50')
		),
		'vat' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_offer_items']['vat'],
			'exclude'                 => true,
			'filter'                  => true,
			'flag'                    => 1,
			'inputType'               => 'select',
			'options'                 => array(19=>'19% MwSt.',7=>'7% MwSt.',0=>'ohne MwSt.')
		),				
		'vat_incl' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_offer_items']['vat_incl'],
			'exclude'                 => true,
			'filter'                  => true,
			'flag'                    => 1,
			'inputType'               => 'select',
			'options'                 => array(1=>'netto',2=>'brutto')
		),				
		'published' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_offer_items']['published'],
			'exclude'                 => true,
			'filter'                  => true,
			'flag'                    => 2,
			'inputType'               => 'checkbox',
			'eval'                    => array('doNotCopy'=>true)
		),
		'pagebreak_after' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_offer_items']['pagebreak_after'],
			'exclude'                 => true,
			'filter'                  => true,
			'flag'                    => 1,
			'inputType'               => 'checkbox',
			'eval'                    => array('doNotCopy'=>true)
		),		
	)
);


/**
 * Class tl_iao_offer_items
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * @copyright  Leo Feyer 2005-2011
 * @author     Leo Feyer <http://www.contao.org>
 * @package    Controller
 */
class tl_iao_offer_items extends Backend
{

	/**
	 * Import the back end user object
	 */
	public function __construct()
	{
		parent::__construct();
		$this->import('BackendUser', 'User');
	}
	
 	public function showPDF($href, $label, $title, $class)
	{
          
	    return '&nbsp; :: &nbsp;<a href="contao/main.php?do=iao_offer&table=tl_iao_offer&'.$href.'" title="'.specialchars($title).'" class="'.$class.'">'.$label.'</a> ';
	}

	/**
	 * Check permissions to edit table tl_iao_offer_items
	 */
	public function checkPermission()
	{
		// HOOK: comments extension required
		if (!in_array('comments', $this->Config->getActiveModules()))
		{
			$key = array_search('allowComments', $GLOBALS['TL_DCA']['tl_iao_offer_items']['list']['sorting']['headerFields']);
			unset($GLOBALS['TL_DCA']['tl_iao_offer_items']['list']['sorting']['headerFields'][$key]);
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
					$this->log('Not enough permissions to create events in calendar ID "'.$this->Input->get('pid').'"', 'tl_iao_offer_items checkPermission', TL_ERROR);
					$this->redirect('contao/main.php?act=error');
				}
				break;

			case 'cut':
			case 'copy':
				if (!in_array($this->Input->get('pid'), $root))
				{
					$this->log('Not enough permissions to '.$this->Input->get('act').' event ID "'.$id.'" to calendar ID "'.$this->Input->get('pid').'"', 'tl_iao_offer_items checkPermission', TL_ERROR);
					$this->redirect('contao/main.php?act=error');
				}
				// NO BREAK STATEMENT HERE

			case 'edit':
			case 'show':
			case 'delete':
			case 'toggle':
				$objCalendar = $this->Database->prepare("SELECT pid FROM tl_iao_offer_items WHERE id=?")
											  ->limit(1)
											  ->execute($id);

				if ($objCalendar->numRows < 1)
				{
					$this->log('Invalid event ID "'.$id.'"', 'tl_iao_offer_items checkPermission', TL_ERROR);
					$this->redirect('contao/main.php?act=error');
				}

				if (!in_array($objCalendar->pid, $root))
				{
					$this->log('Not enough permissions to '.$this->Input->get('act').' event ID "'.$id.'" of calendar ID "'.$objCalendar->pid.'"', 'tl_iao_offer_items checkPermission', TL_ERROR);
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
					$this->log('Not enough permissions to access calendar ID "'.$id.'"', 'tl_iao_offer_items checkPermission', TL_ERROR);
					$this->redirect('contao/main.php?act=error');
				}

				$objCalendar = $this->Database->prepare("SELECT id FROM tl_iao_offer_items WHERE pid=?")
											  ->execute($id);

				if ($objCalendar->numRows < 1)
				{
					$this->log('Invalid calendar ID "'.$id.'"', 'tl_iao_offer_items checkPermission', TL_ERROR);
					$this->redirect('contao/main.php?act=error');
				}

				$session = $this->Session->getData();
				$session['CURRENT']['IDS'] = array_intersect($session['CURRENT']['IDS'], $objCalendar->fetchEach('id'));
				$this->Session->setData($session);
				break;

			default:
				if (strlen($this->Input->get('act')))
				{
					$this->log('Invalid command "'.$this->Input->get('act').'"', 'tl_iao_offer_items checkPermission', TL_ERROR);
					$this->redirect('contao/main.php?act=error');
				}
				elseif (!in_array($id, $root))
				{
					$this->log('Not enough permissions to access calendar ID "'.$id.'"', 'tl_iao_offer_items checkPermission', TL_ERROR);
					$this->redirect('contao/main.php?act=error');
				}
				break;
		}
	}


	/**
	 * Autogenerate a event alias if it has not been set yet
	 * @param mixed
	 * @param object
	 * @return string
	 */
	public function generateAlias($varValue, DataContainer $dc)
	{
		$autoAlias = false;

		// Generate alias if there is none
		if (!strlen($varValue))
		{
			$autoAlias = true;
			$varValue = standardize($dc->activeRecord->headline);
		}

		$objAlias = $this->Database->prepare("SELECT id FROM tl_iao_offer_items WHERE alias=?")
								   ->execute($varValue);

		// Check whether the alias exists
		if ($objAlias->numRows > 1 && !$autoAlias)
		{
			throw new Exception(sprintf($GLOBALS['TL_LANG']['ERR']['aliasExists'], $varValue));
		}

		// Add ID to alias
		if ($objAlias->numRows && $autoAlias)
		{
			$varValue .= '-' . $dc->id;
		}

		return $varValue;
	}



	/**
	 * Add the type of input field
	 * @param array
	 * @return string
	 */
	public function listItems($arrRow)
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
	 * Get all articles and return them as array
	 * @param object
	 * @return array
	 */
	public function getArticleAlias(DataContainer $dc)
	{
		$arrPids = array();
		$arrAlias = array();

		if (!$this->User->isAdmin)
		{
			foreach ($this->User->pagemounts as $id)
			{
				$arrPids[] = $id;
				$arrPids = array_merge($arrPids, $this->getChildRecords($id, 'tl_page', true));
			}

			if (empty($arrPids))
			{
				return $arrAlias;
			}

			$objAlias = $this->Database->prepare("SELECT a.id, a.title, a.inColumn, p.title AS parent FROM tl_article a LEFT JOIN tl_page p ON p.id=a.pid WHERE a.pid IN(". implode(',', array_map('intval', array_unique($arrPids))) .") ORDER BY parent, a.sorting")
									   ->execute($dc->id);
		}
		else
		{
			$objAlias = $this->Database->prepare("SELECT a.id, a.title, a.inColumn, p.title AS parent FROM tl_article a LEFT JOIN tl_page p ON p.id=a.pid ORDER BY parent, a.sorting")
									   ->execute($dc->id);
		}

		if ($objAlias->numRows)
		{
			$this->loadLanguageFile('tl_article');

			while ($objAlias->next())
			{
				$arrAlias[$objAlias->parent][$objAlias->id] = $objAlias->title . ' (' . (strlen($GLOBALS['TL_LANG']['tl_article'][$objAlias->inColumn]) ? $GLOBALS['TL_LANG']['tl_article'][$objAlias->inColumn] : $objAlias->inColumn) . ', ID ' . $objAlias->id . ')';
			}
		}

		return $arrAlias;
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
		$result = $this->Database->prepare('SELECT * FROM `tl_iao_offer_items` WHERE `id`=?')
		                         ->limit(1)
					 ->execute($row['id']);							

		    //Insert Invoice-Entry
		    $postenset = array(
		    'tstamp' => time(),
		    'headline' => $result->headline,
		    'alias' => $result->alias,
		    'sorting' => $result->sorting,
		    'author' => $result->author,
		    'date' => $result->date,
		    'time' => $result->time,
		    'text' => $result->text,
		    'count' => $result->count,
		    'price' => $result->price,
		    'price_netto' => $result->price_netto,
		    'price_brutto' => $result->price_brutto,
		    'published' => $result->published,
		    'vat' => $result->vat,
		    'vat_incl' => $result->vat_incl,
		    'position' => 'offer'
		    );
				    
		    $newposten = $this->Database->prepare('INSERT INTO `tl_iao_posten_templates` %s')
				     ->set($postenset)
				     ->execute();
				     			
                    $newPostenID = $newposten->insertId;
					   						
		    $this->redirect('contao/main.php?do=iao_posten_templates&table=tl_iao_posten_templates&id='.$newPostenID.'&act=edit');
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
            
            $all = $this->Database->prepare('SELECT `id`,`headline` FROM `tl_iao_posten_templates` WHERE `position`=?')
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
		 
		$result = $this->Database->prepare('SELECT * FROM `tl_iao_posten_templates` WHERE `id`=?')
					    ->limit(1)
					    ->execute($varValue);
											
		//Insert Invoice-Entry
		$postenset = array(
		'tstamp' => time(),
		'headline' => $result->headline,
		'sorting' => $result->sorting,
		'author' => $result->author,
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
				
		$this->Database->prepare('UPDATE `tl_iao_offer_items` %s WHERE `id`=?')
			       ->set($postenset)
			       ->execute($dc->id);			
                $this->reload();
		return $varValue;
	}        
        	
}

?>