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
 *
 * @copyright  Sven Rhinow 2011
 * @author     sr-tag Sven Rhinow Webentwicklung <http://www.sr-tag.de>
 * @package    invoice_and_offer
 * @license    LGPL
 * @filesource
 */


/**
 * Table tl_iao_posten_templates
 */
$GLOBALS['TL_DCA']['tl_iao_posten_templates'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'switchToEdit'                => true,
		'enableVersioning'            => false,
		'onload_callback' => array
		(
			array('tl_iao_posten_templates', 'checkPermission')
		),
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 1,
			'fields'                  => array('position'),
			'flag'                    => 12,
			'panelLayout'             => 'filter;search,limit'
		),
		'label' => array
		(
			'fields'                  => array('headline'),
			'format'                  => '%s',
// 			'label_callback'          => array('tl_iao_posten_templates', 'listEntries'),			
		),
		'global_operations' => array
		(
			'all' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'                => 'act=select',
				'class'               => 'header_edit_all',
				'attributes'          => 'onclick="Backend.getScrollOffset();" accesskey="e"'
			)
		),
		'operations' => array
		(
			'edit' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_posten_templates']['edit'],
				'href'                => 'table=tl_iao_posten_templates&act=edit',
				'icon'                => 'edit.gif',
				'attributes'          => 'class="contextmenu"'
			),
			'editheader' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_posten_templates']['editheader'],
				'href'                => 'act=edit',
				'icon'                => 'header.gif',
				'button_callback'     => array('tl_iao_posten_templates', 'editHeader'),
				'attributes'          => 'class="edit-header"'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_posten_templates']['copy'],
				'href'                => 'act=copy',
				'icon'                => 'copy.gif'
			),
			
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_posten_templates']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"',
			),
			
		)
	),

	// Palettes
	'palettes' => array
	(
		'__selector__'                => array(),
		'default'                     => 'position;{title_legend},headline,headline_to_pdf;{item_legend},text,price,vat,count,amountStr,operator,vat_incl;{publish_legend},published'
	),

	// Subpalettes
	'subpalettes' => array
	(

	),

	// Fields
	'fields' => array
	(
		
		'headline' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_posten_templates']['headline'],
			'exclude'                 => true,
			'search'                  => true,
			'sorting'                 => true,
			'flag'                    => 1,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50')
		),
		'headline_to_pdf' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_posten_templates']['headline_to_pdf'],
			'exclude'                 => true,
			'filter'                  => true,
			'flag'                    => 2,
			'inputType'               => 'checkbox',
			'eval'                    => array('doNotCopy'=>true, 'tl_class'=>'w50')
		),						
		'text' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_posten_templates']['text'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'textarea',
			'eval'                    => array('rte'=>'tinyMCE', 'helpwizard'=>true,'style'=>'height:60px;', 'tl_class'=>'clr'),
			'explanation'             => 'insertTags'
		),
		'price' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_posten_templates']['price'],
			'exclude'                 => true,
			'search'                  => true,
			'sorting'                 => true,
			'flag'                    => 1,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50')
		),
		'count' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_posten_templates']['count'],
			'exclude'                 => true,
			'flag'                    => 1,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50')
		),
		'amountStr' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_posten_templates']['amountStr'],
			'exclude'                 => true,
			'filter'                  => true,
			'flag'                    => 1,
			'inputType'               => 'select',
			'options'                 => &$GLOBALS['TL_LANG']['tl_iao_posten_templates']['amountStr_options'],
                        'eval'                    => array('tl_class'=>'w50','includeBlankOption'=>true,'submitOnChange'=>false)
		),		
		'vat' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_posten_templates']['vat'],
			'exclude'                 => true,
			'filter'                  => true,
			'flag'                    => 1,
			'inputType'               => 'select',
			'options'            	  => &$GLOBALS['TL_LANG']['tl_iao_posten_templates']['vat_options'],
			'eval'                    => array('tl_class'=>'w50')
		),				
		'vat_incl' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_posten_templates']['vat_incl'],
			'exclude'                 => true,
			'filter'                  => true,
			'flag'                    => 1,
			'inputType'               => 'select',
			'options'                 => &$GLOBALS['TL_LANG']['tl_iao_posten_templates']['vat_incl_percents'],			
			'eval'                    => array('tl_class'=>'w50')		
		),
		'operator' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_posten_templates']['operator'],
			'exclude'                 => true,
			'filter'                  => true,
			'flag'                    => 1,
			'inputType'               => 'select',
			'options'                 => &$GLOBALS['TL_LANG']['tl_iao_posten_templates']['operators'],
			'eval'                    => array('tl_class'=>'w50')			
		),						
		'published' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_posten_templates']['published'],
			'exclude'                 => true,
			'filter'                  => true,
			'flag'                    => 2,
			'inputType'               => 'checkbox',
			'eval'                    => array('doNotCopy'=>true)
		),
		'position' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_posten_templates']['position'],
			'exclude'                 => true,
			'filter'                  => true,
