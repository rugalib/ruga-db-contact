<?php

declare(strict_types=1);

namespace Ruga\Contact\Test;

use Laminas\ServiceManager\ServiceManager;
use Ruga\Contact\ContactMechanism;

/**
 * @author Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 */
class PersonTest extends \Ruga\Contact\Test\PHPUnit\AbstractTestSetUp
{
    public function testCanDeletePerson()
    {
        /** @var \Ruga\Person\Person $person */
        $person=(new \Ruga\Person\PersonTable($this->getAdapter()))->createRow();
        $person->first_name='Hans';
        $person->last_name='Müller';
        $person->save();
        
        $t = new \Ruga\Contact\ContactMechanismTable($this->getAdapter());
        
        /** @var ContactMechanism $contactmechanism */
        $contactmechanism = $t->createRow();
        $contactmechanism->contactmechanism_type=\Ruga\Contact\ContactMechanismType::EMAIL;
        $contactmechanism->linkTo($person);
        $contactmechanism->address='test@fima.ch';
        $contactmechanism->remark=__METHOD__;
        $contactmechanism->save();
        
        $contactmechanism=$contactmechanism->clone();
        $this->assertSame(__METHOD__, $contactmechanism->remark);
        $contactmechanism->address='test2@fima.ch';
        $contactmechanism->save();
        
        $contactmechanism=$contactmechanism->clone();
        $this->assertSame(__METHOD__, $contactmechanism->remark);
        $contactmechanism->address='test3@fima.ch';
        $contactmechanism->save();
        
        unset($person);
        unset($contactmechanism);
        
        $person=(new \Ruga\Person\PersonTable($this->getAdapter()))->findById(1)->current();
        $this->assertInstanceOf(\Ruga\Person\Person::class, $person);
        \Ruga\Log::log_msg("Person: {$person->idname}");
        
        \Ruga\Log::log_msg("DELETE {$person->idname}");
//        $person->delete();
    }
}
