<?php
/*
 * SPDX-FileCopyrightText: 2023 Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 * SPDX-License-Identifier: AGPL-3.0-only
 */

declare(strict_types=1);

namespace Ruga\Contact;

use Ruga\Contact\Link\AbstractLinkContactMechanism;
use Ruga\Contact\Link\AbstractLinkContactMechanismAttributesInterface;
use Ruga\Contact\Link\ContactMechanismCapableObjectInterface;
use Ruga\Contact\Link\Party\PartyHasContactMechanismAttributesInterface;
use Ruga\Contact\Link\Party\PartyHasContactMechanismTable;
use Ruga\Contact\Link\Person\PersonHasContactMechanismAttributesInterface;
use Ruga\Contact\Link\Person\PersonHasContactMechanismTable;
use Ruga\Contact\Subtype\AbstractSubtypeRow;
use Ruga\Contact\Subtype\AbstractSubtypeTable;
use Ruga\Contact\Subtype\Address\Address;
use Ruga\Contact\Subtype\Address\AddressAttributesInterface;
use Ruga\Contact\Subtype\ElectronicAddress\ElectronicAddress;
use Ruga\Contact\Subtype\ElectronicAddress\ElectronicAddressAttributesInterface;
use Ruga\Contact\Subtype\SubtypeRowInterface;
use Ruga\Contact\Subtype\TelecomNumber\TelecomNumber;
use Ruga\Contact\Subtype\TelecomNumber\TelecomNumberAttributesInterface;
use Ruga\Db\Row\AbstractRow;
use Ruga\Db\Row\AbstractRugaRow;
use Ruga\Party\Party;
use Ruga\Party\PartyTable;
use Ruga\Person\Person;
use Ruga\Person\PersonTable;

/**
 * Abstract address.
 *
 * @see      ContactMechanism
 * @author   Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 */
