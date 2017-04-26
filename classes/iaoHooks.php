<?php
/**
 * PHP version 5
 * @copyright  Sven Rhinow Webentwicklung 2013 <http://www.sr-tag.de>
 * @author     Sven Rhinow
 * @package    BBK (BilderBuchKino)
 * @license    commercial
 * @filesource
 */

class iaoHooks extends \Frontend
{
    public function __construct()
    {
		parent::__construct();
    }
    /**
    * replace iao-specific inserttag if get-paramter isset
    * bn::colname::alternative from objPage
    * @param string
    * @return string
    */
    public function iaoReplaceInsertTags($strTag)
	{

	    if (substr($strTag,0,5) == 'iao::')
	    {
	        global $objPage;

	        $Id = \Input::get('bbk');
	        $split = explode('::',$strTag);

       		if(strlen($bbkId) < 1 || (int) $bbkId < 1) return $objPage->$split[2];

			$objBbk = BBKModel::findBBKByIdOrAlias($Id);


	        switch($split[1]){
	        	case 'printbutton':
	        		return (!$libId) ? '' : '<a href="javascript:window.print()" class="printbutton"><i class="fa fa-print"></i></a>';

	        	break;
	        	default:
	        		return $objBbk->$split[1];
	        }

	    }

	    return false;
	}

}
