<?php



namespace Acme\Bundle\PeriodBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sylius\Bundle\CoreBundle\Model\Shipment as BaseShipment;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_shipment")
 */
class Shipment extends BaseShipment
{
    /**
     * @ORM\Column(name="creneau_id", type="integer")
   	 * @ORM\ManyToOne(targetEntity="Acme\Bundle\PeriodBundle\Entity\Creneau")
   	 */
    protected $creneau;
    
	/**
     * Set creneau
     *
     * @param \Acme\Bundle\PeriodBundle\Entity\Creneau $creneau
     * @return Creneau
     */
    public function setCreneau(\Acme\Bundle\PeriodBundle\Entity\Creneau $creneau=null)
    {
        $this->creneau = $creneau;

        return $this;
    }

    /**
     * Get creneau
     *
     * @return \Acme\Bundle\PeriodBundle\Entity\Creneau
     */
    public function getCreneau()
    {
        return $this->creneau;
    }
}
