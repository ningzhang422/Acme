<?php
namespace Acme\Bundle\PeriodBundle\Controller;


use Acme\Bundle\PeriodBundle\Entity\Creneau;
use Acme\Bundle\PeriodBundle\Form\Type\CreneauType;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class CreneauController extends Controller
{
    
    public function indexAction()
    {
    	$em = $this->getDoctrine()->getManager();
        $request = $this->get('request');
        
        if($request->query->get('selected_date') == null){
        	$date = new \DateTime();
        }else{
        	$date = new \DateTime($request->query->get('selected_date'));
        }
        
        $repository = $this->getDoctrine()
                   ->getManager()
                   ->getRepository('AcmePeriodBundle:Creneau');

		$listeCreneaus = $repository->findInSevenDaysByCurrentDateAllPeriod();
		
		$shipment_method_ids = array();
        $shipment_period_ids = array();
        $shipment_creneau_ids = array();
        $shipment_creneau_valide = array();
        $shipment_method_types = array();
        $creneau_tables = array(); 
        //var_dump($listeCreneaus);
        
        foreach ($listeCreneaus as $key => $creneau) {

            $shipment_method_ids[$key] = $creneau->getPeriod()->getMethod()->getIsdrive() == True ? 'drive':'livraison';
            $shipment_period_ids[$key] = $creneau->getPeriod()->getStartTime()->format('H:i')."-".$creneau->getPeriod()->getEndTime()->format('H:i');
            $shipment_creneau_ids[$key] = $creneau->getId();
            $shipment_creneau_dates[$key] = $creneau->getPerformedAt()->format('d/m/Y');
            $shipment_creneau_valide[$shipment_creneau_ids[$key]] = $creneau->getCapacite() > $creneau->getReserve();
        	if(!isset($creneau_tables[$shipment_method_ids[$key]])){
        		$creneau_tables[$shipment_method_ids[$key]] = array( $shipment_period_ids[$key] => array( $shipment_creneau_dates[$key] => $shipment_creneau_ids[$key]));
        		$shipment_method_types[$shipment_method_ids[$key]] = $creneau->getPeriod()->getMethod()->getIsdrive();
        	}else{
        		if(!isset($creneau_tables[$shipment_method_ids[$key]][$shipment_period_ids[$key]])){
        			$creneau_tables[$shipment_method_ids[$key]][$shipment_period_ids[$key]] = array( $shipment_creneau_dates[$key] => $shipment_creneau_ids[$key]);
        		}else{
        			$creneau_tables[$shipment_method_ids[$key]][$shipment_period_ids[$key]][$shipment_creneau_dates[$key]] = $shipment_creneau_ids[$key];
        		}
        	}
            //$creneau_tables[] = array($shipment_method_ids[$choiceView->value] => array( $shipment_period_ids[$choiceView->value] => array( $shipment_creneau_ids[$choiceView->value])));
        }
       
        
    	return $this->render('AcmePeriodBundle:Creneau:index.html.twig', array(
    		'selected_date' => $date,
    		'start_at' => $date->format('Y-m-d'),
    		'end_at' => $date->modify('+6 day')->format('Y-m-d'),
    		'listecreneaus' => $listeCreneaus,
    		'shipment_method_ids' => $shipment_method_ids,
    		'shipment_period_ids' => $shipment_period_ids,
    		'shipment_creneau_ids' => $shipment_creneau_ids,
    		'shipment_creneau_valide' => $shipment_creneau_valide,
    		'creneau_tables' => $creneau_tables,
    		'shipment_method_types' => $shipment_method_types,
        ));
    }
    
    public function createAction(Request $request)
    {
    	$creneau = new Creneau;
	  	$form = $this->createForm(new CreneauType, $creneau);
	
	  $request = $this->get('request');
	  if ($request->getMethod() == 'POST') {
	    $form->bind($request);
	    
		    if ($form->isValid()) {
		      $em = $this->getDoctrine()->getManager();
		      $em->persist($creneau);
		      $em->flush();
		
		      return new Response("good job"); //$this->redirect($this->generateUrl('sylius_backend_planning_index'));
		    }
	   
	  }
	  
	 
	
	  return $this->render('AcmePeriodBundle:Period:create.html.twig', array(
	    'form' => $form->createView(),
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
