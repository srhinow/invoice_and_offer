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
 * Table tl_member
 */
if($this->Input->get('do') == 'iao_customer')
{

}

/**
 * Table tl_member
 */
$GLOBALS['TL_DCA']['tl_member']['palettes']['iao_customer']   =  '{import_settings:hide},myid;{personal_legend},title,firstname,lastname,dateOfBirth,gender;{address_legend:hide},company,street,postal,city,state,country;{contact_legend},phone,mobile,fax,email,website;{groups_legend},groups;{login_legend},login;{homedir_legend:hide},assignDir;{account_legend},disable,start,stop';

$GLOBALS['TL_DCA']['tl_member']['fields']['title'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_member']['title'],
	'exclude'                 => true,
	'search'                  => true,
	'sorting'                 => true,
	'flag'                    => 1,
	'inputType'               => 'text',
	'eval'                    => array('mandatory'=>false, 'maxlength'=>255, 'feEditable'=>true, 'feViewable'=>true, 'feGroup'=>'personal'),
	'sql'					  => "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_member']['fields']['myid'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_member']['myid'],
	'exclude'                 => true,
	'inputType'               => 'text',
	'eval'                    => array('rgxp'=>'alnum', 'doNotCopy'=>true, 'spaceToUnderscore'=>true, 'maxlength'=>128, 'tl_class'=>'w50'),
	'sql'					  => "int(10) unsigned NOT NULL default '0'"
);

$GLOBALS['TL_DCA']['tl_member']['fields']['iao_group'] = array
(
	'sql'					=> "int(10) unsigned NOT NULL default '0'"
);

/**
 * Class tl_member
 */
class tl_iao_member extends Backend
{
	public function setCustomerGroup(DataContainer $dc)
	{
        $this->import('iao');
        $this->settings = $this->iao->getSettings();

		// Return if there is no active record (override all)
		if (!$dc->activeRecord || $dc->id == 0)
		{
			return;
		}

		$this->Database->prepare("UPDATE tl_member SET iao_group=? WHERE id=?")
						->execute($this->settings['iao_costumer_group'],$dc->id);
    }
}
