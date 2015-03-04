<?php

namespace Acme\Bundle\PeriodBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

/**
 * Creneau
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Acme\Bundle\PeriodBundle\Entity\CreneauRepository")
 */
class Creneau
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="reserve", type="integer")
     * @Assert\NotBlank()
     */
    private $reserve;

    /**
     * @var integer
     *
     * @ORM\Column(name="capacite", type="integer")
     * @Assert\NotBlank()
     */
    private $capacite;

    /**
     * @var integer
     *
     * @ORM\Column(name="frais", type="integer")
     */
    private $frais;

    /**
     * @var boolean
     *
     * @ORM\Column(name="estindisponible", type="boolean")
     */
    private $estindisponible;

    /**
     * @var boolean
     *
     * @ORM\Column(name="estferie", type="boolean")
     */
    private $estferie;

    /**
     * @var boolean
     *
     * @ORM\Column(name="fraisoffert", type="boolean")
     * @Assert\NotBlank()
     */
    private $fraisoffert;
    
    /**
	 * @var date $performedAt
	 *
	 * @ORM\Column(name="performedAt", type="date")
	 * @Assert\NotBlank()
	 */
	private $performedAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updateAt", type="datetime")
     */
    private $updateAt;
    
    /**
   	* @ORM\ManyToOne(targetEntity="Acme\Bundle\PeriodBundle\Entity\Period")
   	* @ORM\JoinColumn(nullable=false)
   	* @ORM\OrderBy({"startTime" = "ASC"})
   	* @Assert\NotBlank()
   	*/
    protected $period;
    
    /**
   	 * @ORM\OneToMany(targetEntity="Acme\Bundle\PeriodBundle\Entity\Shipment", mappedBy="creneau")
   	 */
    protected $shipments;

    
	/**
     * Constructor.
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updateAt = new \DateTime();
    }
    
	/**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return strval($this->id);
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set reserve
     *
     * @param integer $reserve
     * @return Creneau
     */
    public function setReserve($reserve)
    {
        $this->reserve = $reserve;

        return $this;
    }

    /**
     * Get reserve
     *
     * @return integer 
     */
    public function getReserve()
    {
        return $this->reserve;
    }

    /**
     * Set capacite
     *
     * @param integer $capacite
     * @return Creneau
     */
    public function setCapacite($capacite)
    {
        $this->capacite = $capacite;

        return $this;
    }

    /**
     * Get capacite
     *
     * @return integer 
     */
    public function getCapacite()
    {
        return $this->capacite;
    }

    /**
     * Set frais
     *
     * @param integer $frais
     * @return Creneau
     */
    public function setFrais($frais)
    {
        $this->frais = $frais;

        return $this;
    }

    /**
     * Get frais
     *
     * @return integer 
     */
    public function getFrais()
    {
        return $this->frais;
    }

    /**
     * Set estindisponible
     *
     * @param boolean $estindisponible
     * @return Creneau
     */
    public function setEstindisponible($estindisponible)
    {
        $this->estindisponible = $estindisponible;

        return $this;
    }

    /**
     * Get estindisponible
     *
     * @return boolean 
     */
    public function getEstindisponible()
    {
        return $this->estindisponible;
    }

    /**
     * Set estferie
     *
     * @param boolean $estferie
     * @return Creneau
     */
    public function setEstferie($estferie)
    {
        $this->estferie = $estferie;

        return $this;
    }

    /**
     * Get estferie
     *
     * @return boolean 
     */
    public function getEstferie()
    {
        return $this->estferie;
    }

    /**
     * Set fraisoffert
     *
     * @param boolean $fraisoffert
     * @return Creneau
     */
    public function setFraisoffert($fraisoffert)
    {
        $this->fraisoffert = $fraisoffert;

        return $this;
    }

    /**
     * Get fraisoffert
     *
     * @return boolean 
     */
    public function getFraisoffert()
    {
        return $this->fraisoffert;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Creneau
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updateAt
     *
     * @param \DateTime $updateAt
     * @return Creneau
     */
    public function setUpdateAt($updateAt)
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    /**
     * Get updateAt
     *
     * @return \DateTime 
     */
    public function getUpdateAt()
    {
        return $this->updateAt;
    }

    /**
     * Set period
     *
     * @param \Acme\Bundle\PeriodBundle\Entity\Period $period
     * @return Creneau
     */
    public function setPeriod(\Acme\Bundle\PeriodBundle\Entity\Period $period)
    {
        $this->period = $period;

        return $this;
    }

    /**
     * Get period
     *
     * @return \Acme\Bundle\PeriodBundle\Entity\Period 
     */
    public function getPeriod()
    {
        return $this->period;
    }



    /**
     * Set performedAt
     *
     * @param \DateTime $performedAt
     * @return Creneau
     */
    public function setPerformedAt($performedAt)
    {
        $this->performedAt = $performedAt;

        return $this;
    }

    /**
     * Get performedAt
     *
     * @return \DateTime 
     */
    public function getPerformedAt()
    {
        return $this->performedAt;
    }
    
	
	public function getShipments() 
	{
	    return $this->shipments;
	}
}
