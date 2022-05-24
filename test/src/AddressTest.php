<?php

declare(strict_types=1);

namespace Ruga\Contact\Test;

/**
 * @author Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 */
class AddressTest extends \Ruga\Contact\Test\PHPUnit\AbstractTestSetUp
{
    public function testCanCreateAddress(): void
    {
        $t = new \Ruga\Contact\Subtype\Address\AddressTable($this->getAdapter());
        
        /** @var \Ruga\Contact\Subtype\Address\Address $row */
        $row = $t->createRow();
        $this->assertInstanceOf(\Ruga\Contact\Subtype\Address\Address::class, $row);
        $row->save();
    }
}
