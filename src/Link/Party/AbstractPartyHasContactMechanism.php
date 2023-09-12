<?php
/*
 * SPDX-FileCopyrightText: 2023 Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 * SPDX-License-Identifier: AGPL-3.0-only
 */

declare(strict_types=1);

namespace Ruga\Contact\Link\Party;

use Ruga\Contact\Link\AbstractLinkContactMechanism;
use Ruga\Party\Link\Person\PartyHasPersonAttributesInterface;

/**
 * Abstract party <-> contact mechanism link.
 *
 * @see      PartyHasContactMechanism
 * @author   Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 */
abstract class AbstractPartyHasContactMechanism extends AbstractLinkContactMechanism implements
    PartyHasPersonAttributesInterface,
    PartyHasContactMechanismInterface
{
}
