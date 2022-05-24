<?php

declare(strict_types=1);

namespace Ruga\Contact\Subtype\TelecomNumber;

/**
 * The telecom number subtype table.
 *
 * @author   Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 */
class TelecomNumberTable extends AbstractTelecomNumberTable
{
    const TABLENAME = 'TelecomNumber';
    const PRIMARYKEY = ['id'];
//    const RESULTSETCLASS = ;
    const ROWCLASS = TelecomNumber::class;
}
