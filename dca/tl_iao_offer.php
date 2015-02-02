<?php

/**
 * @copyright  Sven Rhinow 2011-2013
 * @author     sr-tag Sven Rhinow Webentwicklung <http://www.sr-tag.de>
 * @package    invoice_and_offer
 * @license    LGPL
 * @filesource
 */

/**
 * Table tl_iao_offer
 */
$GLOBALS['TL_DCA']['tl_iao_offer'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'ctable'                      => array('tl_iao_offer_items'),
		'switchToEdit'                => true,
		'enableVersioning'            => false,
		'onload_callback' => array
		(
			array('tl_iao_offer', 'checkPermission'),
			array('tl_iao_offer', 'updateExpiryToTstmp')
		),
		'sql' => array
		(
			'keys' => array
			(
				'id' => 'primary'
			)
		)
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 1,
			'fields'                  => array('offer_tstamp'),
			'flag'                    => 8,
			'panelLayout'             => 'filter;search,limit'
		),
		'label' => array
		(
			'fields'                  => array('title','offer_id_str'),
			'format'                  => '%s (%s)',
			'label_callback'          => array('tl_iao_offer', 'listEntries'),
		),
		'global_operations' => array
		(
			'importOffer' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_offer']['importOffer'],
				'href'                => 'key=importOffer',
				'class'               => 'global_import',
				'attributes'          => 'onclick="Backend.getScrollOffset();"'
			),
			'exportOffer' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_offer']['exportOffer'],
				'href'                => 'key=exportOffer',
				'class'               => 'global_export',
				'attributes'          => 'onclick="Backend.getScrollOffset();"'
			),
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
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_offer']['edit'],
				'href'                => 'table=tl_iao_offer_items',
				'icon'                => 'edit.gif',
				'attributes'          => 'class="contextmenu"'
			),
			'editheader' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_offer']['editheader'],
				'href'                => 'act=edit',
				'icon'                => 'header.gif',
				'button_callback'     => array('tl_iao_offer', 'editHeader'),
				// 'attributes'          => 'class="edit-header"'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_offer']['copy'],
				'href'                => 'act=copy',
				'icon'                => 'copy.gif'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_offer']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"',
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_offer']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			),
			'invoice' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_offer']['invoice'],
				'href'                => 'key=addInvoice',
				'icon'                => 'system/modules/invoice_and_offer/html/icons/kontact_todo.png',
				'button_callback'     => array('tl_iao_offer', 'addInvoice')
			),
			'toggle' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_credit']['toggle'],
				'icon'                => 'ok.gif',
				#'attributes'          => 'onclick="Backend.getScrollOffset(); return AjaxRequest.toggleVisibility(this, %s);"',
				'button_callback'     => array('tl_iao_offer', 'toggleIcon')
			),
			'pdf' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_offer']['pdf'],
				'href'                => 'key=pdf',
				'icon'                => 'iconPDF.gif',
				'button_callback'     => array('tl_iao_offer', 'showPDFButton')
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'__selector__'                => array(),
		'default'                     => '{settings_legend},setting_id;{title_legend},title;{offer_id_legend:hide},offer_id,offer_id_str,offer_tstamp,offer_pdf_file,expiry_date;{address_legend},member,address_text;{text_legend},before_template,before_text,after_template,after_text;{status_legend},published,status;{extend_legend},noVat;{notice_legend:hide},notice'
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
		'tstamp' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),	
		'sorting' => array
		(
			'sql'					  => "int(10) unsigned NOT NULL default '0'"
		),		
		'setting_id' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_offer']['setting_id'],
			'exclude'                 => true,
			'filter'                  => true,
			'sorting'                 => true,
			'flag'                    => 11,
			'inputType'               => 'select',
			'options_callback'        => array('tl_iao_offer', 'getSettingOptions'),
			'eval'                    => array('tl_class'=>'w50','includeBlankOption'=>false, 'chosen'=>true),
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'title' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_offer']['title'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>255,'tl_class'=>'long'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'offer_tstamp' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_offer']['offer_tstamp'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'datim', 'doNotCopy'=>true, 'datepicker'=>$this->getDatePickerString(), 'tl_class'=>'w50 wizard'),
			'load_callback' => array
			(
				array('tl_iao_offer', 'generateOfferTstamp')
			),
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'expiry_date' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_offer']['expiry_date'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'datim', 'doNotCopy'=>true, 'datepicker'=>$this->getDatePickerString(), 'tl_class'=>'w50 wizard'),
			'save_callback' => array
			(
				array('tl_iao_offer', 'generateExpiryDate')
			),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'offer_id' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_offer']['offer_id'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'alnum', 'doNotCopy'=>true, 'spaceToUnderscore'=>true, 'maxlength'=>128, 'tl_class'=>'w50'),
			'save_callback' => array
			(
				array('tl_iao_offer', 'generateOfferNumber')
			),
			'sql'					  => "int(10) unsigned NOT NULL default '0'"
		),
		'offer_id_str' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_offer']['offer_id_str'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('doNotCopy'=>true, 'spaceToUnderscore'=>true, 'maxlength'=>128, 'tl_class'=>'w50'),
			'save_callback' => array
			(
				array('tl_iao_offer', 'createOfferNumberStr')
			),
			'sql'					  => "varchar(255) NOT NULL default ''"
		),
		'offer_pdf_file' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_offer']['offer_pdf_file'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'fileTree',
			'eval'                    => array('fieldType'=>'radio', 'tl_class'=>'clr','extensions'=>'pdf','files'=>true, 'filesOnly'=>true, 'mandatory'=>false),
			'sql'					  => "varchar(255) NOT NULL default ''"
		),
		'member' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_offer']['member'],
			'exclude'                 => true,
			'filter'                  => true,
			'sorting'                 => true,
			'search'                  => true,
			'flag'                    => 11,
			'inputType'               => 'select',
			'options_callback'        => array('tl_iao_offer', 'getMemberOptions'),
			'eval'                    => array('tl_class'=>'w50','includeBlankOption'=>true,'submitOnChange'=>true, 'chosen'=>true),
			'save_callback' => array
			(
				array('tl_iao_offer', 'fillAdressText')
			),
			'sql'					  => "varbinary(128) NOT NULL default ''"
		),
		'address_text' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_offer']['address_text'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'textarea',
			'eval'                    => array('rte'=>'tinyMCE','style'=>'height:60px;', 'tl_class'=>'clr'),
			'explanation'             => 'insertTags',
			'sql'					  => "mediumtext NULL"
		),
		'before_template' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_offer']['before_template'],
			'exclude'                 => true,
			'sorting'                 => true,
			'flag'                    => 11,
			'inputType'               => 'select',
			'options_callback'        => array('tl_iao_offer', 'getBeforeTemplate'),
			'eval'                    => array('tl_class'=>'w50','includeBlankOption'=>true,'submitOnChange'=>true, 'chosen'=>true),
			'save_callback' => array
			(
				array('tl_iao_offer', 'fillBeforeText')
			),
			'sql'					  => "int(10) unsigned NOT NULL default '0'"
		),
		'before_text' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_offer']['before_text'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'textarea',
			'eval'                    => array('rte'=>'tinyMCE', 'helpwizard'=>true,'style'=>'height:60px;', 'tl_class'=>'clr'),
			'explanation'             => 'insertTags',
			'sql'					  => "text NULL"
		),
		'after_template' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_offer']['after_template'],
			'exclude'                 => true,
			'sorting'                 => true,
			'flag'                    => 11,
			'inputType'               => 'select',
			'options_callback'        => array('tl_iao_offer', 'getAfterTemplate'),
			'eval'                    => array('tl_class'=>'w50','includeBlankOption'=>true,'submitOnChange'=>true, 'chosen'=>true),
			'save_callback' => array
			(
				array('tl_iao_offer', 'fillAfterText')
			),
			'sql'					  => "int(10) unsigned NOT NULL default '0'"
		),
		'after_text' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_offer']['after_text'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'textarea',
			'eval'                    => array('rte'=>'tinyMCE', 'helpwizard'=>true,'style'=>'height:60px;', 'tl_class'=>'clr'),
			'explanation'             => 'insertTags',
			'sql'					  => "text NULL"
		),
		'published' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_offer']['published'],
			'exclude'                 => true,
			'filter'                  => true,
			'flag'                    => 1,
			'inputType'               => 'checkbox',
			'eval'                    => array('doNotCopy'=>true),
			'sql'					  => "char(1) NOT NULL default ''"
		),
		'status' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_offer']['status'],
			'exclude'                 => true,
			'filter'                  => true,
			'flag'                    => 1,
			'inputType'               => 'select',
			'options'                 => &$GLOBALS['TL_LANG']['tl_iao_offer']['status_options'],
			'sql'					=> "char(1) NOT NULL default ''"
		),
		'noVat' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_offer']['noVat'],
			'exclude'                 => true,
			'filter'                  => true,
			'flag'                    => 1,
			'inputType'               => 'checkbox',
			'eval'                    => array('doNotCopy'=>true,'tl_class'=>'w50'),
			'sql'					  => "char(1) NOT NULL default ''"
		),
		'notice' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_offer']['notice'],
			'exclude'                 => true,
			'search'		  => true,
			'filter'                  => false,
			'inputType'               => 'textarea',
			'eval'                    => array('mandatory'=>false, 'cols'=>'10','rows'=>'10','style'=>'height:100px','rte'=>false),
			'sql'					  => "text NULL"
		),
		'price_netto' => array
		(
			'sql' 					=> "varchar(64) NOT NULL default '0'"
		),
		'price_brutto' => array
		(
			'sql' 					=> "varchar(64) NOT NULL default '0'"
		)
	)
);

