<?php


namespace Acme\Bundle\MagasinBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Base zone choice type.
 *
 * @author Saša Stamenkovic <umpirsky@gmail.com>
 */
class MagasinChoiceType extends AbstractType
{
   

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('magasin', 'entity', array(
                'class' => 'AcmeMagasinBundle:Magasin',
				'property' => 'name',
				'expandd' => false,
				'multiple' => false
            ))
        ;

    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults(array(
                'data_class'        => 'Acme\Bundle\MagasinBundle\Entity\Magasin'
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'sylius_magasin_choice';
    }
}