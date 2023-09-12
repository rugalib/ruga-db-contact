<?php
/*
 * SPDX-FileCopyrightText: 2023 Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 * SPDX-License-Identifier: AGPL-3.0-only
 */

declare(strict_types=1);

namespace Ruga\Contact\Link;

use Ruga\Contact\ContactMechanism;
use Ruga\Contact\ContactMechanismAttributesInterface;
use Ruga\Contact\ContactMechanismType;
use Ruga\Db\ResultSet\ResultSet;

/**
 * Interface ContactMechanismCapableObjectInterface. The object implementing this interface is capable of storing
 * contact mechanisms.
 */
interface ContactMechanismCapableObjectInterface
{
    /**
     * Register the contact mechanism to the object, so that the object can save the contect mechanism later.
     *
     * @param ContactMechanism $contactMechanism
     *
     * @return void
     */
    public function registerContactMechanismForSave(ContactMechanism $contactMechanism);
    
    
    
    /**
     * Create a contact mechanism of the given type and register it to the object.
     *
     * @param ContactMechanismType $contactMechanismType
     *
     * @return ContactMechanism
     */
    public function createContactMechanism(ContactMechanismType $contactMechanismType): ContactMechanism;
    
    
}