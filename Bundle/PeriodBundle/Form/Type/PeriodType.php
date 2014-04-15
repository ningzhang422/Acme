<?php


namespace Acme\Bundle\PeriodBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class PeriodType extends AbstractType
{
    private $dataClass;

    public function __construct($dataClass)
    {
        $this->dataClass = $dataClass;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'label' => 'sylius.form.period.name'
            ))
            
            ->add('startTime', 'time', array(
			    'input'  => 'datetime',
    'widget' => 'choice',
			))
            ->add('endTime', 'time', array(
			    'input'  => 'datetime',
    'widget' => 'choice',
			))
            ->add('category', 'sylius_shipping_category_choice', array(
                'required' => false,
                'label'    => 'sylius.form.shipping_method.category'
            ))
        ;

    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults(array(
                'data_class'        => $this->dataClass,
                'validation_groups' => array('sylius')
            )
        );
    }

    public function getName()
    {
        return 'sylius_period';
    }
}
