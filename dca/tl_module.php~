<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * TYPOlight webCMS
 *
 * The TYPOlight webCMS is an accessible web content management system that 
 * specializes in accessibility and generates W3C-compliant HTML code. It 
 * provides a wide range of functionality to develop professional websites 
 * including a built-in search engine, form generator, file and user manager, 
 * CSS engine, multi-language support and many more. For more information and 
 * additional TYPOlight applications like the TYPOlight MVC Framework please 
 * visit the project website http://www.typolight.org.
 *
 * This file modifies the data container array of table tl_module.
 *
 * @copyright  Sven Rhinow 2011
 * @author     Sven Rhinow <sven@sr-tag.de>
 * @package    Geldkoffer
 * @license    LGPL
 * @filesource

 */
$GLOBALS['TL_DCA']['tl_module']['palettes']['mcsp_categoriesmenu']  = 'name,headline,type;mcsp_template,mcsp_categories_jumpTo,mcsp_ignore_filter,mcsp_del_cookie;space,cssID';
$GLOBALS['TL_DCA']['tl_module']['palettes']['mcsp_searchbar_categories']  = 'name,headline,type;mcsp_categories_template;space';
$GLOBALS['TL_DCA']['tl_module']['palettes']['mcsp_breadcrumb']  = 'name,headline,type;mcsp_breadcrumb_start;space';
$GLOBALS['TL_DCA']['tl_module']['palettes']['mcsp_searchbar']  = 'name,type;mcsp_template,mcsp_type,mcsp_sb_min_characters,mcsp_sb_max_characters,mcsp_detail_jumpTo,mcsp_ignore_filter,mcsp_del_cookie';
$GLOBALS['TL_DCA']['tl_module']['palettes']['mcsp_adlist']  = 'name,type;mcsp_template,mcsp_type;mcsp_detail_jumpTo,mcsp_categories_jumpTo,mcsp_css_file;mcsp_count,mcsp_title_maxlength,mcsp_text_maxlength,mcsp_more_str,mcsp_img_size,mcsp_ignore_filter,mcsp_only_with_img;mcsp_alternate_text';
$GLOBALS['TL_DCA']['tl_module']['palettes']['mcsp_addetailsbig']  = 'name,type;mcsp_template;mcsp_css_file;mcsp_img_size,mcsp_thumb_size,mcsp_max_size;mcsp_video_width,mcsp_video_height';
$GLOBALS['TL_DCA']['tl_module']['palettes']['mcsp_addetailssidebar']  = 'name,headline,type;mcsp_template;mcsp_css_file';
$GLOBALS['TL_DCA']['tl_module']['palettes']['mcsp_addetailsplusbox']  = 'name,headline,type;mcsp_template;mcsp_css_file,mcsp_wishlist_jumpTo,mcsp_print_jumpTo,mcsp_share_jumpTo,mcsp_reporting_jumpTo';
$GLOBALS['TL_DCA']['tl_module']['palettes']['mcsp_adshareform']  = 'name,headline,type;mcsp_template,mcsp_detail_jumpTo;mcsp_css_file;mcsp_email_fromAddress,mcsp_email_fromText,mcsp_email_subject,mcsp_email_text,mcsp_email_success';
$GLOBALS['TL_DCA']['tl_module']['palettes']['mcsp_adreportform']  = 'name,headline,type;mcsp_template,mcsp_detail_jumpTo;mcsp_css_file;mcsp_email_fromAddress,mcsp_email_fromText,mcsp_email_toAddress,mcsp_email_subject,mcsp_email_text,mcsp_email_success';
$GLOBALS['TL_DCA']['tl_module']['palettes']['mcsp_adwishlist']  = 'name,headline,type;mcsp_template,mcsp_detail_jumpTo;mcsp_css_file;mcsp_title_maxlength,mcsp_text_maxlength,mcsp_more_str,mcsp_img_size';
$GLOBALS['TL_DCA']['tl_module']['palettes']['mcsp_step1selectcategory']  = 'name,headline,type;mcsp_template,mcsp_next_jumpTo;space,cssID';
$GLOBALS['TL_DCA']['tl_module']['palettes']['mcsp_step2givedata']  = 'name,headline,type;mcsp_template,mcsp_prev_jumpTo,mcsp_next_jumpTo;space,cssID';

