<?php
/*
 * SPDX-FileCopyrightText: 2023 Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 * SPDX-License-Identifier: AGPL-3.0-only
 */

declare(strict_types=1);

namespace Ruga\Contact\Subtype;

use Ruga\Db\Row\AbstractRugaRow;

abstract class AbstractSubtypeRow extends AbstractRugaRow implements SubtypeRowInterface
{
    public function setContactMechanismId($ContactMechanism_id)
    {
        $this->ContactMechanism_id = $ContactMechanism_id;
    }
}