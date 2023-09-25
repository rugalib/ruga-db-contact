<?php
/*
 * SPDX-FileCopyrightText: 2023 Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 * SPDX-License-Identifier: AGPL-3.0-only
 */

declare(strict_types=1);

namespace Ruga\Contact\Link;

use Ruga\Contact\ContactMechanism;
use Ruga\Contact\ContactMechanismTable;
use Ruga\Contact\ContactMechanismType;
use Ruga\Db\Row\AbstractRow;

/**
 * Trait ContactMechanismCapableObjectTrait
 *
 * @see     ContactMechanismCapableObjectInterface
 * @deprecated Does no longer work. Use manyToMany, Child or Parent feature.
 */
trait ContactMechanismCapableObjectTrait
{
    /** @var ContactMechanism[] */
    private $contactMechanismRegistry = [];
    
    
    
    /**
     * Create a contact mechanism of the given type and register it to the object.
     *
     * @param ContactMechanismType $contactMechanismType
     *
     * @return ContactMechanism
     * @throws \ReflectionException
     */
    public function createContactMechanism(ContactMechanismType $contactMechanismType): ContactMechanism
    {
        /** @var AbstractRow $this */
        /** @var ContactMechanism $contactMechanism */
        $contactMechanism = (new ContactMechanismTable($this->getTableGateway()->getAdapter()))->createRow();
        $contactMechanism->contactmechanism_type = $contactMechanismType;
        $contactMechanism->linkTo($this);
        return $contactMechanism;
    }
    
    
    
    /**
     * Register the contact mechanism to the object, so that the object can save the contect mechanism later.
     *
     * @param ContactMechanism $contactMechanism
     *
     * @return void
     */
    public function registerContactMechanismForSave(ContactMechanism $contactMechanism)
    {
        $this->contactMechanismRegistry[] = $contactMechanism;
    }
    
    
    
    /**
     * Persist all the registered contact mechanisms.
     *
     * @throws \Exception
     */
    protected function saveRegisteredContactMechanisms()
    {
        foreach ($this->contactMechanismRegistry as $contactMechanism) {
            $contactMechanism->save();
        }
    }
    
}