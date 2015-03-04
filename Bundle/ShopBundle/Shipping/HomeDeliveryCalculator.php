<?php


namespace Acme\Bundle\ShopBundle\Shipping;

//use Acme\Bundle\ShopBundle\Shipping\HomeDeliveryService;
use Sylius\Bundle\ShippingBundle\Calculator\Calculator;
use Sylius\Bundle\ShippingBundle\Model\ShippingSubjectInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class HomeDeliveryCalculator extends Calculator
{
    //private $homeDeliveryService;
/*
    public function __construct(HomeDeliveryService $homeDeliveryService)
    {
        $this->homeDeliveryService = $homeDeliveryService;
    }
*/
    public function calculate(ShippingSubjectInterface $subject, array $configuration)
    {
        return $this->homeDeliveryService->getShippingCostForWeight($subject->getShippingWeight());
    }
    
	/**
    * {@inheritdoc}
    */
    public function isConfigurable()
    {
        return true;
    }

    public function setConfiguration(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults(array(
                'limit' => 10
            ))
            ->setAllowedTypes(array(
                'limit' => array('integer'),
            ))
        ;
    }
}