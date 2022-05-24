<?php

declare(strict_types=1);

namespace Ruga\Contact\Container;

use Psr\Container\ContainerInterface;
use Ruga\Db\Adapter\Adapter;
use Ruga\Contact\AbstractContactMechanismTable;
use Ruga\Contact\ContactMechanismTable;

class ContactMechanismTableFactory
{
    /**
     * Create and return a AddressTable instance.
     *
     * @param ContainerInterface $container
     *
     * @return AbstractContactMechanismTable
     * @throws \ReflectionException
     */
    public function __invoke(ContainerInterface $container): AbstractContactMechanismTable
    {
        return new ContactMechanismTable($container->get(Adapter::class));
    }
}