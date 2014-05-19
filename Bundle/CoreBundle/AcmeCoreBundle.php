<?php

namespace Acme\Bundle\CoreBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class AcmeCoreBundle extends Bundle
{
    public function getParent()
    {
        return 'SyliusCoreBundle';
    }
}
