<?php

namespace Acme\Bundle\MagasinBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Acme\Bundle\MagasinBundle\Form\Type\MagasinChoiceType;
use Acme\Bundle\MagasinBundle\Entity\Magasin;
use Symfony\Component\HttpFoundation\Session\Session;
use Acme\Bundle\MagasinBundle\Context\MagasinContext;

class MagasinController extends Controller
{
    public function chooseAction()
    {

		$repository = $this->container->get('sylius.repository.magasin');
		
		$builder = $this->createFormBuilder();
		$magasins = $repository->findAll();

		$magasinChoices = array();
		foreach ($magasins as $magasin) {
			$key = $magasin->getId();
			$value = $magasin->getName();
			$magasinChoices[$key] = $value;
		}

		$builder->add('magasin', 
					  'choice',
					   array('choices' => $magasinChoices,
							 'required' => false));
						 
							 
							 
		
		// À partir du formBuilder, on génère le formulaire
		$form = $builder->getForm();
		
		// On récupère la requête
		$request = $this->get('request');
		

		// On vérifie qu'elle est de type POST
		if ($request->getMethod() == 'POST') {
			$this->container->get('sylius.context.magasin')->setMagasin($request->request->get('form')['magasin']);
			
			return $this->redirect($this->generateUrl('sylius_homepage'));
		}	
	
        return $this->render('AcmeMagasinBundle:Magasin:choose.html.twig',array(
				'magasin' => $magasin,
				'form' => $form->createView(),
			)
		);
    }
}
