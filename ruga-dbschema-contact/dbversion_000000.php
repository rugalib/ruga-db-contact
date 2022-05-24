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
CREATE TABLE `{$tableAddress}` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `fullname` VARCHAR(255) NULL,
  `department` VARCHAR(255) NULL DEFAULT NULL,
  `address1` VARCHAR(255) NULL DEFAULT NULL,
  `address2` VARCHAR(255) NULL DEFAULT NULL,
  `postal_code` VARCHAR(255) NULL DEFAULT NULL,
  `city` VARCHAR(255) NULL DEFAULT NULL,
  `province` VARCHAR(255) NULL DEFAULT NULL,
  `territory` VARCHAR(255) NULL DEFAULT NULL,
  `state` VARCHAR(255) NULL DEFAULT NULL,
  `country` VARCHAR(255) NULL DEFAULT NULL,
  `longitude` DECIMAL(11, 8) NULL DEFAULT NULL,
  `latitude` DECIMAL(10, 8) NULL DEFAULT NULL,
  `remark` TEXT NULL,
  `created` DATETIME NULL,
  `createdBy` INT NULL,
  `changed` DATETIME NULL,
  `changedBy` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `{$tableAddress}_fullname_idx` (`fullname`),
  INDEX `fk_{$tableAddress}_changedBy_idx` (`changedBy` ASC),
  INDEX `fk_{$tableAddress}_createdBy_idx` (`createdBy` ASC),
  CONSTRAINT `fk_{$tableAddress}_changedBy` FOREIGN KEY (`changedBy`) REFERENCES `User` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_{$tableAddress}_createdBy` FOREIGN KEY (`createdBy`) REFERENCES `User` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
)
ENGINE=InnoDB
;
SET FOREIGN_KEY_CHECKS = 1;

SQL;
