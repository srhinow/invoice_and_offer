-- ********************************************************
-- *                                                      *
-- * IMPORTANT NOTE                                       *
-- *                                                      *
-- * Do not import this file manually but use the Contao  *
-- * install tool to create and maintain database tables! *
-- *                                                      *
-- ********************************************************


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
  `iao_pdf_css` binary(16) NULL,
  `iao_invoice_mail_from` varchar(255) NOT NULL default '',
  `iao_invoice_startnumber` varchar(55) NOT NULL default '',
  `iao_invoice_number_format` varchar(55) NOT NULL default '',
  `iao_invoice_duration` int(10) unsigned NOT NULL default '14',
  `iao_invoice_pdf` binary(16) NULL,
  `iao_offer_mail_from` varchar(255) NOT NULL default '',
  `iao_offer_startnumber` varchar(55) NOT NULL default '',
  `iao_offer_number_format` varchar(55) NOT NULL default '',
  `iao_offer_pdf` binary(16) NULL,
  `iao_offer_expiry_date` varchar(55) NOT NULL default '',
  `iao_credit_mail_from` varchar(255) NOT NULL default '',
  `iao_credit_startnumber` varchar(55) NOT NULL default '',
  `iao_credit_number_format` varchar(55) NOT NULL default '',
  `iao_credit_pdf` binary(16) NULL,
  `iao_credit_expiry_date` varchar(55) NOT NULL default '',
  `iao_reminder_1_duration` varchar(55) NOT NULL default '',
  `iao_reminder_1_tax` varchar(55) NOT NULL default '',
  `iao_reminder_1_postage` varchar(55) NOT NULL default '',
  `iao_reminder_1_text` text NULL,
  `iao_reminder_1_pdf` binary(16) NULL,
  `iao_reminder_2_duration` varchar(55) NOT NULL default '',
  `iao_reminder_2_tax` varchar(55) NOT NULL default '',
  `iao_reminder_2_postage` varchar(55) NOT NULL default '',
  `iao_reminder_2_text` text NULL,
  `iao_reminder_2_pdf` binary(16) NULL,
  `iao_reminder_3_duration` varchar(55) NOT NULL default '',
  `iao_reminder_3_tax` varchar(55) NOT NULL default '',
  `iao_reminder_3_postage` varchar(55) NOT NULL default '',
  `iao_reminder_3_text` text NULL,
  `iao_reminder_3_pdf` binary(16) NULL,
  `iao_reminder_4_duration` varchar(55) NOT NULL default '',
  `iao_reminder_4_tax` varchar(55) NOT NULL default '',
  `iao_reminder_4_postage` varchar(55) NOT NULL default '',
  `iao_reminder_4_text` text NULL,
  `iao_reminder_4_pdf` binary(16) NULL,
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


