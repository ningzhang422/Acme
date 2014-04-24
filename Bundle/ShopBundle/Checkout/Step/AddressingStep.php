<?php

/*
 * Override Core/Checkout/adressingstep
 */

namespace Acme\Bundle\ShopBundle\Checkout\Step;

use Sylius\Bundle\CoreBundle\Checkout\SyliusCheckoutEvents;
use Sylius\Bundle\CoreBundle\Model\OrderInterface;
use Sylius\Bundle\FlowBundle\Process\Context\ProcessContextInterface;
use Symfony\Component\Form\FormInterface;


class AddressingStep extends CheckoutStep
{
    /**
     * {@inheritdoc}
     */
    public function displayAction(ProcessContextInterface $context)
    {
        $order = $this->getCurrentCart();

        $this->dispatchCheckoutEvent(SyliusCheckoutEvents::ADDRESSING_INITIALIZE, $order);

        $form = $this->createCheckoutAddressingForm($order);
		
        $usr= $this->getUser();
        $arr1 = (array)$usr->getBillingAddress();
        $arr2 = (array)$usr->getShippingAddress();
        if (empty($arr1) && empty($arr2)){
        	return $this->renderStep($context, $order, $form);
        }else{
        	
        	$order->setShippingAddress($usr->getShippingAddress());
        	$order->setBillingAddress($usr->getBillingAddress());
        	$this->dispatchCheckoutEvent(SyliusCheckoutEvents::ADDRESSING_PRE_COMPLETE, $order);

            $this->getManager()->persist($order);
            $this->getManager()->flush();

            $this->dispatchCheckoutEvent(SyliusCheckoutEvents::ADDRESSING_COMPLETE, $order);

            return $this->complete();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function forwardAction(ProcessContextInterface $context)
    {
        $request = $this->getRequest();

        $order = $this->getCurrentCart();
        $this->dispatchCheckoutEvent(SyliusCheckoutEvents::ADDRESSING_INITIALIZE, $order);
        $usr= $this->getUser();
        $arr1 = (array)$usr->getBillingAddress();
        $arr2 = (array)$usr->getShippingAddress();
        if (empty($arr1) && empty($arr2)){
	        $form = $this->createCheckoutAddressingForm($order);
	
	        if ($request->isMethod('POST') && $form->submit($request)->isValid()) {
	            $this->dispatchCheckoutEvent(SyliusCheckoutEvents::ADDRESSING_PRE_COMPLETE, $order);
	
	            $this->getManager()->persist($order);
	            $this->getManager()->flush();
	
	            $this->dispatchCheckoutEvent(SyliusCheckoutEvents::ADDRESSING_COMPLETE, $order);
	
	            return $this->complete();
	        }
	
	        return $this->renderStep($context, $order, $form);
        }else{
        	$order->setShippingAddress($usr->getShippingAddress());
        	$order->setBillingAddress($usr->getBillingAddress());
        	$this->dispatchCheckoutEvent(SyliusCheckoutEvents::ADDRESSING_PRE_COMPLETE, $order);

            $this->getManager()->persist($order);
            $this->getManager()->flush();

            $this->dispatchCheckoutEvent(SyliusCheckoutEvents::ADDRESSING_COMPLETE, $order);

            return $this->complete();
        }
    }

    protected function renderStep(ProcessContextInterface $context, OrderInterface $order, FormInterface $form)
    {
        return $this->render('AcmeShopBundle:Checkout/Step:addressexist.html.twig', array(
            'order'   => $order,
            'form'    => $form->createView(),
            'context' => $context
        ));
    }

    protected function createCheckoutAddressingForm(OrderInterface $order)
    {
        return $this->createForm('sylius_checkout_addressing', $order);
    }
}
