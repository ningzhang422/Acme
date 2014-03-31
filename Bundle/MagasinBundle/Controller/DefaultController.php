<?php

namespace Acme\MagasinBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('AcmeMagasinBundle:Default:index.html.twig', array('name' => $name));
    }
}
