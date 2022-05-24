<?php

declare(strict_types=1);

namespace Ruga\Contact\Link\Person;

/**
 * The person - contact mechanism link table.
 *
 * @author   Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 */
class PersonHasContactMechanismTable extends AbstractPersonHasContactMechanismTable
{
    const TABLENAME = 'Person_has_ContactMechanism';
    const PRIMARYKEY = ['Person_id', 'ContactMechanism_id'];
//    const RESULTSETCLASS = ;
    const ROWCLASS = PersonHasContactMechanism::class;
}
