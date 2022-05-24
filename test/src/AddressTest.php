<?php

declare(strict_types=1);

namespace Ruga\Contact\Test;

use Laminas\ServiceManager\ServiceManager;

/**
 * @author                 Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 */
class AddressTest extends \Ruga\Contact\Test\PHPUnit\AbstractTestSetUp
{
    public function testCanCreateAddress(): void
    {
        $t = new \Ruga\Contact\Address\AddressTable($this->getAdapter());
        
        /** @var \Ruga\Contact\Address\Address $row */
        $row = $t->createRow();
        $this->assertInstanceOf(\Ruga\Contact\Address\Address::class, $row);
        $row->save();
    }
}
