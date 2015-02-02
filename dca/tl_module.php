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
 * PHP version 5
 * @copyright  sr-tag.de 2011-2013
 * @author     Sven Rhinow
 * @package    invoice_and_offer
 * @license    LGPL
 * @filesource
 */
$this->loadLanguageFile('tl_iao_invoice');
/**
 * Add palettes to tl_module
 */
$GLOBALS['TL_DCA']['tl_module']['palettes']['fe_iao_invoice']    = '{title_legend},name,headline,type,fe_iao_numberOfItems,perPage,status;{template_legend},fe_iao_template;{protected_legend:hide},protected;{expert_legend:hide},cssID,space';
$GLOBALS['TL_DCA']['tl_module']['palettes']['fe_iao_offer'] = '{title_legend},name,headline,type,fe_iao_numberOfItems,perPage;{template_legend},fe_iao_template;{protected_legend:hide},protected;{expert_legend:hide},cssID,space';
$GLOBALS['TL_DCA']['tl_module']['palettes']['fe_iao_credit']  = '{title_legend},name,headline,type,fe_iao_numberOfItems,perPage;{template_legend},fe_iao_template;{protected_legend:hide},protected;{expert_legend:hide},cssID,space';
$GLOBALS['TL_DCA']['tl_module']['palettes']['fe_iao_reminder']  = '{title_legend},name,headline,type,fe_iao_numberOfItems,perPage;{template_legend},fe_iao_template;{protected_legend:hide},protected;{expert_legend:hide},cssID,space';
$GLOBALS['TL_DCA']['tl_module']['palettes']['fe_iao_agreements']  = '{title_legend},name,headline,type,fe_iao_numberOfItems,perPage;{template_legend},fe_iao_template;{protected_legend:hide},protected;{expert_legend:hide},cssID,space';

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


$GLOBALS['TL_DCA']['tl_module']['fields']['status'] = array
(
	'label'                 => &$GLOBALS['TL_LANG']['tl_module']['status'],
	'exclude'               => true,
	'filter'                => true,
	'flag'                  => 1,
	'inputType'             => 'select',
	'options'				=>  &$GLOBALS['TL_LANG']['tl_iao_invoice']['status_options'],
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

