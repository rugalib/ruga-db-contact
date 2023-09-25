<?php
/*
 * SPDX-FileCopyrightText: 2023 Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 * SPDX-License-Identifier: AGPL-3.0-only
 */

declare(strict_types=1);

namespace Ruga\Contact\Subtype\Form;

use Laminas\Form\Element\Checkbox;
use Laminas\Form\Element\Date;
use Laminas\Form\Element\Text;
use Laminas\Form\Element\Textarea;
use Laminas\Form\Form;

class ElectronicAddressForm extends Form
{
    public function __construct()
    {
        parent::__construct('contactmechanism-form');
        $this->setAttribute('method', 'POST');
        
        $this->add(
            [
                'type' => Text::class,
                'name' => 'address',
                'options' => [
                    'label' => 'Adresse',
                ],
            ]
        );
        
        $this->add(
            [
                'type' => Textarea::class,
                'name' => 'remark',
                'options' => [
                    'label' => 'Bemerkung',
                ],
            ]
        );
    
        $this->add(
            [
                'type' => Checkbox::class,
                'name' => 'emergency_contact',
                'options' => [
                    'label' => 'Notfallkontakt',
                ],
            ]
        );
    
    }
    
}
