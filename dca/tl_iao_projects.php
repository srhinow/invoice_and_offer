<?php

/**
 * @copyright  Sven Rhinow 2011-2015
 * @author     sr-tag Sven Rhinow Webentwicklung <http://www.sr-tag.de>
 * @package    invoice_and_offer
 * @license    LGPL
 * @filesource
 */


/**
 * Table tl_iao_projects
 */
$GLOBALS['TL_DCA']['tl_iao_projects'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'ctable'                      => array('tl_iao_offer','tl_iao_invoice','tl_iao_credit'),
		'switchToEdit'                => false,
		'enableVersioning'            => true,
		'onload_callback' => array
		(
			// array('tl_iao_projects', 'checkPermission'),
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
			'fields'                  => array('title'),
			'flag'                    => 1,
			'panelLayout'             => 'filter;sort,search,limit'
		),
		'label' => array
		(
			'fields'                  => array('title'),
			'format'                  => '%s',
			// 'label_callback'          => array('tl_iao_projects', 'listEntries'),
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
			'offer' => array
			(
				'label'  => &$GLOBALS['TL_LANG']['tl_iao_projects']['offer'],
				'href'   => 'table=tl_iao_offer&onlyproj=1',
				'icon'   => IAO_PATH.'/html/icons/16-file-page.png',
			),
			'invoice' => array
			(
				'label'  => &$GLOBALS['TL_LANG']['tl_iao_projects']['invoice'],
				'href'   => 'table=tl_iao_invoice&onlyproj=1',
				'icon'   => IAO_PATH.'/html/icons/kontact_todo.png',
			),
			'credit' => array
			(
				'label'  => &$GLOBALS['TL_LANG']['tl_iao_projects']['credit'],
				'href'   => 'table=tl_iao_credit&onlyproj=1',
				'icon'   => IAO_PATH.'/html/icons/16-tag-pencil.png',
			),
			'reminder' => array
			(
				'label'  => &$GLOBALS['TL_LANG']['tl_iao_projects']['reminder'],
				'href'   => 'table=tl_iao_reminder&onlyproj=1',
				'icon'   => IAO_PATH.'/html/icons/warning.png',

			),
			'edit' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_projects']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif',
				'attributes'          => 'class="contextmenu"'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_projects']['copy'],
				'href'                => 'act=copy',
				'icon'                => 'copy.gif'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_projects']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"',
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_projects']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			),
		)
	),

	// Palettes
	'palettes' => array
	(
		'__selector__'                => array('in_reference','finished'),
		'default'                     => '{project_legend},title,member,url,notice;{finshed_legend},finished;{reference_legend},in_reference'
	),

	// Subpalettes
	'subpalettes' => array
	(
		'in_reference' => 'reference_title,reference_short_title,reference_subtitle,reference_customer,reference_todo,reference_desription,tags,singleSRC,multiSRC,orderSRC',
		'finished' => 'finished_date',
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
			'sql'					  => "int(10) unsigned NOT NULL default '0'",
			'sorting'                 => true,
		),	
		'title' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_projects']['title'],
			'exclude'                 => true,
			'search'                  => true,
			'sorting'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>255),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'member' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_projects']['member'],
			'exclude'                 => true,
			'filter'                  => true,
			'sorting'                 => true,
			'flag'                    => 11,
			'inputType'               => 'select',
			'options_callback'        => array('tl_iao_projects', 'getMemberOptions'),
			'eval'                    => array('tl_class'=>'w50','includeBlankOption'=>true,'submitOnChange'=>true, 'chosen'=>true),
			'save_callback' => array
			(
				// array('tl_iao_projects', 'fillAdressText')
			),
			'sql'					  => "varbinary(128) NOT NULL default ''"
		),
		'in_reference' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_projects']['in_reference'],
			'exclude'                 => true,
			'filter'                  => true,
			'flag'                    => 1,
			'inputType'               => 'checkbox',
			'eval'                    => array('doNotCopy'=>true,'submitOnChange'=>true),
			'sql'					  => "char(1) NOT NULL default ''"
		),
		'reference_title' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_projects']['reference_title'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>false, 'maxlength'=>255),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'reference_short_title' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_projects']['reference_short_title'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>false, 'maxlength'=>255),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'reference_subtitle' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_projects']['reference_subtitle'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>false, 'maxlength'=>255),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'reference_customer' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_projects']['reference_customer'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'textarea',
			'eval'                    => array('rte'=>'tinyMCE','style'=>'height:60px;', 'tl_class'=>'clr'),
			'explanation'             => 'insertTags',
			'sql'					  => "mediumtext NULL"
		),
		'reference_todo' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_projects']['reference_todo'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'textarea',
			'eval'                    => array('rte'=>'tinyMCE','style'=>'height:60px;', 'tl_class'=>'clr'),
			'explanation'             => 'insertTags',
			'sql'					  => "mediumtext NULL"
		),
		'reference_desription' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_projects']['reference_desription'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'textarea',
			'eval'                    => array('rte'=>'tinyMCE','style'=>'height:60px;', 'tl_class'=>'clr'),
			'explanation'             => 'insertTags',
			'sql'					  => "mediumtext NULL"
		),
		'tags' => array(
			'label'     => &$GLOBALS['TL_LANG']['MSC']['tags'],
    		'inputType' => 'tag',
    		'sql'					  => "mediumtext NULL"
  		),

		'url' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_projects']['url'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>false, 'maxlength'=>255),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'finished' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_projects']['finished'],
			'exclude'                 => true,
			'filter'                  => true,
			'flag'                    => 1,
			'inputType'               => 'checkbox',
			'eval'                    => array('doNotCopy'=>true,'submitOnChange'=>true),
			'sql'					  => "char(1) NOT NULL default ''"
		),
		'finished_date' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_projects']['finished_date'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'date', 'datepicker'=>true, 'tl_class'=>'w50 wizard'),
			'sql'                     => "varchar(10) NOT NULL default ''"
		),
		'notice' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_projects']['notice'],
			'exclude'                 => true,
			'search'		  => true,
			'filter'                  => false,
			'inputType'               => 'textarea',
			'eval'                    => array('mandatory'=>false, 'cols'=>'10','rows'=>'10','style'=>'height:100px','rte'=>false),
			'sql'					  => "text NULL"
		),
		'singleSRC' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_projects']['singleSRC'],
			'exclude'                 => true,
			'inputType'               => 'fileTree',
			'eval'                    => array('filesOnly'=>true, 'fieldType'=>'radio', 'mandatory'=>false, 'tl_class'=>'clr','extensions'=>Config::get('validImageTypes')),
			'sql'                     => "binary(16) NULL"
		),
		'multiSRC' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_projects']['multiSRC'],
			'exclude'                 => true,
			'inputType'               => 'fileTree',
			'eval'                    => array('multiple'=>true, 'fieldType'=>'checkbox', 'orderField'=>'orderSRC', 'files'=>true, 'mandatory'=>false,'extensions'=>Config::get('validImageTypes')),
			'sql'                     => "blob NULL",
		),
		'orderSRC' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_projects']['orderSRC'],
			'sql'                     => "blob NULL"
		),
	)
);


