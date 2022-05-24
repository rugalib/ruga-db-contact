<?php

declare(strict_types=1);

/**
 * @return string
 * @var \Ruga\Db\Schema\Resolver $resolver
 * @var string                   $addressTable
 * @var string                   $telecomNumberTable
 * @var string                   $electronicAddressTable
 * @var string                   $contactMechanismTable
 * @var string                   $partyHasContactMechanismTable
 * @var string                   $personHasContactMechanismTable
 */
$addressTable = $resolver->getTableName(\Ruga\Contact\Subtype\Address\AddressTable::class);
$telecomNumberTable = $resolver->getTableName(\Ruga\Contact\Subtype\TelecomNumber\TelecomNumberTable::class);
$electronicAddressTable = $resolver->getTableName(\Ruga\Contact\Subtype\ElectronicAddress\ElectronicAddressTable::class);
$contactMechanismTable = $resolver->getTableName(\Ruga\Contact\ContactMechanismTable::class);
$partyHasContactMechanismTable = $resolver->getTableName(\Ruga\Contact\Link\Party\PartyHasContactMechanismTable::class);
$personHasContactMechanismTable = $resolver->getTableName(\Ruga\Contact\Link\Person\PersonHasContactMechanismTable::class);

return <<<"SQL"

SET FOREIGN_KEY_CHECKS = 0;
CREATE TABLE `{$telecomNumberTable}` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `{$contactMechanismTable}_id` INT NULL DEFAULT NULL,
  `number` VARCHAR(190) NOT NULL,
  `remark` TEXT NULL,
  `created` DATETIME NOT NULL,
  `createdBy` INT NOT NULL,
  `changed` DATETIME NOT NULL,
  `changedBy` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_{$telecomNumberTable}_{$contactMechanismTable}1_idx` (`{$contactMechanismTable}_id` ASC),
  INDEX `fk_{$telecomNumberTable}_changedBy_idx` (`changedBy` ASC),
  INDEX `fk_{$telecomNumberTable}_createdBy_idx` (`createdBy` ASC),
  CONSTRAINT `fk_{$telecomNumberTable}_{$contactMechanismTable}1` FOREIGN KEY (`{$contactMechanismTable}_id`) REFERENCES `{$contactMechanismTable}` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_{$telecomNumberTable}_changedBy` FOREIGN KEY (`changedBy`) REFERENCES `User` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_{$telecomNumberTable}_createdBy` FOREIGN KEY (`createdBy`) REFERENCES `User` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
)
ENGINE = InnoDB
;
SET FOREIGN_KEY_CHECKS = 1;

SQL;
