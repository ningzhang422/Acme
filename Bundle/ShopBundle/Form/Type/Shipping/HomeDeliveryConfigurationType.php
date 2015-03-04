<?php

// src/Acme/ShopBundle/Form/Type/Shipping/DHLConfigurationType.php

namespace Acme\Bundle\ShopBundle\Form\Type\Shipping;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class HomeDeliveryConfigurationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('limit', 'integer', array(
                'label' => 'Free shipping above total items',
                'constraints' => array(
                    new NotBlank(),
                    new Type(array('type' => 'integer')),
                )
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults(array(
                'data_class' => null
            ))
        ;
    }

    public function getName()
    {
        return 'acme_shipping_calculator_home_delivery';
    }
}