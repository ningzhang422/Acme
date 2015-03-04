<?php

/*
 * Override Core/Checkout/adressingstep
 */

namespace Acme\Bundle\ShopBundle\Checkout\Step;

use Sylius\Bundle\FlowBundle\Process\Context\ProcessContextInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\UserInterface;
use Sylius\Component\Core\SyliusCheckoutEvents;
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

        $form = $this->createCheckoutAddressingForm($order, $this->getUser());
		
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
        $user= $this->getUser();
        $arr1 = (array)$user->getBillingAddress();
        $arr2 = (array)$user->getShippingAddress();
        if (empty($arr1) && empty($arr2)){
        	
        	
        	
	        $form = $this->createCheckoutAddressingForm($order, $this->getUser());
	
	        if ($form->handleRequest($request)->isValid()) {
	            $this->dispatchCheckoutEvent(SyliusCheckoutEvents::ADDRESSING_PRE_COMPLETE, $order);
	
	            $this->getManager()->persist($order);
	            $this->getManager()->flush();
	            
	            $user->setShippingAddress($order->getShippingAddress());
	        	$user->setBillingAddress($order->getBillingAddress());
	        	$this->getManager()->persist($user);
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

	protected function createCheckoutAddressingForm(OrderInterface $order, UserInterface $user = null)
    {
        return $this->createForm('sylius_checkout_addressing', $order, array('user' => $user));
    }
}
