<?php

namespace Acme\Bundle\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class AcmeUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}