<?php
/*
 * SPDX-FileCopyrightText: 2023 Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 * SPDX-License-Identifier: AGPL-3.0-only
 */

declare(strict_types=1);

namespace Ruga\Contact\Test;

use Ruga\Contact\ContactMechanism;
use Ruga\Contact\ContactMechanismTable;

/**
 * @author Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 */
class LinkTest extends \Ruga\Contact\Test\PHPUnit\AbstractTestSetUp
{
    public function testCreateContactmechanismAndLinkToPerson()
    {
        $cmTable=new ContactMechanismTable($this->getAdapter());
        $cm=$cmTable->createRow();
        
        /** @var \Ruga\Contact\ContactMechanism $cm */
        $cm = $cmTable->createRow();
        $this->assertInstanceOf(\Ruga\Contact\ContactMechanism::class, $cm);
        $cm->contactmechanism_type = \Ruga\Contact\ContactMechanismType::EMAIL;
//        $cm->linkTo($person);
        $cm->address = 'test@easy-smart.ch';
//        $cm->save();
        
        $this->assertInstanceOf(ContactMechanism::class, $cm);
        
        var_dump($cm->getSubtype()->toArray());
        
        
    }
    
    
}