/**
 * Class tl_iao_projects
 */
class tl_iao_projects  extends \iao\iaoBackend
{

	protected $settings = array();

	/**
	 * Import the back end user object
	 */
	public function __construct()
	{
		parent::__construct();
		$this->import('BackendUser', 'User');
		$this->settings = $this->getSettings(1);
		// print_r($this->settings->iao_costumer_group);
	}

	/**
	* add all iao-Settings in array
	*/
	public function setIaoSettings(DataContainer $dc)
	{
			$this->settings = ($dc->id) ? $this->getSettings($dc->id) : array();			 
	}

	/**
	 * Check permissions to edit table tl_iao_projects
	 */
	public function checkPermission()
	{
		// HOOK: comments extension required
		if (!in_array('comments', $this->Config->getActiveModules()))
		{
			unset($GLOBALS['TL_DCA']['tl_iao_projects']['fields']['allowComments']);
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

		$GLOBALS['TL_DCA']['tl_iao_projects']['list']['sorting']['root'] = $root;

		// Check permissions to add archives
		if (!$this->User->hasAccess('create', 'newp'))
		{
			$GLOBALS['TL_DCA']['tl_iao_projects']['config']['closed'] = true;
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

					if (is_array($arrNew['tl_iao_projects']) && in_array($this->Input->get('id'), $arrNew['tl_iao_projects']))
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
					$this->log('Not enough permissions to '.$this->Input->get('act').' news archive ID "'.$this->Input->get('id').'"', 'tl_iao_projects checkPermission', TL_ERROR);
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
					$this->log('Not enough permissions to '.$this->Input->get('act').' news archives', 'tl_iao_projects checkPermission', TL_ERROR);
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
			$format = ( $this->settings['iao_credit_expiry_date'] ) ? $this->settings['iao_credit_expiry_date'] : '+3 month';
			$tstamp = ($dc->activeRecord->credit_tstamp) ? $dc->activeRecord->credit_tstamp : time();
			$varValue = strtotime($format,$tstamp);
	    }
	    return  $varValue;
	}

	public function updateExpiryToTstmp(DataContainer $dc)
	{
		$creditObj = $this->Database->prepare('SELECT * FROM `tl_iao_projects`')
								   ->execute();
	   	while($creditObj->next())
   		{
   			if(!stripos($creditObj->expiry_date,'-')) continue;

			$set = array('expiry_date' => strtotime($creditObj->expiry_date));
			$this->Database->prepare('UPDATE `tl_iao_projects` %s WHERE `id`=?')
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

			$text = '<p>'.$objMember->company.'<br />'.($objMember->gender!='' ? $GLOBALS['TL_LANG']['tl_iao_projects']['gender'][$objMember->gender].' ':'').($objMember->title ? $objMember->title.' ':'').$objMember->firstname.' '.$objMember->lastname.'<br />'.$objMember->street.'</p>';
			$text .='<p>'.$objMember->postal.' '.$objMember->city.'</p>';

			$this->Database->prepare('UPDATE `tl_iao_projects` SET `address_text`=? WHERE `id`=?')
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


		    $this->Database->prepare('UPDATE `tl_iao_projects` SET `before_text`=? WHERE `id`=?')
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

		    $this->Database->prepare('UPDATE `tl_iao_projects` SET `after_text`=? WHERE `id`=?')
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
		return ($this->User->isAdmin || count(preg_grep('/^tl_iao_projects::/', $this->User->alexf)) > 0) ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.specialchars($title).'"'.$attributes.'>'.$this->generateImage($icon, $label).'</a> ' : '';
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

		if (\Input::get('key') == 'pdf' && \Input::get('id') == $row['id'])
		{
		    
		    $objPdfTemplate = 	\FilesModel::findByUuid($this->settings['iao_credit_pdf']);	
			if(strlen($objPdfTemplate->path) < 1 || !file_exists(TL_ROOT . '/' . $objPdfTemplate->path) ) return;  // template file not found

			$pdfname = 'Gutschrift-'.$row['credit_id_str'];

			//-- Calculating dimensions
			$margins = unserialize($this->settings['iao_pdf_margins']);         // Margins as an array
			switch( $margins['unit'] )
			{
				case 'cm':      $factor = 10.0;   break;
				default:        $factor = 1.0;
			}

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
			require_once(TL_ROOT . '/system/modules/invoice_and_offer/classes/iaoPDF.php');
			
			$pdf = new iaoPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true);
			$pdf->setSourceFile( TL_ROOT . '/' . $objPdfTemplate->path);          // Set PDF template

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
		    $file = \FilesModel::findByUuid($settings['iao_pdf_css']);

		    if(strlen($file->path) > 0 && file_exists(TL_ROOT . '/' . $file->path) )
		    {
				$styles = "<style>\n" . file_get_contents(TL_ROOT . '/' . $file->path) . "\n</style>\n";
				$pdf->writeHTML($styles, true, false, true, false, '');
			}

			// write the address-data
			$pdf->drawAddress($this->changeTags($row['address_text']));

			//Rechnungsnummer
			$pdf->drawDocumentNumber($row['credit_id_str']);

			//Datum
			$pdf->drawDate(date($GLOBALS['TL_CONFIG']['dateFormat'],$row['credit_tstamp']));

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
			$fields = $this->getPosten($this->Input->get('id'));

			$parentObj = $this->Database->prepare('SELECT `noVat` FROM `tl_iao_projects` WHERE `id`=?')
						->limit(1)
						->execute($this->Input->get('id'));
			
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

	    $resultObj = $this->Database->prepare('SELECT * FROM `tl_iao_projects_items` WHERE `pid`=? AND `published`=? ORDER BY `sorting`')->execute($id,1);

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

			$parentObj = $this->Database->prepare('SELECT * FROM `tl_iao_projects` WHERE `id`=?')
						->limit(1)
						->execute($id);
			
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
			$format = $this->settings['iao_credit_number_format'];
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
			$objNr = $this->Database->prepare("SELECT `credit_id` FROM `tl_iao_projects` ORDER BY `credit_id` DESC")
			->limit(1)
			->execute();

			if($objNr->numRows < 1 || $objNr->credit_id == 0)  $varValue = $this->settings['iao_credit_startnumber'];
			else  $varValue =  $objNr->credit_id +1;
	    }
	    else
	    {
			$objNr = $this->Database->prepare("SELECT `credit_id` FROM `tl_iao_projects` WHERE `id`=? OR `credit_id`=?")
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
		<div>'.$GLOBALS['TL_LANG']['tl_iao_projects']['price_brutto'][0].': <strong>'.number_format($arrRow['price_brutto'],2,',','.').' '.$GLOBALS['TL_CONFIG']['currency_symbol'].'</strong></div>
		<div>'.$GLOBALS['TL_LANG']['tl_iao_projects']['member'][0].': '.$row['firstname'].' '.$row['lastname'].' ('.$row['company'].')</div>
		'.(($arrRow['notice'])?"<div>".$GLOBALS['TL_LANG']['tl_iao_projects']['notice'][0].":".$arrRow['notice']."</div>": '').'
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

		return '<a href="'.$this->addToUrl($href).'" title="'.$GLOBALS['TL_LANG']['tl_iao_projects']['toggle'].'"'.$attributes.'>'.$this->generateImage($icon, $label).'</a> ';
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
		if (!$this->User->isAdmin && !$this->User->hasAccess('tl_iao_projects::status', 'alexf'))
		{
			$this->log('Not enough permissions to publish/unpublish comment ID "'.$intId.'"', 'tl_iao_projects toggleActivity', TL_ERROR);
			$this->redirect('contao/main.php?act=error');
		}

		$this->createInitialVersion('tl_iao_projects', $intId);

		// Trigger the save_callback
		if (is_array($GLOBALS['TL_DCA']['tl_iao_projects']['fields']['status']['save_callback']))
		{
			foreach ($GLOBALS['TL_DCA']['tl_iao_projects']['fields']['status']['save_callback'] as $callback)
			{
				$this->import($callback[0]);
				$blnVisible = $this->$callback[0]->$callback[1]($blnVisible, $this);
			}
		}

		// Update the database
		$this->Database->prepare("UPDATE tl_iao_projects SET status='" . ($blnVisible==1 ? '1' : '2') . "' WHERE id=?")
		->execute($intId);

		$this->createNewVersion('tl_iao_projects', $intId);
	}
}
