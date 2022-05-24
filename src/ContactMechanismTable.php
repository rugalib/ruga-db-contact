<?php

declare(strict_types=1);

namespace Ruga\Contact;

/**
 * The address table.
 *
 * @author Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 */
class ContactMechanismTable extends AbstractContactMechanismTable
{
    const TABLENAME = 'ContactMechanism';
    const PRIMARYKEY = ['id'];
//    const RESULTSETCLASS = ;
    const ROWCLASS = ContactMechanism::class;
}
