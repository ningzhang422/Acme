<?php
namespace Acme\Bundle\PeriodBundle\EventListener;

use Sylius\Bundle\CoreBundle\Model\OrderInterface;
use Sylius\Bundle\CoreBundle\OrderProcessing\InventoryHandlerInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

class OrderShippingCreneauListener
{
   
    

    /**
     * Get the order from event and run the inventory processor on it.
     *
     * @param GenericEvent $event
     */
    public function calculAvailability(GenericEvent $event)
    {
        $order = $event->getSubject();
        if (!$order instanceof OrderInterface) {
            throw new \InvalidArgumentException(
                'Order inventory listener requires event subject to be instance of "Sylius\Bundle\CoreBundle\Model\OrderInterface"'
            );
        }

        $creneau = $order->getLastShipment()->getCreneau();
        $creneau->setReserve($creneau->getReserve() + 1);
    }

    
}
