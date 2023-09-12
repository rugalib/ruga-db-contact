<?php
/*
 * SPDX-FileCopyrightText: 2023 Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 * SPDX-License-Identifier: AGPL-3.0-only
 */

declare(strict_types=1);

namespace Ruga\Contact\Link\Party;

/**
 * Links a party to a contact mechanism
 * Can be used in ruga projects to add a general ContactMechanism entity.
 *
 * @author   Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 */
class PartyHasContactMechanism extends AbstractPartyHasContactMechanism implements PartyHasContactMechanismInterface
{
}
