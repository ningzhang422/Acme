<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Acme\Bundle\CartBundle\Controller;

use Sylius\Component\Cart\Event\CartEvent;
use Sylius\Component\Cart\Event\CartItemEvent;
use Sylius\Component\Cart\Resolver\ItemResolvingException;
use Sylius\Component\Cart\SyliusCartEvents;
use Sylius\Component\Resource\Event\FlashEvent;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Cart item controller.
 *
 * It manages the cart item resource, but also it has
 * two handy methods for easy adding and removing items
 * using the services, an operator and resolver.
 *
 * The basic cart operations like: adding, removing items,
 * saving and clearing the cart are done in listeners.
 *
 * The resolver is used to create a new cart item, based
 * on the data from current request.
 *
 * @author Paweł Jędrzejewski <pawel@sylius.org>
 */
class CartItemController extends Controller
{
    /**
     * Adds item to cart.
     * It uses the resolver service so you can populate the new item instance
     * with proper values based on current request.
     *
     * It redirect to cart summary page by default.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function addAction(Request $request, $type)
    {
        $cart = $this->getCurrentCart();
        $emptyItem = $this->createNew();

        $eventDispatcher = $this->getEventDispatcher();

        if ($type=="ajax") // this is the altered part, basically replacing flash messages with json response
	    {
	        try {
	            $item = $this->getResolver()->resolve($emptyItem, $request);
	        } catch (ItemResolvingException $exception) {
	            // Write flash message
	            $eventDispatcher->dispatch(SyliusCartEvents::ITEM_ADD_ERROR, new FlashEvent($exception->getMessage()));
	
	            return $this->redirectAfterAdd($request);
	        }
	
	        $event = new CartItemEvent($cart, $item);
	        $event->isFresh(true);
	
	        // Update models
	        $eventDispatcher->dispatch(SyliusCartEvents::ITEM_ADD_INITIALIZE, $event);
	        $eventDispatcher->dispatch(SyliusCartEvents::CART_CHANGE, new GenericEvent($cart));
	        $eventDispatcher->dispatch(SyliusCartEvents::CART_SAVE_INITIALIZE, $event);
	
	        // Write flash message
	        // $this->dispatchEvent(SyliusCartEvents::ITEM_ADD_COMPLETED, new FlashEvent());
	
	        //$cartTotals  = array('items' => $cart->countItems(), 'total' => $cart->getTotal());
	        
	        $ajaxCart = $this->renderView('AcmeWebBundle:Frontend/Cart:ajaxCart.html.twig', array(
	            'cart' => $cart
	        ));
	        
			$form = $this->createForm('sylius_cart_item', $item);
			
			$form_modif = $this->renderView('AcmeWebBundle:Frontend/Product:_form_product_update_with_item.html.twig', array(
		      'form'   => $form->createView(),
			  'item'   => $item
		    ));
			
			
			
	        $return='{"responseCode" : "200", "message" : "ok", "ajaxCart" : '.json_encode($ajaxCart).',"form_modif" : '.json_encode($form_modif).',"item_id" : '.json_encode($item->getId()).' }';        
	
	        return new Response($return,200,array('Content-Type'=>'application/json'));
	    }
	    else // unaltered part of the original action
	    {
	        try {
	            $item = $this->getResolver()->resolve($emptyItem, $request);
	        } catch (ItemResolvingException $exception) {
	            // Write flash message
	            $eventDispatcher->dispatch(SyliusCartEvents::ITEM_ADD_ERROR, new FlashEvent($exception->getMessage()));
	
	            return $this->redirectAfterAdd($request);
	        }
	
	        $event = new CartItemEvent($cart, $item);
	        $event->isFresh(true);
	
	        // Update models
	        $eventDispatcher->dispatch(SyliusCartEvents::ITEM_ADD_INITIALIZE, $event);
	        $eventDispatcher->dispatch(SyliusCartEvents::CART_CHANGE, new GenericEvent($cart));
	        $eventDispatcher->dispatch(SyliusCartEvents::CART_SAVE_INITIALIZE, $event);
	
	        // Write flash message
	        $eventDispatcher->dispatch(SyliusCartEvents::ITEM_ADD_COMPLETED, new FlashEvent());
	
	        return $this->redirectAfterAdd($request);
	    }
    }
    
	/**
     * update item already in cart.
     * It uses the resolver service so you can populate the new item instance
     * with proper values based on current request.
     *
     * It redirect to cart summary page by default.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function modifAction(Request $request, $id, $type)
    {
        $cart = $this->getCurrentCart();
	    // On r�cup�re l'annonce $id
	    $item = $this->get('sylius.repository.cart_item')->find($id);
        
    	$form = $this->createForm('sylius_cart_item', $item);

    	if ($type=="ajax") // this is the altered part, basically replacing flash messages with json response
	    {
        	if ($form->handleRequest($request)->isValid()) {
            	$event = new CartEvent($cart);
	            $event->isFresh(true);
	
	            $eventDispatcher = $this->getEventDispatcher();
	
	            $eventDispatcher->dispatch(SyliusCartEvents::CART_CHANGE, new GenericEvent($cart));
	
	            // Update models
	            $eventDispatcher->dispatch(SyliusCartEvents::CART_SAVE_INITIALIZE, $event);
	
	            // Write flash message
	            //$eventDispatcher->dispatch(SyliusCartEvents::CART_SAVE_COMPLETED, new FlashEvent());
	
	            //return $this->redirectToCartSummary();
	            
	            $ajaxCart = $this->renderView('AcmeWebBundle:Frontend/Cart:ajaxCart.html.twig', array(
		            'cart' => $cart
		        ));
		
		        $return='{"responseCode" : "200", "message" : "ok", "ajaxCart" : '.json_encode($ajaxCart).'}';        
		
		        return new Response($return,200,array('Content-Type'=>'application/json'));
	        }
	    }else{
	    	if ($form->handleRequest($request)->isValid()) {
            	$event = new CartEvent($cart);
	            $event->isFresh(true);
	
	            $eventDispatcher = $this->getEventDispatcher();
	
	            $eventDispatcher->dispatch(SyliusCartEvents::CART_CHANGE, new GenericEvent($cart));
	
	            // Update models
	            $eventDispatcher->dispatch(SyliusCartEvents::CART_SAVE_INITIALIZE, $event);
	
	            // Write flash message
	            $eventDispatcher->dispatch(SyliusCartEvents::CART_SAVE_COMPLETED, new FlashEvent());
	
	            return $this->redirectToCartSummary();
	        }
	    }
    }

    /**
     * Redirect to specific URL or to cart.
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    private function redirectAfterAdd(Request $request)
    {
        if ($request->query->has('_redirect_to')) {
            return $this->redirect($request->query->get('_redirect_to'));
        }

        return $this->redirectToCartSummary();
    }

    /**
     * Removes item from cart.
     * It takes an item id as an argument.
     *
     * If the item is found and the current user cart contains that item,
     * it will be removed and the cart - refreshed and saved.
     *
     * @param mixed $id
     *
     * @return Response
     */
    public function removeAction($id, $type)
    {
        $cart = $this->getCurrentCart();
        $item = $this->getRepository()->find($id);

        if ($type=="ajax") // this is the altered part, basically replacing flash messages with json response
	    {
	    	$eventDispatcher = $this->getEventDispatcher();
	
	        if (!$item || false === $cart->hasItem($item)) {
	            // Write flash message
	            $eventDispatcher->dispatch(SyliusCartEvents::ITEM_REMOVE_ERROR, new FlashEvent());
	
	            return $this->redirectToCartSummary();
	        }
	
	        $event = new CartItemEvent($cart, $item);
	        $event->isFresh(true);
	
	        // Update models
	        $eventDispatcher->dispatch(SyliusCartEvents::ITEM_REMOVE_INITIALIZE, $event);
	        $eventDispatcher->dispatch(SyliusCartEvents::CART_CHANGE, new GenericEvent($cart));
	        $eventDispatcher->dispatch(SyliusCartEvents::CART_SAVE_INITIALIZE, $event);
	
	        $ajaxCart = $this->renderView('AcmeWebBundle:Frontend/Cart:ajaxCart.html.twig', array(
		            'cart' => $cart
		        ));
		
		        $return='{"responseCode" : "200", "message" : "ok", "ajaxCart" : '.json_encode($ajaxCart).'}';        
		
		        return new Response($return,200,array('Content-Type'=>'application/json'));
	    }else{
	        $eventDispatcher = $this->getEventDispatcher();
	
	        if (!$item || false === $cart->hasItem($item)) {
	            // Write flash message
	            $eventDispatcher->dispatch(SyliusCartEvents::ITEM_REMOVE_ERROR, new FlashEvent());
	
	            return $this->redirectToCartSummary();
	        }
	
	        $event = new CartItemEvent($cart, $item);
	        $event->isFresh(true);
	
	        // Update models
	        $eventDispatcher->dispatch(SyliusCartEvents::ITEM_REMOVE_INITIALIZE, $event);
	        $eventDispatcher->dispatch(SyliusCartEvents::CART_CHANGE, new GenericEvent($cart));
	        $eventDispatcher->dispatch(SyliusCartEvents::CART_SAVE_INITIALIZE, $event);
	
	        // Write flash message
	        $eventDispatcher->dispatch(SyliusCartEvents::ITEM_REMOVE_COMPLETED, new FlashEvent());
	
	        return $this->redirectToCartSummary();
	    }
    }
}
