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
RENAME TABLE `tl_iao_posten_templates` TO `tl_iao_templates_items`;

UPDATE `tl_iao_offer` SET `setting_id`=1 WHERE `setting_id`=0;
UPDATE `tl_iao_invoice` SET `setting_id`=1 WHERE `setting_id`=0;
UPDATE `tl_iao_credit` SET `setting_id`=1 WHERE `setting_id`=0;

INSERT INTO `tl_iao_item_units` (`id`, `tstamp`, `sorting`, `name`, `singular`, `majority`, `value`) VALUES
(3, 1385626569, 4, 'Stunde&#40;n&#41;', 'Stunde', 'Stunden', 'hour'),
(4, 1385626499, 3, 'Tag&#40;e&#41;', 'Tag', 'Tage', 'days'),
(5, 1385626455, 1, 'Stück&#40;e&#41;', 'Stück', 'Stücke', 'piece'),
(6, 1385626476, 2, 'Pauschale', 'Pauschale', 'Pauschalen', 'flaterate'),
(7, 1385626562, 5, 'Minute&#40;n&#41;', 'Minute', 'Minuten', 'minutes'),
(8, 1385626591, 6, 'Jahr&#40;e&#41;', 'Jahr', 'Jahre', 'year'),
(9, 1385626422, 0, '--', '', '', '');

INSERT INTO `tl_iao_tax_rates` (`id`, `tstamp`, `name`, `value`, `sorting`) VALUES
(4, 1385626949, '19% Umsatzsteuer', 19, 0),
(5, 1385626956, '7% Umsatzsteuer', 7, 1),
(6, 1385626962, 'keine Umsatzsteuer', 0, 2);
