<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Acme\Bundle\CoreBundle\Doctrine\ORM;

use Sylius\Bundle\CoreBundle\Doctrine\ORM\ProductRepository as BaseProductRepository;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Model\TaxonInterface;

/**
 * Product repository.
 *
 * @author Paweł Jędrzejewski <pawel@sylius.org>
 * @author Gonzalo Vilaseca <gvilaseca@reiss.co.uk>
 */
class ProductRepository extends BaseProductRepository
{
    /**
     * Create paginator for products categorized
     * under given taxon.
     *
     * @param TaxonInterface $taxon
     * @param array          $criteria
     *
     * @return \Pagerfanta\Pagerfanta
     */
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
