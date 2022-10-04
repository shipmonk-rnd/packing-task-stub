<?php

namespace App\Entity;

use App\Helper\Traits\IdentifierTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class PreviousPackaging extends BaseEntity
{

    use IdentifierTrait;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Packaging")
     * @ORM\JoinColumn(name="packaging_id", referencedColumnName="id", nullable=false)
     */
    private Packaging $packaging;

    /**
     * @var Product[]|Collection
     * @ORM\ManyToMany(targetEntity="App\Entity\Product")
     * @ORM\JoinTable( name="previous_packaging_product",
     *     joinColumns={@ORM\JoinColumn(name="previous_package_id", referencedColumnName="id", nullable=false)},
     *     inverseJoinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="id", nullable=false)}
     * )
     */
    private $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    /**
     * @return Product[]|Collection
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): void
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
        }
    }

    public function getPackaging(): Packaging
    {
        return $this->packaging;
    }

    public function setPackaging(Packaging $packaging): void
    {
        $this->packaging = $packaging;
    }
}
