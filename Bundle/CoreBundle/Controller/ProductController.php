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

	private function renderResults(TaxonInterface $taxon, Pagerfanta $results, $template, $page)
    {
        $results->setCurrentPage($page, true, true);
        $results->setMaxPerPage($this->config->getPaginationMaxPerPage());
//die(var_dump($this->config->getTemplate($template)));
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
