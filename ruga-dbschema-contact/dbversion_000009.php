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
ALTER TABLE `{$personHasContactMechanismTable}` ADD COLUMN `emergency_contact` TINYINT NULL DEFAULT '0' AFTER `valid_thru`;
ALTER TABLE `{$partyHasContactMechanismTable}` ADD COLUMN `emergency_contact` TINYINT NULL DEFAULT '0' AFTER `valid_thru`;
SET FOREIGN_KEY_CHECKS = 1;

SQL;
