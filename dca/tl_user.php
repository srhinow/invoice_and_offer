<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2016 Leo Feyer
 *
 * @license LGPL-3.0+
 */


/**
 * Extend default palette
 */
$GLOBALS['TL_DCA']['tl_user']['palettes']['extend'] = $GLOBALS['TL_DCA']['tl_user']['palettes']['extend'].'{iaolegend},iaomodules,iaomodulep,iaosettings,iaosettingp;';
$GLOBALS['TL_DCA']['tl_user']['palettes']['custom'] = $GLOBALS['TL_DCA']['tl_user']['palettes']['custom'].'{iaolegend},iaomodules,iaomodulep,iaosettings,iaosettingp;';


/**
 * Add fields to tl_user_group
 */
$GLOBALS['TL_DCA']['tl_user']['fields']['iaomodules'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_user']['iaomodules'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'foreignKey'              => 'tl_news_archive.title',
	'eval'                    => array('multiple'=>true),
	'sql'                     => "blob NULL"
);

$GLOBALS['TL_DCA']['tl_user']['fields']['iaomodulep'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_user']['iaomodulep'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'options'                 => array('create', 'delete'),
	'reference'               => &$GLOBALS['TL_LANG']['MSC'],
	'eval'                    => array('multiple'=>true),
	'sql'                     => "blob NULL"
);

$GLOBALS['TL_DCA']['tl_user']['fields']['iaosettings'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_user']['iaosettings'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'foreignKey'              => 'tl_news_feed.title',
	'eval'                    => array('multiple'=>true),
	'sql'                     => "blob NULL"
);

$GLOBALS['TL_DCA']['tl_user']['fields']['iaosettingp'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_user']['iaosettingp'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'options'                 => array('create', 'delete'),
	'reference'               => &$GLOBALS['TL_LANG']['MSC'],
	'eval'                    => array('multiple'=>true),
	'sql'                     => "blob NULL"
);
