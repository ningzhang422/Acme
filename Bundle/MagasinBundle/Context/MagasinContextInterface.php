<?php

namespace Acme\Bundle\MagasinBundle\Context;


/**
 * Interface to be implemented by the service providing the shop used
 * magasin.
 *
 * @author Ning ZHANG
 */
interface MagasinContextInterface
{
    /**
     * Get the default locale.
     *
     * @return LocaleInterface
     */
    public function getDefaultMagasin();

    /**
     * Get the currently active locale.
     *
     * @return LocaleInterface
     */
    public function getMagasin();

    /**
     * Set the currently active locale.
     *
     * @param LocaleInterface $locale
     */
    public function setMagasin($magasin_id);
}
