<?php
/*
 * SPDX-FileCopyrightText: 2023 Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 * SPDX-License-Identifier: AGPL-3.0-only
 */

declare(strict_types=1);

namespace Ruga\Contact\Link\Party;

/**
 * The party <-> contact mechanism link table.
 *
 * @author   Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 */
class PartyHasContactMechanismTable extends AbstractPartyHasContactMechanismTable
{
    const TABLENAME = 'Party_has_ContactMechanism';
    const PRIMARYKEY = ['Party_id', 'ContactMechanism_id'];
//    const RESULTSETCLASS = ;
    const ROWCLASS = PartyHasContactMechanism::class;
}
