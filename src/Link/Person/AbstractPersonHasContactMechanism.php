<?php

declare(strict_types=1);

namespace Ruga\Contact\Link\Person;

use Ruga\Contact\Link\AbstractLinkContactMechanism;

/**
 * Abstract person - contact mechanism link.
 *
 * @see      PersonHasContactMechanism
 * @author   Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 */
abstract class AbstractPersonHasContactMechanism extends AbstractLinkContactMechanism implements PersonHasContactMechanismInterface
{
}
