<?php

namespace App\Repositories\Interfaces;

use App\Entities\ShoppingList;

interface ListRepositoryInterface 
{
    function get_by_id(int $id);
    function add(ShoppingList $list);
    function add_products_on_list(array $products_on_list);
    function add_products_on_list_sql(int $list_id, array $products);
    function change_product_quantity(int $list_id, array $products);
    function remove_products(int $list_id, array $products);
}