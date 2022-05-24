<?php

declare(strict_types=1);

namespace Ruga\Contact\Subtype\ElectronicAddress;

use Ruga\Contact\Subtype\AbstractSubtypeTable;
use Ruga\Contact\Subtype\SubtypeTableInterface;
use Ruga\Contact\Subtype\SubtypeTableTrait;

abstract class AbstractElectronicAddressTable extends AbstractSubtypeTable implements SubtypeTableInterface
{
    use SubtypeTableTrait;
}