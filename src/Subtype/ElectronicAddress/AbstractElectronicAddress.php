<?php
/*
 * SPDX-FileCopyrightText: 2023 Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 * SPDX-License-Identifier: AGPL-3.0-only
 */

declare(strict_types=1);

namespace Ruga\Contact\Subtype\ElectronicAddress;

use Ruga\Contact\Subtype\AbstractSubtypeRow;
use Ruga\Contact\Subtype\SubtypeRowInterface;

/**
 * Abstract address.
 *
 * @see      ElectronicAddress
 * @author   Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 */
abstract class AbstractElectronicAddress extends AbstractSubtypeRow implements ElectronicAddressAttributesInterface, ElectronicAddressInterface, SubtypeRowInterface
{
    /**
     * Constructs a display name from the given fields.
     * Fullname is saved in the row to speed up queries.
     *
     * @return string
     */
    public function getFullname(): string
    {
        return implode(', ', array_filter([$this->address]));
    }
    
}
