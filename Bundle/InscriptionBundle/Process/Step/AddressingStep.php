<?php
namespace Acme\Bundle\InscriptionBundle\Process\Step;

use Sylius\Bundle\FlowBundle\Process\Context\ProcessContextInterface;
use Sylius\Bundle\FlowBundle\Process\Step\ControllerStep;


use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\UserEvent;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;

class AddressingStep extends ControllerStep
{
    public function displayAction(ProcessContextInterface $context)
    {
        return $this->renderStep($context, $this->getAddressingForm());
    }

    public function forwardAction(ProcessContextInterface $context)
    {
        $request = $this->getRequest();

        $form = $this->getAddressingForm();

        
        
        
        if ($request->isMethod('POST') && $form->bind($request)->isValid()) {
        	/*
            $this->dispatchCheckoutEvent(SyliusCheckoutEvents::ADDRESSING_PRE_COMPLETE, $order);

            $this->getManager()->persist($order);
            $this->getManager()->flush();

            $this->dispatchCheckoutEvent(SyliusCheckoutEvents::ADDRESSING_COMPLETE, $order);
*/
            return $this->complete();
            
        }

        return $this->renderStep($context, $form);
    }
    
	/**
     * Render step.
     *
     * @param ProcessContextInterface $context
     * @param FormInterface           $registrationForm
     */
    protected function renderStep(ProcessContextInterface $context, FormInterface $addressingForm)
    {
        return $this->render('AcmeInscriptionBundle:Process/Step:addressing.html.twig', array(
            'context'  => $context,
            'addressing_form' => $addressingForm->createView(),
        	'user_data' => $context->getStorage()->get('my_data'),
        ));
    }
    
	/**
     * Get addressing form.
     *
     * @return FormInterface
     */
    protected function getAddressingForm()
    {
        return $this->get('form.factory')->create('sylius_address');
    }
}