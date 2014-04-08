<?php
namespace Acme\Bundle\PeriodBundle\Controller;


use Acme\Bundle\PeriodBundle\Entity\Creneau;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class PlanningController extends Controller
{
    
    public function indexAction()
    {
    	return $this->render('AcmePeriodBundle:Period:index.html.twig');
    }

    

    /**
     * @return object
     */
    private function getUserManager()
    {
        return $this->get('sylius.manager.user');
    }

    /**
     * Accesses address or throws 403
     *
     * @param AddressInterface $address
     *
     * @throws AccessDeniedException
     */
    private function accessOr403(AddressInterface $address)
    {
        if (!$this->getUser()->hasAddress($address)) {
            throw new AccessDeniedException();
        }
    }
}
