<?php

namespace App\Entities\DTO;

class ProductOnListDTO {
    public int $list_id;
    public array $products;

    public function __construct($list_id,$products){
        $this->list_id = $list_id;
        $this->products = $products;
    }
}