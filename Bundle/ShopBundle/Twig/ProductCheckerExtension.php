<?php

namespace Acme\Bundle\ShopBundle\Twig;

use Acme\Bundle\ShopBundle\Templating\Helper\ProductCheckerHelper;
use Sylius\Component\Cart\Provider\CartProviderInterface;
use Sylius\Component\Core\Model\ProductInterface;

class ProductCheckerExtension extends \Twig_Extension
{
	/**
     * @var CartHelper
     */
    private $helper;
	
	/**
     * Constructor.
     *
     * @param ProductCheckerHelper $helper
     */
    public function __construct(ProductCheckerHelper $helper)
    {
        $this->helper = $helper;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('acme_product_is_in_cart', array($this, 'isInCart')),
            new \Twig_SimpleFunction('acme_product_form_is_in_cart', array($this, 'getItemFormView')),
            new \Twig_SimpleFunction('cart', array($this, 'getCurrentCart')),
        );
    }
    
	public function getGlobals()
    {
        return array(
            'cart' => $this->getCurrentCart()
        );
    }

    /**
     * @param ProductInterface $product
     *
     * @return Boolean
     */
    public function isInCart(ProductInterface $product)
    {
    	$quantity = 0;
    	//die(var_dump($this->helper->getCurrentCart()));
    	if($this->helper->getCurrentCart()){
            $cart = $this->helper->getCurrentCart();
            
            foreach ($cart->getItems() as $cartItem) {
            	//die(var_dump($cartItem->getProduct()));
				if ($cartItem->getProduct()->getId() == $product->getId()) {
					$quantity += 1;
				}
			}
			return $quantity > 0 ;
        } else {
            return 1 == 0;
        }
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
        return $this->helper->getItemFormView($options);
    }
    
	/**
	* Returns current cart.
	*
	* @return null|CartInterface
	*/
	public function getCurrentCart()
	{
		return $this->helper->getCurrentCart();
	}

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'acme_product_checker';
    }
}