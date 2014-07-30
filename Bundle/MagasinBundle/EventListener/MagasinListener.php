<?php

namespace Acme\Bundle\MagasinBundle\EventListener;

use Acme\Bundle\MagasinBundle\Context\MagasinContextInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;


class MagasinListener implements EventSubscriberInterface
{
    /**
     * @var MagasinContextInterface
     */
    protected $magasinContext;

    /**
     * @param LocaleContextinterface $localeContext
     */
    public function __construct(MagasinContextInterface $magasinContext)
    {
        $this->magasinContext = $magasinContext;
    }

    /**
     * Set the right locale via context.
     *
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
//var_dump($this->container->get('sylius.context.magasin'));
        if (!$request->hasPreviousSession()) {
            return;
        }
        $this->magasinContext->setMagasin($this->magasinContext->getDefaultMagasin());
        //$this->magasinContext->setMagasin($this->container->get('sylius.context.magasin')->getDefaultMagasin());

        //$request->setMagasin($this->magasinContext->getMagasin() ?: $this->magasinContext->getDefaultMagasin());
    }

    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::REQUEST => array(array('onKernelRequest', 17)),
        );
    }
    
}
