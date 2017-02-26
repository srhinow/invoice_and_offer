<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 *
 * @copyright  Sven Rhinow 2011-2014
 * @author     sr-tag Sven Rhinow Webentwicklung <http://www.sr-tag.de>
 * @package    invoice_and_offer
 * @license    LGPL
 * @filesource
 */


/**
 * Class ModuleTeacherMember
 *
 * Back end module "edit account".
 * @copyright  Sven Rhinow
 * @author     Sven Rhinow <http://www.sr-tag.de>
 * @package    Controller
 */
class ModuleArrears extends BackendModule
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

                #$GLOBALS['TL_DCA'][$this->table]['config']['onsubmit_callback'][] = array('tl_iao_member', 'setCustomerGroup');		
		$GLOBALS['TL_DCA'][$this->table]['palettes'] = array
		(
			'__selector__' => $GLOBALS['TL_DCA'][$this->table]['palettes']['__selector__'],
			'default' => $GLOBALS['TL_DCA'][$this->table]['palettes']['iao_arrears'] 
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

?>
