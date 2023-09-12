<?php
/*
 * SPDX-FileCopyrightText: 2023 Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 * SPDX-License-Identifier: AGPL-3.0-only
 */

declare(strict_types=1);

namespace Ruga\Contact;

use Laminas\Db\Sql\Predicate\IsNull;
use Laminas\Db\Sql\Select;
use Laminas\Db\Sql\Sql;
use Laminas\Db\Sql\Where;
use Ruga\Db\Row\AbstractRow;
use Ruga\Db\Table\AbstractRugaTable;
use Ruga\Log;
use Ruga\Person\Person;
use Ruga\Party\Party;

abstract class AbstractContactMechanismTable extends AbstractRugaTable
{
    
    /**
     *  Find all the contact mechanisms for the given $obj.
     *
     * @param AbstractRow             $obj
     *
     * @param bool                    $findall
     *
     * @param \DateTimeImmutable|null $keydate
     *
     * @return \Laminas\Db\ResultSet\ResultSetInterface|\Ruga\Db\ResultSet\ResultSet
     * @throws \ReflectionException
     */
    public function findContactMechanismTable(AbstractRow $obj, bool $findall=false, \DateTimeImmutable $keydate=null)
    {
        Log::functionHead($this);
        if ($obj->isNew()) {
            return new \ArrayIterator([]);
        }
        
        if($keydate === null) $keydate=new \DateTimeImmutable();
        $keydate_str=$keydate->format('Y-m-d H:i:s');
    
        /** @var Sql $sql */
        if (is_a($obj, Party::class)) {
            $linkTable = new Link\Party\PartyHasContactMechanismTable($this->getAdapter());
            $sql=$linkTable->getSql();
            $select=$sql->select();
            $select->where(['Party_id' => $obj->id]);
        } elseif (is_a($obj, Person::class)) {
            $linkTable = new Link\Person\PersonHasContactMechanismTable($this->getAdapter());
            $sql=$linkTable->getSql();
            $select=$sql->select();
            $select->where(['Person_id' => $obj->id]);
        } else {
            throw new Exception\IllegalLinkedEntityException(
                "Unknown entity '" . get_class($obj) . "' for contact mechanism."
            );
        }
    
        if(!$findall) $select->where(function(Where $where) use($keydate_str) {
            $where->NEST->isNull('valid_from')->or->lessThanOrEqualTo('valid_from', $keydate_str);
            $where->NEST->isNull('valid_thru')->or->greaterThanOrEqualTo('valid_thru', $keydate_str);
        });
    
        
        \Ruga\Log::log_msg("SQL={$sql->buildSqlString($select)}");
        $links=$linkTable->selectWith($select);
    
    
        // Find the referenced ContactMechanisms
        $contactmechanism_ids = [];
        iterator_apply(
            $links,
            function ($links, &$contactmechanism_ids) {
                $contactmechanism_ids[] = $links->current()->ContactMechanism_id;
                return true;
            },
            [$links, &$contactmechanism_ids]
        );
    
        return $this->findById($contactmechanism_ids);
    }
    
    
}