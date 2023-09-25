<?php
/*
 * SPDX-FileCopyrightText: 2023 Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 * SPDX-License-Identifier: AGPL-3.0-only
 */

declare(strict_types=1);

namespace Ruga\Contact\Subtype\Form;

use Laminas\Form\Element\Text;
use Laminas\Form\Element\Textarea;
use Laminas\Form\Form;

class AddressForm extends Form
{
    public function __construct()
    {
        parent::__construct('contactmechanism-form');
        $this->setAttribute('method', 'POST');
        
        $this->add(
            [
                'type' => Text::class,
                'name' => 'address1',
                'options' => [
                    'label' => 'Adresse',
                ],
            ]
        );
    
        $this->add(
            [
                'type' => Text::class,
                'name' => 'address2',
                'options' => [
                    'label' => 'Adresse',
                ],
            ]
        );
    
        $this->add(
            [
                'type' => Text::class,
                'name' => 'postal_code',
                'options' => [
                    'label' => 'PLZ',
                ],
            ]
        );
    
        $this->add(
            [
                'type' => Text::class,
                'name' => 'city',
                'options' => [
                    'label' => 'Ort',
                ],
            ]
        );
    
    
/*        $this->add(
            [
                'type' => Date::class,
                'name' => 'valid_from',
                'options' => [
                    'label' => 'Gültig ab',
                ],
            ]
        );
        
        $this->add(
            [
                'type' => Date::class,
                'name' => 'valid_thru',
                'options' => [
                    'label' => 'Gültig bis',
                ],
            ]
        );*/
        
        $this->add(
            [
                'type' => Textarea::class,
                'name' => 'remark',
                'options' => [
                    'label' => 'Bemerkung',
                ],
            ]
        );
    }
    
}
