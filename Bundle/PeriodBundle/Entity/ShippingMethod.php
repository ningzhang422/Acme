<?php



namespace Acme\Bundle\PeriodBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Sylius\Component\Core\Model\ShippingMethod as BaseShippingMethod;
use Acme\Bundle\PeriodBundle\Entity\Period;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_shipping_method")
 */
class ShippingMethod extends BaseShippingMethod
{
    /**
   	 * @ORM\OneToMany(targetEntity="Acme\Bundle\PeriodBundle\Entity\Period", mappedBy="method")
   	 * @ORM\OrderBy({"startTime" = "ASC"})
   	 */
    protected $periods;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="isdrive", type="boolean")
     */
    protected $isdrive;
    
	/**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->periods = new ArrayCollection();
    }
    
	public function addPeriod(Period $period)
	  {
	    $this->periods[] = $period;
	
	    return $this;
	  }

	public function removePeriod(Period $period)
	  {
	    $this->periods->removeElement($period);
	  }
	
	public function getPeriods()
	  {
	    return $this->periods;
	  }
	  
	  
/**
     * Set isdrive
     *
     * @param boolean $isdrive
     * @return Creneau
     */
    public function setIsdrive($isdrive)
    {
        $this->isdrive = $isdrive;

        return $this;
    }

    /**
     * Get isdrive
     *
     * @return boolean 
     */
    public function getIsdrive()
    {
        return $this->isdrive;
    }
}
