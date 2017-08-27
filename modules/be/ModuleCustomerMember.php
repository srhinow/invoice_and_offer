<?php

/**
 * @copyright  Sven Rhinow 2011-2014
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
    protected $settings = array();

        /**
	 * Change the palette of the current table and switch to edit mode
	 */
	public function generate()
	{
		$this->import('BackendUser', 'User');
		$this->import('iao');
		$this->settings = $this->iao->getSettings($GLOBALS['IAO']['default_settings_id']);

		$GLOBALS['TL_DCA'][$this->table]['config']['onsubmit_callback'][] = array('tl_iao_member', 'setCustomerGroup');
		$GLOBALS['TL_DCA'][$this->table]['palettes'] = array
		(
			'__selector__' => $GLOBALS['TL_DCA'][$this->table]['palettes']['__selector__'],
			'default' => $GLOBALS['TL_DCA'][$this->table]['palettes']['iao_customer']
		);

		$GLOBALS['TL_DCA'][$this->table]['list']['sorting'] = array
		(
			'mode'                  => 2,
			'fields'                => array('company'),
			'flag'                  => 11,
			'panelLayout'           => 'filter;sort,search,limit',
			'filter'		  		=> array(array('iao_group=?',$this->settings['iao_costumer_group']))
		);
		
		$GLOBALS['TL_DCA'][$this->table]['list']['label'] = array
		(
			'fields'                => array('title','firstname','lastname'),
			'format'                => '%s %s %s',
		);

    	unset($GLOBALS['TL_DCA'][$this->table]['list']['operations']['addresses']);

		$GLOBALS['TL_DCA'][$this->table]['fields']['company']['flag'] = false;

		$act = \Input::get('act');
		return (strlen($act) == 0 || $act == 'select') ? $this->objDc->showAll() : $this->objDc->{$act}();
	}

	/**
	 * Generate module
	 */
	protected function compile()
	{
		return '';
	}
}
