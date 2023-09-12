<?php
/*
 * SPDX-FileCopyrightText: 2023 Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 * SPDX-License-Identifier: AGPL-3.0-only
 */

declare(strict_types=1);

namespace Ruga\Contact\Container;

use Psr\Container\ContainerInterface;
use Ruga\Contact\Subtype\Address\AbstractAddressTable;
use Ruga\Contact\Subtype\Address\AddressTable;
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