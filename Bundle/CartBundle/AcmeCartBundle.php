<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Acme\Bundle\CartBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;


class AcmeCartBundle extends Bundle
{
    public function getParent()
    {
        return 'SyliusCartBundle';
    }
}
