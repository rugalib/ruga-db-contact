<?php

declare(strict_types=1);

namespace Ruga\Contact\Address;

use Ruga\Db\Row\RowAttributesInterface;

/**
 * Interface AddressAttributesInterface
 *
 * @property int    $id          Primary key
 * @property string $fullname    Full name / display name
 * @property string $department  Department
 * @property string $address1    Address line 1
 * @property string $address2    Address line 2
 * @property string $postal_code Postal code
 * @property string $city        City
 * @property string $province    Province
 * @property string $territory   Territory
 * @property string $state       State
 * @property string $country     Country
 * @property float  $longitude   Longitude
 * @property float  $latitude    Latitude
 * @property string $remark      Remark
 */
interface AddressAttributesInterface extends RowAttributesInterface
{
    
}