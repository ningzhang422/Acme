<?php


namespace Acme\Bundle\MagasinBundle\Provider;


interface MagasinProviderInterface
{
    /**
     * @return LocaleInterface[]
     */
    public function getAvailableMagasins();
}