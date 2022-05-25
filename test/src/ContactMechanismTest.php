<?php

declare(strict_types=1);

namespace Ruga\Contact\Test;

define('REMARK', 'This is a remark, saved in the ContactMechanism object.');

use Ruga\Contact\ContactMechanism as ContactMechanismAlias;

/**
 * @author Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 */
class ContactMechanismTest extends \Ruga\Contact\Test\PHPUnit\AbstractTestSetUp
{
    public function testCanCreateContactMechanism(): void
    {
        echo PHP_EOL . PHP_EOL;
        \Ruga\Log::functionHead();
        
        /** @var \Ruga\Person\Person $person */
        $person = (new \Ruga\Person\PersonTable($this->getAdapter()))->createRow();
        $person->first_name = 'Hans';
        $person->last_name = 'Müller';
        $person->save();
        
        
        $t = new \Ruga\Contact\ContactMechanismTable($this->getAdapter());
        
        /** @var \Ruga\Contact\ContactMechanism $contactmechanism */
        $contactmechanism = $t->createRow();
        $this->assertInstanceOf(\Ruga\Contact\ContactMechanism::class, $contactmechanism);
        $contactmechanism->contactmechanism_type = \Ruga\Contact\ContactMechanismType::EMAIL;
        $contactmechanism->linkTo($person);
        $contactmechanism->address = 'test@easy-smart.ch';
        $contactmechanism->save();
    }
    
    
    
    public function testCanChangeContactMechanism(): void
    {
        echo PHP_EOL . PHP_EOL;
        \Ruga\Log::functionHead();
        
        /** @var \Ruga\Person\Person $person */
        $person = (new \Ruga\Person\PersonTable($this->getAdapter()))->createRow();
        $person->first_name = 'Hans';
        $person->last_name = 'Müller';
        $person->save();
        
        $t = new \Ruga\Contact\ContactMechanismTable($this->getAdapter());
        
        /** @var \Ruga\Contact\ContactMechanism $contactmechanism */
        $contactmechanism = $t->createRow();
        $contactmechanism->contactmechanism_type = \Ruga\Contact\ContactMechanismType::EMAIL;
        $contactmechanism->linkTo($person);
        $contactmechanism->address = 'test@easy-smart.ch';
        $contactmechanism->remark = REMARK;
        $contactmechanism->save();
        
        
        unset($person);
        unset($contactmechanism);
        
        $person = (new \Ruga\Person\PersonTable($this->getAdapter()))->findById(1)->current();
        $this->assertInstanceOf(\Ruga\Person\Person::class, $person);
        \Ruga\Log::log_msg("Person: {$person->idname}");
        
        $contactmechanisms = $t->findContactMechanismTable($person);
        $this->assertGreaterThan(0, count($contactmechanisms));
        $contactmechanism = $contactmechanisms->current();
        $this->assertInstanceOf(ContactMechanismAlias::class, $contactmechanism);
        \Ruga\Log::log_msg($contactmechanism->idname);
        $this->assertSame(REMARK, $contactmechanism->remark);
        
        
        $contactmechanism = $contactmechanism->clone();
        $this->assertSame(REMARK, $contactmechanism->remark);
        $contactmechanism->address = 'test2@easy-smart.ch';
        $contactmechanism->save();
        
        
        unset($person);
        unset($contactmechanism);
        $person = (new \Ruga\Person\PersonTable($this->getAdapter()))->findById(1)->current();
        $contactmechanisms = $t->findContactMechanismTable($person);
        $this->assertCount(1, $contactmechanisms);
        $contactmechanism = $contactmechanisms->current();
        print_r($contactmechanism->toArray());
    }
    
    
    
