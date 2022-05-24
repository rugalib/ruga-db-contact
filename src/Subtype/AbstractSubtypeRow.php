<?php

declare(strict_types=1);

namespace Ruga\Contact\Subtype;

use Ruga\Db\Row\AbstractRugaRow;

abstract class AbstractSubtypeRow extends AbstractRugaRow implements SubtypeRowInterface
{
    public function setContactMechanismId($ContactMechanism_id)
    {
        $this->ContactMechanism_id = $ContactMechanism_id;
    }
}