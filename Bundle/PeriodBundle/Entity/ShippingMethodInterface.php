<?php


namespace Acme\Bundle\PeriodBundle\Entity;

use Sylius\Component\Shipping\Model\ShippingMethodInterface as BaseShippingMethodInterface;

/**
 * Shipping method interface.
 *
 * @author Paweł Jędrzejewski <pawel@sylius.org>
 */
interface ShippingMethodInterface extends BaseShippingMethodInterface
{
   
    public function getPeriods();
}
