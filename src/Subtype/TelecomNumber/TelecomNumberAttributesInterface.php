<?php
/*
 * SPDX-FileCopyrightText: 2023 Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 * SPDX-License-Identifier: AGPL-3.0-only
 */

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