<?php

namespace Acme\Bundle\ShopBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sylius\Bundle\TaxonomiesBundle\Model\Taxonomy as BaseTaxonomy;

/**
 * Model for taxonomies.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_taxonomy")
 */
class Taxonomy extends BaseTaxonomy
{
    /**
   	* @ORM\OneToOne(targetEntity="Acme\Bundle\MagasinBundle\Entity\Magasin")
   	*/
  	protected $magasin;
  	
  	
/**
     * Set magasin
     *
     * @param \Acme\Bundle\MagasinBundle\Entity\Magasin $magasin
     * @return Magasin
     */
    public function setMagasin(\Acme\Bundle\MagasinBundle\Entity\Magasin $magasin = null)
    {
        $this->magasin = $magasin;

        return $this;
    }

    /**
     * Get magasin
     *
     * @return \Acme\Bundle\MagasinBundle\Entity\Magasin 
     */
    public function getMagasin()
    {
        return $this->magasin;
    }
}
