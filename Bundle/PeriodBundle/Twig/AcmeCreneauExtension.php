<?php

namespace Acme\Bundle\PeriodBundle\Twig;

use Acme\Bundle\PeriodBundle\Entity\Creneau;
use Acme\Bundle\PeriodBundle\Entity\CreneauRepository;

class AcmeCreneauExtension extends \Twig_Extension
{
	
	public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('cwday', array($this, 'cwdayFilter')),
            new \Twig_SimpleFilter('weeknumber', array($this, 'weekNumberFilter')),
        );
    }

    public function cwdayFilter($date)
    {
        $cwday = date('N', strtotime($date));

        return $cwday;
    }
    
	public function weekNumberFilter($date)
    {
        $weekNumber = date('W', strtotime($date));

        return $weekNumber;
    }
	
	
	/**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'creneau_helper';
    }
}