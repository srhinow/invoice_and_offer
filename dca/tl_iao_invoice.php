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
 * Table tl_iao_invoice
 */
$GLOBALS['TL_DCA']['tl_iao_invoice'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'ctable'                      => array('tl_iao_invoice_items'),
		'switchToEdit'                => true,
		'enableVersioning'            => false,
		'onload_callback' => array
		(
			array('tl_iao_invoice','IAOSettings'),
			array('tl_iao_invoice', 'checkPermission'),
			array('tl_iao_invoice','upgradeInvoices')
		),
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 1,
			'fields'                  => array('invoice_tstamp'),
			'flag'                    => 8,
			'panelLayout'             => 'filter;search,limit'
		),
		'label' => array
		(
			'fields'                  => array('title','invoice_id_str'),
			'format'                  => '%s (%s)',
			'label_callback'          => array('tl_iao_invoice', 'listEntries'),
		),
		'global_operations' => array
		(
			'importInvoices' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_invoice']['importInvoices'],
				'href'                => 'key=importInvoices',
				'class'               => 'global_import',
				'attributes'          => 'onclick="Backend.getScrollOffset();"'
			),
			'exportInvoices' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_invoice']['exportInvoices'],
				'href'                => 'key=exportInvoices',
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
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_invoice']['edit'],
				'href'                => 'table=tl_iao_invoice_items',
				'icon'                => 'edit.gif',
				'attributes'          => 'class="contextmenu"'
			),
			'editheader' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_invoice']['editheader'],
				'href'                => 'act=edit',
				'icon'                => 'header.gif',
				'button_callback'     => array('tl_iao_invoice', 'editHeader'),
				// 'attributes'          => 'class="edit-header"'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_invoice']['copy'],
				'href'                => 'act=copy',
				'icon'                => 'copy.gif'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_invoice']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"',
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_invoice']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			),
			'toggle' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_invoice']['toggle'],
				'icon'                => 'ok.gif',
				// 'attributes'          => 'onclick="Backend.getScrollOffset(); return AjaxRequest.toggleVisibility(this, %s);"',
				'button_callback'     => array('tl_iao_invoice', 'toggleIcon')
			),
			'pdf' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iao_invoice']['pdf'],
				'href'                => 'key=pdf',
				'icon'                => 'iconPDF.gif',
				'button_callback'     => array('tl_iao_invoice', 'showPDFButton')
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'__selector__'                => array('discount'),
		'default'                     => '{settings_legend},setting_id;{title_legend},title;{invoice_id_legend:hide},invoice_id,invoice_id_str,invoice_tstamp,agreement_id,invoice_pdf_file,execute_date,expiry_date;{address_legend},member,address_text;{text_legend},before_template,before_text,after_template,after_text;{status_legend},published;{paid_legend},priceall_brutto,status,paid_on_dates,remaining;{extend_legend},noVat,discount;{notice_legend:hide},notice',
		// 'iao_arrears'		      => '{title_legend},title;{invoice_id_legend:hide},invoice_id,invoice_id_str,invoice_tstamp,invoice_pdf_file,execute_date,expiry_date;{address_legend},member,address_text;{text_legend},before_template,before_text,after_template,after_text;{status_legend},published,status,noVat;{notice_legend:hide},notice'
	),

	// Subpalettes
	'subpalettes' => array
	(
             'discount' => ('discount_title,discount_value,discount_operator')
	),

	// Fields
	'fields' => array
	(
		'setting_id' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_invoice']['setting_id'],
			'exclude'                 => true,
			'filter'                  => true,
			'sorting'                 => true,
			'flag'                    => 11,
			'inputType'               => 'select',
			'options_callback'        => array('tl_iao_invoice', 'getSettings'),
			'eval'                    => array('tl_class'=>'w50','includeBlankOption'=>false, 'chosen'=>true),
		),
		'title' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_invoice']['title'],
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>255,'tl_class'=>'long')
		),
		'invoice_tstamp' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_invoice']['invoice_date'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('doNotCopy'=>true,'rgxp'=>'date', 'datepicker'=>$this->getDatePickerString(), 'tl_class'=>'w50 wizard'),
			'save_callback' => array
			(
				array('tl_iao_invoice', 'generateInvoiceTstamp')
			)
		),
		'csv_export_dir' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_invoice']['csv_export_dir'],
			'eval'                    => array('fieldType'=>'radio', 'files'=>false, 'filesOnly'=>false, 'class'=>'mandatory')
		),
		'pdf_import_dir' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_invoice']['pdf_import_dir'],
			'eval'                    => array('fieldType'=>'radio', 'files'=>false, 'filesOnly'=>false, 'class'=>'mandatory')
		),
		'csv_source' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_invoice']['csv_source'],
			'eval'                    => array('fieldType'=>'radio', 'files'=>true, 'filesOnly'=>true, 'extensions'=>'csv', 'class'=>'mandatory')
		),
		'csv_posten_source' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_invoice']['csv_posten_source'],
			'eval'                    => array('fieldType'=>'radio', 'files'=>true, 'filesOnly'=>true, 'extensions'=>'csv', 'class'=>'mandatory')
		),
		'execute_date' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_invoice']['execute_date'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('doNotCopy'=>true,'rgxp'=>'date', 'datepicker'=>$this->getDatePickerString(), 'tl_class'=>'w50 wizard'),
			'save_callback' => array
			(
				array('tl_iao_invoice', 'generateExecuteDate')
			)
		),
		'expiry_date' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_invoice']['expiry_date'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('doNotCopy'=>true,'rgxp'=>'date', 'datepicker'=>$this->getDatePickerString(), 'tl_class'=>'w50 wizard'),
			'save_callback' => array
			(
				array('tl_iao_invoice', 'generateExpiryDate')
			)
		),
		'paid_on_date' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_invoice']['paid_on_date'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('doNotCopy'=>true,'rgxp'=>'date', 'datepicker'=>$this->getDatePickerString(), 'tl_class'=>'w50 wizard'),
		),
		'invoice_id' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_invoice']['invoice_id'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('doNotCopy'=>true, 'tl_class'=>'w50'),
			'save_callback' => array
			(
				array('tl_iao_invoice', 'generateInvoiceNumber')
			)
		),
		'invoice_id_str' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_invoice']['invoice_id_str'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('doNotCopy'=>true, 'spaceToUnderscore'=>true, 'maxlength'=>128, 'tl_class'=>'w50'),
			'save_callback' => array
			(
				array('tl_iao_invoice', 'createInvoiceNumberStr')
			)
		),
		'invoice_pdf_file' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_invoice']['invoice_pdf_file'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'fileTree',
			'eval'                    => array('fieldType'=>'radio', 'tl_class'=>'clr','extensions'=>'pdf','files'=>true, 'filesOnly'=>true, 'mandatory'=>false)
		),

		'member' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_invoice']['member'],
			'filter'                  => true,
			'search'                  => true,
			'sorting'                 => true,
			'flag'                    => 11,
			'inputType'               => 'select',
			'options_callback'        => array('tl_iao_invoice', 'getMembers'),
			'eval'                    => array('tl_class'=>'w50','includeBlankOption'=>true,'submitOnChange'=>true, 'chosen'=>true),
			'save_callback' => array
			(
				array('tl_iao_invoice', 'fillAdressText')
			)
		),
		'address_text' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_invoice']['address_text'],
			'search'                  => true,
			'inputType'               => 'textarea',
			'eval'                    => array('rte'=>'tinyMCE','style'=>'height:60px;', 'tl_class'=>'clr'),
			'explanation'             => 'insertTags'
		),
		'before_template' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_invoice']['before_template'],
			'sorting'                 => true,
			'flag'                    => 11,
			'inputType'               => 'select',
			'options_callback'        => array('tl_iao_invoice', 'getBeforeTemplate'),
			'eval'                    => array('tl_class'=>'w50','includeBlankOption'=>true,'submitOnChange'=>true, 'chosen'=>true),
			'save_callback' => array
			(
				array('tl_iao_invoice', 'fillBeforeText')
			)

		),
		'before_text' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_invoice']['before_text'],
			'search'                  => true,
			'inputType'               => 'textarea',
			'eval'                    => array('rte'=>'tinyMCE', 'helpwizard'=>true,'style'=>'height:60px;', 'tl_class'=>'clr'),
			'explanation'             => 'insertTags'
		),
		'after_template' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_invoice']['after_template'],
			'sorting'                 => true,
			'flag'                    => 11,
			'inputType'               => 'select',
			'options_callback'        => array('tl_iao_invoice', 'getAfterTemplate'),
			'eval'                    => array('tl_class'=>'w50','includeBlankOption'=>true,'submitOnChange'=>true, 'chosen'=>true),
			'save_callback' => array
			(
				array('tl_iao_invoice', 'fillAfterText')
			)
		),
		'after_text' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_invoice']['after_text'],
			'search'                  => true,
			'inputType'               => 'textarea',
			'eval'                    => array('rte'=>'tinyMCE', 'helpwizard'=>true,'style'=>'height:60px;', 'tl_class'=>'clr'),
			'explanation'             => 'insertTags'
		),
		'published' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_invoice']['published'],
			'filter'                  => true,
			'flag'                    => 1,
			'inputType'               => 'checkbox',
			'eval'                    => array('doNotCopy'=>true)
		),
		'status' => array
		(
			'label'                 => &$GLOBALS['TL_LANG']['tl_iao_invoice']['status'],
			'exclude'               => true,
			'filter'                => true,
			'flag'                  => 1,
			'inputType'             => 'select',
			'options'				=>  &$GLOBALS['TL_LANG']['tl_iao_invoice']['status_options'],
            'eval'					=> array('doNotCopy'=>true),
			'save_callback' => array
			(
				array('tl_iao_invoice', 'updateStatus')
			)
		),
		'paid_on_dates' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_invoice']['paid_on_dates'],
			'exclude'                 => true,
			'inputType'               => 'multiColumnWizard',
			'eval' => array(
				'style'                 => 'width:100%;',
				'doNotCopy'=>true,
				'columnFields' => array
				(
					'paydate' => array
					(
						'label'             => $GLOBALS['TL_LANG']['tl_iao_invoice']['paydate'],
						'exclude'                 => true,
						'inputType'         => 'text',
						'default'				=> '',
						'eval'              => array( 'tl_class'=>'wizard','style' => 'width:100px;'),
					),
					'payamount' => array
					(
						'label'             => $GLOBALS['TL_LANG']['tl_iao_invoice']['payamount'],
						'exclude'                 => true,
						'search'            => true,
						'inputType'         => 'text',
						'eval'              => array('style' => 'width:100px'),
					),
					'paynotice' => array
					(
						'label'             => $GLOBALS['TL_LANG']['tl_iao_invoice']['paynotice'],
						'exclude'                 => true,
						'search'            => true,
						'inputType'         => 'text',
						'eval'              => array('style' => 'width:350px;'),
					)
				)
			),
			'save_callback'			=> array
			(
				array('tl_iao_invoice', 'updateRemaining')
			)
		),
		'remaining' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_invoice']['remaining'],
			'filter'				=> true,
			'inputType'               => 'text',
			'eval'                    => array('readonly'=>true,'style'=>'border:0'),
			'load_callback'			=> array
			(
				array('tl_iao_invoice', 'priceFormat')
			),
		),
		'priceall_brutto' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_invoice']['price_brutto'],
			'inputType'               => 'text',
			'eval'                    => array('readonly'=>true,'style'=>'border:0'),
			'load_callback'			=> array
			(
				array('tl_iao_invoice','getPriceallValue'),
				array('tl_iao_invoice', 'priceFormat')
			)
		),
		'noVat' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_invoice']['noVat'],
			'filter'                  => true,
			'flag'                    => 1,
			'inputType'               => 'checkbox',
			'eval'                    => array('doNotCopy'=>true)
		),
		'discount' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_invoice']['discount'],
			'filter'                  => true,
			'flag'                    => 1,
			'inputType'               => 'checkbox',
			'eval'                    => array('doNotCopy'=>true,'submitOnChange'=>true)
		),
		'discount_title' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_invoice']['discount_title'],
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>255,'tl_class'=>'w50')
		),
		'discount_value' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_invoice']['discount_value'],
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>255,'tl_class'=>'w50')
		),
		'discount_operator' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_invoice']['discount_operator'],
			'filter'                  => true,
			'flag'                    => 1,
			'inputType'               => 'select',
			'options'                 => &$GLOBALS['TL_LANG']['tl_iao_invoice']['discount_operators'],
                        'eval'			  => array('tl_class'=>'w50')
		),
		'notice' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_invoice']['notice'],
			'search'		  => true,
			'filter'                  => false,
			'inputType'               => 'textarea',
			'eval'                    => array('mandatory'=>false, 'cols'=>'10','rows'=>'10','style'=>'height:100px','rte'=>false)

		),
		'agreement_id' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_iao_invoice']['agreement_id'],
			'exclude'                 => false,
			'filter'                  => true,
			'search'                  => true,
			'sorting'                 => false,
			'flag'                    => 11,
			'inputType'               => 'select',
			'options_callback'        => array('tl_iao_invoice', 'getAgreements'),
			'eval'                    => array('tl_class'=>'w50','includeBlankOption'=>true, 'chosen'=>true),
		),
	)
);


