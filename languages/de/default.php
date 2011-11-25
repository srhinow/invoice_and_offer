<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Contao webCMS
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
 * @package    invoice_and_offer
 * @license    LGPL
 * @filesource

 */
$GLOBALS['TL_LANG']['tl_iao']['active']    = array('aktiv', '');
$GLOBALS['TL_LANG']['tl_iao']['status']['title']    = array('Status', '');
$GLOBALS['TL_LANG']['tl_iao']['counter'] = array('Counter','');

$GLOBALS['TL_LANG']['tl_iao']['credit_status'][0]    = array('nicht angenommen', '');
$GLOBALS['TL_LANG']['tl_iao']['credit_status'][1]    = array('angenommen', '');

$GLOBALS['TL_LANG']['ERR']['PermissionDenied'] = 'keine Berechtigung für %s';
?>