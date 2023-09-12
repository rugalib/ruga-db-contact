<?php
/*
 * SPDX-FileCopyrightText: 2023 Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 * SPDX-License-Identifier: AGPL-3.0-only
 */

declare(strict_types=1);

namespace Ruga\Contact\Subtype\ElectronicAddress;

use Ruga\Contact\Subtype\SubtypeAttributesInterface;

/**
 * Interface ElectronicAddressAttributesInterface
 *
 * @property int    $id          Primary key
 * @property string $fullname    Full name / display name
 * @property string $address     Electronic address
 * @property string $remark      Remark
 */
interface ElectronicAddressAttributesInterface extends SubtypeAttributesInterface
{
}