<?php
/*
 * SPDX-FileCopyrightText: 2023 Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 * SPDX-License-Identifier: AGPL-3.0-only
 */

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
ALTER TABLE `{$addressTable}` ADD COLUMN `Tenant_id` INT NULL DEFAULT NULL AFTER `latitude`;
ALTER TABLE `{$addressTable}` ADD INDEX `fk_{$addressTable}_Tenant_id_idx` (`Tenant_id`);
# ALTER TABLE `{$addressTable}` ADD CONSTRAINT `fk_{$addressTable}_Tenant_id` FOREIGN KEY (`Tenant_id`) REFERENCES `Tenant` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
SET FOREIGN_KEY_CHECKS = 1;

SQL;
