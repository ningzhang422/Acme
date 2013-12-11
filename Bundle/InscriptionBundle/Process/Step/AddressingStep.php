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
     	
        	$userManager = $this->get('fos_user.user_manager');
        	$dispatcher = $this->get('event_dispatcher');
        	$user = $userManager->createUser();
        	$user->setEnabled(true);
        	
        	$login  = $context->getStorage()->get('my_data')['email'];
        	$pass   = $context->getStorage()->get('my_data')['plainPassword']['first'];
        	$mobile = $context->getStorage()->get('my_data')['mobile'];
        	$firstName = $context->getStorage()->get('my_data')['firstName'];
        	$lastName  = $context->getStorage()->get('my_data')['lastName'];
        	
        	$user->setUsername($login);
        	$user->setPlainPassword($pass);
        	$user->setMobile($mobile);
        	$user->setEmail($login);
        	$user->setFirstName($firstName);
        	$user->setLastName($lastName);
        	$user->addAddress($form->getData());
        	$user->setShippingAddress($form->getData());
        	$user->setBillingAddress($form->getData());
        	$userManager->updateUser($user);
        	    	
        	$event = new FormEvent($form, $request);
	        
	        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);
	
			$userManager->updateUser($user);
	
	        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request, new Response()));
        	
        	

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