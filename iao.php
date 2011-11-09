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
	 * Import a theme
	 */
	public function importInvoices()
	{
		if ($this->Input->post('FORM_SUBMIT') == 'tl_iao_import')
		{
			$source = $this->Input->post('source', true);

			// Check the file names
			if (!$source || !is_array($source))
			{
				$_SESSION['TL_ERROR'][] = $GLOBALS['TL_LANG']['ERR']['all_fields'];
				$this->reload();
			}

			$arrFiles = array();

			// Skip invalid entries
			foreach ($source as $strFile)
			{
				// Skip folders
				if (is_dir(TL_ROOT . '/' . $strFile))
				{
					$_SESSION['TL_ERROR'][] = sprintf($GLOBALS['TL_LANG']['ERR']['importFolder'], basename($strFile));
					continue;
				}

				$objFile = new File($strFile);

				// Skip anything but .cto files
				if ($objFile->extension != 'csv')
				{
					$_SESSION['TL_ERROR'][] = sprintf($GLOBALS['TL_LANG']['ERR']['filetype'], $objFile->extension);
					continue;
				}

				$arrFiles[] = $strFile;
			}

			// Check wether there are any files left
			if (count($arrFiles) < 1)
			{
				$_SESSION['TL_ERROR'][] = $GLOBALS['TL_LANG']['ERR']['all_fields'];
				$this->reload();
			}

			// Store the field names of the theme tables
			$arrDbFields = array
			(
				'tl_fss_items'       => $this->Database->getFieldNames('tl_fss_items')
			);


			return $this->extractEntryFiles($arrFiles, $arrDbFields);

		}

		$objTree = new FileTree($this->prepareForWidget($GLOBALS['TL_DCA']['tl_iao_invoice']['fields']['csv_source'], 'csv_source', null, 'csv_source', 'tl_iao_invoice'));

		// Return the form
		return '
		    <div id="tl_buttons">
		    <a href="'.ampersand(str_replace('&key=importInvoices', '', $this->Environment->request)).'" class="header_back" title="'.specialchars($GLOBALS['TL_LANG']['MSC']['backBT']).'" accesskey="b">'.$GLOBALS['TL_LANG']['MSC']['backBT'].'</a>
		    </div>
		    
		    <h2 class="sub_headline">'.$GLOBALS['TL_LANG']['tl_fss_items']['importFssItems'][1].'</h2>'.$this->getMessages().'
		    
		    <form action="'.ampersand($this->Environment->request, true).'" id="tl_fss_import" class="tl_form" method="post">
		    <div class="tl_formbody_edit">
		    <input type="hidden" name="FORM_SUBMIT" value="tl_fss_import" />
		    <select name="separator" id="separator" class="tl_select" onfocus="Backend.getScrollOffset();">
    <option value="comma">'.$GLOBALS['TL_LANG']['MSC']['comma'].'</option>
    <option value="semicolon">'.$GLOBALS['TL_LANG']['MSC']['semicolon'].'</option>
    <option value="tabulator">'.$GLOBALS['TL_LANG']['MSC']['tabulator'].'</option>
    <option value="linebreak">'.$GLOBALS['TL_LANG']['MSC']['linebreak'].'</option>
  </select>'.(($GLOBALS['TL_LANG']['MSC']['separator'][1] != '') ? '
  <p class="tl_help tl_tip">'.$GLOBALS['TL_LANG']['MSC']['separator'][1].'</p>' : '').' 
		    <div class="tl_tbox block">
		      <h3><label for="source">'.$GLOBALS['TL_LANG']['tl_fss_items']['source'][0].'</label> <a href="contao/files.php" title="' . specialchars($GLOBALS['TL_LANG']['MSC']['fileManager']) . '" onclick="Backend.getScrollOffset(); Backend.openWindow(this, 750, 500); return false;">' . $this->generateImage('filemanager.gif', $GLOBALS['TL_LANG']['MSC']['fileManager'], 'style="vertical-align:text-bottom;"') . '</a></h3>'.$objTree->generate().(strlen($GLOBALS['TL_LANG']['tl_theme']['source'][1]) ? '
		      <p class="tl_help tl_tip">'.$GLOBALS['TL_LANG']['tl_fss_items']['source'][1].'</p>' : '').'
		    </div>
		    
		    </div>
		    
		    <div class="tl_formbody_submit">
		    
		    <div class="tl_submit_container">
		      <input type="submit" name="save" id="save" class="tl_submit" accesskey="s" value="'.specialchars($GLOBALS['TL_LANG']['tl_fss_items']['importTheme'][0]).'" />
		    </div>
		    
		    </div>
		    </form>';
	}


	/**
	 * Extract the Entry files and write the data to the database
	 * @param array
	 * @param array
	 */
	protected function extractEntryFiles($arrFiles, $arrDbFields)
	{
		$this->import('Database');
		
		foreach ($arrFiles as $strFile)
		{
			$csv = null;
                        $this->import('Files');      			
			
			// Lock the tables
 			$arrLocks = array('tl_fss_items' => 'WRITE');
 			$this->Database->lockTables($arrLocks);
      			
      			$handle = $this->Files->fopen($strFile,'r');
      			while (($data = fgetcsv ($handle, 1000, ",")) !== FALSE ) {
      			      
      			      if(empty($data[0])) continue;
      			      
      			      $alias = $this->generateAlias($data[0]);
      			      //Falls ürtümlich vom System vorangestelltes id- entfernen
      			      if(strncmp($alias, 'id-', 3) === 0) $alias = substr($alias,3);
      			      
      			      $set = array(
				  'pid'  => $this->Input->get('id'),
				  'name' => $data[0],
				  'alias' => $alias,
				  'tstamp' => time()
      			      );
      			            			      
      			      // Update the datatbase
			      $this->Database->prepare("INSERT INTO `tl_fss_items` %s")->set($set)->execute();

      			}

			// Unlock the tables
 			$this->Database->unlockTables();


			// Notify the user
			$_SESSION['TL_CONFIRM'][] = sprintf($GLOBALS['TL_LANG']['tl_fss_items']['FssItems_imported'], basename($strFile));
		}

		// Redirect
		setcookie('BE_PAGE_OFFSET', 0, 0, '/');
		$this->redirect(str_replace('&key=importFssItems', '', $this->Environment->request));
	}
	
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

?>