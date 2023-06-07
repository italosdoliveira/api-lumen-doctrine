<?php

namespace App\Repositories;

use App\Repositories\Interfaces\ListRepositoryInterface;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManagerInterface;
use App\Entities\ShoppingList;

class ListRepository implements ListRepositoryInterface
{   
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function get_by_id(int $id){
        $connection = $this->get_connection();
        $queryBuilder = $connection->createQueryBuilder();

        $queryBuilder
            ->select('pl.id', 'pl.shopping_list_id as list_id', 'pl.product_id', 'p.name','pl.quantity')
            ->from('products_on_list', 'pl')
            ->innerJoin('pl', 'products', 'p', 'pl.product_id = p.id')
            ->where('pl.shopping_list_id', $id);

        return $queryBuilder->execute()->fetchAll();
    }

    public function add(ShoppingList $list)
    {
        $this->entityManager->persist($list);
        $this->entityManager->flush();
        
        return $list;
    }

    public function add_products_on_list(array $products_on_list){
        foreach($products_on_list as $product_on_list){
            $this->entityManager->persist($product_on_list);
            $this->entityManager->flush();
            
            return $list;
        }
    }

    public function add_products_on_list_sql(int $list_id, array $products){
        $connection = $this->get_connection();
        $queryBuilder = $connection->createQueryBuilder();

        foreach($products as $product)
        {
            $queryBuilder
                ->insert('products_on_list')
                ->setValue('shopping_list_id', $list_id)
                ->setValue('product_id', $product["id"])
                ->setValue('quantity', $product["quantity"]);
            
            $connection->executeQuery($queryBuilder->getSQL());
        }
    }

    public function change_product_quantity(int $list_id, array $products)
    {
        $connection = $this->get_connection();
        $queryBuilder = $connection->createQueryBuilder();

        foreach($products as $product)
        {
            $queryBuilder
                ->update('products_on_list', 'pl')
                ->set('pl.quantity', $product["quantity"])
                ->where(
                    $queryBuilder->expr()->and(
                        $queryBuilder->expr()->eq('shopping_list_id', $list_id),
                        $queryBuilder->expr()->eq('product_id', $product["id"])
                    )
                );
            
            $connection->executeQuery($queryBuilder->getSQL());
        }
    }

    public function remove_products(int $list_id, array $products){
        $connection = $this->get_connection();
        $queryBuilder = $connection->createQueryBuilder();

        foreach($products as $product)
        {
            $queryBuilder
                ->delete('products_on_list')
                ->where(
                    $queryBuilder->expr()->and(
                        $queryBuilder->expr()->eq('shopping_list_id', $list_id),
                        $queryBuilder->expr()->eq('product_id', $product["id"])
                    )
                );
        
            $connection->executeQuery($queryBuilder->getSQL());
        }
    }

    private function get_connection(){
        $connectionParams = array(
            'dbname' => env('DB_DATABASE'),
            'user' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'host' => 'localhost',
            'driver' => 'pdo_mysql',
        );

        $connection = DriverManager::getConnection($connectionParams);

        return $connection;
    }
}