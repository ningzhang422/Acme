<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Acme\Bundle\CoreBundle\Controller;

use Pagerfanta\Pagerfanta;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Model\TaxonInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sylius\Bundle\CoreBundle\Controller\ProductController as BaseProductController;
/**
 * Product controller.
 *
 * @author Paweł Jędrzejewski <pawel@sylius.org>
 */
class ProductController extends BaseProductController
{
    /**
     * List products categorized under given taxon.
     *
     * @param Request $request
     * @param string  $permalink
     *
     * @return Response
     *
     * @throws NotFoundHttpException
     */
    public function indexByTaxonAction(Request $request, $permalink)
    {
    	//var $reponseALL = '';
        if ($request->attributes->has('_sylius_entity')) {
            $taxon = $request->attributes->get('_sylius_entity');
        } else {
            $taxon = $this->get('sylius.repository.taxon')
                ->findOneByPermalink($permalink);

            if (!isset($taxon)) {
                throw new NotFoundHttpException('Requested taxon does not exist.');
            }
        }
        //var_dump($this->get('sylius.repository.taxon')->getTaxonsAsListByParent($taxon));

        $paginator = $this
            ->getRepository()
            ->createByTaxonPaginator($taxon)
        ;
        
        if($this->startsWith($permalink,'category')){
        	$reponseALL = $this->renderResults($taxon, $paginator, 'SyliusWebBundle:Frontend/Product:indexByTaxon.html.twig', $request->get('page', 1));
        }else{
        	$reponseALL = $this->renderResults($taxon, $paginator, 'SyliusWebBundle:Frontend/Product:indexByAP.html.twig', $request->get('page', 1));
        }
		return $reponseALL;
    }
    
    public function promotionsAction(){
    	$taxonomie = $this->get('sylius.repository.taxonomy')->find(4);
    	$products = $this->get('sylius.repository.product')->findPromotions($taxonomie,12);
    	
    	return $this->render('SyliusWebBundle:Frontend/Product:latest.html.twig', array(
    		'products' => $products,
        ));
    }
    
	public function promotions5Action(){
    	$taxonomie = $this->get('sylius.repository.taxonomy')->find(4);
    	$products = $this->get('sylius.repository.product')->findPromotions($taxonomie,5);
    	
    	return $this->render('SyliusWebBundle:Frontend/Product:latestSidebar.html.twig', array(
    		'products' => $products,
        ));
    }
    
	public function topVentesAction(){
    	$taxon = $this->get('sylius.repository.taxon')->find(25);
    	$products = $this->get('sylius.repository.product')->findTaxon($taxon,12);
    	
    	return $this->render('SyliusWebBundle:Frontend/Product:latest.html.twig', array(
    		'products' => $products,
        ));
    }
    
	public function newProductsAction(){
    	$taxon = $this->get('sylius.repository.taxon')->find(24);
    	$products = $this->get('sylius.repository.product')->findTaxon($taxon,12);
    	
    	return $this->render('SyliusWebBundle:Frontend/Product:latest.html.twig', array(
    		'products' => $products,
        ));
    }

	private function renderResults(TaxonInterface $taxon, Pagerfanta $results, $template, $page)
    {
        $results->setCurrentPage($page, true, true);
        $results->setMaxPerPage($this->config->getPaginationMaxPerPage());
        $view = $this
            ->view()
            ->setTemplate($template)
            ->setData(array(
                'taxon'    => $taxon,
                'products' => $results,
            ))
        ;

        return $this->handleView($view);
    }
    
    private function startsWith($haystack, $needle)
	{
	    return $needle === "" || strpos($haystack, $needle) === 0;
	}
	
	
    
}
