<?php


namespace Acme\Bundle\ShopBundle\Templating\Helper;

use Sylius\Component\Cart\Model\CartInterface;
use Sylius\Component\Cart\Provider\CartProviderInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Templating\Helper\Helper;

class ProductCheckerHelper extends Helper
{
    /**
     * Cart provider.
     *
     * @var CartProviderInterface
     */
    protected $cartProvider;
    
    /**
     * Form factory.
     *
     * @var FormFactoryInterface
     */
    protected $formFactory;
    

    /**
     * Constructor.
     *
     * @param CartProviderInterface $cartProvider
     * @param FormFactoryInterface  $formFactory
     */
    public function __construct(CartProviderInterface $cartProvider, FormFactoryInterface $formFactory)
    {
        $this->cartProvider = $cartProvider;
        $this->formFactory = $formFactory;
    }

    /**
     * Returns current cart.
     *
     * @return null|CartInterface
     */
    public function getCurrentCart()
    {
        return $this->cartProvider->getCart();
    }

    /**
     * Check if a cart exists.
     *
     * @return Boolean
     */
    public function hasCart()
    {
        return $this->cartProvider->hasCart();
    }
    
	/**
     * Returns cart item form view.
     *
     * @param array $options
     *
     * @return FormView
     */
    public function getItemFormView(array $options = array())
    {
    	$cart = $this->getCurrentCart();
        //$form = $this->formFactory->create('sylius_cart', $cart, $options);
        
    	foreach ($cart->getItems() as $cartItem) {
				if ($cartItem->getProduct()->getId() == $options['product']->getId()) {
					$item_en_question = $cartItem;
				}
			}
    	
    	
        $form = $this->formFactory->create('sylius_cart_item', $item_en_question);

        return $form->createView();
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'product_checker_helper';
    }
}
