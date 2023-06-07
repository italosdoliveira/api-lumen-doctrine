<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Services\Interfaces\ListServiceInterface;
use App\Repositories\Interfaces\ListRepositoryInterface;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Entities\ShoppingList;
use App\Entities\Product;
use App\Entities\ProductOnList;
use App\Entities\DTO\ProductOnListDTO;

class ListService implements ListServiceInterface 
{
    private ListRepositoryInterface $listRepository;
    private ProductRepositoryInterface $productRepository;

    public function __construct(ListRepositoryInterface $listRepository, ProductRepositoryInterface $productRepository)
    {
        $this->listRepository = $listRepository;
        $this->productRepository = $productRepository;
    }

    public function add(Request $request){
        $body = $request->all();
        $list_name = $body["name"];
        $products = $body["products"];

        $this->has_name($list_name);
        $this->has_products($products);

        $list = new ShoppingList($list_name);
        $array_products_object = $this->get_products_from_request($products);

        try{
            $saved_list = $this->listRepository->add($list);
            $saved_products = $this->productRepository->add($array_products_object);

            $list_from_product_on_list = array();
            $counter = 0;

            foreach($saved_products as $saved_product){
                array_push($list_from_product_on_list, new ProductOnList($saved_list, $saved_product, $products[$counter]["quantity"]));
                $counter++;
            }
            $this->listRepository->add_products_on_list($list_from_product_on_list);

            response()->json("Lista adicionada com sucesso", 200);
        }
        catch(Exception $ex){
            return response()->json("Houve um erro ao salvar os dados", 500);
        }
    }

    public function add_products_on_list_from_request(Request $request, int $id){
        $body = $request->all();
        $products = $body["products"];
        
        try{
            $this->listRepository->add_products_on_list_sql($id, $products);
            response()->json("Produto adicionado com sucesso na lista", 200);
        }
        catch(Exception $ex){
            return response()->json("Houve um erro ao salvar os dados", 500);
        }
    }

    public function remove_products(Request $request, int $id){
        $body = $request->all();
        $products = $body["products"];

        try{
            $this->listRepository->remove_products($id, $products);
            response()->json("Lista atualizada com sucesso", 200);
        }
        catch(Exception $ex){
            return response()->json("Houve um erro ao salvar os dados", 500);
        }
    }

    public function get_list(int $id){
        $result = $this->listRepository->get_by_id($id);
        $list_id = $result[0]["list_id"];
        $products = array();
        
        foreach($result as $list){
            array_push($products, array(
                "id" => $list["product_id"],
                "name" => $list["name"],
                "quantity" => $list["quantity"]
            ));
        }

        $productOnListDTO = new ProductOnListDTO($list_id, $products);

        return response()->json($productOnListDTO, 200);
    }

    public function change_product_quantity(Request $request, $id){
        $body = $request->all();
        $products = $body["products"];

        try{
            $this->listRepository->change_product_quantity($id, $products);
            response()->json("Lista atualizada com sucesso", 200);
        }
        catch(Exception $ex){
            return response()->json("Houve um erro ao salvar os dados", 500);
        }
    }

    public function has_name(string $name){
        if(empty($name)){
            return response()->json("Informe o nome da lista", 500);
        }
    }

    public function has_products(array $products){
        if(empty($products)){
            return response()->json("Informe pelo menos um produto", 500);
        }
    }

    private function get_products_from_request(array $products){
        $products_quantity = array();

        foreach($products as $product){
            array_push($products_quantity, new Product($product["name"], $product["quantity"]));
        }

        return $products_quantity; 
    }
}
