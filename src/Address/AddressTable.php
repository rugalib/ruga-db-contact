<?php

declare(strict_types=1);

namespace Ruga\Contact\Address;

/**
 * The address table.
 *
 * @author   Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 */
class AddressTable extends AbstractAddressTable
{
    const TABLENAME = 'Address';
    const PRIMARYKEY = ['id'];
//    const RESULTSETCLASS = ;
    const ROWCLASS = Address::class;
}
