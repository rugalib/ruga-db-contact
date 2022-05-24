<?php

declare(strict_types=1);

namespace Ruga\Contact;

use Ruga\Db\Schema\Updater;
use Ruga\Contact\Link\Party\PartyHasContactMechanismTable;
use Ruga\Contact\Link\Person\PersonHasContactMechanismTable;
use Ruga\Contact\Subtype\Address\AddressTable;
use Ruga\Contact\Subtype\ElectronicAddress\ElectronicAddressTable;
use Ruga\Contact\Subtype\TelecomNumber\TelecomNumberTable;
use Ruga\Contact\Container\AddressTableFactory;

class ConfigProvider
{
    public function __invoke()
    {
        return [
            'db' => [
                Updater::class => [
                    'components' => [
                        ContactMechanism::class => [
                            Updater::CONF_REQUESTED_VERSION => 12,
                            Updater::CONF_SCHEMA_DIRECTORY => __DIR__ . '/../ruga-dbschema-contact',
                            Updater::CONF_TABLES => [
                                'ContactMechanismTable' => ContactMechanismTable::class,
                                'TelecomNumberTable' => TelecomNumberTable::class,
                                'ElectronicAddressTable' => ElectronicAddressTable::class,
                                'AddressTable' => AddressTable::class,
                                'PersonHasContactMechanismTable' => PersonHasContactMechanismTable::class,
                                'PartyHasContactMechanismTable' => PartyHasContactMechanismTable::class,
                            ],
                        ],
                    ],
                ],
            ],
            'dependencies' => [
                'factories' => [
                    AddressTable::class => AddressTableFactory::class,
                ],
            ],
        ];
    }
}