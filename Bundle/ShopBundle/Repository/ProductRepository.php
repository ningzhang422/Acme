<?php

namespace Acme\Bundle\ShopBundle\Repository;

use Sylius\Bundle\CoreBundle\Doctrine\ORM\ProductRepository as BaseProductRepository;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Model\TaxonInterface;
use Sylius\Component\Taxonomy\Model\TaxonomyInterface;

/**
 * Product repository.
 *
 * @author Paweł Jędrzejewski <pawel@sylius.org>
 */
class ProductRepository extends BaseProductRepository
{
    
    public function findPromotions(TaxonomyInterface $taxonomy,$limit)
    {
    	$queryBuilder = $this->getQueryBuilder();
        $queryBuilder
            ->innerJoin('product.taxons', 'taxon')
            ->innerJoin('taxon.taxonomy', 'taxonomy')
            ->andWhere('taxonomy = :taxonomy')
            ->setParameter('taxonomy', $taxonomy)
            ->setMaxResults($limit)
        ;
        
    	return $queryBuilder
            ->getQuery()
            ->getResult();
    }
    
    public function findTaxon(TaxonInterface $taxon,$limit)
    {
    	$queryBuilder = $this->getQueryBuilder();
        $queryBuilder
            ->innerJoin('product.taxons', 'taxon')
            ->andWhere('taxon = :taxon')
            ->setParameter('taxon', $taxon)
            ->setMaxResults(12)
        ;
        
    	return $queryBuilder
            ->getQuery()
            ->getResult();
    }
    
public function createByTaxonPaginator(TaxonInterface $taxon, array $criteria = array())
    {
        $queryBuilder = $this->getCollectionQueryBuilder();
        $queryBuilder
            ->innerJoin('product.taxons', 'taxon')
            ->andWhere('taxon = :taxon OR taxon.parent = :taxon')
            ->setParameter('taxon', $taxon)
        ;

        foreach ($criteria as $attributeName => $value) {
            $queryBuilder
                ->andWhere('product.' . $attributeName . ' IN (:' . $attributeName . ')')
                ->setParameter($attributeName, $value)
            ;
        }

        return $this->getPaginator($queryBuilder);
    }
}
