<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;
use App\Entities\ShoppingList;
use App\Entities\Product;

/**
 * @ORM\Entity
 * @ORM\Table(name="products_on_list")
 */
class ProductOnList 
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="ShoppingList")
     * @ORM\JoinColumn(name="shopping_list_id", referencedColumnName="id")
     */
     private ShoppingList $list;

     /**
     * @ORM\OneToOne(targetEntity="Product")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    private Product $product;

    /**
     * @ORM\Column(type="integer")
     */
    private int $quantity;

    public function __construct(ShoppingList $list, Product $product, $quantity){
        $this->list = $list;
        $this->product = $product;
        $this->quantity = $quantity;
    }
}