<?php

/**
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
 * @copyright  Sven Rhinow 2011-2013
 * @author     sr-tag Sven Rhinow Webentwicklung <http://www.sr-tag.de>
 * @package    invoice_and_offer
 * @license    LGPL
 * @filesource
 */


/**
 * Table tl_iao_credit
 */
$GLOBALS['TL_DCA']['tl_iao_credit'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'ctable'                      => array('tl_iao_credit_items'),
		'switchToEdit'                => true,
		'enableVersioning'            => false,
		'onload_callback' => array
		(
			array('tl_iao_credit','IAOSettings'),
			array('tl_iao_credit', 'checkPermission'),
			// array('tl_iao_credit', 'updateExpiryToTstmp')
		),
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 1,
			'fields'                  => array('credit_tstamp'),
			'flag'                    => 8,
			'panelLayout'             => 'filter;search,limit'
		),
		'label' => array
		(
			'fields'                  => array('title','credit_id_str'),
			'format'                  => '%s (%s)',
			'label_callback'          => array('tl_iao_credit', 'listEntries'),
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
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_credit']['edit'],
				'href'                => 'table=tl_iao_credit_items',
				'icon'                => 'edit.gif',
				'attributes'          => 'class="contextmenu"'
			),
			'editheader' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_credit']['editheader'],
				'href'                => 'act=edit',
				'icon'                => 'header.gif',
				'button_callback'     => array('tl_iao_credit', 'editHeader'),
				// 'attributes'          => 'class="edit-header"'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_credit']['copy'],
				'href'                => 'act=copy',
				'icon'                => 'copy.gif'
			),

			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_credit']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"',
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_credit']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			),
			'toggle' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_credit']['toggle'],
				'icon'                => 'ok.gif',
				'button_callback'     => array('tl_iao_credit', 'toggleIcon')
			),
			'pdf' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_credit']['pdf'],
				'href'                => 'key=pdf',
				'icon'                => 'iconPDF.gif',
				'button_callback'     => array('tl_iao_credit', 'showPDFButton')
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'__selector__'                => array(),
		'default'                     => '{settings_legend},setting_id;title;{credit_id_legend:hide},credit_id,credit_id_str,credit_date,credit_tstamp,credit_pdf_file,expiry_date;{address_legend},member,address_text;{text_legend},before_template,before_text,after_template,after_text;{extend_legend},noVat;{status_legend},published,status;{notice_legend:hide},notice'
	),

	// Subpalettes
	'subpalettes' => array
	(

	),

	// Fields
	'fields' => array
	(
		'setting_id' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_credit']['setting_id'],
			'exclude'                 => true,
			'filter'                  => true,
			'sorting'                 => true,
			'flag'                    => 11,
			'inputType'               => 'select',
			'options_callback'        => array('tl_iao_credit', 'getSettings'),
			'eval'                    => array('tl_class'=>'w50','includeBlankOption'=>false, 'chosen'=>true),
		),
		'title' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_credit']['title'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>255)
		),

		'alias' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_credit']['alias'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'alnum', 'doNotCopy'=>true, 'spaceToUnderscore'=>true, 'maxlength'=>128),
			'save_callback' => array
			(
				array('tl_iao_credit', 'generateAlias')
			)
		),
		'credit_tstamp' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_credit']['credit_tstamp'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'date', 'doNotCopy'=>true, 'datepicker'=>$this->getDatePickerString(), 'tl_class'=>'w50 wizard'),
			'save_callback' => array
			(
				array('tl_iao_credit', 'generateCreditTstamp')
			)
		),
		'expiry_date' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_credit']['expiry_date'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'date', 'doNotCopy'=>true, 'datepicker'=>$this->getDatePickerString(), 'tl_class'=>'w50 wizard'),
			'save_callback' => array
			(
				array('tl_iao_credit', 'generateExpiryDate')
			)
		),
		'credit_id' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_credit']['credit_id'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'alnum', 'doNotCopy'=>true, 'spaceToUnderscore'=>true, 'maxlength'=>128, 'tl_class'=>'w50'),
			'save_callback' => array
			(
				array('tl_iao_credit', 'generateCreditNumber')
			)
		),
		'credit_id_str' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_credit']['credit_id_str'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('doNotCopy'=>true, 'spaceToUnderscore'=>true, 'maxlength'=>128, 'tl_class'=>'w50'),
			'save_callback' => array
			(
				array('tl_iao_credit', 'createCreditNumberStr')
			)
		),
		'credit_pdf_file' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_credit']['credit_pdf_file'],
			'exclude'                 => true,
			'inputType'               => 'fileTree',
			'eval'                    => array('fieldType'=>'radio', 'tl_class'=>'clr','extensions'=>'pdf','files'=>true, 'filesOnly'=>true, 'mandatory'=>false)
		),
		'member' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_credit']['member'],
			'exclude'                 => true,
			'filter'                  => true,
			'sorting'                 => true,
			'flag'                    => 11,
			'inputType'               => 'select',
			'options_callback'        => array('tl_iao_credit', 'getMembers'),
			'eval'                    => array('tl_class'=>'w50','includeBlankOption'=>true,'submitOnChange'=>true, 'chosen'=>true),
			'save_callback' => array
			(
				array('tl_iao_credit', 'fillAdressText')
			)
		),
		'address_text' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_credit']['address_text'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'textarea',
			'eval'                    => array('rte'=>'tinyMCE','style'=>'height:60px;', 'tl_class'=>'clr'),
			'explanation'             => 'insertTags'
		),
		'before_template' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_credit']['before_template'],
			'exclude'                 => true,
			'filter'                  => true,
			'sorting'                 => true,
			'flag'                    => 11,
			'inputType'               => 'select',
			'options_callback'        => array('tl_iao_credit', 'getBeforeTemplate'),
			'eval'                    => array('tl_class'=>'w50','includeBlankOption'=>true,'submitOnChange'=>true),
			'save_callback' => array
			(
				array('tl_iao_credit', 'fillBeforeText')
			)
		),
		'before_text' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_credit']['before_text'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'textarea',
			'eval'                    => array('rte'=>'tinyMCE', 'helpwizard'=>true,'style'=>'height:60px;', 'tl_class'=>'clr'),
			'explanation'             => 'insertTags'
		),
		'after_template' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_credit']['before_template'],
			'exclude'                 => true,
			'filter'                  => true,
			'sorting'                 => true,
			'flag'                    => 11,
			'inputType'               => 'select',
			'options_callback'        => array('tl_iao_credit', 'getAfterTemplate'),
			'eval'                    => array('tl_class'=>'w50','includeBlankOption'=>true,'submitOnChange'=>true),
			'save_callback' => array
			(
				array('tl_iao_credit', 'fillAfterText')
			)
		),
		'after_text' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_credit']['after_text'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'textarea',
			'eval'                    => array('rte'=>'tinyMCE', 'helpwizard'=>true,'style'=>'height:60px;', 'tl_class'=>'clr'),
			'explanation'             => 'insertTags'
		),
		'published' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_credit']['published'],
			'exclude'                 => true,
			'filter'                  => true,
			'flag'                    => 1,
			'inputType'               => 'checkbox',
			'eval'                    => array('doNotCopy'=>true)
		),
		'status' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_credit']['status'],
			'exclude'                 => true,
			'filter'                  => true,
			'flag'                    => 1,
			'inputType'               => 'select',
			'options' => array(
			'1'=>'nicht angenommen',
			'2'=>'angenommen'
			 ),
		),
		'noVat' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_credit']['noVat'],
			'exclude'                 => true,
			'filter'                  => true,
			'flag'                    => 1,
			'inputType'               => 'checkbox',
			'eval'                    => array('doNotCopy'=>true,'tl_class'=>'w50')
		),
		'notice' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_credit']['notice'],
			'exclude'                 => true,
			'search'		  => true,
			'filter'                  => false,
			'inputType'               => 'textarea',
			'eval'                    => array('mandatory'=>false, 'cols'=>'10','rows'=>'10','style'=>'height:100px','rte'=>false)

		)
	)
);