array_insert($GLOBALS['TL_DCA']['tl_module']['fields'] , 2, array
(


	
	'mcsp_categories_jumpTo' => array
	(
		'label'                   => &$GLOBALS['TL_LANG']['tl_module']['mcsp_categories_jumpTo'],
		'exclude'                 => true,
		'inputType'               => 'pageTree',
		'eval'                    => array('fieldType'=>'radio','tl_class'=>'clr'),
		'explanation'             => 'jumpTo'
	),
	'mcsp_detail_jumpTo' => array
	(
		'label'                   => &$GLOBALS['TL_LANG']['tl_module']['mcsp_detail_jumpTo'],
		'exclude'                 => true,
		'inputType'               => 'pageTree',
		'eval'                    => array('fieldType'=>'radio','tl_class'=>'clr'),
		'explanation'             => 'jumpTo'
	),
	'mcsp_wishlist_jumpTo' => array
	(
		'label'                   => &$GLOBALS['TL_LANG']['tl_module']['mcsp_wishlist_jumpTo'],
		'exclude'                 => true,
		'inputType'               => 'pageTree',
		'eval'                    => array('fieldType'=>'radio','tl_class'=>'clr'),
		'explanation'             => 'jumpTo'
	),
	'mcsp_print_jumpTo' => array
	(
		'label'                   => &$GLOBALS['TL_LANG']['tl_module']['mcsp_print_jumpTo'],
		'exclude'                 => true,
		'inputType'               => 'pageTree',
		'eval'                    => array('fieldType'=>'radio','tl_class'=>'clr'),
		'explanation'             => 'jumpTo'
	),
	'mcsp_share_jumpTo' => array
	(
		'label'                   => &$GLOBALS['TL_LANG']['tl_module']['mcsp_share_jumpTo'],
		'exclude'                 => true,
		'inputType'               => 'pageTree',
		'eval'                    => array('fieldType'=>'radio','tl_class'=>'clr'),
		'explanation'             => 'jumpTo'
	),
	'mcsp_reporting_jumpTo' => array
	(
		'label'                   => &$GLOBALS['TL_LANG']['tl_module']['mcsp_reporting_jumpTo'],
		'exclude'                 => true,
		'inputType'               => 'pageTree',
		'eval'                    => array('fieldType'=>'radio','tl_class'=>'clr'),
		'explanation'             => 'jumpTo'
	),			
	'mcsp_count' => array
	(
		'label'                   => &$GLOBALS['TL_LANG']['tl_module']['mcsp_count'],
		'exclude'                 => true,
		'inputType'               => 'text',
		'eval'                    => array('rgxp'=>'digit', 'nospace'=>true)
	),
	'mcsp_sb_min_characters' => array
	(
		'label'                   => &$GLOBALS['TL_LANG']['tl_module']['mcsp_sb_min_characters'],
		'exclude'                 => true,
		'inputType'               => 'text',
		'eval'                    => array('rgxp'=>'digit', 'nospace'=>true,'tl_class'=>'w50')
	),
	'mcsp_sb_max_characters' => array
	(
		'label'                   => &$GLOBALS['TL_LANG']['tl_module']['mcsp_sb_max_characters'],
		'exclude'                 => true,
		'inputType'               => 'text',
		'eval'                    => array('rgxp'=>'digit', 'nospace'=>true,'tl_class'=>'w50')
	),	
	'mcsp_template' => array
	(
		'label'                   => &$GLOBALS['TL_LANG']['tl_module']['mcsp_template'],
		'exclude'                 => true,
		'inputType'               => 'select',
		'options'                 => $this->getTemplateGroup('mcsp_')
	),
	'mcsp_type' => array(
			'label'                   => &$GLOBALS['TL_LANG']['tl_module']['mcsp_type'],
			'inputType'               => 'select',
			'filter'                  => true,
			'sorting'                 => false,
			'search'		  => false,		
			'foreignKey'              => 'tl_mcsp_types.name',
			'save_callback' => array
			(
// 			    array('tl_gk_polls_helper', 'saveCompanyName')
			)
	),
	'mcsp_count' => array
	(
		'label'                   => &$GLOBALS['TL_LANG']['tl_module']['mcsp_count'],
		'exclude'                 => true,
		'default'                 => '4',
		'inputType'               => 'text',
		'eval'                    => array('rgxp'=>'digit', 'nospace'=>true,'tl_class'=>'w50'),

	),
	'mcsp_email' =>  array
	(
		'label'                   => &$GLOBALS['TL_LANG']['tl_module']['mcsp_email'],
		'exclude'                 => true,		
		'inputType'               => 'text',
		'eval'			=> array('tl_class'=>'w50','rgxp'=>'email')
	),

	'mcsp_title_maxlength' => array
	(
		'label'                   => &$GLOBALS['TL_LANG']['tl_module']['mcsp_title_maxlength'],
		'exclude'                 => true,
		'inputType'               => 'text',
		'eval'                    => array('rgxp'=>'digit', 'nospace'=>true,'tl_class'=>'w50')
	),
	'mcsp_text_maxlength' => array
	(
		'label'                   => &$GLOBALS['TL_LANG']['tl_module']['mcsp_text_maxlength'],
		'exclude'                 => true,
		'inputType'               => 'text',
		'eval'                    => array('rgxp'=>'digit', 'nospace'=>true,'tl_class'=>'w50')
	),
	'mcsp_video_width' => array
	(
		'label'                   => &$GLOBALS['TL_LANG']['tl_module']['mcsp_video_width'],
		'exclude'                 => true,
		'inputType'               => 'text',
		'eval'                    => array('rgxp'=>'digit', 'nospace'=>true,'tl_class'=>'w50')
	),
	'mcsp_video_height' => array
	(
		'label'                   => &$GLOBALS['TL_LANG']['tl_module']['mcsp_video_height'],
		'exclude'                 => true,
		'inputType'               => 'text',
		'eval'                    => array('rgxp'=>'digit', 'nospace'=>true,'tl_class'=>'w50')
	),				
	'mcsp_breadcrumb_start' => array
	(
		'label'                   => &$GLOBALS['TL_LANG']['tl_module']['mcsp_breadcrumb_start'],
		'exclude'                 => true,
		'inputType'               => 'text',
		'eval'                    => array('nospace'=>true,'tl_class'=>'w50')
	),
	'mcsp_more_str' => array
	(
		'label'                   => &$GLOBALS['TL_LANG']['tl_module']['mcsp_more_str'],
		'exclude'                 => true,
		'inputType'               => 'text',
 		'eval'                    => array('tl_class'=>'w50')
	),	
	'mcsp_img_size' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_module']['mcsp_img_size'],
			'exclude'                 => true,
			'inputType'               => 'imageSize',
			'options'                 => array('crop', 'proportional', 'box'),
			'reference'               => &$GLOBALS['TL_LANG']['MSC'],
			'eval'                    => array('rgxp'=>'digit', 'nospace'=>true,'tl_class'=>'w50')
	),
	'mcsp_thumb_size' => array
	(
			'label'                   => &$GLOBALS['TL_LANG']['tl_module']['mcsp_thumb_size'],
			'exclude'                 => true,
			'inputType'               => 'imageSize',
			'options'                 => array('crop', 'proportional', 'box'),
			'reference'               => &$GLOBALS['TL_LANG']['MSC'],
			'eval'                    => array('rgxp'=>'digit', 'nospace'=>true,'tl_class'=>'w50')
	),
	'mcsp_max_size' => array
	(
			'label'                   => &$GLOBALS['TL_LANG']['tl_module']['mcsp_max_size'],
			'exclude'                 => true,
			'inputType'               => 'imageSize',
			'options'                 => array('crop', 'proportional', 'box'),
			'reference'               => &$GLOBALS['TL_LANG']['MSC'],
			'eval'                    => array('rgxp'=>'digit', 'nospace'=>true,'tl_class'=>'w50')
	),		
	'mcsp_ignore_filter' => array
	(
		'label'                   => &$GLOBALS['TL_LANG']['tl_module']['mcsp_ignore_filter'],
		'exclude'                 => true,
		'filter'                  => true,
		'inputType'               => 'checkbox',
		'eval'                    => array('tl_class'=>'clr')
		
	),
	'mcsp_del_cookie' => array
	(
		'label'                   => &$GLOBALS['TL_LANG']['tl_module']['mcsp_del_cookie'],
		'exclude'                 => true,
		'filter'                  => true,
		'inputType'               => 'checkbox',
		'eval'                    => array('tl_class'=>'clr')
		
	),	
	'mcsp_only_with_img' => array
	(
		'label'                   => &$GLOBALS['TL_LANG']['tl_module']['mcsp_only_with_img'],
		'exclude'                 => true,
		'filter'                  => true,
		'inputType'               => 'checkbox',
		'eval'                    => array('tl_class'=>'clr')
		
	),	
	'mcsp_css_file' => array
	(
		'label'                   => &$GLOBALS['TL_LANG']['tl_module']['mcsp_css_file'],
		'exclude'                 => true,
		'inputType'               => 'fileTree',
		'eval'                    => array('fieldType'=>'checkbox', 'files'=>true, 'filesOnly'=>true, 'mandatory'=>false)
	),
	'mcsp_email_fromAddress' =>  array
	(
		'label'                   => &$GLOBALS['TL_LANG']['tl_module']['mcsp_email_fromAddress'],
		'exclude'                 => false,		
		'inputType'               => 'text',
		'eval'			=> array('mandatory'=>true, 'tl_class'=>'w50','rgxp'=>'email')
	),

	'mcsp_email_fromText' => array
	(
		'label'                   => &$GLOBALS['TL_LANG']['tl_module']['mcsp_email_fromText'],
		'exclude'                 => false,
		'inputType'               => 'text',
		'eval'                    => array('mandatory'=>true, 'tl_class'=>'w50', 'rgxp'=>'alnum')
	),					
	'mcsp_email_toAddress' =>  array
	(
		'label'                   => &$GLOBALS['TL_LANG']['tl_module']['mcsp_email_toAddress'],
		'exclude'                 => false,		
		'inputType'               => 'text',
		'eval'			=> array('mandatory'=>true, 'tl_class'=>'w50','rgxp'=>'email')
	),
	'mcsp_email_toText' => array
	(
		'label'                   => &$GLOBALS['TL_LANG']['tl_module']['mcsp_email_toText'],
		'exclude'                 => false,
		'inputType'               => 'text',
		'eval'                    => array('mandatory'=>true, 'tl_class'=>'w50', 'rgxp'=>'alnum')
	),					
	'mcsp_email_subject' =>  array
	(
		'label'                   => &$GLOBALS['TL_LANG']['tl_module']['mcsp_email_subject'],
		'exclude'                 => false,		
		'inputType'               => 'text',
		'eval'			=> array('mandatory'=>true,'tl_class'=>'long')
	),
	'mcsp_alternate_text' => array
	(
		'label'                   => &$GLOBALS['TL_LANG']['tl_module']['mcsp_alternate_text'],
		'exclude'                 => false,
		'filter'                  => false,
		'search'                  => false,
		'inputType'               => 'textarea',
		'eval'                    => array('mandatory'=>false, 'cols'=>'5','rows'=>'30','rte'=>false,'allowHtml'=>true),			
		
	),	
	'mcsp_email_text' => array
	(
		'label'                   => &$GLOBALS['TL_LANG']['tl_module']['mcsp_email_text'],
		'exclude'                 => false,
		'filter'                  => false,
		'search'                  => false,
		'inputType'               => 'textarea',
		'eval'                    => array('mandatory'=>true, 'cols'=>'5','rows'=>'30','rte'=>false,'allowHtml'=>true),			
		
	),
	'mcsp_email_success' => array
	(
		'label'                   => &$GLOBALS['TL_LANG']['tl_module']['mcsp_email_success'],
		'exclude'                 => false,
		'filter'                  => false,
		'search'                  => false,
		'inputType'               => 'textarea',
		'eval'                    => array('mandatory'=>true, 'cols'=>'5','rows'=>'30','rte'=>false,'allowHtml'=>true),			
		
	),
	'mcsp_next_jumpTo' => array
	(
		'label'                   => &$GLOBALS['TL_LANG']['tl_module']['mcsp_next_jumpTo'],
		'exclude'                 => true,
		'inputType'               => 'pageTree',
		'eval'                    => array('fieldType'=>'radio','tl_class'=>'clr'),
		'explanation'             => 'jumpTo'
	),					
	'mcsp_prev_jumpTo' => array
	(
		'label'                   => &$GLOBALS['TL_LANG']['tl_module']['mcsp_prev_jumpTo'],
		'exclude'                 => true,
		'inputType'               => 'pageTree',
		'eval'                    => array('fieldType'=>'radio','tl_class'=>'clr'),
		'explanation'             => 'jumpTo'
	),					
		
));


