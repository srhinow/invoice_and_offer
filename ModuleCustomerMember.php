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
 * Class ModuleCustomerMember
 */
class ModuleCustomerMember extends BackendModule
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_member';


	/**
	 * Change the palette of the current table and switch to edit mode
	 */
	public function generate()
	{
		$this->import('BackendUser', 'User');

		$GLOBALS['TL_DCA'][$this->table]['config']['onsubmit_callback'][] = array('tl_iao_member', 'setCustomerGroup');
		$GLOBALS['TL_DCA'][$this->table]['palettes'] = array
		(
			'__selector__' => $GLOBALS['TL_DCA'][$this->table]['palettes']['__selector__'],
			'default' => $GLOBALS['TL_DCA'][$this->table]['palettes']['iao_customer']
		);

		$GLOBALS['TL_DCA'][$this->table]['list']['sorting'] = array
		(
			'mode'                    => 2,
			'fields'                  => array('company'),
			'flag'                    =>11,
			'panelLayout'             => 'filter;sort,search,limit',
			'filter'		  => array(array('iao_group=?',$GLOBALS['TL_CONFIG']['iao_costumer_group']))
		);

		$GLOBALS['TL_DCA'][$this->table]['fields']['company']['flag'] = false;

		return strlen($_GET['act'])==0 ? $this->objDc->showAll() : $this->objDc->$_GET['act']();
	}

	/**
	 * Generate module
	 */
	protected function compile()
	{
		return '';
	}
}
