<?php
/*
 * SPDX-FileCopyrightText: 2023 Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 * SPDX-License-Identifier: AGPL-3.0-only
 */

declare(strict_types=1);

namespace Ruga\Contact;

use Ruga\Std\Enum\AbstractEnum;

/**
 * Defines the types of communication mechanisms available.
 *
 * @package Ruga\ContactMechanism
 * @method static self PHONE()
 * @method static self MOBILE()
 * @method static self FAX()
 * @method static self MODEM()
 * @method static self EMAIL()
 * @method static self URL()
 * @method static self POSTAL_ADDRESS()
 * @method static self UNKNOWN()
 */
class ContactMechanismType extends AbstractEnum
{
    const PHONE = 'PHONE';
    const MOBILE = 'MOBILE';
    const FAX = 'FAX';
    const MODEM = 'MODEM';
    const EMAIL = 'EMAIL';
    const URL = 'URL';
    const POSTAL_ADDRESS = 'POSTAL_ADDRESS';
    const UNKNOWN = 'UNKNOWN';
    
    const __fullnameMap = [
        self::PHONE => 'Telefon',
        self::MOBILE => 'Mobile',
        self::FAX => 'FAX',
        self::MODEM => 'Modem',
        self::EMAIL => 'E-Mail',
        self::URL => 'Webseite',
        self::POSTAL_ADDRESS => 'Post-Adresse',
        self::UNKNOWN => 'Unbekannt',
    ];
    
    const __extraMap = [
        self::PHONE => [
            'subtypeTableClass' => Subtype\TelecomNumber\TelecomNumberTable::class,
            'template' => 'contactmechanism-TelecomNumber-edit',
            'formClass' => Subtype\Form\TelecomNumberForm::class,
        ],
        self::MOBILE => [
            'subtypeTableClass' => Subtype\TelecomNumber\TelecomNumberTable::class,
            'template' => 'contactmechanism-TelecomNumber-edit',
            'formClass' => Subtype\Form\TelecomNumberForm::class,
        ],
        self::FAX => [
            'subtypeTableClass' => Subtype\TelecomNumber\TelecomNumberTable::class,
            'template' => 'contactmechanism-TelecomNumber-edit',
            'formClass' => Subtype\Form\TelecomNumberForm::class,
        ],
        self::MODEM => [
            'subtypeTableClass' => Subtype\TelecomNumber\TelecomNumberTable::class,
            'template' => 'contactmechanism-TelecomNumber-edit',
            'formClass' => Subtype\Form\TelecomNumberForm::class,
        ],
        self::EMAIL => [
            'subtypeTableClass' => Subtype\ElectronicAddress\ElectronicAddressTable::class,
            'template' => 'contactmechanism-ElectronicAddress-edit',
            'formClass' => Subtype\Form\ElectronicAddressForm::class,
        ],
        self::URL => [
            'subtypeTableClass' => Subtype\ElectronicAddress\ElectronicAddressTable::class,
            'template' => 'contactmechanism-ElectronicAddress-edit',
            'formClass' => Subtype\Form\ElectronicAddressForm::class,
        ],
        self::POSTAL_ADDRESS => [
            'subtypeTableClass' => Subtype\Address\AddressTable::class,
            'template' => 'contactmechanism-PostalAddress-edit',
            'formClass' => Subtype\Form\AddressForm::class,
        ],
    ];
}

