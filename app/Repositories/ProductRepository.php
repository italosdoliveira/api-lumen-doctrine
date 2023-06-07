<?php

namespace App\Repositories;

use Doctrine\ORM\EntityManagerInterface;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Entities\Product;

class ProductRepository implements ProductRepositoryInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function add(array $products){
        foreach ($products as $product){
            $this->entityManager->persist($product);
            $this->entityManager->flush();
        }
        
        return $products;
    }
}