<?php

declare(strict_types=1);

namespace Ruga\Contact;

use Ruga\Contact\Link\AbstractLinkContactMechanism;

/**
 * Interface to a ContactMechanism.
 *
 * @see      ContactMechanism
 * @author   Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 */
interface ContactMechanismInterface
{
    /**
     * Link the given $obj to the contact mechanism.
     *
     * @param $obj
     *
     * @return AbstractLinkContactMechanism
     * @throws \ReflectionException
     */
    public function linkTo($obj): AbstractLinkContactMechanism;
    
    
    
    /**
     * Get the link object instance.
     *
     * @return AbstractLinkContactMechanism
     * @throws \Exception
     */
    public function getLinkObj(): AbstractLinkContactMechanism;
    
    
    
    /**
     * Checks if this contact mechanism is archived at the time of $keydate. A contact mechanism is considered as
     * archived, if valid_thru is earlier than the $keydate.
     *
     * @param \DateTimeImmutable|null $keydate
     *
     * @return bool
     * @throws \Exception
     */
    public function isArchived(\DateTimeImmutable $keydate = null): bool;

}
