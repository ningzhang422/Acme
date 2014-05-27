<?php

namespace Acme\Bundle\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Sylius\Component\Addressing\Model\Address as BaseAddress;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_address")
 */
class Address extends BaseAddress
{
  /**
     * @var string
     *
     * @ORM\Column(name="addressTitle", type="string", nullable=true)
     */
  protected $addressTitle;

  
  public function setAddressTitle($addressTitle)
  {
    $this->addressTitle = $addressTitle;
  }
  
  public function getAddressTitle()
  {
    return $this->addressTitle;
  }
  
}