<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
use Sylius\Component\Cart\Model\CartInterface;
use Sylius\Component\Cart\Provider\CartProviderInterface;

/**
 * A select form which allows the user to select
 * a method that supports given shippables aware.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class ShippingMethodChoiceType extends AbstractType
{
    /**
     * Supported methods resolver.
     *
     * @var MethodsResolverInterface
     */
    protected $resolver;

    /**
     * @var CalculatorRegistryInterface
     */
    protected $calculators;
    
    protected $container;
    /**
     * Cart provider.
     *
     * @var CartProviderInterface
     */
    protected $cartProvider;

    /**
     * Constructor.
     *
     * @param MethodsResolverInterface    $resolver
     * @param CalculatorRegistryInterface $calculators
     * @param ContainerInterface		  $container
     */
    public function __construct(MethodsResolverInterface $resolver, CalculatorRegistryInterface $calculators, ContainerInterface $container,CartProviderInterface $cartProvider)
    {
        $this->resolver = $resolver;
        $this->calculators = $calculators;
        $this->container = $container;
        $this->cartProvider = $cartProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $methodsResolver = $this->resolver;

        $choiceList = function (Options $options) use ($methodsResolver) {
            $methods = $methodsResolver->getSupportedMethods($options['subject'], $options['criteria']);

            return new ObjectChoiceList($methods);
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
        $shippingCosts = array();
        $shipment_category_ids = array();
        $shipment_method_types = array();

        foreach ($view->vars['choices'] as $choiceView) {
        	
            $method = $choiceView->data;

            if (!$method instanceof ShippingMethodInterface) {
                throw new UnexpectedTypeException($method, 'ShippingMethodInterface');
            }

            $calculator = $this->calculators->getCalculator($method->getCalculator());
            $shippingCosts[$choiceView->value] = $calculator->calculate($subject, $method->getConfiguration());
            $shipment_category_ids[$choiceView->value] = $method->getId();
            $shipment_method_types[$choiceView->value] = $method->getIsdrive();
        }

        $view->vars['shipping_costs'] = $shippingCosts;
        $view->vars['shipment_category_ids'] = $shipment_category_ids;
        $view->vars['shipment_method_types'] = $shipment_method_types;
        $repository = $this->container->get('sylius.repository.magasin');

		$magasin = $repository->find($this->container->get('sylius.context.magasin')->getMagasin())->getAddress();
        $view->vars['magasin'] = $magasin;
        
        $view->vars['cart'] = $this->cartProvider->getCart();
        
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
        return 'sylius_shipping_method_choice';
    }
}
