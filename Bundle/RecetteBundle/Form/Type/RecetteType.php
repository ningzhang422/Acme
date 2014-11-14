<?php



namespace Acme\Bundle\RecetteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
//use Acme\Bundle\RecetteBundle\Entity\Product;


class RecetteType extends AbstractType
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
                'label' => 'sylius.form.recette.name'
            ))
            ->add('enabled', 'checkbox', array(
                'required' => false,
                'label'    => 'sylius.form.recette.enabled',
            ))
            ->add('slug', 'text', array(
                'label' => 'sylius.form.recette.permalink'
            ))
            ->add('short_description', 'text', array(
                'label' => 'sylius.form.recette.short_description'
            ))
            ->add('description', 'textarea', array(
                'label' => 'sylius.form.recette.description'
            ))
            ->add('nbPersonnes', 'text', array(
                'label' => 'sylius.form.recette.nbPersonnes'
            ))
            ->add('typeCuisine', 'text', array(
                'label' => 'sylius.form.recette.typeCuisine'
            ))
            ->add('preparation', 'text', array(
                'label' => 'sylius.form.recette.preparation'
            ))
            ->add('cuisson', 'text', array(
                'label' => 'sylius.form.recette.cuisson'
            ))
            ->add('difficulte', 'text', array(
                'label' => 'sylius.form.recette.difficulte'
            ))
            	->add('products', 'entity', array(
					    'class' => 'Sylius\Component\Core\Model\Product',
					    'property' => 'name',
            			'expanded' => false,
            			'multiple' => true,
					))
            ->add(
            'file',
            'file',
            array(
                'label' => 'sylius.form.recette.file'
            )
        );

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
        return 'sylius_recette';
    }
}