/**
 * Class tl_iao_credit
 */
class tl_iao_credit extends Backend
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
		$this->import('iao');
		$this->iao->setIAOSettings($dc->activeRecord->setting_id);
	}

	/**
	 * Check permissions to edit table tl_iao_credit
	 */
	public function checkPermission()
	{
		// HOOK: comments extension required
		if (!in_array('comments', $this->Config->getActiveModules()))
		{
			unset($GLOBALS['TL_DCA']['tl_iao_credit']['fields']['allowComments']);
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

		$GLOBALS['TL_DCA']['tl_iao_credit']['list']['sorting']['root'] = $root;

		// Check permissions to add archives
		if (!$this->User->hasAccess('create', 'newp'))
		{
			$GLOBALS['TL_DCA']['tl_iao_credit']['config']['closed'] = true;
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

					if (is_array($arrNew['tl_iao_credit']) && in_array($this->Input->get('id'), $arrNew['tl_iao_credit']))
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
					$this->log('Not enough permissions to '.$this->Input->get('act').' news archive ID "'.$this->Input->get('id').'"', 'tl_iao_credit checkPermission', TL_ERROR);
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
					$this->log('Not enough permissions to '.$this->Input->get('act').' news archives', 'tl_iao_credit checkPermission', TL_ERROR);
					$this->redirect('contao/main.php?act=error');
				}
			break;
		}
	}

	/**
	 * Autogenerate an article alias if it has not been set yet
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
			$varValue = standardize($dc->activeRecord->title);
		}


		$objAlias = $this->Database->prepare("SELECT id FROM `tl_iao_credit` WHERE id=? OR alias=?")
								   ->execute($dc->id, $varValue);

		// Check whether the page alias exists
		if ($objAlias->numRows > 1)
		{
			if (!$autoAlias)
			{
				throw new Exception(sprintf($GLOBALS['TL_LANG']['ERR']['aliasExists'], $varValue));
			}

			$varValue .= '-' . $dc->id;
		}

		return $varValue;
	}
    /**
	 * fill date-Field if this empty
	 * @param mixed
	 * @param object
	 * @return date
	 */
	public function  generateCreditDate($varValue, DataContainer $dc)
	{
		return ($varValue==0) ? date('Y-m-d') : $varValue;
	}

	/**
	 * fill date-Field if this empty
	 * @param mixed
	 * @param object
	 * @return date
	 */
	public function  generateExpiryDate($varValue, DataContainer $dc)
	{
		if($varValue==0)
	    {
			$format = ( $GLOBALS['TL_CONFIG']['iao_credit_expiry_date'] ) ? $GLOBALS['TL_CONFIG']['iao_credit_expiry_date'] : '+3 month';
			$tstamp = ($dc->activeRecord->credit_tstamp) ? $dc->activeRecord->credit_tstamp : time();
			$varValue = strtotime($format,$tstamp);
	    }
	    return  $varValue;
	}

	public function updateExpiryToTstmp(DataContainer $dc)
	{
		$creditObj = $this->Database->prepare('SELECT * FROM `tl_iao_credit`')
								   ->execute();
	   	while($creditObj->next())
   		{
   			if(!stripos($creditObj->expiry_date,'-')) continue;

			$set = array('expiry_date' => strtotime($creditObj->expiry_date));
			$this->Database->prepare('UPDATE `tl_iao_credit` %s WHERE `id`=?')
						->set($set)
						->execute($creditObj->id);
   		}
	}

	/**
	 * fill date-Field if this empty
	 * @param mixed
	 * @param object
	 * @return date
	 */
	public function  generateCreditTstamp($varValue, DataContainer $dc)
	{
		return ($varValue == '') ? time() : $varValue;
	}

	/**
	 * fill Adress-Text
	 * @param object
	 * @throws Exception
	 */
	public function fillAdressText($varValue, DataContainer $dc)
	{
		if(strip_tags($dc->activeRecord->address_text)=='')
		{
		    if(strlen($varValue)<=0) return $varValue;

		    $objMember = $this->Database->prepare('SELECT * FROM `tl_member` WHERE `id`=?')
						->limit(1)
						->execute($varValue);

			$text = '<p>'.$objMember->company.'<br />'.($objMember->gender!='' ? $GLOBALS['TL_LANG']['tl_iao_credit']['gender'][$objMember->gender].' ':'').($objMember->title ? $objMember->title.' ':'').$objMember->firstname.' '.$objMember->lastname.'<br />'.$objMember->street.'</p>';
			$text .='<p>'.$objMember->postal.' '.$objMember->city.'</p>';

			$this->Database->prepare('UPDATE `tl_iao_credit` SET `address_text`=? WHERE `id`=?')
				   ->limit(1)
				   ->execute($text,$dc->id);
		}
		return $varValue;
	}

	/**
	 * fill Text before
	 * @param object
	 * @throws Exception
	 */
	public function fillBeforeText($varValue, DataContainer $dc)
	{
		if(strip_tags($dc->activeRecord->before_text)=='')
		{
			if(strlen($varValue)<=0) return $varValue;

		    $objTemplate = $this->Database->prepare('SELECT * FROM `tl_iao_templates` WHERE `id`=?')
						->limit(1)
						->execute($varValue);


		    $this->Database->prepare('UPDATE `tl_iao_credit` SET `before_text`=? WHERE `id`=?')
				   ->limit(1)
				   ->execute($objTemplate->text,$dc->id);
		}
		return $varValue;
	}

	/**
	 * fill Text after
	 * @param object
	 * @throws Exception
	 */
	public function fillAfterText($varValue, DataContainer $dc)
	{

		if(strip_tags($dc->activeRecord->after_text)=='')
		{
			if(strlen($varValue)<=0) return $varValue;

			$objTemplate = $this->Database->prepare('SELECT `text` FROM `tl_iao_templates` WHERE `id`=?')
						->limit(1)
						->execute($varValue);

		    $this->Database->prepare('UPDATE `tl_iao_credit` SET `after_text`=? WHERE `id`=?')
				   ->limit(1)
				   ->execute($objTemplate->text,$dc->id);
		}
		return $varValue;
	}

	/**
	 * get all members to valid groups
	 * @param object
	 * @throws Exception
	 */
	public function getMembers(DataContainer $dc)
	{
		$varValue= array();

		if(!$GLOBALS['TL_CONFIG']['iao_costumer_group'])  return $varValue;

		$member = $this->Database->prepare('SELECT `id`,`groups`,`firstname`,`lastname`,`company` FROM `tl_member` WHERE `iao_group`')
						 ->execute($GLOBALS['TL_CONFIG']['iao_costumer_group']);
		while($member->next())
		{
			$varValue[$member->id] =  $member->firstname.' '.$member->lastname.' ('.$member->company.')';
		}

		return $varValue;
	}

	/**
	 * get all settings to valid groups
	 * @param object
	 * @throws Exception
	 */
	public function getSettings(DataContainer $dc)
	{
		$varValue= array();

		$settings = $this->Database->prepare('SELECT `id`,`name` FROM `tl_iao_settings` ORDER BY `fallback` DESC, `name` DESC')
						 ->execute();
		while($settings->next())
		{
			$varValue[$settings->id] =  $settings->name;
		}

		return $varValue;
	}

	/**
	 * get all invoice before template
	 * @param object
	 * @throws Exception
	 */
	public function getBeforeTemplate(DataContainer $dc)
	{
		$varValue= array();

		$all = $this->Database->prepare('SELECT `id`,`title` FROM `tl_iao_templates` WHERE `position`=?')
		->execute('credit_before_text');

		while($all->next())
		{
			$varValue[$all->id] = $all->title;
		}

		return $varValue;
	}

	/**
	 * get all invoice after template
	 * @param object
	 * @throws Exception
	 */
	public function getAfterTemplate(DataContainer $dc)
	{
		$varValue= array();

		$all = $this->Database->prepare('SELECT `id`,`title` FROM `tl_iao_templates` WHERE `position`=?')
		->execute('credit_after_text');

		while($all->next())
		{
			$varValue[$all->id] = $all->title;
		}

		return $varValue;
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
		return ($this->User->isAdmin || count(preg_grep('/^tl_iao_credit::/', $this->User->alexf)) > 0) ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.specialchars($title).'"'.$attributes.'>'.$this->generateImage($icon, $label).'</a> ' : '';
	}

	/**
	 * Generate a "PDF" button and return it as string
	 * @param array
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @return string
	 */
	public function showPDFButton($row, $href, $label, $title, $icon)
	{
		if (!$this->User->isAdmin)
		{
			return '';
		}

		if ($this->Input->get('key') == 'pdf' && $this->Input->get('id') == $row['id'])
		{

			if( !file_exists(TL_ROOT . '/' . $GLOBALS['TL_CONFIG']['iao_credit_pdf']) ) return;  // template file not found

			$this->import('iao');

			$pdfname = 'Gutschrift-'.$row['credit_id_str'];

			//-- Calculating dimensions
			$margins = unserialize($GLOBALS['TL_CONFIG']['iao_pdf_margins']);         // Margins as an array
			switch( $margins['unit'] )
			{
				case 'cm':      $factor = 10.0;   break;
				default:        $factor = 1.0;
			}

			require_once(TL_ROOT . '/system/modules/invoice_and_offer/iaoPDF.php');

			$dim['top']    = !is_numeric($margins['top'])   ? PDF_MARGIN_TOP    : $margins['top'] * $factor;
			$dim['right']  = !is_numeric($margins['right']) ? PDF_MARGIN_RIGHT  : $margins['right'] * $factor;
			$dim['bottom'] = !is_numeric($margins['top'])   ? PDF_MARGIN_BOTTOM : $margins['bottom'] * $factor;
			$dim['left']   = !is_numeric($margins['left'])  ? PDF_MARGIN_LEFT   : $margins['left'] * $factor;

			// TCPDF configuration
			$l['a_meta_dir'] = 'ltr';
			$l['a_meta_charset'] = $GLOBALS['TL_CONFIG']['characterSet'];
			$l['a_meta_language'] = $GLOBALS['TL_LANGUAGE'];
			$l['w_page'] = 'page';

			// Create new PDF document with FPDI extension
			$pdf = new iaoPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true);
			$pdf->setSourceFile( TL_ROOT . '/' . $GLOBALS['TL_CONFIG']['iao_credit_pdf']);          // Set PDF template

			// Set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor(PDF_AUTHOR);
			$pdf->SetTitle($pdfname);
			$pdf->SetSubject($pdfname);
			$pdf->SetKeywords($pdfname);

			$pdf->SetDisplayMode('fullwidth', 'OneColumn', 'UseNone');
			$pdf->SetHeaderData( );

			// Remove default header/footer
			$pdf->setPrintHeader(false);
			$pdf->setPrintFooter(false);

			// Set margins
			$pdf->SetMargins($dim['left'], $dim['top'], $dim['right']);

			// Set auto page breaks
			$pdf->SetAutoPageBreak(true, $dim['bottom']);

			// Set image scale factor
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

			// Set some language-dependent strings
			$pdf->setLanguageArray($l);

			// Initialize document and add a page
			$pdf->AddPage();

			// Include CSS (TCPDF 5.1.000 an newer)
			if(file_exists(TL_ROOT . '/' . $GLOBALS['TL_CONFIG']['iao_pdf_css']) )
			{
				$styles = "<style>\n" . file_get_contents(TL_ROOT . '/' . $GLOBALS['TL_CONFIG']['iao_pdf_css']) . "\n</style>\n";
			}

			// write the address-data
			$pdf->drawAddress($styles.$this->iao->changeTags($row['address_text']));

			//Rechnungsnummer
			$pdf->drawDocumentNumber($row['credit_id_str']);

			//Datum
			$pdf->drawDate(date($GLOBALS['TL_CONFIG']['dateFormat'],$row['credit_tstamp']));

			//gültig bis
			$pdf->drawExpiryDate(date($GLOBALS['TL_CONFIG']['dateFormat'],$row['expiry_date']));

			//Text vor der Posten-Tabelle
		    if(strip_tags($row['before_text']))
		    {
				$row['before_text']  = $this->iao->changeTags($row['before_text']);
				$pdf->drawTextBefore($row['before_text']);
			}

			//Posten-Tabelle
			$header = array('Menge','Beschreibung','Einzelpreis','Gesamt');
			$fields = $this->getPosten($this->Input->get('id'));
			$pdf->drawPostenTable($header,$fields);

			//Text vor der Posten-Tabelle
			if(strip_tags($row['after_text']))
			{
				$row['after_text']  = $this->iao->changeTags($row['after_text']);
				$pdf->drawTextAfter($row['after_text']);
			}

			// Close and output PDF document
			$pdf->lastPage();
			$pdf->Output($pdfname. '.pdf', 'D');

			// Stop script execution
			exit();
		}

		return '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.specialchars($title).'">'.$this->generateImage($icon, $label).'</a> ';
	}

	public function getPosten($id)
	{
		$posten = array();

		if(!$id) return $posten;

	    $resultObj = $this->Database->prepare('SELECT * FROM `tl_iao_credit_items` WHERE `pid`=? AND `published`=1 ORDER BY `sorting`')->execute($id);

		if($resultObj->numRows <= 0) return $posten;

		$parentObj = $this->Database->prepare('SELECT * FROM `tl_iao_offer` WHERE `id`=?')
						->limit(1)
						->execute($id);

		while($resultObj->next())
	    {
			$resultObj->price = str_replace(',','.',$resultObj->price);
			$einzelpreis = ($resultObj->vat_incl == 1) ? $this->iao->getBruttoPrice($resultObj->price,$resultObj->vat) : $resultObj->price;

			if($resultObj->headline_to_pdf == 1) $resultObj->text = substr_replace($resultObj->text, '<p><strong>'.$resultObj->headline.'</strong><br>', 0, 3);
			$resultObj->text = $this->iao->changeTags($resultObj->text);

			// get units from DB-Table
			$unitObj = $this->Database->prepare('SELECT * FROM `tl_iao_item_units` WHERE `value`=?')
										->limit(1)
										->execute($resultObj->amountStr);

			$formatCount = stripos($resultObj->count, '.') ? number_format($resultObj->count,1,',','.') : $resultObj->count;

			$posten['fields'][] = array
			(
				$formatCount.' '.(($resultObj->count <= 1) ? $unitObj->singular : $unitObj->majority),
				$resultObj->text,
				number_format($einzelpreis,2,',','.'),
				number_format($resultObj->price_brutto,2,',','.')
			);

			$posten['pagebreak_after'][] = $resultObj->pagebreak_after;
			$posten['type'][] = $resultObj->type;

			if($resultObj->operator == '-')
			{
				$posten['summe']['price'] -= $resultObj->operator = $resultObj->price;
				$posten['summe']['netto'] -= $resultObj->price_netto;
				$posten['summe']['brutto'] -= $resultObj->price_brutto;
			}
			else
			{
				$posten['summe']['price'] += $resultObj->operator = $resultObj->price;
				$posten['summe']['netto'] += $resultObj->price_netto;
				$posten['summe']['brutto'] += $resultObj->price_brutto;
			}

			if($parentObj->noVat != 1) $posten['summe']['mwst'][$resultObj->vat] += $resultObj->price_brutto - $resultObj->price_netto;
		}

		$posten['summe']['netto_format'] =  number_format($posten['summe']['netto'],2,',','.');
		$posten['summe']['brutto_format'] =  number_format($posten['summe']['brutto'],2,',','.');

		return $posten;
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
	 * Autogenerate an article alias if it has not been set yet
	 * @param mixed
	 * @param object
	 * @return string
	 */
	public function generateCreditNumber($varValue, DataContainer $dc)
	{
		$autoNr = false;
		$varValue = (int) $varValue;

		// Generate credit_id if there is none
		if($varValue == 0)
		{
			$autoNr = true;
			$objNr = $this->Database->prepare("SELECT `credit_id` FROM `tl_iao_credit` ORDER BY `credit_id` DESC")
			->limit(1)
			->execute();

			if($objNr->numRows < 1 || $objNr->credit_id == 0)  $varValue = $GLOBALS['TL_CONFIG']['iao_credit_startnumber'];
			else  $varValue =  $objNr->credit_id +1;
	    }
	    else
	    {
			$objNr = $this->Database->prepare("SELECT `credit_id` FROM `tl_iao_credit` WHERE `id`=? OR `credit_id`=?")
			->limit(1)
			->execute($dc->id,$varValue);

			// Check whether the CreditNumber exists
			if ($objNr->numRows > 1 )
			{
				if (!$autoNr)
				{
					throw new Exception(sprintf($GLOBALS['TL_LANG']['ERR']['aliasExists'], $varValue));
				}

				$varValue .= '-' . $dc->id;
			}
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
		<div>'.$GLOBALS['TL_LANG']['tl_iao_credit']['price_brutto'][0].': <strong>'.number_format($arrRow['price_brutto'],2,',','.').' '.$GLOBALS['TL_CONFIG']['currency_symbol'].'</strong></div>
		<div>'.$GLOBALS['TL_LANG']['tl_iao_credit']['member'][0].': '.$row['firstname'].' '.$row['lastname'].' ('.$row['company'].')</div>
		'.(($arrRow['notice'])?"<div>".$GLOBALS['TL_LANG']['tl_iao_credit']['notice'][0].":".$arrRow['notice']."</div>": '').'
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

		return '<a href="'.$this->addToUrl($href).'" title="'.$GLOBALS['TL_LANG']['tl_iao_credit']['toggle'].'"'.$attributes.'>'.$this->generateImage($icon, $label).'</a> ';
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

		// Check permissions to publish
		if (!$this->User->isAdmin && !$this->User->hasAccess('tl_iao_credit::status', 'alexf'))
		{
			$this->log('Not enough permissions to publish/unpublish comment ID "'.$intId.'"', 'tl_iao_credit toggleActivity', TL_ERROR);
			$this->redirect('contao/main.php?act=error');
		}

		$this->createInitialVersion('tl_iao_credit', $intId);

		// Trigger the save_callback
		if (is_array($GLOBALS['TL_DCA']['tl_iao_credit']['fields']['status']['save_callback']))
		{
			foreach ($GLOBALS['TL_DCA']['tl_iao_credit']['fields']['status']['save_callback'] as $callback)
			{
				$this->import($callback[0]);
				$blnVisible = $this->$callback[0]->$callback[1]($blnVisible, $this);
			}
		}

		// Update the database
		$this->Database->prepare("UPDATE tl_iao_credit SET status='" . ($blnVisible==1 ? '1' : '2') . "' WHERE id=?")
		->execute($intId);

		$this->createNewVersion('tl_iao_credit', $intId);
	}
}
