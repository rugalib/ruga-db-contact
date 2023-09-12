<?php
/*
 * SPDX-FileCopyrightText: 2023 Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 * SPDX-License-Identifier: AGPL-3.0-only
 */

declare(strict_types=1);

namespace Ruga\Contact\Link;

use Ruga\Db\Row\AbstractRugaRow;

/**
 * Abstract contact mechanism link.
 * Links contact mechanism to an entity like Person or Party.
 *
 * @author   Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 */
abstract class AbstractLinkContactMechanism extends AbstractRugaRow implements AbstractLinkContactMechanismAttributesInterface
{
    public function getObjectKeyName(): string
    {
        return $this->getTableGateway()::PRIMARYKEY[0];
    }
    
    
    
    public function __get($name)
    {
        switch ($name) {
            case 'Object_id':
                return parent::__get($this->getObjectKeyName());
                break;
        }
        return parent::__get($name);
    }
    
    
    
    public function __set($name, $value)
    {
        switch ($name) {
            case 'Object_id':
                parent::__set($this->getObjectKeyName(), $value);
                return;
                break;
        }
        parent::__set($name, $value);
    }
    
    
}