<?php

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