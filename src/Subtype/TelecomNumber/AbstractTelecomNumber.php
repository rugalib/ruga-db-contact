<?php

declare(strict_types=1);

namespace Ruga\Contact\Subtype\TelecomNumber;

use Ruga\Contact\Subtype\AbstractSubtypeRow;
use Ruga\Contact\Subtype\SubtypeRowInterface;

/**
 * Abstract address.
 *
 * @see      ContactMechanism
 * @author   Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 */
abstract class AbstractTelecomNumber extends AbstractSubtypeRow implements TelecomNumberInterface, SubtypeRowInterface
{
    /**
     * Constructs a display name from the given fields.
     * Fullname is saved in the row to speed up queries.
     *
     * @return string
     */
    public function getFullname(): string
    {
        return implode(', ', array_filter([$this->number]));
    }
    
}
