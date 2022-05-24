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
ALTER TABLE `{$tableAddress}` ADD COLUMN `Tenant_id` INT NULL DEFAULT NULL AFTER `latitude`;
ALTER TABLE `{$tableAddress}` ADD INDEX `fk_{$tableAddress}_Tenant_id_idx` (`Tenant_id`);
# ALTER TABLE `{$tableAddress}` ADD CONSTRAINT `fk_{$tableAddress}_Tenant_id` FOREIGN KEY (`Tenant_id`) REFERENCES `Tenant` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
SET FOREIGN_KEY_CHECKS = 1;

SQL;
