<?php

namespace Acme\Bundle\PeriodBundle\Twig;

class AcmePeriodExtension extends \Twig_Extension
{
	/**
    * @var ContainerInterface
    */
    protected $container;
    
	/**
    * Constructor
    * 
    * @param ContainerInterface $container
    */
       
   	public function __construct($container)
        {
            $this->container = $container;
        }
	
	
	public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('cwday', array($this, 'cwdayFilter')),
            new \Twig_SimpleFilter('weeknumber', array($this, 'weekNumberFilter')),
        );
    }
    
	public function getFunctions()
    {
        return array(
        	new \Twig_SimpleFunction('acme_get_periods', array($this, 'getPeriods')),
            new \Twig_SimpleFunction('acme_get_periods_retrait', array($this, 'getPeriodsRetrait')),
            new \Twig_SimpleFunction('acme_get_periods_livraison', array($this, 'getPeriodsLivraison')),
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
    
	public function getPeriods(){
    	$em = $this->container->get('doctrine.orm.entity_manager');
    	$repository = $em->getRepository('AcmePeriodBundle:Period');
    	
    	return $repository->findAllOrderByMethod();
    }
    
    public function getPeriodsRetrait(){
    	
    }
    
	public function getPeriodsLivraison(){
    	
    }
	
	
	/**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'period_helper';
    }
}