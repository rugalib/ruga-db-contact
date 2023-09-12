<?php
/*
 * SPDX-FileCopyrightText: 2023 Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 * SPDX-License-Identifier: AGPL-3.0-only
 */

declare(strict_types=1);

namespace Ruga\Contact;


use Laminas\Db\Sql\Expression;
use Ruga\Contact\Address\Address;
use Ruga\Contact\Link\AbstractLinkContactMechanism;
use Ruga\Contact\Link\AbstractLinkContactMechanismAttributesInterface;
use Ruga\Contact\Link\ContactMechanismCapableObjectInterface;
use Ruga\Contact\Link\Party\AbstractPartyHasContactMechanism;
use Ruga\Contact\Link\Party\PartyHasContactMechanismAttributesInterface;
use Ruga\Contact\Link\Party\PartyHasContactMechanismTable;
use Ruga\Contact\Link\Person\AbstractPersonHasContactMechanism;
use Ruga\Contact\Link\Person\PersonHasContactMechanismAttributesInterface;
use Ruga\Contact\Link\Person\PersonHasContactMechanismTable;
use Ruga\Contact\Subtype\AbstractSubtypeRow;
use Ruga\Contact\Subtype\AbstractSubtypeTable;
use Ruga\Contact\Subtype\Address\AddressAttributesInterface;
use Ruga\Contact\Subtype\ElectronicAddress\ElectronicAddress;
use Ruga\Contact\Subtype\ElectronicAddress\ElectronicAddressAttributesInterface;
use Ruga\Contact\Subtype\SubtypeRowInterface;
use Ruga\Contact\Subtype\TelecomNumber\TelecomNumber;
use Ruga\Contact\Subtype\TelecomNumber\TelecomNumberAttributesInterface;
use Ruga\Db\Row\AbstractRow;
use Ruga\Db\Row\AbstractRugaRow;
use Ruga\Db\Table\Exception\InvalidArgumentException;
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
    /** @var SubtypeRowInterface */
    private $subtype;
    
    /** @var int */
    private $link_party_id;
    
    /** @var int */
    private $link_person_id;
    
    /** @var AbstractLinkContactMechanism */
    private $link_obj;
    
    /** @var AbstractRow */
    private $linkTo;
    
    /** @var AbstractContactMechanism $prevClone */
    private $prevClone;
    
    
    
    /**
     * Returns the subtype object. The subtype object is a concrete subtype row like an address, electronic address or
     * a telecom number.
     *
     * @return SubtypeRowInterface|AbstractSubtypeRow|Address|TelecomNumber|ElectronicAddress
     * @throws \ReflectionException
     */
    public function getSubtype(): SubtypeRowInterface
    {
//        \Ruga\Log::functionHead($this);
        
        if (!$this->subtype) {
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
            
            $this->subtype = $subtype;
        }
        return $this->subtype;
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
     * Link the given $obj to the contact mechanism.
     *
     * @param $obj
     *
     * @return AbstractLinkContactMechanism
     * @throws \ReflectionException
     */
    public function linkTo($obj): AbstractLinkContactMechanism
    {
        if($obj instanceof ContactMechanismCapableObjectInterface) {
            $this->linkTo = $obj;
            $obj->registerContactMechanismForSave($this);
            return $this->getLinkObj();
        }
    
        if (($obj instanceof Person) || ($obj instanceof Party)) {
            $this->linkTo = $obj;
            return $this->getLinkObj();
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
        if (($obj instanceof Person) || ($obj instanceof Party)) {
            $linkobj = $this->getLinkObj();
            $linkobj->delete();
            $this->linkTo = null;
        } else {
            throw new Exception\IllegalLinkedEntityException(
                "Can not unlink from unknown entity '" . get_class($obj) . "'"
            );
        }
    }
    
    
    
    /**
     * Get the link object instance.
     *
     * @return AbstractLinkContactMechanism
     * @throws \Exception
     */
    public function getLinkObj(): AbstractLinkContactMechanism
    {
        if (!$this->link_obj) {
            if ($this->linkTo instanceof Person) {
                $this->link_obj = (new PersonHasContactMechanismTable(
                    $this->getTableGateway()->getAdapter()
                ))->createRow();
            } elseif ($this->linkTo instanceof Party) {
                $this->link_obj = (new PartyHasContactMechanismTable(
                    $this->getTableGateway()->getAdapter()
                ))->createRow();
            } else {
                throw new Exception\IllegalLinkedEntityException("ContactMechanism is not linked to an entity.");
            }
        }
//        if(!$this->isNew()) $this->link_obj->ContactMechanism_id=$this->id;
//        if(!$this->linkTo->isNew()) $this->link_obj->Object_id=$this->linkTo->id;
        return $this->link_obj;
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
            return $this->getLinkObj()->__get($name);
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
        
        // try link object attributes
        try {
            $this->getLinkObj()->__set($name, $value);
            return;
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
    
    
    
    public function clone(): self
    {
        /** @var AbstractContactMechanism $clone */
        $clone = $this->getTableGateway()->createRow();
        $clone->linkTo($this->linkTo);
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
                $this->prevClone->getLinkObj()->offsetSet(
                    'valid_thru',
                    $this->valid_from->sub(new \DateInterval('PT1S'))
                )->save();
            }
            $ret = parent::save();
            $this->getSubtype()->setContactMechanismId($this->id);
            $this->getSubtype()->save();
            
            try {
                $this->getLinkObj()->ContactMechanism_id = $this->id;
                $this->getLinkObj()->Object_id = $this->linkTo->id;
                $this->getLinkObj()->save();
            } catch (\Exception $e) {
                throw new Exception\IllegalLinkedEntityException("ContactMechanism is not linked to an entity.");
            }
            
            return $ret;
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
            
            if ($this->getLinkObj()->isNew()) {
                // No link to a person or a party
                // => really delete contactmechanism and his subtype
                $this->getSubtype()->delete();
                return parent::delete();
            } else {
                // There is a link to a person or a party
                // don't delete contactmechanism, just set thru date to now-1sec
                $this->getLinkObj()->valid_thru = (new \DateTimeImmutable())->sub(new \DateInterval('PT1S'));
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
     * Initialize row.
     * Populate $this->link_obj for existing rows. If the row is new, the link to an entity is not defined and must be
     * set by the user.
     *
     * @throws \ReflectionException
     */
    protected function init()
    {
        parent::init();
        
        
        if (!$this->link_obj && !$this->isNew()) {
            if ($link_obj = (new PersonHasContactMechanismTable($this->getTableGateway()->getAdapter()))->select(
                ['ContactMechanism_id' => $this->id]
            )->current()) {
                $this->link_obj = $link_obj;
                $this->link_person_id = $this->link_obj->Person_id;
                $this->linkTo = (new PersonTable($this->getTableGateway()->getAdapter()))->findById(
                    $this->link_obj->Person_id
                )->current();
            }
            
            if ($link_obj = (new PartyHasContactMechanismTable($this->getTableGateway()->getAdapter()))->select(
                ['ContactMechanism_id' => $this->id]
            )->current()) {
                $this->link_obj = $link_obj;
                $this->link_party_id = $this->link_obj->Party_id;
                $this->linkTo = (new PartyTable($this->getTableGateway()->getAdapter()))->findById(
                    $this->link_obj->Party_id
                )->current();
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
        return $this->getLinkObj()->valid_thru && ($this->getLinkObj()->valid_thru < $keydate);
    }
    
    
}
