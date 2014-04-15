<?php


namespace Acme\Bundle\PeriodBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;



class CreneauType extends AbstractType
{
   

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('period', 'acme_period_choice', array(
                'required' => false,
                'label'    => 'acme.form.creneau.period'
            ))
            ->add('reserve', 'integer', array(
                'label' => 'acme.form.crenau.reserve'
            ))
            ->add('capacite', 'integer', array(
                'label' => 'acme.form.crenau.capacite'
            ))
            ->add('frais', 'integer', array(
                'label' => 'acme.form.crenau.frais'
            ))
            ->add('estindisponible', 'checkbox', array(
                'label' => 'acme.form.crenau.estindisponible'
            ))
            ->add('estferie', 'checkbox', array(
                'label' => 'acme.form.crenau.estferie'
            ))
            ->add('fraisoffert', 'checkbox', array(
                'label' => 'acme.form.crenau.fraisoffert'
            ))
        ;

    }

   

    public function getName()
    {
        return 'sylius_creneau';
    }
}
