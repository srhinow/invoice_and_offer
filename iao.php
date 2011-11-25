<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2011 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
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
 * @copyright  Leo Feyer 2005-2011
 * @author     Leo Feyer <http://www.contao.org>
 * @package    Backend
 * @license    LGPL
 * @filesource
 */


/**
 * Class iao
 *
 * Provide methods to handle invoice_and_offer-module.
 * @copyright  Sven Rhinow 2011
 * @author     sr-tag Sven Rhinow Webentwicklung <http://www.sr-tag.de>
 * @package    invoice_and_offer
 * @license    LGPL
 */
class iao extends Backend
{
    /**
     * Get netto-price from brutto
     * @param float
     * @param integer
     * @return float
     */	
     public function getNettoPrice($brutto,$vat)
     {
	 return ($brutto * 100) / ($vat + 100);
     }
     
    /**
     * Get brutto-price from netto
     * @param float
     * @param integer
     * @return float
     */	
     public function getBruttoPrice($netto,$vat)
     {
	 return ($netto / 100) * ($vat + 100);
     }

    
    /**
    * change Contao-Placeholder with html-characters
    * 
    */
    public function changeTags($text)
    {
	$ctags = array('[nbsp]'=>'&nbsp;','[lg]'=>'&lg;','[gt]'=>'&gt;','[&]'=>'&amp;');
	foreach($ctags as $tag => $html)
	{
	     $text = str_replace($tag,$html,$text);
	} 
	return $text;
    }

}
