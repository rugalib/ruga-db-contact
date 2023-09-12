<?php
/*
 * SPDX-FileCopyrightText: 2023 Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 * SPDX-License-Identifier: AGPL-3.0-only
 */

declare(strict_types=1);

namespace Ruga\Contact\Link\Party;

use Ruga\Contact\Link\AbstractLinkContactMechanismAttributesInterface;

/**
 * Interface PartyHasContactMechanismAttributesInterface
 *
 * @property int $Party_id                        Primary key / foreign key to Party
 */
interface PartyHasContactMechanismAttributesInterface extends AbstractLinkContactMechanismAttributesInterface
{
    
}