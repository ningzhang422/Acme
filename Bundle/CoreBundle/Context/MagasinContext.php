<?php

namespace Acme\Bundle\CoreBundle\Context;

use Doctrine\Common\Persistence\ObjectManager;
use Acme\Bundle\MagasinBundle\Context\MagasinContext as BaseMagasinContext;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;


class MagasinContext extends BaseMagasinContext
{
    protected $securityContext;
    protected $container;
    protected $userManager;

    public function __construct(
        SessionInterface $session,
        SecurityContextInterface $securityContext,
        ContainerInterface $container,
        ObjectManager $userManager
    ) {
        $this->securityContext = $securityContext;
        $this->container = $container;
        $this->userManager = $userManager;

        parent::__construct($session, $this->getDefaultMagasin());
    }

    public function getDefaultMagasin()
    {
    	$repository = $this->container->get('sylius.repository.magasin');
    	$magasin = $repository->find(1);
    	//var_dump($magasin);
        return $magasin->getId();
    }

    public function getMagasin()
    {
        if ((null !== $user = $this->getUser()) && null !== $user->getMagasin()) {
            return $user->getMagasin();
        }

        return parent::getMagasin();
    }

    public function setMagasin($magasin)
    {
        if (null === $user = $this->getUser()) {
            return parent::setMagasin($magasin);
        }

        //$user->setMagasin($magasin);

        //$this->userManager->persist($user);
        //$this->userManager->flush();
    }

    protected function getUser()
    {
        if ($this->securityContext->getToken() && $this->securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->securityContext->getToken()->getUser();
        }
    }
}
