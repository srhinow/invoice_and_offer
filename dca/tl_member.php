<?php

/**
 * @copyright  Sven Rhinow 2014
 * @author     sr-tag Sven Rhinow Webentwicklung <http://www.sr-tag.de>
 * @package    invoice_and_offer
 * @license    LGPL
 * @filesource
 */

/**
 * Table tl_member
 */
$GLOBALS['TL_DCA']['tl_member']['list']['label'] = array
(
	'fields'                  => array('title','firstname','lastname'),
	'format'                  => '%s %s %s',
	'label_callback'          => array('tl_member', 'addIcon')
);
$GLOBALS['TL_DCA']['tl_member']['list']['sorting'] = array
(
	'mode'                    => 1,
	'fields'                  => array('lastname'),
	'flag'                    => 1,
	'panelLayout'             => 'filter;sort,search,limit'
);
$GLOBALS['TL_DCA']['tl_member']['config'] = array
(
	'dataContainer'               => 'Table',
	'enableVersioning'            => true,
	'onsubmit_callback' => array
	(
		array('tl_member', 'storeDateAdded')
	)
);

if($this->Input->get('do') == 'iao_customer')
{
    unset($GLOBALS['TL_DCA']['tl_member']['list']['operations']['addresses']);
}

/**
 * Table tl_member
 */
$GLOBALS['TL_DCA']['tl_member']['palettes']['iao_customer']   =  '{import_settings:hide},myid;{personal_legend},title,firstname,lastname,dateOfBirth,gender;{address_legend:hide},company,street,postal,city,state,country;{contact_legend},phone,mobile,fax,email,website;{login_legend},login;{homedir_legend:hide},assignDir;{account_legend},disable,start,stop';

$GLOBALS['TL_DCA']['tl_member']['fields']['title'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_member']['title'],
	'exclude'                 => true,
	'search'                  => true,
	'sorting'                 => true,
	'flag'                    => 1,
	'inputType'               => 'text',
	'eval'                    => array('mandatory'=>false, 'maxlength'=>255, 'feEditable'=>true, 'feViewable'=>true, 'feGroup'=>'personal')
);

$GLOBALS['TL_DCA']['tl_member']['fields']['myid'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_member']['myid'],
	'exclude'                 => true,
	'inputType'               => 'text',
	'eval'                    => array('rgxp'=>'alnum', 'doNotCopy'=>true, 'spaceToUnderscore'=>true, 'maxlength'=>128, 'tl_class'=>'w50'),
);

/**
 * Class tl_member
 */
class tl_iao_member extends Backend
{
	public function setCustomerGroup(DataContainer $dc)
	{
		// Return if there is no active record (override all)
		if (!$dc->activeRecord || $dc->id == 0)
		{
			return;
		}

		$this->Database->prepare("UPDATE tl_member SET iao_group=? WHERE id=?")
						->execute($GLOBALS['TL_CONFIG']['iao_costumer_group'],$dc->id);
    }
}
