<?php

declare(strict_types=1);

namespace Ruga\Contact\Subtype\Address;

use Ruga\Contact\Subtype\SubtypeTableInterface;
use Ruga\Contact\Subtype\SubtypeTableTrait;

class AddressTable extends AbstractAddressTable implements SubtypeTableInterface
{
    const TABLENAME = 'Address';
    const PRIMARYKEY = ['id'];
//    const RESULTSETCLASS = ;
    const ROWCLASS = Address::class;
    
    use SubtypeTableTrait;
}