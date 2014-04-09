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
    	$em = $this->getDoctrine()->getManager();
        $request = $this->get('request');
        if($request->query->get('selected_date') == null){
        	$date = new \DateTime();
        }else{
        	$date = strtotime($request->query->get('selected_date'));
        }
        
        $year = $date->format('Y'); //to start calendar on current year
        $month = $date->format('m'); //to start calendar on current month
        $day = $date->format('d');
        
    	return $this->render('AcmePeriodBundle:Period:index.html.twig', array(
            'year' => $year,
            'month' => $month,
            'day' => $day,
    		'selected_date' => $date,
    		'start_at' => $date->modify('first day of this month'),
    		'end_at' => $date->modify('last day of this month'),
        ));
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
