<?php

namespace Acme\Bundle\InscriptionBundle\Form\Type;

//use Sylius\Bundle\CoreBundle\Form\Type\UserType as BaseType;
use FOS\UserBundle\Form\Type\ProfileFormType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

class InscriptionType extends ProfileFormType
{
	/** @var string */
    private $dataClass;

    /**
     * {@inheritdoc}
     */
    public function __construct($dataClass)
    {
        $this->dataClass = $dataClass;
    }
	
	/**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
		
    }
    
	/**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'         => $this->dataClass
        ));
    }
	
	/**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'inscription_user';
    }
}