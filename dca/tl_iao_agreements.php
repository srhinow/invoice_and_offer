<?php

/**
 * @copyright  Sven Rhinow 2011-2017
 * @author     sr-tag Sven Rhinow Webentwicklung <http://www.sr-tag.de>
 * @package    invoice_and_offer
 * @license    LGPL
 * @filesource
 */

/**
 * Table tl_iao_agreements
 */
$GLOBALS['TL_DCA']['tl_iao_agreements'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'ptable'                      => 'tl_iao_projects',
		'switchToEdit'                => true,
		'enableVersioning'            => false,
		'onload_callback' => array
		(
			array('tl_iao_agreements','IAOSettings')
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
			'mode'                    => 2,
			'fields'                  => array('end_date'),
			'flag'                    => 8,
			'panelLayout'             => 'filter;search,limit'
		),
		'label' => array
		(
			'fields'                  => array('title','beginn_date','end_date'),
			'format'                  => '%s (aktuelle Laufzeit: %s - %s)',
			'label_callback'          => array('tl_iao_agreements', 'listEntries'),
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
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_agreements']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif',
				'attributes'          => 'class="contextmenu"'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_agreements']['copy'],
				'href'                => 'act=copy',
				'icon'                => 'copy.gif'
			),
			'invoice' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_agreements']['invoice'],
				'href'                => 'key=addInvoice',
				'icon'                => 'system/modules/invoice_and_offer/html/icons/kontact_todo.png',
				'button_callback'     => array('tl_iao_agreements', 'addInvoice')
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_agreements']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"',
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_agreements']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'__selector__'                => array('sendEmail'),
		'default'                     => '{settings_legend},setting_id,pid;{title_legend},title;{agreement_legend:hide},agreement_pdf_file;{address_legend},member,address_text;{other_legend},price;{status_legend},agreement_date,periode,beginn_date,end_date,status,terminated_date,new_generate;{email_legend},sendEmail;{invoice_generate_legend},before_template,after_template,posten_template;{notice_legend:hide},notice'
	),
	// Subpalettes
	'subpalettes' => array
	(
             'sendEmail' => ('remind_before,email_from,email_to,email_subject,email_text')
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
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_agreements']['pid'],
			'foreignKey'              => 'tl_iao_projects.title',
			'filter'                  => true,
			'sorting'                 => true,
			'flag'                    => 11,
			'inputType'               => 'select',
			'eval'                    => array('tl_class'=>'w50','includeBlankOption'=>false, 'chosen'=>true),
			'sql'                     => "int(10) unsigned NOT NULL default '1'",
			'relation'                => array('type'=>'belongsTo', 'load'=>'eager')
		),
		'setting_id' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_agreements']['setting_id'],
			'exclude'                 => true,
			'filter'                  => true,
			'sorting'                 => true,
			'flag'                    => 11,
			'inputType'               => 'select',
			'options_callback'        => array('tl_iao_agreements', 'getSettingOptions'),
			'eval'                    => array('tl_class'=>'w50','includeBlankOption'=>false, 'chosen'=>true),
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'tstamp' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'title' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_agreements']['title'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>false, 'maxlength'=>255,'tl_class'=>'long'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'agreement_date' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_agreements']['agreement_date'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'date', 'datepicker'=>$this->getDatePickerString(), 'tl_class'=>'w50 wizard'),
			'load_callback'			=> array (
				array('tl_iao_agreements','getAgreementValue')
			),
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'periode' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_agreements']['periode'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>255,'tl_class'=>'w50'),
			'load_callback'			=> array (
				array('tl_iao_agreements','getPeriodeValue')
			),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'beginn_date' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_agreements']['beginn_date'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'date', 'datepicker'=>$this->getDatePickerString(), 'tl_class'=>'w50 wizard'),
			'load_callback'				=> array
			(
				array('tl_iao_agreements','getBeginnDateValue')
			),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'end_date' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_agreements']['end_date'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'date', 'datepicker'=>$this->getDatePickerString(), 'tl_class'=>'w50 wizard'),
			'load_callback'				=> array
			(
				array('tl_iao_agreements','getEndDateValue')
			),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'new_generate' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_agreements']['new_generate'],
			'filter'                  => true,
			'flag'                    => 1,
			'inputType'               => 'checkbox',
			'eval'                    => array('tl_class'=>'clr'),
			'save_callback'				=> array
			(
				array('tl_iao_agreements','generateNewCycle')
			),
			'sql'                     => "char(1) NOT NULL default ''"
		),
		'terminated_date' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_agreements']['terminated_date'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'date', 'datepicker'=>$this->getDatePickerString(), 'tl_class'=>'w50 wizard'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'price' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_agreements']['price'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'tl_class'=>'w50 wizard'),
			'sql'                     => "varchar(64) NOT NULL default '0'"
		),
		'member' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_agreements']['member'],
			'exclude'                 => true,
			'filter'                  => true,
			'search'                  => true,
			'sorting'                 => true,
			'flag'                    => 11,
			'inputType'               => 'select',
			'options_callback'        => array('tl_iao_agreements', 'getMembers'),
			'eval'                    => array('tl_class'=>'w50','includeBlankOption'=>true,'submitOnChange'=>true, 'chosen'=>true),
			'save_callback' => array
			(
				array('tl_iao_agreements', 'fillAdressText')
			),
			'sql'                     => "varbinary(128) NOT NULL default ''"
		),
		'address_text' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_agreements']['address_text'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'textarea',
			'eval'                    => array('rte'=>'tinyMCE','style'=>'height:60px;', 'tl_class'=>'clr'),
			'explanation'             => 'insertTags',
			'sql'                     => "mediumtext NULL"
		),
		'status' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_iao_agreements']['status'],
			'exclude'               => true,
			'filter'                => true,
			'flag'                  => 1,
			'inputType'             => 'select',
			'options'               => &$GLOBALS['TL_LANG']['tl_iao_agreements']['status_options'],
            'eval'			  		=> array('tl_class'=>'w50'),
            'sql'                     => "char(1) NOT NULL default ''"
		),
		'agreement_pdf_file' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_agreements']['agreement_pdf_file'],
			'exclude'                 => true,
			'inputType'               => 'fileTree',
			'eval'                    => array('fieldType'=>'radio', 'files'=>true, 'filesOnly'=>true, 'mandatory'=>false,'extensions'=>'pdf'),
			'sql'                     => "binary(16) NULL"
		),
		'sendEmail' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_agreements']['sendEmail'],
			'filter'                  => true,
			'flag'                    => 1,
			'inputType'               => 'checkbox',
			'eval'                    => array('doNotCopy'=>true,'submitOnChange'=>true),
			'sql'                     => "char(1) NOT NULL default ''"
		),
		'remind_before' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_agreements']['remind_before'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>255,'tl_class'=>'clr'),
			'sql'                     => "varchar(32) NOT NULL default ''"
		),
		'email_from' => array
	    (
		    'label'                   => &$GLOBALS['TL_LANG']['tl_iao_agreements']['email_from'],
		    'exclude'                 => true,
		    'inputType'               => 'text',
		    'eval'                    => array('mandatory'=>true, 'rgxp'=>'email', 'maxlength'=>32, 'decodeEntities'=>true, 'tl_class'=>'clr w50'),
		    'sql'                     => "varchar(32) NOT NULL default ''"
	    ),
	    'email_to' => array
	    (
		    'label'                   => &$GLOBALS['TL_LANG']['tl_iao_agreements']['email_to'],
		    'exclude'                 => true,
		    'flag'                    => 11,
		    'inputType'               => 'text',
		    'eval'                    => array('mandatory'=>true, 'decodeEntities'=>true, 'maxlength'=>128, 'tl_class'=>'w50'),
		    'sql'                     => "varchar(32) NOT NULL default ''"
	    ),
	    'email_subject' => array
	    (
		    'label'                   => &$GLOBALS['TL_LANG']['tl_iao_agreements']['email_subject'],
		    'exclude'                 => true,
		    'flag'                    => 11,
		    'inputType'               => 'text',
		    // 'default'		  		=> &$GLOBALS['TL_LANG']['tl_iao_agreements']['email_subject_default'],
		    'eval'                    => array('mandatory'=>false, 'maxlength'=>255, 'tl_class'=>'clr long'),
		    'sql'                     => "varchar(255) NOT NULL default ''"
	    ),
	    'email_text' => array
	    (
		    'label'                   => &$GLOBALS['TL_LANG']['tl_iao_agreements']['email_text'],
		    'exclude'                 => true,
		    'inputType'               => 'textarea',
		    'eval'                    => array('mandatory'=>true, 'decodeEntities'=>true),
		    'sql'                     => "text NULL"
	    ),
		'before_template' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_agreements']['before_template'],
			'inputType'               => 'select',
			'options_callback'        => array('tl_iao_agreements', 'getBeforeTemplate'),
			'eval'                    => array('tl_class'=>'w50','includeBlankOption'=>true,'submitOnChange'=>false, 'chosen'=>true),
			'sql'					  => "int(10) unsigned NOT NULL default '0'"
		),
		'after_template' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_agreements']['after_template'],
			'inputType'               => 'select',
			'options_callback'        => array('tl_iao_agreements', 'getAfterTemplate'),
			'eval'                    => array('tl_class'=>'w50','includeBlankOption'=>true, 'submitOnChange'=>false, 'chosen'=>true),
			'sql'					  => "int(10) unsigned NOT NULL default '0'"
		),
   		'posten_template' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_agreements']['posten_template'],
			'inputType'               => 'select',
			'options_callback'        => array('tl_iao_agreements', 'getPostenTemplate'),
			'eval'                    => array('tl_class'=>'w50', 'includeBlankOption'=>true, 'submitOnChange'=>false, 'chosen'=>true),
			'sql'					  => "int(10) unsigned NOT NULL default '0'"
		),
		'notice' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_agreements']['notice'],
			'exclude'                 => true,
			'search'		  		=> true,
			'inputType'               => 'textarea',
			'eval'                    => array('mandatory'=>false, 'cols'=>'10','rows'=>'10','style'=>'height:100px','rte'=>false),
			'sql'                     => "text NULL"
		),
	)
);

