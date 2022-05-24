<?php

declare(strict_types=1);

namespace Ruga\Contact\Address;

use Ruga\Db\Row\AbstractRugaRow;
use Ruga\Db\Row\Feature\FullnameFeatureRowInterface;

/**
 * Abstract address.
 *
 * @see      Address
 * @author   Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 */
abstract class AbstractAddress extends AbstractRugaRow implements AddressInterface, FullnameFeatureRowInterface
{
    /**
     * Constructs a display name from the given fields.
     * Fullname is saved in the row to speed up queries.
     *
     * @return string
     */
    public function getFullname(): string
    {
        return implode(', ', array_filter([$this->address1, $this->address2, $this->city]));
    }
    
    
    
    /**
     * @param $ContactMechanism_id
     *
     * @deprecated
     */
    public function setContactMechanismId($ContactMechanism_id)
    {
        $this->ContactMechanism_id = $ContactMechanism_id;
    }
    
    
}