/**
 * Class tl_iao_invoice
 */
class tl_iao_invoice extends Backend
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
	 * Check permissions to edit table tl_iao_invoice
	 */
	public function checkPermission()
	{
		// HOOK: comments extension required
		if (!in_array('comments', $this->Config->getActiveModules()))
		{
			unset($GLOBALS['TL_DCA']['tl_iao_invoice']['fields']['allowComments']);
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

		$GLOBALS['TL_DCA']['tl_iao_invoice']['list']['sorting']['root'] = $root;

		// Check permissions to add archives
		if (!$this->User->hasAccess('create', 'newp'))
		{
			$GLOBALS['TL_DCA']['tl_iao_invoice']['config']['closed'] = true;
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

					if (is_array($arrNew['tl_iao_invoice']) && in_array($this->Input->get('id'), $arrNew['tl_iao_invoice']))
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
					$this->log('Not enough permissions to '.$this->Input->get('act').' news archive ID "'.$this->Input->get('id').'"', 'tl_iao_invoice checkPermission', TL_ERROR);
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
					$this->log('Not enough permissions to '.$this->Input->get('act').' news archives', 'tl_iao_invoice checkPermission', TL_ERROR);
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
	public function  generateExpiryDate($varValue, DataContainer $dc)
	{
		if(!$varValue)
		{
			$dur = (int) ($GLOBALS['TL_CONFIG']['iao_invoice_duration']) ? $GLOBALS['TL_CONFIG']['iao_invoice_duration'] : 14;
			$invoiceTstamp = ($dc->activeRecord->invoice_tstamp) ? $dc->activeRecord->invoice_tstamp : time();

			//auf Sonabend prüfen wenn ja dann auf Montag setzen
			if(date('N',$invoiceTstamp+($dur * 24 * 60 * 60)) == 6)  $dur = $dur+2;

			//auf Sontag prüfen wenn ja dann auf Montag setzen
			if(date('N',$invoiceTstamp+($dur * 24 * 60 * 60)) == 7)  $dur = $dur+1;

			$varValue = $invoiceTstamp+($dur * 24 * 60 * 60);

	    }
		return $varValue;

	}

	/**
	 * fill date-Field if this empty
	 * @param mixed
	 * @param object
	 * @return date
	 */
	public function  generateInvoiceTstamp($varValue, DataContainer $dc)
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

			$text = '<p>'.$objMember->company.'<br />'.($objMember->gender!='' ? $GLOBALS['TL_LANG']['tl_iao_invoice']['gender'][$objMember->gender].' ':'').($objMember->title ? $objMember->title.' ':'').$objMember->firstname.' '.$objMember->lastname.'<br />'.$objMember->street.'</p>';
			$text .='<p>'.$objMember->postal.' '.$objMember->city.'</p>';

			$this->Database->prepare('UPDATE `tl_iao_invoice` SET `address_text`=? WHERE `id`=?')
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
		$this->import('iao');

		if(strip_tags($dc->activeRecord->before_text)=='')
		{
			if(strlen($varValue)<=0) return $varValue;

			$objTemplate = $this->Database->prepare('SELECT * FROM `tl_iao_templates` WHERE `id`=?')
			->limit(1)
			->execute($varValue);

			$objTemplate->text = $this->iao->changeIAOTags($objTemplate->text,'invoice',$dc->id);

			$this->Database->prepare('UPDATE `tl_iao_invoice` SET `before_text`=? WHERE `id`=?')
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
		$this->import('iao');

		if(strip_tags($dc->activeRecord->after_text)=='')
		{
		    if(strlen($varValue)<=0) return $varValue;

		    $objTemplate = $this->Database->prepare('SELECT `text` FROM `tl_iao_templates` WHERE `id`=?')
							->limit(1)
							->execute($varValue);

			$objTemplate->text = $this->iao->changeIAOTags($objTemplate->text,'invoice',$dc->id);

			$this->Database->prepare('UPDATE `tl_iao_invoice` SET `after_text`=? WHERE `id`=?')
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
	 * get all settings
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
	 * get all Agreements to valid groups
	 * @param object
	 * @throws Exception
	 */
	public function getAgreements(DataContainer $dc)
	{
		$varValue= array();

		$agrObj = $this->Database->prepare('SELECT * FROM `tl_iao_agreements` WHERE `status`=?')
					->execute('1');

		while($agrObj->next())
		{
			$varValue[$agrObj->id] =  $agrObj->title.' ('.$agrObj->price.' &euro;)';
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
		return ($this->User->isAdmin || count(preg_grep('/^tl_iao_invoice::/', $this->User->alexf)) > 0) ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.specialchars($title).'"'.$attributes.'>'.$this->generateImage($icon, $label).'</a> ' : '';
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

			$this->import('iao');

			if(!empty($row['invoice_pdf_file']) && file_exists(TL_ROOT . '/' . $row['invoice_pdf_file']))
			{

				header("Content-type: application/pdf");
				header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // Date in the past
				header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
	 			header('Content-Length: '.strlen($row['invoice_pdf_file']));
				header('Content-Disposition: inline; filename="'.basename($row['invoice_pdf_file']).'";');

				// The PDF source is in original.pdf
				readfile(TL_ROOT . '/' . $row['invoice_pdf_file']);
				exit();
		    }

			if( !file_exists(TL_ROOT . '/' . $GLOBALS['TL_CONFIG']['iao_invoice_pdf']) ) return;  // template file not found

			$pdfname = 'Rechnung-'.$row['invoice_id_str'];

			// Calculating dimensions
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
			$pdf->setSourceFile( TL_ROOT . '/' . $GLOBALS['TL_CONFIG']['iao_invoice_pdf']);          // Set PDF template

			// Set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetTitle($pdfname);
			$pdf->SetSubject($pdfname);
			$pdf->SetKeywords($pdfname);

			$pdf->SetDisplayMode('fullwidth', 'OneColumn', 'UseNone');
			$pdf->SetHeaderData();

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
		    if(file_exists(TL_ROOT . '/' . $GLOBALS['TL_CONFIG']['iao_pdf_css']) )
		    {
				$styles = "<style>\n" . file_get_contents(TL_ROOT . '/' . $GLOBALS['TL_CONFIG']['iao_pdf_css']) . "\n</style>\n";
				$pdf->writeHTML($styles, true, false, true, false, '');
			}

			// write the address-data
			$row['address_text'] = $this->iao->changeIAOTags($row['address_text'],'invoice',$row['id']);
			$row['address_text'] = $this->iao->changeTags($row['address_text']);
			$pdf->drawAddress($row['address_text']);

			//Rechnungsnummer
			$pdf->drawDocumentNumber($row['invoice_id_str']);

			//Datum
			$pdf->drawDate(date($GLOBALS['TL_CONFIG']['dateFormat'],$row['invoice_tstamp']));

			//ausgeführt am
			$newdate= $row['execute_date'];
			$pdf->drawInvoiceExecuteDate(date($GLOBALS['TL_CONFIG']['dateFormat'],$newdate));

			//ausgeführt am
			$newdate= $row['expiry_date'];
			$pdf->drawInvoiceDurationDate(date($GLOBALS['TL_CONFIG']['dateFormat'],$newdate));

			//Text vor der Posten-Tabelle
			if(strip_tags($row['before_text']))
			{
				$row['before_text'] = $this->iao->changeIAOTags($row['before_text'],'invoice',$row['id']);
				$row['before_text'] = $this->iao->changeTags($row['before_text']);
				$pdf->drawTextBefore($row['before_text']);
			}

			//Posten-Tabelle
			$header = array('Menge','Beschreibung','Einzelpreis','Gesamt');
			$fields = $this->getPosten($this->Input->get('id'));

			$pdf->drawPostenTable($header,$fields);

			//Text vor der Posten-Tabelle
			if(strip_tags($row['after_text']))
			{
				$row['after_text'] = $this->iao->changeIAOTags($row['after_text'],'invoice',$row['id']);
				$row['after_text'] = $this->iao->changeTags($row['after_text']);
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
		$this->loadLanguageFile('tl_iao_invoice_items');

		$resultObj = $this->Database->prepare('SELECT * FROM `tl_iao_invoice_items` WHERE `pid`=? AND `published`=1 ORDER BY `sorting`')->execute($id);

		$parentObj = $this->Database->prepare('SELECT * FROM `tl_iao_invoice` WHERE `id`=?')
					->limit(1)
					->execute($id);

		if($resultObj->numRows <= 0) return $posten;

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

			$posten['discount'] = false;

			if($parentObj->discount)
			{
				$posten['discount'] = array
				(
					'discount' =>  $parentObj->discount,
					'discount_title' => $parentObj->discount_title,
					'discount_value' => $parentObj->discount_value,
					'discount_operator' => $parentObj->discount_operator
				);
			}

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

			$posten['summe']['mwst'][$resultObj->vat] += ($parentObj->noVat != 1) ? $resultObj->price_brutto - $resultObj->price_netto : 0;
		}

	    $posten['summe']['netto_format'] =  number_format($posten['summe']['netto'],2,',','.');
	    $posten['summe']['brutto_format'] =  number_format($posten['summe']['brutto'],2,',','.');

	    return $posten;
	}

	public function createInvoiceNumberStr($varValue, DataContainer $dc)
	{
		if(!$varValue)
		{
			$tstamp = $dc->activeRecord->date ? $dc->activeRecord->date : time();

			$format = $GLOBALS['TL_CONFIG']['iao_invoice_number_format'];
			$format =  str_replace('{date}',date('Ymd',$tstamp),$format);
			$format =  str_replace('{nr}',$dc->activeRecord->invoice_id,$format);
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
	public function generateInvoiceNumber($varValue, DataContainer $dc)
	{
		$autoNr = false;
		$varValue = (int) $varValue;

		// Generate invoice_id if there is none
		if($varValue == 0)
		{
			$autoNr = true;
			$objNr = $this->Database->prepare("SELECT `invoice_id` FROM `tl_iao_invoice` ORDER BY `invoice_id` DESC")
					->limit(1)
					->execute();

			if($objNr->numRows < 1 || $objNr->invoice_id == 0)  $varValue = $GLOBALS['TL_CONFIG']['iao_invoice_startnumber'];
			else  $varValue =  $objNr->invoice_id +1;
	    }
	    else
	    {
			$objNr = $this->Database->prepare("SELECT `invoice_id` FROM `tl_iao_invoice` WHERE `id`=? OR `invoice_id`=?")
					    ->limit(1)
					    ->execute($dc->id,$varValue);

			// Check whether the InvoiceNumber exists
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
		<div class="cte_type status' . $arrRow['status'] . '"><strong>' . $arrRow['title'] . '</strong> '.$arrRow['invoice_id_str'].'</div>
		<div>'.$GLOBALS['TL_LANG']['tl_iao_invoice']['price_brutto'][0].': <strong>'.number_format($arrRow['price_brutto'],2,',','.').' '.$GLOBALS['TL_CONFIG']['iao_currency_symbol'].'</strong></div>
		<div>'.$GLOBALS['TL_LANG']['tl_iao_invoice']['remaining'][0].': <strong>'.number_format($arrRow['remaining'],2,',','.').' '.$GLOBALS['TL_CONFIG']['iao_currency_symbol'].'</strong></div>
		<div>'.$GLOBALS['TL_LANG']['tl_iao_invoice']['member'][0].': '.$row['firstname'].' '.$row['lastname'].' ('.$row['company'].')</div>
		'.(($arrRow['notice'])?"<div>".$GLOBALS['TL_LANG']['tl_iao_invoice']['notice'][0].":".$arrRow['notice']."</div>": '').'
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

		return '<a href="'.$this->addToUrl($href).'" title="'.$GLOBALS['TL_LANG']['tl_iao_invoice']['toggle'].'"'.$attributes.'>'.$this->generateImage($icon, $label).'</a> ';
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
		if (!$this->User->isAdmin && !$this->User->hasAccess('tl_iao_invoice::status', 'alexf'))
		{
			$this->log('Not enough permissions to publish/unpublish comment ID "'.$intId.'"', 'tl_iao_invoice toggleActivity', TL_ERROR);
			$this->redirect('contao/main.php?act=error');
		}

		$this->createInitialVersion('tl_iao_invoice', $intId);

		// Trigger the save_callback
		if (is_array($GLOBALS['TL_DCA']['tl_iao_invoice']['fields']['status']['save_callback']))
		{
			foreach ($GLOBALS['TL_DCA']['tl_iao_invoice']['fields']['status']['save_callback'] as $callback)
			{
				$this->import($callback[0]);
				$blnVisible = $this->$callback[0]->$callback[1]($blnVisible, $this);
			}
		}

		// Update the database
		$this->Database->prepare("UPDATE tl_iao_invoice SET status='" . ($blnVisible==1 ? '1' : '2') . "' WHERE id=?")
					   ->execute($intId);

		$this->createNewVersion('tl_iao_invoice', $intId);
	}

	public function updateStatus($varValue, DataContainer $dc)
	{
		if($varValue == 2)
	    {
			$set = array
			(
				'status' => $varValue,
				'paid_on_date' => $dc->activeRecord->paid_on_date
			);

			$this->Database->prepare('UPDATE `tl_iao_reminder` %s WHERE `invoice_id`=?')
							->set($set)
							->execute($dc->id);
	    }
	    return $varValue;
	}
	/**
	* zur Aktualisierung der Datensätze aus älterer Modul-Versionen
	*/
	public function upgradeInvoices(DataContainer $dc)
	{
		// $allInvObj = $this->Database->prepare('SELECT * FROM `tl_iao_invoice` WHERE `remaining`=? AND `paid_on_dates`=?')
		$allInvObj = $this->Database->prepare('SELECT * FROM `tl_iao_invoice` WHERE `remaining`=? AND `paid_on_dates` IS NULL')
									->execute(0, '');

		if($allInvObj->numRows > 0)
		{

			while($allInvObj->next())
			{

				$paidArr = array();

				switch($allInvObj->status)
				{
					case '1': // noch offen
					case '3': // ruht
						$set = array (
							'remaining' => $allInvObj->price_brutto
						);

						$this->Database->prepare('UPDATE `tl_iao_invoice` %s WHERE `id`=?')
							->set($set)
							->execute($allInvObj->id);
					break;
					case '2': //bezahlt
						$paidArr[] = array (
							'paydate'=>$allInvObj->paid_on_date,
							'payamount'=> $allInvObj->price_brutto, 
							'paynotice'=>''
						);

						$set = array (
							'remaining' => 0,
							'paid_on_dates' => serialize($paidArr)
						);

						$this->Database->prepare('UPDATE `tl_iao_invoice` %s WHERE `id`=?')
							->set($set)
							->execute($allInvObj->id);
					break;
				}


				$paid_on_date = ($allInvObj->price_brutto == $already) ? $lastPayDate : $allInvObj->paid_on_date;

			}
		}
	}
	public function priceFormat($varValue, DataContainer $dc)
	{
		$this->import('iao');
		return $this->iao->getPriceStr($varValue);
	}
	public function getPriceallValue($varValue, DataContainer $dc)
	{
		return $dc->activeRecord->price_brutto;
	}
	/**
	* calculate and update fields
	*/
	public function updateRemaining($varValue, DataContainer $dc)
	{
		$paidsArr = unserialize($varValue);
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

		return $varValue;
	}

}
