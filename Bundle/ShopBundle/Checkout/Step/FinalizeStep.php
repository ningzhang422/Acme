<?php


namespace Acme\Bundle\ShopBundle\Checkout\Step;

use Sylius\Bundle\FlowBundle\Process\Context\ProcessContextInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\SyliusCheckoutEvents;
use Sylius\Component\Core\SyliusOrderEvents;
use Sylius\Component\Order\OrderTransitions;
use Acme\Bundle\PeriodBundle\AcmePeriodEvents;




class FinalizeStep extends CheckoutStep
{
    /**
     * {@inheritdoc}
     */
    public function displayAction(ProcessContextInterface $context)
    {
        $order = $this->getCurrentCart();
        $this->dispatchCheckoutEvent(SyliusCheckoutEvents::FINALIZE_INITIALIZE, $order);

        return $this->renderStep($context, $order);
    }

    /**
     * {@inheritdoc}
     */
    public function forwardAction(ProcessContextInterface $context)
    {
        $order = $this->getCurrentCart();
        $this->dispatchCheckoutEvent(SyliusCheckoutEvents::FINALIZE_INITIALIZE, $order);

        $order->setUser($this->getUser());

        $this->completeOrder($order);

        return $this->complete();
    }

    protected function renderStep(ProcessContextInterface $context, OrderInterface $order)
    {
        return $this->render('SyliusWebBundle:Frontend/Checkout/Step:finalize.html.twig', array(
            'context' => $context,
            'order'   => $order
        ));
    }

    /**
     * Mark the order as completed.
     *
     * @param OrderInterface $order
     */
    protected function completeOrder(OrderInterface $order)
    {
        $this->dispatchCheckoutEvent(SyliusOrderEvents::PRE_CREATE, $order);
        $this->dispatchCheckoutEvent(SyliusCheckoutEvents::FINALIZE_PRE_COMPLETE, $order);
        $this->dispatchCheckoutEvent(AcmePeriodEvents::CRENEAU_AJUSTEMENT, $order);
        $order->complete();

        $manager = $this->get('sylius.manager.order');
        $manager->persist($order);
        $manager->flush();

        $this->dispatchCheckoutEvent(SyliusCheckoutEvents::FINALIZE_COMPLETE, $order);
        $this->dispatchCheckoutEvent(SyliusOrderEvents::POST_CREATE, $order);
    }
}
