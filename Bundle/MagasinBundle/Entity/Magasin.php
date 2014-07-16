<?php

namespace Acme\Bundle\MagasinBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Magasin
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Acme\Bundle\MagasinBundle\Entity\MagasinRepository")
 */
class Magasin
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="latitude", type="string", length=255)
     */
    private $latitude;

    /**
     * @var string
     *
     * @ORM\Column(name="longitude", type="string", length=255)
     */
    private $longitude;
    
    /**
   	* @ORM\OneToOne(targetEntity="Acme\Bundle\ShopBundle\Entity\Address", cascade={"persist"})
   	* @ORM\JoinColumn(nullable=false)
   	*/
  	private $address;
  	
  	/**
   	* @ORM\Column(name="enabled", type="boolean")
   	*/
  	private $enabled;
  	
  	/**
   	* @ORM\Column(name="createdAt", type="date")
   	*/
  	private $createdAt;
  	
  	/**
   	* @ORM\Column(name="updatedAt", type="date")
   	*/
  	private $updatedAt;
  	
	public function __construct()
	  {
	    $this->enabled = true;
	    $this->createdAt = new \DateTime();
	    $this->updatedAt = new \DateTime();
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
     * Set name
     *
     * @param string $name
     * @return Magasin
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set latitude
     *
     * @param string $latitude
     * @return Magasin
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return string 
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param string $longitude
     * @return Magasin
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return string 
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set address
     *
     * @param \Sylius\Bundle\AddressingBundle\Model\Address $address
     * @return Magasin
     */
    public function setAddress(\Acme\Bundle\ShopBundle\Entity\Address $address = null)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return \Sylius\Bundle\AddressingBundle\Model\Address 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     * @return Magasin
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean 
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Magasin
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
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Magasin
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}
