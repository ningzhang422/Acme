<?php

namespace Acme\Bundle\ShopBundle\Form\Type;

use Sylius\Component\Shipping\Calculator\Registry\CalculatorRegistryInterface;
use Sylius\Component\Core\Model\ShippingMethodInterface;
use Sylius\Component\Shipping\Resolver\MethodsResolverInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Form\Extension\Core\ChoiceList\ObjectChoiceList;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * A select form which allows the user to select
 * a method that supports given shippables aware.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class ShippingCreneauChoiceType extends AbstractType
{
    /**
     * Supported methods resolver.
     *
     * @var MethodsResolverInterface
     */
    protected $resolver;
    protected $container;

    /**
     * Constructor.
     *
     * @param MethodsResolverInterface    $resolver
     */
    public function __construct(MethodsResolverInterface $resolver, ContainerInterface $container)
    {
        $this->resolver = $resolver;
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $methodsResolver = $this->resolver;
		
        $choiceList = function (Options $options) use ($methodsResolver) {
        	$creneaus = array(); 
            $methods = $methodsResolver->getSupportedMethods($options['subject'], $options['criteria']);
			//var_dump(reset($methods)->getPeriods()->toArray());
			foreach ($methods as $method){
				foreach ($method->getPeriods()->toArray() as $period){
					$creneaus = array_merge($creneaus, $this->container->get('doctrine.orm.entity_manager')->getRepository('AcmePeriodBundle:Creneau')->findInSevenDaysByCurrentDate($period));
				}
			}
            return new ObjectChoiceList($creneaus);
        };
        
        $resolver
            ->setDefaults(array(
                'choice_list' => $choiceList,
                'criteria'    => array()
            ))
            ->setRequired(array(
                'subject',
            ))
            ->setAllowedTypes(array(
                'subject'  => array('Sylius\Component\Shipping\Model\ShippingSubjectInterface'),
                'criteria' => array('array')
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $subject = $options['subject'];
        
        $shipment_method_ids = array();
        $shipment_period_ids = array();
        $shipment_creneau_ids = array();
        $shipment_creneau_valide = array();
        $shipment_method_types = array();
        $creneau_tables = array(); 
        
        foreach ($view->vars['choices'] as $choiceView) {
        	
            $creneau = $choiceView->data;

            $shipment_method_ids[$choiceView->value] = $creneau->getPeriod()->getMethod()->getId();
            
            $shipment_period_ids[$choiceView->value] = $creneau->getPeriod()->getStartTime()->format('H:i')."-".$creneau->getPeriod()->getEndTime()->format('H:i');
            $shipment_creneau_ids[$choiceView->value] = $creneau->getId();
            $shipment_creneau_dates[$choiceView->value] = $creneau->getPerformedAt()->format('d/m/Y');
            $shipment_creneau_valide[$choiceView->value] = $creneau->getCapacite() > $creneau->getReserve();
        	if(!isset($creneau_tables[$shipment_method_ids[$choiceView->value]])){
        		$creneau_tables[$shipment_method_ids[$choiceView->value]] = array( $shipment_period_ids[$choiceView->value] => array( $shipment_creneau_dates[$choiceView->value] => $shipment_creneau_ids[$choiceView->value]));
        		$shipment_method_types[$shipment_method_ids[$choiceView->value]] = $creneau->getPeriod()->getMethod()->getIsdrive();
        	}else{
        		if(!isset($creneau_tables[$shipment_method_ids[$choiceView->value]][$shipment_period_ids[$choiceView->value]])){
        			$creneau_tables[$shipment_method_ids[$choiceView->value]][$shipment_period_ids[$choiceView->value]] = array( $shipment_creneau_dates[$choiceView->value] => $shipment_creneau_ids[$choiceView->value]);
        		}else{
        			$creneau_tables[$shipment_method_ids[$choiceView->value]][$shipment_period_ids[$choiceView->value]][$shipment_creneau_dates[$choiceView->value]] = $shipment_creneau_ids[$choiceView->value];
        		}
        	}
            //$creneau_tables[] = array($shipment_method_ids[$choiceView->value] => array( $shipment_period_ids[$choiceView->value] => array( $shipment_creneau_ids[$choiceView->value])));
        }

        $view->vars['shipment_method_ids'] = $shipment_method_ids;
        $view->vars['shipment_period_ids'] = $shipment_period_ids;
        $view->vars['shipment_creneau_ids'] = $shipment_creneau_ids;
        $view->vars['shipment_creneau_valide'] = $shipment_creneau_valide;
		
		$view->vars['creneau_tables'] = $creneau_tables;
        $view->vars['shipment_method_types'] = $shipment_method_types;
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'choice';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'sylius_shipping_creneau_choice';
    }
}
