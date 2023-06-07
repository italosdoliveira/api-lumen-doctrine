<?php

namespace App\Services\Interfaces;

use Illuminate\Http\Request;

interface ListServiceInterface 
{
    function add(Request $request);
    function add_products_on_list_from_request(Request $request, int $id);
    function remove_products(Request $request, int $id);
    function get_list(int $id);
    function change_product_quantity(Request $request, int $id);
}