    public function testCanDeleteContactMechanism(): void
    {
        echo PHP_EOL . PHP_EOL;
        \Ruga\Log::functionHead();
        
        /** @var \Ruga\Person\Person $person */
        $person = (new \Ruga\Person\PersonTable($this->getAdapter()))->createRow();
        $person->first_name = 'Hans';
        $person->last_name = 'Müller';
        $person->save();
        
        $t = new \Ruga\Contact\ContactMechanismTable($this->getAdapter());
        
        /** @var \Ruga\Contact\ContactMechanism $contactmechanism */
        $contactmechanism = $t->createRow();
        $contactmechanism->contactmechanism_type = \Ruga\Contact\ContactMechanismType::EMAIL;
        $contactmechanism->linkTo($person);
        $contactmechanism->address = 'test@easy-smart.ch';
        $contactmechanism->remark = __METHOD__;
        $contactmechanism->save();
        
        $contactmechanism = $contactmechanism->clone();
        $this->assertSame(__METHOD__, $contactmechanism->remark);
        $contactmechanism->address = 'test2@easy-smart.ch';
        $contactmechanism->save();
        
        $contactmechanism = $contactmechanism->clone();
        $this->assertSame(__METHOD__, $contactmechanism->remark);
        $contactmechanism->address = 'test3@easy-smart.ch';
        $contactmechanism->save();
        
        unset($person);
        unset($contactmechanism);
        
        $person = (new \Ruga\Person\PersonTable($this->getAdapter()))->findById(1)->current();
        $this->assertInstanceOf(\Ruga\Person\Person::class, $person);
        \Ruga\Log::log_msg("Person: {$person->idname}");
        
        $contactmechanisms = $t->findContactMechanismTable($person);
        $this->assertGreaterThan(0, count($contactmechanisms));
        $contactmechanism = $contactmechanisms->current();
        $this->assertInstanceOf(\Ruga\Contact\ContactMechanism::class, $contactmechanism);
        \Ruga\Log::log_msg($contactmechanism->idname);
        $this->assertSame(__METHOD__, $contactmechanism->remark);
        
        $contactmechanism->delete();
    }
    
    
    
    public function testCanReallyDeleteContactMechanism(): void
    {
        echo PHP_EOL . PHP_EOL;
        \Ruga\Log::functionHead();
        
        /** @var \Ruga\Person\Person $person */
        $person = (new \Ruga\Person\PersonTable($this->getAdapter()))->createRow();
        $person->first_name = 'Hans';
        $person->last_name = 'Müller';
        $person->save();
        
        $t = new \Ruga\Contact\ContactMechanismTable($this->getAdapter());
        
        /** @var \Ruga\Contact\ContactMechanism $contactmechanism */
        $contactmechanism = $t->createRow();
        $contactmechanism->contactmechanism_type = \Ruga\Contact\ContactMechanismType::EMAIL;
        $contactmechanism->linkTo($person);
        $contactmechanism->address = 'test@easy-smart.ch';
        $contactmechanism->remark = __METHOD__;
        $contactmechanism->save();
        
        $contactmechanism = $contactmechanism->clone();
        $this->assertSame(__METHOD__, $contactmechanism->remark);
        $contactmechanism->address = 'test2@easy-smart.ch';
        $contactmechanism->save();
        
        $contactmechanism = $contactmechanism->clone();
        $this->assertSame(__METHOD__, $contactmechanism->remark);
        $contactmechanism->address = 'test3@easy-smart.ch';
        $contactmechanism->save();
        
        unset($person);
        unset($contactmechanism);
        
        $person = (new \Ruga\Person\PersonTable($this->getAdapter()))->findById(1)->current();
        $this->assertInstanceOf(\Ruga\Person\Person::class, $person);
        \Ruga\Log::log_msg("Person: {$person->idname}");
        
        $contactmechanisms = $t->findContactMechanismTable($person, true);
        $this->assertGreaterThan(0, count($contactmechanisms));
        foreach ($contactmechanisms as $contactmechanism) {
            $this->assertInstanceOf(\Ruga\Contact\ContactMechanism::class, $contactmechanism);
            \Ruga\Log::log_msg("UNLINK {$contactmechanism->idname}");
            $contactmechanism->unlinkFrom($person);
            \Ruga\Log::log_msg("DELETE {$contactmechanism->idname}");
            $contactmechanism->delete();
        }
        
        \Ruga\Log::log_msg("DELETE {$person->idname}");
        $person->delete();
    }
    
    
}
