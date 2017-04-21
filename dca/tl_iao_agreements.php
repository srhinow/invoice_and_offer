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
		'switchToEdit'                => true,
		'enableVersioning'            => false,
		'onload_callback' => array
		(
			array('tl_iao_agreements','IAOSettings')
		),
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
			'editheader' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_agreements']['editheader'],
				'href'                => 'act=edit',
				'icon'                => 'header.gif',
				'button_callback'     => array('tl_iao_agreements', 'editHeader'),
				'attributes'          => 'class="edit-header"'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_agreements']['copy'],
				'href'                => 'act=copy',
				'icon'                => 'copy.gif'
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
			),
			'pdf' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_invoice']['pdf'],
				'href'                => 'key=pdf',
				'icon'                => 'iconPDF.gif',
				'button_callback'     => array('tl_iao_agreements', 'showPDF')
			)

		)
	),

	// Palettes
	'palettes' => array
	(
		'__selector__'                => array('sendEmail'),
		'default'                     => 'title,agreement_pdf_file;{address_legend},member,address_text;{other_legend},price;{status_legend},agreement_date,periode,beginn_date,end_date,status,terminated_date,new_generate;{email_legend},sendEmail;{notice_legend:hide},notice'
	),
	// Subpalettes
	'subpalettes' => array
	(
             'sendEmail' => ('remind_before,email_from,email_to,email_subject,email_text')
	),


	// Fields
	'fields' => array
	(
		'title' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_agreements']['title'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>false, 'maxlength'=>255,'tl_class'=>'long'),
		),
		'agreement_date' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_agreements']['agreement_date'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'date', 'datepicker'=>$this->getDatePickerString(), 'tl_class'=>'w50 wizard'),
			'load_callback'			=> array (
				array('tl_iao_agreements','getAgreementValue')
			)
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
			)
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
			)
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
			)

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
			)
		),
		'terminated_date' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_agreements']['terminated_date'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'date', 'datepicker'=>$this->getDatePickerString(), 'tl_class'=>'w50 wizard'),
		),
		'price' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_agreements']['price'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'tl_class'=>'w50 wizard'),
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
			)
		),
		'address_text' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_agreements']['address_text'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'textarea',
			'eval'                    => array('rte'=>'tinyMCE','style'=>'height:60px;', 'tl_class'=>'clr'),
			'explanation'             => 'insertTags'
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
		),
		'agreement_pdf_file' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_agreements']['agreement_pdf_file'],
			'exclude'                 => true,
			'inputType'               => 'fileTree',
			'eval'                    => array('fieldType'=>'radio', 'files'=>true, 'filesOnly'=>true, 'mandatory'=>false,'extensions'=>'pdf')
		),
		'sendEmail' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_agreements']['sendEmail'],
			'filter'                  => true,
			'flag'                    => 1,
			'inputType'               => 'checkbox',
			'eval'                    => array('doNotCopy'=>true,'submitOnChange'=>true)
		),
		'remind_before' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_agreements']['remind_before'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>255,'tl_class'=>'clr'),
		),
		'email_from' => array
	    (
		    'label'                   => &$GLOBALS['TL_LANG']['tl_iao_agreements']['email_from'],
		    'exclude'                 => true,
		    'inputType'               => 'text',
		    'eval'                    => array('mandatory'=>true, 'rgxp'=>'email', 'maxlength'=>32, 'decodeEntities'=>true, 'tl_class'=>'clr w50')
	    ),
	    'email_to' => array
	    (
		    'label'                   => &$GLOBALS['TL_LANG']['tl_iao_agreements']['email_to'],
		    'exclude'                 => true,
		    'flag'                    => 11,
		    'inputType'               => 'text',
		    'eval'                    => array('mandatory'=>true, 'decodeEntities'=>true, 'maxlength'=>128, 'tl_class'=>'w50')
	    ),
	    'email_subject' => array
	    (
		    'label'                   => &$GLOBALS['TL_LANG']['tl_iao_agreements']['email_subject'],
		    'exclude'                 => true,
		    'flag'                    => 11,
		    'inputType'               => 'text',
		    // 'default'		  		=> &$GLOBALS['TL_LANG']['tl_iao_agreements']['email_subject_default'],
		    'eval'                    => array('mandatory'=>false, 'maxlength'=>255, 'tl_class'=>'clr long')
	    ),
	    'email_text' => array
	    (
		    'label'                   => &$GLOBALS['TL_LANG']['tl_iao_agreements']['email_text'],
		    'exclude'                 => true,
		    'inputType'               => 'textarea',
		    'eval'                    => array('mandatory'=>true, 'decodeEntities'=>true)
	    ),
		'notice' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_agreements']['notice'],
			'exclude'                 => true,
			'search'		  		=> true,
			'inputType'               => 'textarea',
			'eval'                    => array('mandatory'=>false, 'cols'=>'10','rows'=>'10','style'=>'height:100px','rte'=>false)
		),
	)
);

/**
 * Class tl_iao_agreements
 */
class tl_iao_agreements extends Backend
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
					'new_generate' => '',
					'email_date' => ''
				);
				$this->Database->prepare('UPDATE `tl_iao_agreements` %s WHERE `id`=?')
							->set($set)
							->execute($dc->id);
			}
		}
		return '';
	}
}
