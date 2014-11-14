<?php


namespace Acme\Bundle\ShopBundle\Form\Type\Checkout;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Acme\Bundle\PeriodBundle\Entity\CreneauRepository;

/**
 * Order shipments type.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class ShipmentType extends AbstractType
{
    protected $dataClass;
    protected $translator;

    public function __construct($dataClass, TranslatorInterface $translator)
    {
        $this->dataClass = $dataClass;
        $this->translator = $translator;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $criteria = $options['criteria'];
        
        $notBlank = new NotBlank();
        $notBlank->message = $this->translator->trans('sylius.checkout.shipping_method.not_blank');

        $builder
            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($notBlank, $criteria) {
            	
                $form = $event->getForm();
                $shipment = $event->getData();

                $form->add('method', 'sylius_shipping_method_choice', array(
	                    'label'       => 'sylius.form.checkout.shipping_method',
	                    'subject'     => $shipment,
	                    'criteria'    => $criteria,
	                    'expanded'    => true,
	                    'constraints' => array(
	                        $notBlank
	                    )
	                ))
	                ->add('creneau', 'sylius_shipping_creneau_choice', array(
	                    'label'       => 'sylius.form.checkout.shipment_creneau',
	                    'subject'     => $shipment,
	                    'criteria'    => $criteria,
	                    'expanded'    => true,
	                    'constraints' => array(
	                        $notBlank
	                    )
		            ));
            })
            
            /*
            ->add('creneau', 'entity', array(
                'class' => 'AcmePeriodBundle:Creneau',
            	'expanded' => true,
            	'multiple' => false,
            	'query_builder' => function(CreneauRepository $er)
				            {
				            	return $er->findInSevenDaysByCurrentDate();
				            },
    			'required' => true,
                    'constraints' => array(
                        $notBlank
                    )
            ))*/
            
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults(array(
                'data_class' => $this->dataClass
            ))
            ->setOptional(array(
                'criteria'
            ))
            ->setAllowedTypes(array(
                'criteria'   => array('array')
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'sylius_checkout_shipment';
    }
}
