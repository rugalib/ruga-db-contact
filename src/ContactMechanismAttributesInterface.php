<?php
/*
 * SPDX-FileCopyrightText: 2023 Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 * SPDX-License-Identifier: AGPL-3.0-only
 */

declare(strict_types=1);

namespace Ruga\Contact;

use Ruga\Db\Row\RowAttributesInterface;

/**
 * Interface ContactMechanismAttributesInterface
 *
 * @property int                  $id                       Primary key
 * @property string               $fullname                 Full name / display name
 * @property ContactMechanismType $contactmechanism_type    Type of contact mechanism (PHONE, MOBILE, FAX, EMAIL, ...)
 * @property string               $remark                   Remark
 */
interface ContactMechanismAttributesInterface extends RowAttributesInterface
{
    
}