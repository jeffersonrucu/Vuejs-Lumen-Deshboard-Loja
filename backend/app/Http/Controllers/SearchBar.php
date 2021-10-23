<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\freddom_fashion_product;


class They_Tools_SearchBar extends Controller
{
    public function SearchMessage (Request $data) {
        
        if ($data->search == null || $data->search == "" || $data->search == " ") {
            $products = freddom_fashion_product::orderBy('created_at','desc')->get();
            for ($i = 0; $i < count($products); $i++) {
                $urlImage = $products[$i]->featured_image;
                $products[$i]->featured_image = str_replace('/var/www/html/0_Controle_de_Vendas/', 'http://localhost/cadastrar_produto/' , $urlImage);
            }
            return response($products, 200);
        } else {
            $query_search =  " SELECT * FROM product 
                                WHERE name LIKE '%" . $data->search . "%'
                                OR barcode LIKE '%" . $data->search . "%;'";

            $products = app('db')->select($query_search);

            for ($i = 0; $i < count($products); $i++) {
                $urlImage = $products[$i]->featured_image;
                $products[$i]->featured_image = str_replace('/var/www/html/0_Controle_de_Vendas/', 'http://localhost/cadastrar_produto/' , $urlImage);
            }
            return response($products, 200);
        }
    }
}
