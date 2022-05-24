<?php

declare(strict_types=1);

namespace Ruga\Contact\Subtype\TelecomNumber;

use Ruga\Contact\Subtype\SubtypeAttributesInterface;

/**
 * Interface TelecomNumberAttributesInterface
 *
 * @property int    $id          Primary key
 * @property string $fullname    Full name / display name
 * @property string $number      Telecom number
 * @property string $remark      Remark
 */
interface TelecomNumberAttributesInterface extends SubtypeAttributesInterface
{
}