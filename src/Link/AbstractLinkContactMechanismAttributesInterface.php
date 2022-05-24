<?php

declare(strict_types=1);

namespace Ruga\Contact\Link;

use Ruga\Db\Row\RowAttributesInterface;

/**
 * Interface AbstractLinkContactMechanismAttributesInterface
 *
 * @property int                $Object_id                       Primary key / foreign key to the linked object
 * @property int                $ContactMechanism_id             Primary key / foreign key to ContactMechanism
 * @property \DateTimeImmutable $valid_from                      Valid from
 * @property \DateTimeImmutable $valid_thru                      Valid thru
 * @property int                $emergency_contact               Is emergency contact
 * @property string             $remark                          Remark
 */
interface AbstractLinkContactMechanismAttributesInterface extends RowAttributesInterface
{
    
}