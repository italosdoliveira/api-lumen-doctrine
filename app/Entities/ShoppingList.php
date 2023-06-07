<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="shopping_lists")
 */
class ShoppingList 
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

     /**
     * @ORM\Column(type="string")
     */
    private $name;

    public function __construct($name = ""){
        if(empty($name)){
            throw new Exception();
        }

        $this->name = $name;
    }
}