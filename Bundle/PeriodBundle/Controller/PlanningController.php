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


class PlanningController extends Controller
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
        
       
        
    	return $this->render('AcmePeriodBundle:Period:index.html.twig', array(
    		'selected_date' => $date,
    		'start_at' => $date->modify('first day of this month')->format('Y-m-d'),
    		'end_at' => $date->modify('last day of this month')->format('Y-m-d'),
        ));
    }
    
    public function createAction(Request $request)
    {
    	$creneau = new Creneau;
	  	$form = $this->createForm(new CreneauType, $creneau);
	
	  $request = $this->get('request');
	  if ($request->getMethod() == 'POST') {
	    $form->bind($request);
	    if ($request->isXmlHttpRequest()) {
		    if ($form->isValid()) {
		      $em = $this->getDoctrine()->getManager();
		      $em->persist($creneau);
		      $em->flush();
		
		      return $this->redirect($this->generateUrl('sylius_backend_planning_index'));
		    }else{
		    	// On r�cup�re le service validator
			    $validator = $this->get('validator');
			        
			    // On d�clenche la validation
			    $liste_erreurs = $validator->validate($creneau);
			
			    return new Response(print_r($liste_erreurs, true));
			  
		    }
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