// 			'flag'                    => 1,
			'inputType'               => 'select',
			'options' => array(
			    'invoice'=>'Rechnung',
			    'offer'=>'Angebot',
			    'credit'=>'Gutschrift'
			 ),
		),
								
	)
);


/**
 * Class tl_iao_posten_templates
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * @copyright  Leo Feyer 2005-2011
 * @author     Leo Feyer <http://www.contao.org>
 * @package    Controller
 */
class tl_iao_posten_templates extends Backend
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
	 * Check permissions to edit table tl_iao_posten_templates
	 */
	public function checkPermission()
	{
		// HOOK: comments extension required
		if (!in_array('comments', $this->Config->getActiveModules()))
		{
			unset($GLOBALS['TL_DCA']['tl_iao_posten_templates']['fields']['allowComments']);
		}

		if ($this->User->isAdmin)
		{
			return;
		}

		// Set root IDs
		if (!is_array($this->User->news) || count($this->User->news) < 1)
		{
			$root = array(0);
		}
		else
		{
			$root = $this->User->news;
		}

		$GLOBALS['TL_DCA']['tl_iao_posten_templates']['list']['sorting']['root'] = $root;

		// Check permissions to add archives
		if (!$this->User->hasAccess('create', 'newp'))
		{
			$GLOBALS['TL_DCA']['tl_iao_posten_templates']['config']['closed'] = true;
		}

		// Check current action
		switch ($this->Input->get('act'))
		{
			case 'create':
			case 'select':
				// Allow
				break;

			case 'edit':
				// Dynamically add the record to the user profile
				if (!in_array($this->Input->get('id'), $root))
				{
					$arrNew = $this->Session->get('new_records');

					if (is_array($arrNew['tl_iao_posten_templates']) && in_array($this->Input->get('id'), $arrNew['tl_iao_posten_templates']))
					{
						// Add permissions on user level
						if ($this->User->inherit == 'custom' || !$this->User->groups[0])
						{
							$objUser = $this->Database->prepare("SELECT news, newp FROM tl_user WHERE id=?")
													   ->limit(1)
													   ->execute($this->User->id);

							$arrNewp = deserialize($objUser->newp);

							if (is_array($arrNewp) && in_array('create', $arrNewp))
							{
								$arrNews = deserialize($objUser->news);
								$arrNews[] = $this->Input->get('id');

								$this->Database->prepare("UPDATE tl_user SET news=? WHERE id=?")
											   ->execute(serialize($arrNews), $this->User->id);
							}
						}

						// Add permissions on group level
						elseif ($this->User->groups[0] > 0)
						{
							$objGroup = $this->Database->prepare("SELECT news, newp FROM tl_user_group WHERE id=?")
													   ->limit(1)
													   ->execute($this->User->groups[0]);

							$arrNewp = deserialize($objGroup->newp);

							if (is_array($arrNewp) && in_array('create', $arrNewp))
							{
								$arrNews = deserialize($objGroup->news);
								$arrNews[] = $this->Input->get('id');

								$this->Database->prepare("UPDATE tl_user_group SET news=? WHERE id=?")
											   ->execute(serialize($arrNews), $this->User->groups[0]);
							}
						}

						// Add new element to the user object
						$root[] = $this->Input->get('id');
						$this->User->news = $root;
					}
				}
				// No break;

			case 'copy':
			case 'delete':
			case 'show':
				if (!in_array($this->Input->get('id'), $root) || ($this->Input->get('act') == 'delete' && !$this->User->hasAccess('delete', 'newp')))
				{
					$this->log('Not enough permissions to '.$this->Input->get('act').' news archive ID "'.$this->Input->get('id').'"', 'tl_iao_posten_templates checkPermission', TL_ERROR);
					$this->redirect('contao/main.php?act=error');
				}
				break;

			case 'editAll':
			case 'deleteAll':
			case 'overrideAll':
				$session = $this->Session->getData();
				if ($this->Input->get('act') == 'deleteAll' && !$this->User->hasAccess('delete', 'newp'))
				{
					$session['CURRENT']['IDS'] = array();
				}
				else
				{
					$session['CURRENT']['IDS'] = array_intersect($session['CURRENT']['IDS'], $root);
				}
				$this->Session->setData($session);
				break;

			default:
				if (strlen($this->Input->get('act')))
				{
					$this->log('Not enough permissions to '.$this->Input->get('act').' news archives', 'tl_iao_posten_templates checkPermission', TL_ERROR);
					$this->redirect('contao/main.php?act=error');
				}
				break;
		}
	}

	
        /**
        * fill date-Field if this empty
        * @param mixed
        * @param object
        * @return date
        */
        public function  generateCreditDate($varValue, DataContainer $dc){
	    
	    return ($varValue==0) ? date('Y-m-d') : $varValue;
	    
        }	

	/**
	 * Return the edit header button
	 * @param array
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @return string
	 */
	public function editHeader($row, $href, $label, $title, $icon, $attributes)
	{
		return ($this->User->isAdmin || count(preg_grep('/^tl_iao_posten_templates::/', $this->User->alexf)) > 0) ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.specialchars($title).'"'.$attributes.'>'.$this->generateImage($icon, $label).'</a> ' : '';
	}



	
	
	public function changeTags($text)
	{
	    $ctags = array('[nbsp]'=>'&nbsp;','[lg]'=>'&lg;','[gt]'=>'&gt;','[&]'=>'&amp;');
	    foreach($ctags as $tag => $html)
	    {
		 $text = str_replace($tag,$html,$text);
	    } 
	    return $text;
	}
			
	public function getPosten($id)
	{
	    $posten = array();
	    
	    if(!$id) return $posten;
	    
	    $resultObj = $this->Database->prepare('SELECT * FROM `tl_iao_posten_templates_items` WHERE `pid`=? AND `published`=1 ORDER BY `sorting`')->execute($id);
	    
	    if($resultObj->numRows > 0) while($resultObj->next())
	    {
		$resultObj->price = str_replace(',','.',$resultObj->price);
		$einzelpreis = ($resultObj->vat_incl == 1) ? $this->getBruttoPrice($resultObj->price,$resultObj->vat) : $resultObj->price;
		
		$posten['fields'][] = array(
			$resultObj->count,
			$resultObj->text,
			number_format($einzelpreis,2,',','.'),
			number_format(($resultObj->price_brutto),2,',','.'));
			
		$posten['summe']['netto'] += $resultObj->price_netto;
		$posten['summe']['brutto'] += $resultObj->price_brutto; 
		$posten['vat'] = $resultObj->vat;
	    }
	    $posten['summe']['mwst'] =  number_format(($posten['summe']['brutto'] - $posten['summe']['netto']),2,',','.');
	    $posten['summe']['netto'] =  number_format($posten['summe']['netto'],2,',','.');
	    $posten['summe']['brutto'] =  number_format($posten['summe']['brutto'],2,',','.');	    
	    return $posten;
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
	 	
	public function createCreditNumberStr($varValue, DataContainer $dc)
	{
	   if(!$varValue)
	   {
	       $tstamp = $dc->activeRecord->tstamp ? $dc->activeRecord->tstamp : time();
	       
	       $format = $GLOBALS['TL_CONFIG']['iao_credit_number_format']; 
	       $format =  str_replace('{date}',date('Ymd',$tstamp),$format);
	       $format =  str_replace('{nr}',$dc->activeRecord->credit_id,$format);
	       $varValue = $format;
	   }
	   return $varValue;
	}
	
      
    /**
     * List a particular record
     * @param array
     * @return string
     */
    public function listEntries($arrRow)
    {
	    
	    $this->import('Database');
	    $result = $this->Database->prepare("SELECT `firstname`,`lastname`,`company` FROM `tl_member`  WHERE id=?")
				       ->limit(1)
				       ->execute($arrRow['member']);
	    $row = $result->fetchAssoc();

	    return '
		<div class="comment_wrap">
		<div class="cte_type status' . $arrRow['status'] . '"><strong>' . $arrRow['title'] . '</strong> '.$arrRow['credit_id_str'].'</div>
		<div>'.$GLOBALS['TL_LANG']['tl_iao_posten_templates']['price_brutto'][0].': <strong>'.number_format($arrRow['price_brutto'],2,',','.').' '.$GLOBALS['TL_CONFIG']['currency_symbol'].'</strong></div>
		<div>'.$GLOBALS['TL_LANG']['tl_iao_posten_templates']['member'][0].': '.$row['firstname'].' '.$row['lastname'].' ('.$row['company'].')</div>
		</div>' . "\n    ";
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
		$this->import('BackendUser', 'User');
				
		if (strlen($this->Input->get('tid')))
		{
			$this->toggleVisibility($this->Input->get('tid'), ($this->Input->get('state')));
			$this->redirect($this->getReferer());
			
		}


		$href .= '&amp;tid='.$row['id'].'&amp;state='.($row['status']==1 ? 2 : 1);

		if ($row['status']==2)
		{
			$icon = 'logout.gif';
		}		

		return '<a href="'.$this->addToUrl($href).'" title="'.$GLOBALS['TL_LANG']['tl_iao_posten_templates']['toggle'].'"'.$attributes.'>'.$this->generateImage($icon, $label).'</a> ';
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
		#$this->checkPermission();

		// Check permissions to publish
		if (!$this->User->isAdmin && !$this->User->hasAccess('tl_iao_posten_templates::status', 'alexf'))
		{
			$this->log('Not enough permissions to publish/unpublish comment ID "'.$intId.'"', 'tl_iao_posten_templates toggleActivity', TL_ERROR);
			$this->redirect('contao/main.php?act=error');
		}

		$this->createInitialVersion('tl_iao_posten_templates', $intId);
	
		// Trigger the save_callback
		if (is_array($GLOBALS['TL_DCA']['tl_iao_posten_templates']['fields']['status']['save_callback']))
		{
			foreach ($GLOBALS['TL_DCA']['tl_iao_posten_templates']['fields']['status']['save_callback'] as $callback)
			{
				$this->import($callback[0]);
				$blnVisible = $this->$callback[0]->$callback[1]($blnVisible, $this);
			}
		}
                
		// Update the database
		$this->Database->prepare("UPDATE tl_iao_posten_templates SET status='" . ($blnVisible==1 ? '1' : '2') . "' WHERE id=?")
					   ->execute($intId);

		$this->createNewVersion('tl_iao_posten_templates', $intId);
	}    	
}

?>