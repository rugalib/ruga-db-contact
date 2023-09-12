<?php
/*
 * SPDX-FileCopyrightText: 2023 Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 * SPDX-License-Identifier: AGPL-3.0-only
 */

declare(strict_types=1);

namespace Ruga\Contact\Link\Person;

use Ruga\Contact\Link\AbstractLinkContactMechanismAttributesInterface;

/**
 * Interface PersonHasContactMechanismAttributesInterface
 *
 * @property int $Person_id                       Primary key / foreign key to Person
 */
interface PersonHasContactMechanismAttributesInterface extends AbstractLinkContactMechanismAttributesInterface
{
    
}