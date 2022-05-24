<?php

declare(strict_types=1);

namespace Ruga\Contact\Subtype\Address;

use Ruga\Contact\Subtype\SubtypeTableInterface;
use Ruga\Contact\Subtype\SubtypeTableTrait;

class AddressTable extends \Ruga\Contact\Address\AddressTable implements SubtypeTableInterface
{
    const ROWCLASS = Address::class;
    
    use SubtypeTableTrait;
}