abstract class AbstractContactMechanism extends AbstractRugaRow implements ContactMechanismAttributesInterface,
                                                                           AbstractLinkContactMechanismAttributesInterface,
                                                                           PartyHasContactMechanismAttributesInterface,
                                                                           PersonHasContactMechanismAttributesInterface,
                                                                           AddressAttributesInterface,
                                                                           ElectronicAddressAttributesInterface,
                                                                           TelecomNumberAttributesInterface,
                                                                           ContactMechanismInterface
{
    
    private ?AbstractContactMechanism $prevClone = null;
    
    
    
    /**
     * Returns the subtype object. The subtype object is a concrete subtype row like an address, electronic address or
     * a telecom number.
     *
     * @return SubtypeRowInterface|AbstractSubtypeRow|Address|TelecomNumber|ElectronicAddress
     * @throws \ReflectionException
     */
    public function getSubtype(): SubtypeRowInterface
    {
        if (!ContactMechanismType::isValidValue($this->contactmechanism_type)) {
            throw new Exception\IllegalContactmechanismTypeException(
                "'{$this->contactmechanism_type}' is not a valid contact mechanism type."
            );
        }
        
        $subtypeClassName = null;
        foreach (ContactMechanismType::getObjects() as $object) {
            if ($object->val == $this->contactmechanism_type) {
                $subtypeClassName = $object->subtypeTableClass;
            }
        }
        
        if (!$subtypeClassName) {
            throw new Exception\IllegalContactmechanismTypeException(
                "No class found for contactmechanism_type={$this->contactmechanism_type}."
            );
        }
        
        /** @var AbstractSubtypeTable $subtypetable */
        $subtypetable = new $subtypeClassName($this->getTableGateway()->getAdapter());
        $subtype = $subtypetable->findOrCreateRowByContactMechanism($this);
        
        return $subtype;
    }
    
    
    
    /**
     * Constructs a display name from the given fields.
     * Fullname is saved in the row to speed up queries.
     *
     * @return string
     * @throws \Exception
     */
    public function getFullname(): string
    {
        return implode(': ', array_filter([$this->contactmechanism_type, $this->getSubtype()->getFullname()]));
    }
    
    
    
    /**
     * Link the contact mechanism to the given $obj.
     *
     * @param $obj
     *
     * @return AbstractLinkContactMechanism iRow
     * @throws \ReflectionException|\Exception
     */
    public function linkTo($obj): AbstractLinkContactMechanism
    {
        if ($obj instanceof ContactMechanismCapableObjectInterface) {
            $obj->registerContactMechanismForSave($this);
            return $this->getLinkedEntityIntersection();
        }
        
        if ($obj instanceof Party) {
            $this->linkManyToManyRow($obj, PartyHasContactMechanismTable::class);
            return $this->getLinkedEntityIntersection();
        }
        
        if ($obj instanceof Person) {
            $this->linkManyToManyRow($obj, PersonHasContactMechanismTable::class);
            return $this->getLinkedEntityIntersection();
        }
        
        throw new Exception\IllegalLinkedEntityException(
            "Can not link unknown entity '" . get_class($obj) . "' to contact mechanism."
        );
    }
    
    
    
    /**
     * Unlinks the contactmechanism from the object (person/organization).
     * This should typically not be used in a real world environment. It allows the deletion of
     * the contactmechanism row, which is not recommended. Normal use would be to just "delete" the record and let
     * the library set a valid_thru date.
     *
     * @param $obj
     *
     * @throws \Exception
     * @see        AbstractContactMechanism::delete()
     * @deprecated This should typically not be used in a real world environment.
     */
    public function unlinkFrom($obj)
    {
        if ($obj instanceof Party) {
            if ($iRow = $this->findIntersectionRows($obj, PartyHasContactMechanismTable::class)->current()) {
                $this->unlinkManyToManyRow($obj, PartyHasContactMechanismTable::class);
                $iRow->delete();
            }
        } elseif ($obj instanceof Person) {
            if ($iRow = $this->findIntersectionRows($obj, PersonHasContactMechanismTable::class)->current()) {
                $this->unlinkManyToManyRow($obj, PersonHasContactMechanismTable::class);
                $iRow->delete();
            }
        } else {
            throw new Exception\IllegalLinkedEntityException(
                "Can not unlink from unknown entity '" . get_class($obj) . "'"
            );
        }
    }
    
    
    
    /**
     * Return the PARTY or PERSON the contact mechanism is linked to.
     *
     * @return AbstractRow
     * @deprecated Use \Ruga\Contact\AbstractContactMechanism::getLinkedEntity()
     */
    public function getLinkTo(): ?AbstractRow
    {
        return $this->getLinkedEntity();
    }
    
    
    
    /**
     * Return the PARTY or PERSON the contact mechanism is linked to.
     *
     * @return AbstractRow
     */
    public function getLinkedEntity(): ?AbstractRow
    {
        if ($party = $this->findManyToManyRowset(PartyTable::class, PartyHasContactMechanismTable::class)->current()) {
            return $party;
        }
        if ($person = $this->findManyToManyRowset(PersonTable::class, PersonHasContactMechanismTable::class)->current(
        )) {
            return $person;
        }
        return null;
    }
    
    
    
    /**
     * Get the link object instance. This is either a PartyHasContactMechanism or a PersonHasContactMechanism.
     *
     * @return AbstractLinkContactMechanism
     * @throws \Exception
     * @deprecated Use \Ruga\Contact\AbstractContactMechanism::getLinkedEntityIntersection()
     */
    public function getLinkObj(): ?AbstractLinkContactMechanism
    {
        return $this->getLinkedEntityIntersection();
    }
    
    
    
    /**
     * Get the link object instance. This is either a PartyHasContactMechanism or a PersonHasContactMechanism.
     *
     * @return AbstractLinkContactMechanism
     * @throws \Exception
     */
    public function getLinkedEntityIntersection(): ?AbstractLinkContactMechanism
    {
        $partyRowset = $this->findManyToManyRowset(PartyTable::class, PartyHasContactMechanismTable::class);
        if ($partyRowset->count() > 0) {
            return $this->findIntersectionRows($partyRowset->current(), PartyHasContactMechanismTable::class)->current(
            );
        }
        $personRowset = $this->findManyToManyRowset(PersonTable::class, PersonHasContactMechanismTable::class);
        if ($personRowset->count() > 0) {
            return $this->findIntersectionRows(
                $personRowset->current(),
                PersonHasContactMechanismTable::class
            )->current();
        }
        return null;
    }
    
    
    
    /**
     * Magic function that gets database columns and class attributes.
     *
     * @param string $name
     *
     * @return mixed
     * @throws \Exception
     */
    public function __get($name)
    {
        if ($name == 'contactmechanism_type') {
            return new ContactMechanismType(parent::__get($name));
        }
        
        // Try my attributes
        try {
            return parent::__get($name);
        } catch (\Exception $eThis) {
            if (!$eThis instanceof \Ruga\Db\Row\Exception\InvalidArgumentException) {
                throw $eThis;
            }
        }
        
        // try link object attributes
        try {
            if ($obj = $this->getLinkedEntityIntersection()) {
                return $obj->__get($name);
            }
        } catch (\Exception $eLinkobj) {
            if (!$eLinkobj instanceof \Ruga\Db\Row\Exception\InvalidArgumentException) {
                throw $eLinkobj;
            }
        }
        
        // try subtype attributes
        try {
            return $this->getSubtype()->__get($name);
        } catch (\Exception $eSubtype) {
            if (!$eSubtype instanceof \Ruga\Db\Row\Exception\InvalidArgumentException) {
                throw $eSubtype;
            }
        }
        
        throw $eThis;
    }
    
    
    
    /**
     * Magic function that sets database columns and class attributes.
     *
     * @param string $name  Name of the column
     * @param mixed  $value Value of the column
     *
     * @return void
     * @throws \Exception
     */
    public function __set($name, $value)
    {
        if (!$this->isNew()) {
            throw new \Exception("Object is immutable. Please clone before write.");
        }
        
        // Try my attributes
        try {
            parent::__set($name, $value);
            return;
        } catch (\Exception $eThis) {
            if (!$eThis instanceof \Ruga\Db\Row\Exception\InvalidArgumentException) {
                throw $eThis;
            }
        }
        
        // try link object attributes (=intersection table to person or party)
        try {
            if ($obj = $this->getLinkedEntityIntersection()) {
                $obj->__set($name, $value);
                return;
            }
        } catch (\Exception $eLinkobj) {
            if (!$eLinkobj instanceof \Ruga\Db\Row\Exception\InvalidArgumentException) {
                throw $eLinkobj;
            }
        }
        
        // try subtype attributes
        try {
            $this->getSubtype()->__set($name, $value);
            return;
        } catch (\Exception $eSubtype) {
            if (!$eSubtype instanceof \Ruga\Db\Row\Exception\InvalidArgumentException) {
                throw $eSubtype;
            }
        }
        
        throw $eThis;
    }
    
    
    
    /**
     * Clone the current contact mechanism.
     *
     * @return self
     * @throws \ReflectionException
     */
    public function clone(): self
    {
        /** @var AbstractContactMechanism $clone */
        $clone = $this->getTableGateway()->createRow();
        $clone->linkTo($this->getLinkedEntity());
        $clone->contactmechanism_type = $this->contactmechanism_type;
        $clone->remark = $this->remark;
        $clone->emergency_contact = $this->emergency_contact;
        foreach ($this->getSubtype()->getArrayCopy() as $key => $val) {
            if ($clone->getSubtype()->offsetExists($key) && !in_array($key, ['id'])) {
                $clone->getSubtype()->offsetSet($key, $val);
            }
        }
        
        $clone->setPreviousClone($this);
        
        return $clone;
    }
    
    
    
    public function setPreviousClone(AbstractContactMechanism $prevClone)
    {
        $this->prevClone = $prevClone;
    }
    
    
    
    /**
     * Persist the row, subtype and link.
     *
     * @return int Affected Rows
     * @throws \Exception
     */
    public function save()
    {
        try {
            $this->getTableGateway()->getAdapter()->getDriver()->getConnection()->beginTransaction();
            
            if ($this->prevClone) {
                $this->valid_from = new \DateTimeImmutable();
                $this->prevClone->getLinkedEntityIntersection()->offsetSet(
                    'valid_thru',
                    $this->valid_from->sub(new \DateInterval('PT1S'))
                )->save();
            }
            return parent::save();
        } catch (\Exception $e) {
            $this->getTableGateway()->getAdapter()->getDriver()->getConnection()->rollback();
            throw $e;
        } finally {
            if (!isset($e)) {
                $this->getTableGateway()->getAdapter()->getDriver()->getConnection()->commit();
            }
        }
    }
    
    
    
    /**
     * Delete the contactmechanism.
     * Actually the record will only be deleted, if there is no link to an entity (person/organization).
     * If contactmechanism is linked, just set the valid_thru value to the time 1 second before.
     *
     * @return int
     * @throws \Exception
     */
    public function delete()
    {
        try {
            $this->getTableGateway()->getAdapter()->getDriver()->getConnection()->beginTransaction();
            
            if (!$this->getLinkedEntityIntersection() || $this->getLinkedEntityIntersection()->isNew()) {
                // No link to a person or a party
                // => really delete contactmechanism and his subtype
                $this->getSubtype()->delete();
                return parent::delete();
            } else {
                // There is a link to a person or a party
                // don't delete contactmechanism, just set thru date to now-1sec
                $this->getLinkedEntityIntersection()->valid_thru = (new \DateTimeImmutable())->sub(
                    new \DateInterval('PT1S')
                );
                $this->save();
            }
            return 0;
        } catch (\Exception $e) {
            $this->getTableGateway()->getAdapter()->getDriver()->getConnection()->rollback();
            throw $e;
        } finally {
            if (!isset($e)) {
                $this->getTableGateway()->getAdapter()->getDriver()->getConnection()->commit();
            }
        }
    }
    
    
    
    /**
     * Create an array representation of the data in the row.
     *
     * @inheritDoc
     * @return array
     * @throws \Exception
     */
    public function toArray(): array
    {
        $aA = [];
        $aA['html_link'] = "<a href=\"contactmechanism/{$this->PK}/edit\">" . $this->fullname . '</a>';
        $aA['isDisabled'] = $this->isDisabled();
        
        $aA['isDisabled'] = false;
        $aA['isDeleted'] = false;
        $aA['canBeChangedBy'] = true;
        
        $aC = $this->getSubtype()->toArray();
        $aD = $this->getLinkObj()->toArray();
        
        $aB = parent::toArray();
        return array_merge($aA, $aC, $aD, $aB);
    }
    
    
    
    /**
     * Checks if this contact mechanism is archived at the time of $keydate. A contact mechanism is considered as
     * archived, if valid_thru is earlier than the $keydate.
     *
     * @param \DateTimeImmutable|null $keydate
     *
     * @return bool
     * @throws \Exception
     */
    public function isArchived(\DateTimeImmutable $keydate = null): bool
    {
        $keydate = $keydate ?? new \DateTimeImmutable();
        return $this->getLinkedEntityIntersection()->valid_thru && ($this->getLinkedEntityIntersection(
                )->valid_thru < $keydate);
    }
}