/**
 * Class tl_iao_agreements
 */
class tl_iao_agreements extends \iao\iaoBackend
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
	 * Check permissions to edit table tl_iao_agreements
	 */
	public function checkPermission()
	{
		// HOOK: comments extension required
		if (!in_array('comments', $this->Config->getActiveModules()))
		{
			unset($GLOBALS['TL_DCA']['tl_iao_agreements']['fields']['allowComments']);
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

		$GLOBALS['TL_DCA']['tl_iao_agreements']['list']['sorting']['root'] = $root;

		// Check permissions to add archives
		if (!$this->User->hasAccess('create', 'newp'))
		{
			$GLOBALS['TL_DCA']['tl_iao_agreements']['config']['closed'] = true;
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

					if (is_array($arrNew['tl_iao_agreements']) && in_array($this->Input->get('id'), $arrNew['tl_iao_agreements']))
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
					$this->log('Not enough permissions to '.$this->Input->get('act').' news archive ID "'.$this->Input->get('id').'"', 'tl_iao_agreements checkPermission', TL_ERROR);
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
					$this->log('Not enough permissions to '.$this->Input->get('act').' news archives', 'tl_iao_agreements checkPermission', TL_ERROR);
					$this->redirect('contao/main.php?act=error');
				}
			break;
		}
	}

    /**
    * List a particular record
    * @param array
    * @return string
    */
    public function listEntries($arrRow)
    {

		$return = '
		<div class="comment_wrap">
		<div class="cte_type agreement_status' . $arrRow['status'] . '"><strong>' . $arrRow['title'].'</strong></div>
		<div>Vertragszeit: '.date($GLOBALS['TL_CONFIG']['dateFormat'], $arrRow['beginn_date']).' - '.date($GLOBALS['TL_CONFIG']['dateFormat'], $arrRow['end_date']).'</div>';
		if($arrRow['status'] == 2) $return .= '<div>gekündigt am: '.date($GLOBALS['TL_CONFIG']['dateFormat'], $arrRow['terminated_date']).'</div>';
		if($arrRow['price'] != '') $return .= '<div>Betrag: '.$arrRow['price'].' '.$GLOBALS['TL_CONFIG']['currency_symbol'].'</div>';
		$return .= '</div>' . "\n    ";

		return $return;
    }

    /**
	 * fill date-Field if this empty
	 * @param mixed
	 * @param object
	 * @return date
	 */
	public function  generateExecuteDate($varValue, DataContainer $dc)
	{
		$altdate = ($dc->activeRecord->invoice_tstamp) ? $dc->activeRecord->invoice_tstamp : time();
		return ($varValue==0) ? $altdate : $varValue;
	}

	/**
	 * fill date-Field if this empty
	 * @param mixed
	 * @param object
	 * @return date
	 */
	public function  getPeriodeValue($varValue, DataContainer $dc)
	{
		return ($varValue == '') ? '+1 year' : $varValue;
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

			$text = '<p>'.$objMember->company.'<br />'.($objMember->gender!='' ? $GLOBALS['TL_LANG']['tl_iao_invoice']['gender'][$objMember->gender].' ':'').($objMember->title ? $objMember->title.' ':'').$objMember->firstname.' '.$objMember->lastname.'<br />'.$objMember->street.'</p>';
			$text .='<p>'.$objMember->postal.' '.$objMember->city.'</p>';

			$this->Database->prepare('UPDATE `tl_iao_agreements` SET `address_text`=? WHERE `id`=?')
			->limit(1)
			->execute($text,$dc->id);
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
		return ($this->User->isAdmin || count(preg_grep('/^tl_iao_agreements::/', $this->User->alexf)) > 0) ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.specialchars($title).'"'.$attributes.'>'.$this->generateImage($icon, $label).'</a> ' : '';
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
				'pid' => (\Input::get('projId')) ? : '',
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

				$this->redirect($this->addToUrl('do=iao_invoice&table=tl_iao_invoice&id='.$newInvoiceID.'&act=edit') );
		    }
		}
		
		$link = (\Input::get('onlyproj') == 1) ? 'do=iao_offer&amp;id='.$row['id'].'&amp;projId='.\Input::get('id') : 'do=iao_offer&amp;id='.$row['id'].'';
		$link = $this->addToUrl($href.'&amp;'.$link);
		$link = str_replace('table=tl_iao_offer&amp;','',$link);
		return '<a href="'.$link.'" title="'.specialchars($title).'">'.$this->generateImage($icon, $label).'</a> ';
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

		return '<a href="'.$this->addToUrl($href).'" title="'.$GLOBALS['TL_LANG']['tl_iao_agreements']['toggle'].'"'.$attributes.'>'.$this->generateImage($icon, $label).'</a> ';
	}

	/**
	 * paid/not paid
	 * @param integer
	 * @param boolean
	 */
	public function toggleVisibility($intId, $blnVisible)
	{
		// Check permissions to edit
		$this->Input->setGet('id', $intId);
		$this->Input->setGet('act', 'toggle');

		// Check permissions to publish
		if (!$this->User->isAdmin && !$this->User->hasAccess('tl_iao_agreements::status', 'alexf'))
		{
			$this->log('Not enough permissions to publish/unpublish comment ID "'.$intId.'"', 'tl_iao_agreements toggleActivity', TL_ERROR);
			$this->redirect('contao/main.php?act=error');
		}

		$this->createInitialVersion('tl_iao_agreements', $intId);

		// Trigger the save_callback
		if (is_array($GLOBALS['TL_DCA']['tl_iao_agreements']['fields']['status']['save_callback']))
		{
			foreach ($GLOBALS['TL_DCA']['tl_iao_agreements']['fields']['status']['save_callback'] as $callback)
			{
				$this->import($callback[0]);
				$blnVisible = $this->$callback[0]->$callback[1]($blnVisible, $this);
			}
		}

		$visibility = $blnVisible==1 ? '1' : '2';

		// Update the database
		$this->Database->prepare("UPDATE tl_iao_agreements SET status=? WHERE id=?")
					   ->execute($visibility, $intId);

		//get reminder-Data
		$remindObj = $this->Database->prepare('SELECT * FROM `tl_iao_agreements` WHERE `id`=?')
									->limit(1)
									->execute($intId);

		if($remindObj->numRows)
		{
			$dbObj = $this->Database->prepare("UPDATE `tl_iao_invoice` SET `status`=?, `notice` = `notice`+?  WHERE id=?")
									->execute($visibility, $remindObj->notice, $remindObj->invoice_id);
		}

		$this->createNewVersion('tl_iao_agreements', $intId);
	}

	public function getAgreementValue($varValue, DataContainer $dc)
	{

		return ($varValue == '0') ? time() : $varValue ;
	}

	public function getBeginnDateValue($varValue, DataContainer $dc)
	{
		$agreement_date = ($dc->activeRecord->agreement_date) ? $dc->activeRecord->agreement_date : time() ;
		$beginn_date = ($varValue == '') ? $agreement_date : $varValue ;
		$end_date = $this->getEndDateValue($dc->activeRecord->end_date, $dc);

		$set = array
		(
			'beginn_date' => $beginn_date,
			'end_date' => $end_date
		);

		$this->Database->prepare('UPDATE `tl_iao_agreements` %s WHERE `id`=?')
					->set($set)
					->execute($dc->id);

		return $beginn_date;
	}

	public function getEndDateValue($varValue, DataContainer $dc)
	{
		if($varValue != '') return $varValue;
		
		$agreement_date = ($dc->activeRecord->agreement_date) ? $dc->activeRecord->agreement_date : time() ;
		$beginn_date = ($dc->activeRecord->beginn_date) ? $dc->activeRecord->beginn_date : $agreement_date;
		$periode = ($dc->activeRecord->periode) ? $dc->activeRecord->periode : $GLOBALS['IAO']['default_agreement_cycle'];
		// wenn der Wert nicht manuell verändert wurde die Periode berechnen
		return ($varValue == $dc->activeRecord->end_date) ? strtotime($periode.' -1 day', $beginn_date) : $varValue ;
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
	public function showPDF($row, $href, $label, $title, $icon)
	{
		if (!$this->User->isAdmin)
		{
			return '';
		}

		$pdfFile = TL_ROOT . '/' . $row['agreement_pdf_file'];

		if ($this->Input->get('key') == 'pdf' && $this->Input->get('id') == $row['id'])
		{

			if(!empty($row['agreement_pdf_file']) && file_exists($pdfFile))
			{
				header("Content-type: application/pdf");
				header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // Date in the past
				header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
	 			header('Content-Length: '.filesize($pdfFile));
				header('Content-Disposition: inline; filename="'.basename($pdfFile).'";');
			    ob_clean();
			    flush();
			    readfile($pdfFile);
				exit();
		    }
		}

		$button = (!empty($row['agreement_pdf_file']) && file_exists($pdfFile)) ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.specialchars($title).'">'.$this->generateImage($icon, $label).'</a> ' : '';
		return $button;
	}

	public function generateNewCycle($varValue, DataContainer $dc)
	{
		if($varValue == 1)
		{
			$agreement = $dc->activeRecord->agreement_date;
			$beginn = $dc->activeRecord->beginn_date;
			$end = $dc->activeRecord->end_date;
			$periode = $dc->activeRecord->periode;
			$today = time();

			if($end && $beginn && ($today > $end))
			{
				$new_beginn = strtotime($periode, $beginn);
				$set = array
				(
					'beginn_date' => $new_beginn,
					'end_date' => strtotime($periode.' -1 day', $new_beginn),
					'new_generate' => ''
				);
				$this->Database->prepare('UPDATE `tl_iao_agreements` %s WHERE `id`=?')
							->set($set)
							->execute($dc->id);
			}
		}
		return '';
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
	 * get all invoice before template
	 * @param object
	 * @throws Exception
	 */
	public function getBeforeTemplate(DataContainer $dc)
	{
		$varValue= array();

		$all = $this->Database->prepare('SELECT `id`,`title` FROM `tl_iao_templates` WHERE `position`=?')
				->execute('invoice_before_text');

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
				->execute('invoice_after_text');

		while($all->next())
		{
			$varValue[$all->id] = $all->title;
		}

	    return $varValue;
	}


}
