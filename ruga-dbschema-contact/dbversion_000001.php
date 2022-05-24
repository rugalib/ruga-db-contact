<?php

declare(strict_types=1);

/**
 * @return string
 * @var \Ruga\Db\Schema\Resolver $resolver
 * @var string                   $tableAddress
 */
$tableAddress = \Ruga\Contact\Address\AddressTable::TABLENAME;

return <<<"SQL"

SET FOREIGN_KEY_CHECKS = 0;
ALTER TABLE `{$tableAddress}` ADD COLUMN `ContactMechanism_id` INT NULL DEFAULT NULL AFTER `fullname`;
ALTER TABLE `{$tableAddress}` ADD INDEX `fk_{$tableAddress}_ContactMechanism1_idx` (`ContactMechanism_id` ASC);
ALTER TABLE `{$tableAddress}` ADD CONSTRAINT `fk_{$tableAddress}_ContactMechanism1` FOREIGN KEY (`ContactMechanism_id`) REFERENCES `ContactMechanism` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
SET FOREIGN_KEY_CHECKS = 1;

SQL;
