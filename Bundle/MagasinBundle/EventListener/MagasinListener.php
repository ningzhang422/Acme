<?php

namespace Acme\Bundle\MagasinBundle\EventListener;

use Acme\Bundle\MagasinBundle\Context\MagasinContextInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpFoundation\RedirectResponse;



class MagasinListener implements EventSubscriberInterface
{
    /**
     * @var MagasinContextInterface
     */
    protected $magasinContext;
    protected $router;

    /**
     * @param LocaleContextinterface $localeContext
     */
    public function __construct(MagasinContextInterface $magasinContext,$router)
    {
        $this->magasinContext = $magasinContext;
        $this->router = $router;
    }

    /**
     * Set the right locale via context.
     *
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        
        if (!$request->hasPreviousSession()) {
            return;
        }
        //$this->magasinContext->setMagasin($this->magasinContext->getDefaultMagasin());
        $this->magasinContext->setMagasin(1);
        if($this->magasinContext->getMagasin() == null){
		
        	$route = 'acme_magasin_homepage';

			if ($route === $event->getRequest()->get('_route')) {
			    return;
			}
			
			$url = $this->router->generate($route);
			$response = new RedirectResponse($url);
			$event->setResponse($response);
        }
        
    }

    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::REQUEST => array(array('onKernelRequest', 17)),
        );
    }
    
}
