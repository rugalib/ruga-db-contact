<?php

declare(strict_types=1);

namespace Ruga\Contact\Subtype;

use Ruga\Contact\AbstractContactMechanism;

interface SubtypeTableInterface
{
    /**
     * Find the subtype row associated to the contact mechanism.
     * If the row does not exist, create a new one.
     *
     * @param AbstractContactMechanism $contactMechanism
     *
     * @return SubtypeRowInterface|\Ruga\Db\Row\RowInterface
     * @throws \ReflectionException
     */
    public function findOrCreateRowByContactMechanism(AbstractContactMechanism $contactMechanism): SubtypeRowInterface;
}