/**
 * Class tl_ourimages
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * @copyright  Leo Feyer 2008-2009
 * @author     Leo Feyer <leo@typolight.org>
 * @package    Controller
 */
class tl_mcsp_categories extends Backend
{

	/**
	 * Autogenerate a news alias if it has not been set yet
	 * @param mixed
	 * @param object
	 * @return string
	 */
	public function getImgSize($varValue, DataContainer $dc)
	{
	    $ObjSize=unserialize($varValue);
	   # print_r($dc->Input->post('imagesrc'));
	    $ImgSrc =$dc->Input->post('imagesrc');
	    if(!empty($ImgSrc) && empty($ObjSize[0]) && empty($ObjSize[1])){
		 
		 $objFile = new File($ImgSrc);
		 
		 $ObjSize[0] =$objFile->width; 
		 $ObjSize[1] =$objFile->height;
		 
		 $varValue = serialize($ObjSize); 		 	    
	    }		
	    return $varValue;
	}

	/**
	 * Autogenerate a news alias if it has not been set yet
	 * @param mixed
	 * @param object
	 * @return string
	 */
	public function saveTags($varValue, DataContainer $dc)
	{

		$isTagExist = false;
		$tagArr =array();
		// Generate tags if there is none
		if (strlen($varValue))
		{
			$tagArr = explode(",",$varValue);
			if(count($tagArr)>0)foreach($tagArr AS $tag)
			{
			    $this->Database->prepare("INSERT IGNORE INTO `tl_fr24_tags`(`tagname`) VALUES(?)")
									   ->execute(trim($tag));
                        }
		}
		
		return $varValue;
	}

 }

?>