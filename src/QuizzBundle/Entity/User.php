<?php

namespace QuizzBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=100)
     */
    private $ville;

    /**
     * @ORM\OneToMany(targetEntity="Produits", mappedBy="user")
     */
    private $produits;

    public function __construct()
    {
        $this->user = new ArrayCollection();
    }


    /**
     * Set ville
     *
     * @param string $ville
     *
     * @return User
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Add produit
     *
     * @param \QuizzBundle\Entity\Produits $produit
     *
     * @return User
     */
    public function addProduit(\QuizzBundle\Entity\Produits $produit)
    {
        $this->produits[] = $produit;

        return $this;
    }

    /**
     * Remove produit
     *
     * @param \QuizzBundle\Entity\Produits $produit
     */
    public function removeProduit(\QuizzBundle\Entity\Produits $produit)
    {
        $this->produits->removeElement($produit);
    }

    /**
     * Get produits
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProduits()
    {
        return $this->produits;
    }
}
