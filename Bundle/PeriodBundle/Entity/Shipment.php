<?php



namespace Acme\Bundle\PeriodBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\Shipment as BaseShipment;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_shipment")
 */
class Shipment extends BaseShipment implements ShipmentInterface
{
    /**
   	 * @ORM\ManyToOne(targetEntity="Acme\Bundle\PeriodBundle\Entity\Creneau")
   	 * @ORM\JoinColumn(name="creneau_id", referencedColumnName="id")
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
