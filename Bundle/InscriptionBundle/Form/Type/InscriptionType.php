<?php

namespace Acme\Bundle\InscriptionBundle\Form\Type;

use Sylius\Bundle\CoreBundle\Form\Type\UserType as BaseType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

class InscriptionType extends BaseType
{
	
	
	/**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
		parent::buildForm($builder, $options);
    }
	
	/**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'inscription_user';
    }
}