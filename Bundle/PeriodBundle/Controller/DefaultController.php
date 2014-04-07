<?php

namespace Acme\Bundle\PeriodBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('AcmePeriodBundle:Default:index.html.twig', array('name' => $name));
    }
}
