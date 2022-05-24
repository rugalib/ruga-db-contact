<?php

declare(strict_types=1);

/**
 * @return string
 * @var \Ruga\Db\Schema\Resolver $resolver
 * @var string                   $addressTable
 * @var string                   $contactMechanism
 */
$addressTable = $resolver->getTableName(\Ruga\Contact\Subtype\Address\AddressTable::class);
$contactMechanism = $resolver->getTableName(\Ruga\Contact\ContactMechanismTable::class);

return <<<"SQL"

SET FOREIGN_KEY_CHECKS = 0;
ALTER TABLE `{$addressTable}` ADD COLUMN `{$contactMechanism}_id` INT NULL DEFAULT NULL AFTER `fullname`;
ALTER TABLE `{$addressTable}` ADD INDEX `fk_{$addressTable}_ContactMechanism1_idx` (`ContactMechanism_id` ASC);
ALTER TABLE `{$addressTable}` ADD CONSTRAINT `fk_{$addressTable}_ContactMechanism1` FOREIGN KEY (`ContactMechanism_id`) REFERENCES `{$contactMechanism}` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
SET FOREIGN_KEY_CHECKS = 1;

SQL;
