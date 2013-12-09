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

class RegisterStep extends ControllerStep
{
    public function displayAction(ProcessContextInterface $context)
    {
    	return $this->renderStep($context, $this->getRegistrationForm());
    }

    public function forwardAction(ProcessContextInterface $context)
    {
    	$request = $this->getRequest();
    	
    	
        //$userManager = $this->get('fos_user.user_manager');
        //$dispatcher = $this->get('event_dispatcher');
        //$user = $userManager->createUser();
        //$user->setEnabled(true);
        $form = $this->getRegistrationForm();
        //$form->setData($user);

        //$dispatcher->dispatch(FOSUserEvents::REGISTRATION_INITIALIZE, new UserEvent($user, $request));

        if ($request->isMethod('POST')) {
        	$form->bind($request); 
			
	        if($form->isValid()) {
	        	//print_r($form->getData());
	        	     	
	        	$context->getStorage()->set('my_data', $_POST['fos_user_registration_form']);
	        	
            	
	            //$event = new FormEvent($form, $request);
	            //$dispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);
	
	            //$userManager->updateUser($user);
	
	            //$dispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request, new Response()));
	
	            return $this->complete();
	            
	        }
        }

        return $this->renderStep($context, $form);
    }
    
    
	/**
     * Render step.
     *
     * @param ProcessContextInterface $context
     * @param FormInterface           $registrationForm
     */
    protected function renderStep(ProcessContextInterface $context, FormInterface $registrationForm)
    {
        return $this->render('AcmeInscriptionBundle:Process/Step:register.html.twig', array(
            'context'           => $context,
            'registration_form' => $registrationForm->createView(),
        ));
    }
    
	/**
     * Get registration form.
     *
     * @return FormInterface
     */
    protected function getRegistrationForm()
    {
        return $this->get('fos_user.registration.form.factory')->createForm();
    }
    
    
}