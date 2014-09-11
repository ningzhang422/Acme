<?php

namespace Acme\Bundle\MagasinBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MagasinController extends Controller
{
    public function chooseAction()
    {
        return $this->render('AcmeMagasinBundle:Magasin:index.html.twig');
    }
}
