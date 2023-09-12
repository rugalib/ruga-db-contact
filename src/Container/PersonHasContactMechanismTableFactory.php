<?php
/*
 * SPDX-FileCopyrightText: 2023 Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 * SPDX-License-Identifier: AGPL-3.0-only
 */

declare(strict_types=1);

namespace Ruga\Contact\Container;

use Psr\Container\ContainerInterface;
use Ruga\Contact\Link\Person\AbstractPersonHasContactMechanismTable;
use Ruga\Contact\Link\Person\PersonHasContactMechanismTable;
use Ruga\Db\Adapter\Adapter;

class PersonHasContactMechanismTableFactory
{
    /**
     * Create and return a AddressTable instance.
     *
     * @return AbstractPersonHasContactMechanismTable
     * @throws \ReflectionException
     */
    public function __invoke(ContainerInterface $container): AbstractPersonHasContactMechanismTable
    {
        return new PersonHasContactMechanismTable($container->get(Adapter::class));
    }
}