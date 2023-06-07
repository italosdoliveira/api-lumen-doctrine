<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Services\Interfaces\ListServiceInterface;
use App\Entities\ShoppingList;
use App\Entities\Product;

class ListController extends BaseController
{
    private ListServiceInterface $listService;

    public function __construct(ListServiceInterface $listService){
        $this->listService = $listService;
    }

    public function show($id){
        return $this->listService->get_list($id);
    }

    public function add(Request $request){
        return $this->listService->add($request);
    }

    public function add_products(Request $request, $id){
        return $this->listService->add_products_on_list_from_request($request, $id);
    }

    public function remove_products(Request $request, $id){
        return $this->listService->remove_products($request, $id);
    }

    public function change(Request $request, $id){
        return $this->listService->change_product_quantity($request, $id);
    }
}