/**
 * Class tl_iao_offer
 */
class tl_iao_offer extends \iao\iaoBackend
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
	public function setIaoSettings($id)
	{
			$this->settings = ($id) ? $this->getSettings($id) : array();
	}

	/**
	 * Check permissions to edit table tl_iao_offer
	 */
	public function checkPermission()
	{
		// HOOK: comments extension required
		if (!in_array('comments', $this->Config->getActiveModules()))
		{
			unset($GLOBALS['TL_DCA']['tl_iao_offer']['fields']['allowComments']);
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

		$GLOBALS['TL_DCA']['tl_iao_offer']['list']['sorting']['root'] = $root;

		// Check permissions to add archives
		if (!$this->User->hasAccess('create', 'newp'))
		{
			$GLOBALS['TL_DCA']['tl_iao_offer']['config']['closed'] = true;
		}

		// Check current action
		switch (\Input::get('act'))
		{
			case 'create':
			case 'select':
				// Allow
			break;

			case 'edit':
				// Dynamically add the record to the user profile
				if (!in_array(\Input::get('id'), $root))
				{
					$arrNew = \Session::get('new_records');

					if (is_array($arrNew['tl_iao_offer']) && in_array(\Input::get('id'), $arrNew['tl_iao_offer']))
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
								$arrNews[] = \Input::get('id');

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
								$arrNews[] = \Input::get('id');

								$this->Database->prepare("UPDATE tl_user_group SET news=? WHERE id=?")
												->execute(serialize($arrNews), $this->User->groups[0]);
							}
						}

						// Add new element to the user object
						$root[] = \Input::get('id');
						$this->User->news = $root;
					}
				}
				// No break;

			case 'copy':
			case 'delete':
			case 'show':
				if (!in_array(\Input::get('id'), $root) || (\Input::get('act') == 'delete' && !$this->User->hasAccess('delete', 'newp')))
				{
					$this->log('Not enough permissions to '.\Input::get('act').' news archive ID "'.\Input::get('id').'"', 'tl_iao_offer checkPermission', TL_ERROR);
					$this->redirect('contao/main.php?act=error');
				}
			break;

			case 'editAll':
			case 'deleteAll':
			case 'overrideAll':
				$session = $this->Session->getData();
				if (\Input::get('act') == 'deleteAll' && !$this->User->hasAccess('delete', 'newp'))
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
				if (strlen(\Input::get('act')))
				{
					$this->log('Not enough permissions to '.\Input::get('act').' news archives', 'tl_iao_offer checkPermission', TL_ERROR);
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
	public function  generateExpiryDate($varValue, DataContainer $dc)
	{
		if($varValue == 0)
		{
			$format = ( $GLOBALS['TL_CONFIG']['iao_offer_expiry_date'] ) ? $GLOBALS['TL_CONFIG']['iao_offer_expiry_date'] : '+3 month';
			$tstamp = ($dc->activeRecord->offer_tstamp) ? $dc->activeRecord->offer_tstamp : time();
			$varValue = strtotime($format,$tstamp);
		}
		return  $varValue;
	}

	public function updateExpiryToTstmp(DataContainer $dc)
	{
		$offerObj = $this->Database->prepare('SELECT * FROM `tl_iao_offer`')
								   ->execute();
	   	while($offerObj->next())
   		{
   			if(!stripos($offerObj->expiry_date,'-')) continue;

			$set = array('expiry_date' => strtotime($offerObj->expiry_date));
			$this->Database->prepare('UPDATE `tl_iao_offer` %s WHERE `id`=?')
						->set($set)
						->execute($offerObj->id);
   		}
	}

	/**
	 * fill date-Field if this empty
	 * @param mixed
	 * @param object
	 * @return date
	 */
	public function  generateOfferTstamp($varValue, DataContainer $dc)
	{
		return ((int)$varValue == 0) ? time() : $varValue;
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

			$text = '<p>'.$objMember->company.'<br />'.($objMember->gender!='' ? $GLOBALS['TL_LANG']['tl_iao_offer']['gender'][$objMember->gender].' ':'').($objMember->title ? $objMember->title.' ':'').$objMember->firstname.' '.$objMember->lastname.'<br />'.$objMember->street.'</p>';
			$text .='<p>'.$objMember->postal.' '.$objMember->city.'</p>';

			$this->Database->prepare('UPDATE `tl_iao_offer` SET `address_text`=? WHERE `id`=?')
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

			$this->Database->prepare('UPDATE `tl_iao_offer` SET `before_text`=? WHERE `id`=?')
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

			$this->Database->prepare('UPDATE `tl_iao_offer` SET `after_text`=? WHERE `id`=?')
					->limit(1)
					->execute($objTemplate->text,$dc->id);
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
					->execute('offer_before_text');

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
					->execute('offer_after_text');

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
		return ($this->User->isAdmin || count(preg_grep('/^tl_iao_offer::/', $this->User->alexf)) > 0) ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.specialchars($title).'"'.$attributes.'>'.$this->generateImage($icon, $label).'</a> ' : '';
	}

	/**
	 * Generate a button and return it as string
	 * @param array
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @return string
	 */
    public function addInvoice($row, $href, $label, $title, $icon)
    {
		if (!$this->User->isAdmin)
		{
			return '';
		}

		if (\Input::get('key') == 'addInvoice' && \Input::get('id') == $row['id'])
		{
			//Insert Invoice-Entry
			$set = array
			(
				'tstamp' => time(),
				'invoice_tstamp' => time(),
				'title' => $row['title'],
				'address_text' => $row['address_text'],
				'member' => $row['member'],
				'price_netto' => $row['price_netto'],
				'price_brutto' => $row['price_brutto'],
				'noVat' => $row['noVat'],
				'notice' => $row['notice'],
		    );

			$result = $this->Database->prepare('INSERT INTO `tl_iao_invoice` %s')
							->set($set)
							->execute();

			$newInvoiceID = $result->insertId;

			//Insert Postions for this Entry
			if($newInvoiceID)
			{
				$posten = $this->Database->prepare('SELECT * FROM `tl_iao_offer_items` WHERE `pid`=? ')
								->execute($row['id']);

				while($posten->next())
				{

					//Insert Invoice-Entry
					$postenset = array
					(
						'pid' => $newInvoiceID,
						'tstamp' => $posten->tstamp,
						'type' => $posten->type,
						'headline' => $posten->headline,
						'headline_to_pdf' => $posten->headline_to_pdf,
						'sorting' => $posten->sorting,
						'date' => $posten->date,
						'time' => $posten->time,
						'text' => $posten->text,
						'count' => $posten->count,
						'amountStr' => $posten->amountStr,
						'operator' => $posten->operator,
						'price' => $posten->price,
						'price_netto' => $posten->price_netto,
						'price_brutto' => $posten->price_brutto,
						'published' => $posten->published,
						'vat' => $posten->vat,
						'vat_incl' => $posten->vat_incl
					);

					$newposten = $this->Database->prepare('INSERT INTO `tl_iao_invoice_items` %s')
									->set($postenset)
									->execute();
				}

				// Update the database
				$this->Database->prepare("UPDATE tl_iao_offer SET status='2' WHERE id=?")
								->execute($row['id']);

				$this->redirect('contao/main.php?do=iao_invoice&table=tl_iao_invoice&id='.$newInvoiceID.'&act=edit');
		    }
		}
		return '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.specialchars($title).'">'.$this->generateImage($icon, $label).'</a> ';
	}

	/**
	 * Generate a "PDF" button and return it as pdf-document on Browser
	 * @param array
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @return string
	 */
	public function showPDFButton($row, $href, $label, $title, $icon)
	{
		$this->setIaoSettings($row['setting_id']); 

		if (!$this->User->isAdmin)
		{
			return '';
		}

		// Wenn keine PDF-Vorlage dann kein PDF-Link
	    $objPdfTemplate = 	\FilesModel::findByUuid($this->settings['iao_offer_pdf']);			

		if(strlen($objPdfTemplate->path) < 1 || !file_exists(TL_ROOT . '/' . $objPdfTemplate->path) ) return;  // template file not found

		if (\Input::get('key') == 'pdf' && \Input::get('id') == $row['id'])
		{
			//wenn eine feste Rechnung als PDF zugewiesen wurde
			if(strlen($row['invoice_pdf_file']) > 0 )
			{
				$objPdf = 	\FilesModel::findByPk($row['offer_pdf_file']);			
				if(!empty($objPdf->path) && file_exists(TL_ROOT . '/' . $objPdf->path))
				{
					header("Content-type: application/pdf");
					header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // Date in the past
					header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
					header('Content-Length: '.strlen($row['invoice_pdf_file']));
					header('Content-Disposition: inline; filename="'.basename($objPdf->path).'";');

					// The PDF source is in original.pdf
					readfile(TL_ROOT . '/' . $row['offer_pdf_file']);
					exit();
				}
			}

			$pdfname = 'Angebot-'.$row['offer_id_str'];

			//-- Calculating dimensions
			$margins = unserialize($GLOBALS['TL_CONFIG']['iao_pdf_margins']);         // Margins as an array
			switch( $margins['unit'] )
			{
				case 'cm':      $factor = 10.0;   break;
				default:        $factor = 1.0;
		    }

			require_once(TL_ROOT . '/system/modules/invoice_and_offer/classes/iaoPDF.php');

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
			$pdf->setSourceFile( TL_ROOT . '/' . $GLOBALS['TL_CONFIG']['iao_offer_pdf']);          // Set PDF template

			// Set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetTitle($pdfname);
			$pdf->SetSubject($pdfname);
			$pdf->SetKeywords($pdfname);

			$pdf->SetDisplayMode('fullwidth', 'OneColumn', 'UseNone');
			$pdf->SetHeaderData( );

			// Remove default header/footer
			$pdf->setPrintHeader(false);

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
		    $file = \FilesModel::findByUuid($settings['iao_pdf_css']);

		    if(strlen($file->path) > 0 && file_exists(TL_ROOT . '/' . $file->path) )
		    {
				$styles = "<style>\n" . file_get_contents(TL_ROOT . '/' . $file->path) . "\n</style>\n";
				$pdf->writeHTML($styles, true, false, true, false, '');
			}

			// write the address-data
			$pdf->drawAddress($this->changeTags($row['address_text']));

			//Rechnungsnummer
			$pdf->drawDocumentNumber($row['offer_id_str']);

			//Datum
			$pdf->drawDate(date($GLOBALS['TL_CONFIG']['dateFormat'],$row['offer_tstamp']));

			//gültig bis
			$pdf->drawExpiryDate(date($GLOBALS['TL_CONFIG']['dateFormat'],$row['expiry_date']));

			//Text vor der Posten-Tabelle
			if(strip_tags($row['before_text']))
			{
				$row['before_text']  = $this->changeTags($row['before_text']);
				$pdf->drawTextBefore($row['before_text']);
			}

			//Posten-Tabelle
			$header = array('Menge','Beschreibung','Einzelpreis','Gesamt');
			$fields = $this->getPosten(\Input::get('id'));

			$parentObj = $this->Database->prepare('SELECT `noVat` FROM `tl_iao_offer` WHERE `id`=?')
						->limit(1)
						->execute(\Input::get('id'));
			
			$noVat = $parentObj->noVat;

			$pdf->drawPostenTable($header,$fields, $noVat);

			//Text vor der Posten-Tabelle
			if(strip_tags($row['after_text']))
			{
				$row['after_text']  = $this->changeTags($row['after_text']);
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

		$this->import('iao');
		$this->loadLanguageFile('tl_iao_offer_items');

		$resultObj = $this->Database->prepare('SELECT * FROM `tl_iao_offer_items` WHERE `pid`=? AND `published`= ?  ORDER BY `sorting`')
									->execute($id,1);

		if($resultObj->numRows <= 0) return $posten;


		while($resultObj->next())
		{
			$resultObj->price = str_replace(',','.',$resultObj->price);
			$einzelpreis = ($resultObj->vat_incl == 1) ? $this->getBruttoPrice($resultObj->price,$resultObj->vat) : $resultObj->price;

			if($resultObj->headline_to_pdf == 1) $resultObj->text = substr_replace($resultObj->text, '<p><strong>'.$resultObj->headline.'</strong><br>', 0, 3);
			$resultObj->text = $this->changeTags($resultObj->text);

			// get units from DB-Table
			$unitObj = $this->Database->prepare('SELECT * FROM `tl_iao_item_units` WHERE `value`=?')
										->limit(1)
										->execute($resultObj->amountStr);

			$formatCount = stripos($resultObj->count, '.') ? number_format($resultObj->count,1,',','.') : $resultObj->count;

			$posten['fields'][] = array
			(
				$formatCount.' '.(((float)$resultObj->count <= 1) ? $unitObj->singular : $unitObj->majority),
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

			$parentObj = $this->Database->prepare('SELECT `noVat` FROM `tl_iao_offer` WHERE `id`=?')
						->limit(1)
						->execute($id);
			
			if($parentObj->noVat != 1)
			{
				$posten['summe']['mwst'][$resultObj->vat] +=  $resultObj->price_brutto - $resultObj->price_netto;
			}

		}

		$posten['summe']['netto_format'] =  number_format($posten['summe']['netto'],2,',','.');
		$posten['summe']['brutto_format'] =  number_format($posten['summe']['brutto'],2,',','.');
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

	/**
	 * create an offer-number-string and replace placeholder
	 * @param mixed
	 * @param object
	 * @return string
	 */
	public function createOfferNumberStr($varValue, DataContainer $dc)
	{
		if(!$varValue)
		{
			$tstamp = $dc->activeRecord->tstamp ? $dc->activeRecord->tstamp : time();

			$format = $GLOBALS['TL_CONFIG']['iao_offer_number_format'];
			$format =  str_replace('{date}',date('Ymd',$tstamp), $format);
			$format =  str_replace('{nr}',$dc->activeRecord->offer_id, $format);
			$varValue = $format;
		}
		return $varValue;
	}

	/**
	 * generate a offer-number if not set
	 * @param mixed
	 * @param object
	 * @return string
	 */
	public function generateOfferNumber($varValue, DataContainer $dc)
	{
		$autoNr = false;
		$varValue = (int) $varValue;

		// Generate offer_id if there is none
		if($varValue == 0)
		{
			$autoNr = true;
			$objNr = $this->Database->prepare("SELECT `offer_id` FROM `tl_iao_offer` ORDER BY `offer_id` DESC")
							->limit(1)
							->execute();

			if($objNr->numRows < 1 || $objNr->offer_id == 0)  $varValue = $GLOBALS['TL_CONFIG']['iao_offer_startnumber'];
			else  $varValue =  $objNr->offer_id +1;
		}
		else
		{
			$objNr = $this->Database->prepare("SELECT `offer_id` FROM `tl_iao_offer` WHERE `id`=? OR `offer_id`=?")
							->limit(1)
							->execute($dc->id,$varValue);

			// Check whether the OfferNumber exists
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
		<div class="cte_type status' . $arrRow['status'] . '"><strong>' . $arrRow['title'] . '</strong> '.$arrRow['offer_id_str'].'</div>
		<div>'.$GLOBALS['TL_LANG']['tl_iao_offer']['price_brutto'][0].': <strong>'.number_format($arrRow['price_brutto'],2,',','.').' '.$GLOBALS['TL_CONFIG']['iao_currency_symbol'].'</strong></div>
		<div>'.$GLOBALS['TL_LANG']['tl_iao_offer']['member'][0].': '.$row['firstname'].' '.$row['lastname'].' ('.$row['company'].')</div>
		'.(($arrRow['notice'])?"<div>".$GLOBALS['TL_LANG']['tl_iao_offer']['notice'][0].":".$arrRow['notice']."</div>": '').'
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

		if (strlen(\Input::get('tid')))
		{
			$this->toggleVisibility(\Input::get('tid'), (\Input::get('state')));
			$this->redirect($this->getReferer());
		}

		$href .= '&amp;tid='.$row['id'].'&amp;state='.($row['status']==1 ? 2 : 1);

		if ($row['status']==2)
		{
			$icon = 'logout.gif';
		}

		return '<a href="'.$this->addToUrl($href).'" title="'.$GLOBALS['TL_LANG']['tl_iao_offer']['toggle'].'"'.$attributes.'>'.$this->generateImage($icon, $label).'</a> ';
	}

	/**
	 * Disable/enable a offer
	 * @param integer
	 * @param boolean
	 */
	public function toggleVisibility($intId, $blnVisible)
	{
		// Check permissions to edit
		$this->Input->setGet('id', $intId);
		$this->Input->setGet('act', 'toggle');

		// Check permissions to publish
		if (!$this->User->isAdmin && !$this->User->hasAccess('tl_iao_offer::status', 'alexf'))
		{
			$this->log('Not enough permissions to publish/unpublish comment ID "'.$intId.'"', 'tl_iao_offer toggleActivity', TL_ERROR);
			$this->redirect('contao/main.php?act=error');
		}

		$this->createInitialVersion('tl_iao_offer', $intId);

		// Trigger the save_callback
		if (is_array($GLOBALS['TL_DCA']['tl_iao_offer']['fields']['status']['save_callback']))
		{
			foreach ($GLOBALS['TL_DCA']['tl_iao_offer']['fields']['status']['save_callback'] as $callback)
			{
				$this->import($callback[0]);
				$blnVisible = $this->$callback[0]->$callback[1]($blnVisible, $this);
			}
		}

		// Update the database
		$this->Database->prepare("UPDATE tl_iao_offer SET status='" . ($blnVisible==1 ? '1' : '2') . "' WHERE id=?")
						->execute($intId);

		$this->createNewVersion('tl_iao_offer', $intId);
	}
}
