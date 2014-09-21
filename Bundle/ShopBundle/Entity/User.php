<?php

namespace Acme\Bundle\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Sylius\Component\Core\Model\User as BaseUser;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_user")
 * @ORM\HasLifecycleCallbacks();
 */
class User extends BaseUser
{
  /**
     * @var string
     *
     * @ORM\Column(name="mobile", type="string", length=10, nullable=true)
     */
  protected $mobile;
  
  /**
   	* @ORM\OneToOne(targetEntity="Acme\Bundle\MagasinBundle\Entity\Magasin")
   	*/
  protected $magasin;

  
  public function setMobile($mobile)
  {
    $this->mobile = $mobile;
  }
  
  public function getMobile()
  {
    return $this->mobile;
  }
  
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
  
	/**
	* @ORM\PrePersist
	*/
	public function upload()
	{
		//var_dump($this);
		//if (null === $this->differentBillingAddress) {
			$this->billingAddress = $this->shippingAddress;
		//}
		
	}
}