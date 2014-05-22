<?php

namespace Acme\Bundle\PeriodBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Period
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Acme\Bundle\PeriodBundle\Entity\PeriodRepository")
 */
class Period
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
     * @var \DateTime
     *
     * @ORM\Column(name="startTime", type="time")
     */
    private $startTime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="endTime", type="time")
     */
    private $endTime;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;
    
    /**
   	* @ORM\ManyToOne(targetEntity="Sylius\Component\Shipping\Model\ShippingCategory")
   	* @ORM\JoinColumn(nullable=false)
   	*/
    protected $category;

	

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->name;
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
     * Set startTime
     *
     * @param \DateTime $startTime
     * @return Period
     */
    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;

        return $this;
    }

    /**
     * Get startTime
     *
     * @return \DateTime 
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * Set endTime
     *
     * @param \DateTime $endTime
     * @return Period
     */
    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;

        return $this;
    }

    /**
     * Get endTime
     *
     * @return \DateTime 
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Period
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
     * Set shipping_category
     *
     * @param Sylius\Component\Shipping\Model\ShippingCategory $shippingCategory
     * @return Period
     */
    public function setCategory(\Sylius\Component\Shipping\Model\ShippingCategory $category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get shipping_category
     *
     * @return \Sylius\Bundle\ShippingBundle\Model\ShippingCategory 
     */
    public function getCategory()
    {
        return $this->category;
    }
}
