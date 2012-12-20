-- ********************************************************
-- *                                                      *
-- * IMPORTANT NOTE                                       *
-- *                                                      *
-- * Do not import this file manually but use the Contao  *
-- * install tool to create and maintain database tables! *
-- *                                                      *
-- ********************************************************

-- 
-- Table `tl_iao_invoice`
-- 

CREATE TABLE `tl_member` (
   `title` varchar(255) NOT NULL default '',
   `myid` int(10) unsigned NOT NULL default '0',
   `iao_group` varchar(255) NOT NULL default '',   
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- 
-- Table `tl_iao_invoice`
-- 

CREATE TABLE `tl_iao_invoice` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `tstamp` int(10) unsigned NOT NULL default '0',
  `invoice_tstamp` int(10) unsigned NOT NULL default '0',
  `execute_date` varchar(255) NOT NULL default '',
  `expiry_date` varchar(255) NOT NULL default '',
  `paid_on_date` varchar(255) NOT NULL default '',
  `title` varchar(255) NOT NULL default '',
  `invoice_id` int(10) unsigned NOT NULL default '0',
  `invoice_id_str` varchar(255) NOT NULL default '',
  `invoice_pdf_file` varchar(255) NOT NULL default '',  
  `notice` mediumtext NULL,
  `address_text` mediumtext NULL,
  `member` varbinary(128) NOT NULL default '',
  `sorting` int(10) unsigned NOT NULL default '0',
  `sendEmail` char(1) NOT NULL default '',
  `FromEmail` varchar(32) NOT NULL default '',
  `ToEmail` varchar(32) NOT NULL default '',
  `alias` varbinary(128) NOT NULL default '',
  `before_template` int(10) unsigned NOT NULL default '0',
  `before_text` text NULL,
  `after_template` int(10) unsigned NOT NULL default '0',
  `after_text` text NULL,
  `published` char(1) NOT NULL default '',
  `status` char(1) NOT NULL default '',
  `noVat` char(1) NOT NULL default '',
  `price_netto` varchar(64) NOT NULL default '0',
  `price_brutto` varchar(64) NOT NULL default '0',
  `discount` char(1) NOT NULL default '',
  `discount_title` varchar(64) NOT NULL default 'Skonto',
  `discount_value` varchar(64) NOT NULL default '3',
  `discount_operator` char(1) NOT NULL default '%',
  `reminder_id` int(10) unsigned NOT NULL default '0',
  `notice` text NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Table `tl_iao_invoice_items`
-- 

CREATE TABLE `tl_iao_invoice_items` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `pid` int(10) unsigned NOT NULL default '0',
  `tstamp` int(10) unsigned NOT NULL default '0',
  `type` varchar(32) NOT NULL default 'item',  
  `headline` varchar(255) NOT NULL default '',
  `headline_to_pdf` char(1) NOT NULL default '',  
  `sorting` int(10) unsigned NOT NULL default '0', 
  `date` int(10) unsigned NOT NULL default '0',
  `time` int(10) unsigned NOT NULL default '0',
  `text` mediumtext NULL,
  `count` varchar(64) NULL default '0',
  `amountStr` varchar(64) NOT NULL default '',
  `operator` char(1) NOT NULL default '+',       
  `price` varchar(64) NOT NULL default '0',
  `price_netto` varchar(64) NOT NULL default '0',
  `price_brutto` varchar(64) NOT NULL default '0',  
  `published` char(1) NOT NULL default '',
  `vat` int(10) unsigned NOT NULL default '19',
  `vat_incl` int(10) unsigned NOT NULL default '1',
  `posten_template` int(10) unsigned NOT NULL default '0',  
  `pagebreak_after` char(1) NOT NULL default '', 
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Table `tl_iao_offer`
-- 

CREATE TABLE `tl_iao_offer` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `tstamp` int(10) unsigned NOT NULL default '0',
  `offer_tstamp` int(10) unsigned NOT NULL default '0',
  `offer_date` date NOT NULL default '0000-00-00',
  `expiry_date` varchar(255) NOT NULL default '',
  `title` varchar(255) NOT NULL default '',
  `offer_id` int(10) unsigned NOT NULL default '0',
  `offer_id_str` varchar(255) NOT NULL default '',
  `offer_pdf_file` varchar(255) NOT NULL default '',  
  `address_text` mediumtext NULL,
  `member` varbinary(128) NOT NULL default '',
  `sorting` int(10) unsigned NOT NULL default '0',
  `sendEmail` char(1) NOT NULL default '',
  `FromEmail` varchar(32) NOT NULL default '',
  `ToEmail` varchar(32) NOT NULL default '',
  `alias` varbinary(128) NOT NULL default '',
  `before_template` int(10) unsigned NOT NULL default '0',
  `before_text` text NULL,
  `after_template` int(10) unsigned NOT NULL default '0',
  `after_text` text NULL,
  `published` char(1) NOT NULL default '',
  `status` char(1) NOT NULL default '',
  `noVat` char(1) NOT NULL default '',  
  `price_netto` varchar(64) NOT NULL default '0',
  `price_brutto` varchar(64) NOT NULL default '0',
  `notice` text NULL,  
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Table `tl_iao_offer_items`
-- 

CREATE TABLE `tl_iao_offer_items` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `pid` int(10) unsigned NOT NULL default '0',
  `tstamp` int(10) unsigned NOT NULL default '0',
  `type` varchar(32) NOT NULL default 'item',  
  `headline` varchar(255) NOT NULL default '',
  `headline_to_pdf` char(1) NOT NULL default '',   
  `sorting` int(10) unsigned NOT NULL default '0', 
  `date` int(10) unsigned NOT NULL default '0',
  `time` int(10) unsigned NOT NULL default '0',
  `text` mediumtext NULL,
  `count` varchar(64) NULL default '0',
  `amountStr` varchar(64) NOT NULL default '', 
  `operator` char(1) NOT NULL default '+',       
  `price` varchar(64) NOT NULL default '0',
  `price_netto` varchar(64) NOT NULL default '0',
  `price_brutto` varchar(64) NOT NULL default '0',  
  `published` char(1) NOT NULL default '',
  `vat` int(10) unsigned NOT NULL default '19',
  `vat_incl` int(10) unsigned NOT NULL default '1',
  `posten_template` int(10) unsigned NOT NULL default '0', 
  `pagebreak_after` char(1) NOT NULL default '', 
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Table `tl_iao_credit`
-- 

CREATE TABLE `tl_iao_credit` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `tstamp` int(10) unsigned NOT NULL default '0',
  `credit_tstamp` int(10) unsigned NOT NULL default '0',
  `credit_date` date NOT NULL default '0000-00-00',
  `expiry_date` varchar(255) NOT NULL default '', 
  `title` varchar(255) NOT NULL default '',
  `credit_id` int(10) unsigned NOT NULL default '0',
  `credit_id_str` varchar(255) NOT NULL default '',
  `credit_pdf_file` varchar(255) NOT NULL default '',  
  `notice` mediumtext NULL,
  `address_text` mediumtext NULL,
  `member` varbinary(128) NOT NULL default '',
  `sorting` int(10) unsigned NOT NULL default '0',
  `sendEmail` char(1) NOT NULL default '',
  `FromEmail` varchar(32) NOT NULL default '',
  `ToEmail` varchar(32) NOT NULL default '',
  `alias` varbinary(128) NOT NULL default '',
  `before_template` int(10) unsigned NOT NULL default '0',
  `before_text` text NULL,
  `after_template` int(10) unsigned NOT NULL default '0',
  `after_text` text NULL,
  `published` char(1) NOT NULL default '',
  `status` char(1) NOT NULL default '',
  `noVat` char(1) NOT NULL default '',   
  `price_netto` varchar(64) NOT NULL default '0',
  `price_brutto` varchar(64) NOT NULL default '0',
  `notice` text NULL,  
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Table `tl_iao_credit_items`
-- 

CREATE TABLE `tl_iao_credit_items` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `pid` int(10) unsigned NOT NULL default '0',
  `tstamp` int(10) unsigned NOT NULL default '0',
  `type` varchar(32) NOT NULL default 'item',  
  `headline` varchar(255) NOT NULL default '',
  `sorting` int(10) unsigned NOT NULL default '0', 
  `date` int(10) unsigned NOT NULL default '0',
  `time` int(10) unsigned NOT NULL default '0',
  `text` mediumtext NULL,
  `count` varchar(64) NULL default '0',
  `amountStr` varchar(64) NOT NULL default '',
  `operator` char(1) NOT NULL default '+',    
  `price` varchar(64) NOT NULL default '0',
  `price_netto` varchar(64) NOT NULL default '0',
  `price_brutto` varchar(64) NOT NULL default '0',  
  `published` char(1) NOT NULL default '',
  `vat` int(10) unsigned NOT NULL default '19',
  `vat_incl` int(10) unsigned NOT NULL default '1',
  `posten_template` int(10) unsigned NOT NULL default '0',  
  `pagebreak_after` char(1) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `tl_iao_templates` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `tstamp` int(10) unsigned NOT NULL default '0',
  `title` varchar(255) NOT NULL default '',
  `area` varchar(55) NOT NULL default '',  
  `position` varchar(25) NOT NULL default '',    
  `sorting` int(10) unsigned NOT NULL default '0', 
  `text` mediumtext NULL,
  PRIMARY KEY  (`id`),
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `tl_iao_posten_templates` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `tstamp` int(10) unsigned NOT NULL default '0',
  `headline` varchar(255) NOT NULL default '',
  `headline_to_pdf` char(1) NOT NULL default '',  
  `sorting` int(10) unsigned NOT NULL default '0',  
  `date` int(10) unsigned NOT NULL default '0',
  `time` int(10) unsigned NOT NULL default '0',
  `text` mediumtext NULL,
  `count` varchar(64) NULL default '0', 
  `amountStr` varchar(64) NOT NULL default '', 
  `operator` char(1) NOT NULL default '+',        
  `price` varchar(64) NOT NULL default '0',
  `price_netto` varchar(64) NOT NULL default '0',
  `price_brutto` varchar(64) NOT NULL default '0',    
  `vat` int(10) unsigned NOT NULL default '19',
  `vat_incl` int(10) unsigned NOT NULL default '1',  
  `position` varchar(25) NOT NULL default '', 
  `published` char(1) NOT NULL default '',  
  PRIMARY KEY  (`id`),
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `tl_iao_reminder` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `tstamp` int(10) unsigned NOT NULL default '0',
  `title` varchar(255) NOT NULL default '',
  `text` mediumtext NULL,
  `text_finish` mediumtext NULL,
  `address_text` mediumtext NULL,
  `member` varbinary(128) NOT NULL default '',
  `invoice_id` int(10) unsigned NOT NULL default '0',
  `step` varchar(255) NOT NULL default '',  
  `status` char(1) NOT NULL default '',
  `published` char(1) NOT NULL default '', 
  `periode_date` int(10) unsigned NOT NULL default '0',
  `paid_on_date` varchar(255) NOT NULL default '',
  `unpaid` varchar(64) NOT NULL default '0',
  `sum` varchar(64) NOT NULL default '0',
  `tax` varchar(2) NOT NULL default '0',
  `tax_typ` varchar(25) NOT NULL default '',       
  `postage` varchar(25) NOT NULL default '0', 
  `notice` text NULL,    
  PRIMARY KEY  (`id`),
) ENGINE=MyISAM DEFAULT CHARSET=utf8;