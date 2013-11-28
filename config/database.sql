-- ********************************************************
-- *                                                      *
-- * IMPORTANT NOTE                                       *
-- *                                                      *
-- * Do not import this file manually but use the Contao  *
-- * install tool to create and maintain database tables! *
-- *                                                      *
-- ********************************************************

-- update zu aelteren Versionen
-- 1.1.3
RENAME TABLE `sr-tag_contao`.`tl_iao_posten_templates` TO `sr-tag_contao`.`tl_iao_templates_items`;
UPDATE `tl_iao_offer` SET `setting_id`=1 WHERE `setting_id`=0;
UPDATE `tl_iao_invoice` SET `setting_id`=1 WHERE `setting_id`=0;
UPDATE `tl_iao_credit` SET `setting_id`=1 WHERE `setting_id`=0;

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
  `setting_id` int(10) unsigned NOT NULL default '0',
  `invoice_tstamp` int(10) unsigned NOT NULL default '0',
  `execute_date` varchar(255) NOT NULL default '',
  `expiry_date` varchar(255) NOT NULL default '',
  `remaining` varchar(64) NOT NULL default '0',
  `paid_on_dates` blob NULL,
  `paid_on_date` varchar(255) NOT NULL default '',
  `title` varchar(255) NOT NULL default '',
  `invoice_id` int(10) unsigned NOT NULL default '0',
  `invoice_id_str` varchar(255) NOT NULL default '',
  `invoice_pdf_file` varchar(255) NOT NULL default '',
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
  `agreement_id` int(10) unsigned NOT NULL default '0',
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
  `headline_to_pdf` char(1) NOT NULL default '1',
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
  `setting_id` int(10) unsigned NOT NULL default '0',
  `offer_tstamp` int(10) unsigned NOT NULL default '0',
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
  `headline_to_pdf` char(1) NOT NULL default '1',
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
  `setting_id` int(10) unsigned NOT NULL default '0',
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

CREATE TABLE `tl_iao_templates_items` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `tstamp` int(10) unsigned NOT NULL default '0',
  `headline` varchar(255) NOT NULL default '',
  `headline_to_pdf` char(1) NOT NULL default '1',
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
  `setting_id` int(10) unsigned NOT NULL default '0',
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

CREATE TABLE `tl_iao_agreements` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `tstamp` int(10) unsigned NOT NULL default '0',
  `title` varchar(255) NOT NULL default '',
  `member` varbinary(128) NOT NULL default '',
  `address_text` mediumtext NULL,
  `step` varchar(255) NOT NULL default '',
  `status` char(1) NOT NULL default '',
  `periode` varchar(255) NOT NULL default '',
  `agreement_date` int(10) unsigned NOT NULL default '0',
  `beginn_date` varchar(255) NOT NULL default '',
  `end_date` varchar(255) NOT NULL default '',
  `new_generate` char(1) NOT NULL default '',
  `terminated_date` varchar(255) NOT NULL default '',
  `price` varchar(64) NOT NULL default '0',
  `agreement_pdf_file` varchar(255) NOT NULL default '',
  `sendEmail` char(1) NOT NULL default '',
  `remind_before` varchar(32) NOT NULL default '',
  `email_from` varchar(32) NOT NULL default '',
  `email_to` varchar(32) NOT NULL default '',
  `email_subject` varchar(255) NOT NULL default '',
  `email_text` text NULL,
  `email_date` varchar(255) NOT NULL default '',
  `notice` text NULL,
  PRIMARY KEY  (`id`),
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table `tl_iso_settings`
--

CREATE TABLE `tl_iao_settings` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `tstamp` int(10) unsigned NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `fallback` char(1) NOT NULL default '',
  `iao_costumer_group` int(10) unsigned NOT NULL default '0',
  `iao_currency` varchar(10) NOT NULL default '',
  `iao_currency_symbol` varchar(10) NOT NULL default '',
  `iao_pdf_margins` varchar(255) NOT NULL default '',
  `iao_pdf_css` varchar(255) NOT NULL default '',
  `iao_invoice_mail_from` varchar(255) NOT NULL default '',
  `iao_invoice_startnumber` varchar(55) NOT NULL default '',
  `iao_invoice_number_format` varchar(55) NOT NULL default '',
  `iao_invoice_duration` int(10) unsigned NOT NULL default '14',
  `iao_invoice_pdf` varchar(255) NOT NULL default '',
  `iao_offer_mail_from` varchar(255) NOT NULL default '',
  `iao_offer_startnumber` varchar(55) NOT NULL default '',
  `iao_offer_number_format` varchar(55) NOT NULL default '',
  `iao_offer_pdf` varchar(255) NOT NULL default '',
  `iao_offer_expiry_date` varchar(55) NOT NULL default '',
  `iao_credit_mail_from` varchar(255) NOT NULL default '',
  `iao_credit_startnumber` varchar(55) NOT NULL default '',
  `iao_credit_number_format` varchar(55) NOT NULL default '',
  `iao_credit_pdf` varchar(255) NOT NULL default '',
  `iao_credit_expiry_date` varchar(55) NOT NULL default '',
  `iao_reminder_1_duration` varchar(55) NOT NULL default '',
  `iao_reminder_1_tax` varchar(55) NOT NULL default '',
  `iao_reminder_1_postage` varchar(55) NOT NULL default '',
  `iao_reminder_1_text` text NULL,
  `iao_reminder_1_pdf` varchar(255) NOT NULL default '',
  `iao_reminder_2_duration` varchar(55) NOT NULL default '',
  `iao_reminder_2_tax` varchar(55) NOT NULL default '',
  `iao_reminder_2_postage` varchar(55) NOT NULL default '',
  `iao_reminder_2_text` text NULL,
  `iao_reminder_2_pdf` varchar(255) NOT NULL default '',
  `iao_reminder_3_duration` varchar(55) NOT NULL default '',
  `iao_reminder_3_tax` varchar(55) NOT NULL default '',
  `iao_reminder_3_postage` varchar(55) NOT NULL default '',
  `iao_reminder_3_text` text NULL,
  `iao_reminder_3_pdf` varchar(255) NOT NULL default '',
  `iao_reminder_4_duration` varchar(55) NOT NULL default '',
  `iao_reminder_4_tax` varchar(55) NOT NULL default '',
  `iao_reminder_4_postage` varchar(55) NOT NULL default '',
  `iao_reminder_4_text` text NULL,
  `iao_reminder_4_pdf` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `tl_iao_tax_rates` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `tstamp` int(10) unsigned NOT NULL default '0',
  `sorting` int(10) unsigned NOT NULL default '0',
  `name` varchar(125) NOT NULL default '',
  `value` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `tl_iao_item_units` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `tstamp` int(10) unsigned NOT NULL default '0',
  `sorting` int(10) unsigned NOT NULL default '0',
  `name` varchar(25) NOT NULL default '',
  `singular` varchar(25) NOT NULL default '',
  `majority` varchar(25) NOT NULL default '',
  `value` varchar(25) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
