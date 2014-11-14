<?php

namespace Acme\Bundle\RecetteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\ImageInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Sylius\Component\Core\Model\Product;

/**
 * Recette
 *
 * @ORM\Table(name="sylius_recette")
 * @ORM\Entity(repositoryClass="Acme\Bundle\RecetteBundle\Entity\RecetteRepository")
 */
class Recette implements ImageInterface
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
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="permalink", type="string", length=255, nullable=true)
     */
    private $permalink;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="short_description", type="string", length=255)
     */
    private $shortDescription;
    
    /**
     * @var \SplFileInfo
     */
    protected $file;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255)
     */
    private $path;
    
    /**
     * @var boolean
     * 
   	 * @ORM\Column(name="enabled", type="boolean")
   	 */
  	private $enabled;
  	
  	/**
     * @var integer
     *
     * @ORM\Column(name="nbPersonnes", type="integer", length=11, nullable=true)
     */
    private $nbPersonnes;
    
    /**
     * @var string
     *
     * @ORM\Column(name="typeCuisine", type="string", length=255, nullable=true)
     */
    private $typeCuisine;
    
    /**
     * @var string
     *
     * @ORM\Column(name="preparation", type="string", length=255, nullable=true)
     */
    private $preparation;
    
    /**
     * @var string
     *
     * @ORM\Column(name="cuisson", type="string", length=255, nullable=true)
     */
    private $cuisson;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="difficulte", type="integer", length=11, nullable=true)
     */
    private $difficulte;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updatedAt", type="datetime")
     */
    private $updatedAt;
    
    /**
     * @var ArrayCollection
     * 
     * @ORM\ManyToMany(targetEntity="Sylius\Component\Core\Model\Product", cascade={"persist"})
     */
    protected $products;
    
	public function __construct()
	{
	    $this->createdAt = new \DateTime();
	    $this->updatedAt = new \DateTime();
	    $this->products = new ArrayCollection();
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
     * @return Recette
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
     * Set slug
     *
     * @param string $slug
     * @return Recette
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set permalink
     *
     * @param string $permalink
     * @return Recette
     */
    public function setPermalink($permalink)
    {
        $this->permalink = $permalink;

        return $this;
    }

    /**
     * Get permalink
     *
     * @return string 
     */
    public function getPermalink()
    {
        return $this->permalink;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Recette
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set shortDescription
     *
     * @param string $shortDescription
     * @return Recette
     */
    public function setShortDescription($shortDescription)
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }

    /**
     * Get shortDescription
     *
     * @return string 
     */
    public function getShortDescription()
    {
        return $this->shortDescription;
    }
    
	/**
     * {@inheritdoc}
     */
    public function hasFile()
    {
        return null !== $this->file;
    }

    /**
     * {@inheritdoc}
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * {@inheritdoc}
     */
    public function setFile(\SplFileInfo $file)
    {
        $this->file = $file;

        return $this;
    }
    
	/**
     * {@inheritdoc}
     */
    public function hasPath()
    {
        return null !== $this->path;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return Recette
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
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
     * @return Recette
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createAt = $createdAt;

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
     * @return Recette
     */
    public function setUpdatedAt(\DateTime $updatedAt)
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
    
	/**
     * {@inheritdoc}
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * {@inheritdoc}
     */
    public function setProducts(ArrayCollection $products)
    {
        $this->products = $products;
    }
    
	/**
     * {@inheritdoc}
     */
    public function addProduct(Product $product)
    {
        if (!$this->hasProduct($product)) {
            $this->products->add($product);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeProduct(Product $product)
    {
        if ($this->hasProduct($recette)) {
            $this->products->removeElement($product);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function hasProduct(Product $product)
    {
        return $this->products->contains($product);
    }

    /**
     * Set nbPersonnes
     *
     * @param integer $nbPersonnes
     * @return Recette
     */
    public function setNbPersonnes($nbPersonnes)
    {
        $this->nbPersonnes = $nbPersonnes;

        return $this;
    }

    /**
     * Get nbPersonnes
     *
     * @return integer 
     */
    public function getNbPersonnes()
    {
        return $this->nbPersonnes;
    }

    /**
     * Set typeCuisine
     *
     * @param string $typeCuisine
     * @return Recette
     */
    public function setTypeCuisine($typeCuisine)
    {
        $this->typeCuisine = $typeCuisine;

        return $this;
    }

    /**
     * Get typeCuisine
     *
     * @return string 
     */
    public function getTypeCuisine()
    {
        return $this->typeCuisine;
    }

    /**
     * Set preparation
     *
     * @param string $preparation
     * @return Recette
     */
    public function setPreparation($preparation)
    {
        $this->preparation = $preparation;

        return $this;
    }

    /**
     * Get preparation
     *
     * @return string 
     */
    public function getPreparation()
    {
        return $this->preparation;
    }

    /**
     * Set cuisson
     *
     * @param string $cuisson
     * @return Recette
     */
    public function setCuisson($cuisson)
    {
        $this->cuisson = $cuisson;

        return $this;
    }

    /**
     * Get cuisson
     *
     * @return string 
     */
    public function getCuisson()
    {
        return $this->cuisson;
    }

    /**
     * Set difficulte
     *
     * @param integer $difficulte
     * @return Recette
     */
    public function setDifficulte($difficulte)
    {
        $this->difficulte = $difficulte;

        return $this;
    }

    /**
     * Get difficulte
     *
     * @return integer 
     */
    public function getDifficulte()
    {
        return $this->difficulte;
    }
}
