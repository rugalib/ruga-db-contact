<?php

declare(strict_types=1);

namespace Ruga\Contact\Subtype\TelecomNumber;

use Ruga\Contact\Subtype\AbstractSubtypeTable;
use Ruga\Contact\Subtype\SubtypeTableInterface;
use Ruga\Contact\Subtype\SubtypeTableTrait;

abstract class AbstractTelecomNumberTable extends AbstractSubtypeTable implements SubtypeTableInterface
{
    use SubtypeTableTrait;
}