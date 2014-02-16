<?php

namespace Acme\Bundle\ShopBundle\Form;

//use Symfony\Component\Form\FormBuilderInterface;
//use Sylius\Bundle\CoreBundle\Form\Type\RegistrationFormType as BaseType;
use FOS\UserBundle\Form\Type\ProfileFormType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

class RegistrationFormType extends ProfileFormType
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
        $builder
            ->addEventListener(FormEvents::PRE_BIND, function (FormEvent $event) {
                $data = $event->getData();
var_dump($data);
                if (!array_key_exists('differentBillingAddress', $data) || false === $data['differentBillingAddress']) {
                    //$data['billingAddress'] = $data['shippingAddress'];

                    $event->setData($data);
                }
            })
            ->add('firstName', 'text', array(
                'label' => 'sylius.form.user.first_name'
            ))
            ->add('lastName', 'text', array(
                'label' => 'sylius.form.user.last_name'
            ))
            ->add('mobile', 'text', array('label' => 'acme.form.user.mobile'))
        ;

        $this->buildUserForm($builder, $options);
        

        $builder
            ->add('plainPassword', 'repeated', array(
                'type' => 'password',
                'options' => array('translation_domain' => 'FOSUserBundle'),
                'first_options' => array('label' => 'form.password'),
                'second_options' => array('label' => 'form.password_confirmation'),
                'invalid_message' => 'fos_user.password.mismatch',
            ))
            ->add('shippingAddress', 'sylius_address', array(
                'label' => 'sylius.form.user.shipping_address',
                'error_bubbling' => false
            ))
            ->add('differentBillingAddress', 'checkbox', array(
                'mapped' => false,
                'label'  => 'sylius.form.user.different_billing_address',
                'error_bubbling' => false
            ))
            ->add('billingAddress', 'sylius_address', array(
                'label' => 'sylius.form.user.billing_address',
                'error_bubbling' => false
            ))
            ->remove('username')
        ;
        
    }
    
/**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'         => $this->dataClass,
            'validation_groups'  => function(FormInterface $form) {
                $data = $form->getData();
                $groups = array('Profile', 'sylius');
                if ($data && !$data->getId()) {
                    $groups[] = 'ProfileAdd';
                }

                return $groups;
            },
            'cascade_validation' => true,
            'intention'          => 'profile',
        ));
    }

    public function getName()
    {
        return 'acme_user_registration';
    }
}
