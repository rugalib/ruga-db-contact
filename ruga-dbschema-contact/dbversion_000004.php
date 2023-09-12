<?php
/*
 * SPDX-FileCopyrightText: 2023 Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 * SPDX-License-Identifier: AGPL-3.0-only
 */

declare(strict_types=1);

/**
 * @return string
 * @var \Ruga\Db\Schema\Resolver $resolver
 * @var string                   $personTable
 * @var string                   $addressTable
 * @var string                   $telecomNumberTable
 * @var string                   $electronicAddressTable
 * @var string                   $contactMechanismTable
 * @var string                   $partyHasContactMechanismTable
 * @var string                   $personHasContactMechanismTable
 */
$personTable = $resolver->getTableName(\Ruga\Person\PersonTable::class);
$addressTable = $resolver->getTableName(\Ruga\Contact\Subtype\Address\AddressTable::class);
$telecomNumberTable = $resolver->getTableName(\Ruga\Contact\Subtype\TelecomNumber\TelecomNumberTable::class);
$electronicAddressTable = $resolver->getTableName(\Ruga\Contact\Subtype\ElectronicAddress\ElectronicAddressTable::class);
$contactMechanismTable = $resolver->getTableName(\Ruga\Contact\ContactMechanismTable::class);
$partyHasContactMechanismTable = $resolver->getTableName(\Ruga\Contact\Link\Party\PartyHasContactMechanismTable::class);
$personHasContactMechanismTable = $resolver->getTableName(\Ruga\Contact\Link\Person\PersonHasContactMechanismTable::class);

return <<<"SQL"

SET FOREIGN_KEY_CHECKS = 0;
CREATE TABLE `{$personHasContactMechanismTable}` (
  `{$personTable}_id` INT NOT NULL,
  `{$contactMechanismTable}_id` INT NOT NULL,
  `valid_from` DATETIME NULL DEFAULT NULL,
  `valid_thru` DATETIME NULL DEFAULT NULL,
  `remark` TEXT NULL,
  `created` DATETIME NOT NULL,
  `createdBy` INT NOT NULL,
  `changed` DATETIME NOT NULL,
  `changedBy` INT NOT NULL,
  PRIMARY KEY (`{$personTable}_id`, `{$contactMechanismTable}_id`),
  INDEX `fk_{$personHasContactMechanismTable}_{$personTable}1_idx` (`{$personTable}_id` ASC),
  INDEX `fk_{$personHasContactMechanismTable}_{$contactMechanismTable}1_idx` (`{$contactMechanismTable}_id` ASC),
  INDEX `fk_{$personHasContactMechanismTable}_changedBy_idx` (`changedBy` ASC),
  INDEX `fk_{$personHasContactMechanismTable}_createdBy_idx` (`createdBy` ASC),
  CONSTRAINT `fk_{$personHasContactMechanismTable}_{$personTable}1` FOREIGN KEY (`{$personTable}_id`) REFERENCES `{$personTable}` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT ,
  CONSTRAINT `fk_{$personHasContactMechanismTable}_{$contactMechanismTable}1` FOREIGN KEY (`{$contactMechanismTable}_id`) REFERENCES `{$contactMechanismTable}` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_{$personHasContactMechanismTable}_changedBy` FOREIGN KEY (`changedBy`) REFERENCES `User` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_{$personHasContactMechanismTable}_createdBy` FOREIGN KEY (`createdBy`) REFERENCES `User` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
)
ENGINE = InnoDB
;
SET FOREIGN_KEY_CHECKS = 1;

SQL;
