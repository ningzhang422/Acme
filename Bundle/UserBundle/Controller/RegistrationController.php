<?php
namespace Acme\Bundle\UserBundle\Controller;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\HttpFoundation\Response;
use FOS\UserBundle\Controller\RegistrationController as BaseController;

/**
 * Controller managing the registration
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 * @author Christophe Coevoet <stof@notk.org>
 */
class RegistrationController extends BaseController
{
    public function registerAction(Request $request)
    {
        /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
        $formFactory = $this->get('fos_user.registration.form.factory');
        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');
        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $user = $userManager->createUser();
        $user->setEnabled(true);

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $form = $formFactory->createForm();
        $form->setData($user);

        if ($request->isMethod('POST')) {
        $form->handleRequest($request);
        
        	if ($request->isXmlHttpRequest()) {
        
		        if ($form->isValid()) {
		            $event = new FormEvent($form, $request);
		            $dispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);
		
		            $userManager->updateUser($user);
		
		            if (null === $response = $event->getResponse()) {
		                $url = $this->generateUrl('fos_user_registration_confirmed');
		                $response = new RedirectResponse($url);
		            }
		
		            $dispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request, $response));
		    
		            $result = array('success' => true,'href' => $url);
		            $response = new Response(json_encode($result));
		            $response->headers->set('Content-Type', 'application/json');
		            return $response;
		        }else{
		        	
		        	$result = array(
				        'success' => false, 
				        'error' => true, 
				        'message' => $form->getErrorsAsString()
				    );
				    $response = new Response(json_encode($result));
				    $response->headers->set('Content-Type', 'application/json');
				//die(var_dump($response));
				    return $response;
		        
		        }
        	}else{
        		if ($form->isValid()) {
		            $event = new FormEvent($form, $request);
		            $dispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);
		
		            $userManager->updateUser($user);
		
		            if (null === $response = $event->getResponse()) {
		                $url = $this->generateUrl('fos_user_registration_confirmed');
		                $response = new RedirectResponse($url);
		            }
		
		            $dispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request, $response));
		    
		            return $response;
		        }
        	}
        }
        
        
		return $this->render('FOSUserBundle:Registration:register.html.twig', array(
            'form' => $form->createView(),
        ));
    }

}
