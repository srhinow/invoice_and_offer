<?php

/**
 * PHP version 5
 * @copyright  sr-tag.de 2011-2017
 * @author     Sven Rhinow
 * @package    invoice_and_offer
 * @license    LGPL
 * @filesource
 */
$this->loadLanguageFile('tl_iao_invoice');
$this->loadLanguageFile('tl_iao_credit');
$this->loadLanguageFile('tl_iao_offer');
$this->loadLanguageFile('tl_iao_reminder');
$this->loadLanguageFile('tl_iao_agreement');

/**
 * Add palettes to tl_module
 */
$GLOBALS['TL_DCA']['tl_module']['palettes']['fe_iao_invoice']    = '{title_legend},name,headline,type,fe_iao_numberOfItems,perPage,invoice_status;{template_legend},fe_iao_template;{protected_legend:hide},protected;{expert_legend:hide},cssID,space';
$GLOBALS['TL_DCA']['tl_module']['palettes']['fe_iao_offer'] = '{title_legend},name,headline,type,fe_iao_numberOfItems,perPage,offer_status;{template_legend},fe_iao_template;{protected_legend:hide},protected;{expert_legend:hide},cssID,space';
$GLOBALS['TL_DCA']['tl_module']['palettes']['fe_iao_credit']  = '{title_legend},name,headline,type,fe_iao_numberOfItems,perPage,credit_status;{template_legend},fe_iao_template;{protected_legend:hide},protected;{expert_legend:hide},cssID,space';
$GLOBALS['TL_DCA']['tl_module']['palettes']['fe_iao_reminder']  = '{title_legend},name,headline,type,fe_iao_numberOfItems,perPage,reminder_status;{template_legend},fe_iao_template;{protected_legend:hide},protected;{expert_legend:hide},cssID,space';
$GLOBALS['TL_DCA']['tl_module']['palettes']['fe_iao_agreement']  = '{title_legend},name,headline,type,fe_iao_numberOfItems,perPage,agreement_status;{template_legend},fe_iao_template;{protected_legend:hide},protected;{expert_legend:hide},cssID,space';
$GLOBALS['TL_DCA']['tl_module']['palettes']['fe_iao_projects']  = '{title_legend},name,headline,type,fe_iao_numberOfItems,perPage;{template_legend},fe_iao_template;{protected_legend:hide},protected;{expert_legend:hide},cssID,space';
$GLOBALS['TL_DCA']['tl_module']['palettes']['fe_iao_public_project_list']  = '{title_legend},name,headline,type,fe_iao_numberOfItems,perPage;{config_legend},jumpTo;{template_legend},fe_iao_template;{protected_legend:hide},protected;{expert_legend:hide},cssID,space';
$GLOBALS['TL_DCA']['tl_module']['palettes']['fe_iao_public_project_details']  = '{title_legend},name,headline,type;{template_legend},fe_iao_template;{protected_legend:hide},protected;{expert_legend:hide},cssID,space';

$GLOBALS['TL_DCA']['tl_module']['fields']['fe_iao_template'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['fe_iao_template'],
	'default'                 => 'bbk_default',
	'exclude'                 => true,
	'inputType'               => 'select',
	'options_callback'        => array('tl_module_iao', 'getTemplates'),
	'eval'                    => array('tl_class'=>'w50'),
	'sql'					  => "varchar(32) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['fe_iao_numberOfItems'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['fe_iao_numberOfItems'],
	'default'                 => 3,
	'exclude'                 => true,
	'inputType'               => 'text',
	'eval'                    => array('mandatory'=>true, 'rgxp'=>'digit', 'tl_class'=>'w50'),
	'sql'					  => "smallint(5) unsigned NOT NULL default '0'"
);


$GLOBALS['TL_DCA']['tl_module']['fields']['invoice_status'] = array
(
	'label'                 => &$GLOBALS['TL_LANG']['tl_module']['invoice_status'],
	'exclude'               => true,
	'filter'                => true,
	'flag'                  => 1,
	'inputType'             => 'select',
	'options'				=>  &$GLOBALS['TL_LANG']['tl_iao_invoice']['status_options'],
    'eval'					=> array('doNotCopy'=>true,'includeBlankOption'=>true),
	'sql'					=> "char(1) NOT NULL default ''"
);
$GLOBALS['TL_DCA']['tl_module']['fields']['offer_status'] = array
(
	'label'                 => &$GLOBALS['TL_LANG']['tl_module']['offer_status'],
	'exclude'               => true,
	'filter'                => true,
	'flag'                  => 1,
	'inputType'             => 'select',
	'options'				=>  &$GLOBALS['TL_LANG']['tl_iao_offer']['status_options'],
    'eval'					=> array('doNotCopy'=>true,'includeBlankOption'=>true),
	'sql'					=> "char(1) NOT NULL default ''"
);
$GLOBALS['TL_DCA']['tl_module']['fields']['credit_status'] = array
(
	'label'                 => &$GLOBALS['TL_LANG']['tl_module']['credit_status'],
	'exclude'               => true,
	'filter'                => true,
	'flag'                  => 1,
	'inputType'             => 'select',
	'options'				=>  &$GLOBALS['TL_LANG']['tl_iao_credit']['status_options'],
    'eval'					=> array('doNotCopy'=>true,'includeBlankOption'=>true),
	'sql'					=> "char(1) NOT NULL default ''"
);
$GLOBALS['TL_DCA']['tl_module']['fields']['reminder_status'] = array
(
	'label'                 => &$GLOBALS['TL_LANG']['tl_module']['reminder_status'],
	'exclude'               => true,
	'filter'                => true,
	'flag'                  => 1,
	'inputType'             => 'select',
	'options'				=>  &$GLOBALS['TL_LANG']['tl_iao_reminder']['status_options'],
    'eval'					=> array('doNotCopy'=>true,'includeBlankOption'=>true),
	'sql'					=> "char(1) NOT NULL default ''"
);
$GLOBALS['TL_DCA']['tl_module']['fields']['agreement_status'] = array
(
	'label'                 => &$GLOBALS['TL_LANG']['tl_module']['agreement_status'],
	'exclude'               => true,
	'filter'                => true,
	'flag'                  => 1,
	'inputType'             => 'select',
	'options'				=>  &$GLOBALS['TL_LANG']['tl_iao_agreement']['status_options'],
    'eval'					=> array('doNotCopy'=>true,'includeBlankOption'=>true),
	'sql'					=> "char(1) NOT NULL default ''"
);
/**
 * Class tl_module_iao
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * @copyright  Leo Feyer 2005-2012
 * @author     Leo Feyer <http://www.contao.org>
 * @package    Controller
 */
class tl_module_iao extends Backend
{
	/**
	 * Return all info templates as array
	 * @param DataContainer
	 * @return array
	 */
	public function getTemplates(DataContainer $dc)
	{
		$intPid = $dc->activeRecord->pid;

		if ($this->Input->get('act') == 'overrideAll')
		{
			$intPid = $this->Input->get('id');
		}

		return $this->getTemplateGroup('iao_', $intPid);
	}
}

