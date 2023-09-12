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
CREATE TABLE `{$addressTable}` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `fullname` VARCHAR(190) NULL,
  `department` VARCHAR(190) NULL DEFAULT NULL,
  `address1` VARCHAR(190) NULL DEFAULT NULL,
  `address2` VARCHAR(190) NULL DEFAULT NULL,
  `postal_code` VARCHAR(190) NULL DEFAULT NULL,
  `city` VARCHAR(190) NULL DEFAULT NULL,
  `province` VARCHAR(190) NULL DEFAULT NULL,
  `territory` VARCHAR(190) NULL DEFAULT NULL,
  `state` VARCHAR(190) NULL DEFAULT NULL,
  `country` VARCHAR(190) NULL DEFAULT NULL,
  `longitude` DECIMAL(11, 8) NULL DEFAULT NULL,
  `latitude` DECIMAL(10, 8) NULL DEFAULT NULL,
  `remark` TEXT NULL,
  `created` DATETIME NULL,
  `createdBy` INT NULL,
  `changed` DATETIME NULL,
  `changedBy` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `{$addressTable}_fullname_idx` (`fullname`),
  INDEX `fk_{$addressTable}_changedBy_idx` (`changedBy` ASC),
  INDEX `fk_{$addressTable}_createdBy_idx` (`createdBy` ASC),
  CONSTRAINT `fk_{$addressTable}_changedBy` FOREIGN KEY (`changedBy`) REFERENCES `User` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_{$addressTable}_createdBy` FOREIGN KEY (`createdBy`) REFERENCES `User` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
)
ENGINE=InnoDB
;
SET FOREIGN_KEY_CHECKS = 1;

SQL;
