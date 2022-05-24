<?php

declare(strict_types=1);

namespace Ruga\Contact\Container;

use Psr\Container\ContainerInterface;
use Ruga\Contact\Address\AddressTable;
use Ruga\Contact\Subtype\Address\AbstractAddressTable;
use Ruga\Db\Adapter\Adapter;

class AddressTableFactory
{
    /**
     * Create and return a AddressTable instance.
     *
     * @param ContainerInterface $container
     *
     * @return AbstractAddressTable
     * @throws \ReflectionException
     */
    public function __invoke(ContainerInterface $container): AbstractAddressTable
    {
        return new AddressTable($container->get(Adapter::class));
    }
}