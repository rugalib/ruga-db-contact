<?php

declare(strict_types=1);

namespace Ruga\Contact;

use Ruga\Db\Schema\Updater;
use Ruga\Contact\Address\Address;
use Ruga\Contact\Address\AddressTable;
use Ruga\Contact\Container\AddressTableFactory;

class ConfigProvider
{
    public function __invoke()
    {
        return [
            'db' => [
                Updater::class => [
                    'components' => [
                        Address::class => [
                            Updater::CONF_REQUESTED_VERSION => 3,
                            Updater::CONF_SCHEMA_DIRECTORY => __DIR__ . '/../ruga-dbschema-contact',
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