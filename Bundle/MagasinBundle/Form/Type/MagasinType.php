<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Acme\Bundle\MagasinBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class MagasinType extends AbstractType
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
                'label' => 'sylius.form.magasin.name'
            ))
            ->add('enabled', 'checkbox', array(
                'required' => false,
                'label'    => 'sylius.form.magasin.enabled',
            ))
            ->add('latitude', 'text', array(
                'label' => 'sylius.form.magasin.latitude'
            ))
            ->add('longitude', 'text', array(
                'label' => 'sylius.form.magasin.longitude'
            ))
            ->add('address',  'sylius_address')
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
        return 'sylius_magasin';
    }
}
