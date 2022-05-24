<?php

declare(strict_types=1);

namespace Ruga\Contact\Subtype\ElectronicAddress;

/**
 * The address table.
 *
 * @author   Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 */
class ElectronicAddressTable extends AbstractElectronicAddressTable
{
    const TABLENAME = 'ElectronicAddress';
    const PRIMARYKEY = ['id'];
//    const RESULTSETCLASS = ;
    const ROWCLASS = ElectronicAddress::class;
}
