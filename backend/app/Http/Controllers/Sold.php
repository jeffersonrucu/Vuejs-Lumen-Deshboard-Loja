<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;

// table database
use App\Models\freddom_fashion_product;
use App\Models\freddom_fashion_sold;


class Sold extends Controller
{
    public function SoldProduct(Request $data) {
        $product = freddom_fashion_product::find($data->id);
        $amount = $product->amount - 1;
        if ($product->amount = 0) {
            return response()->json([
                'status' => 'Sem Estoque'
            ],200);
        } else {
            try {
                $product->amount = $amount;
                $product->save();
    
                freddom_fashion_sold::create([
                    'id_product' => $data->id
                ]);
            }catch (Exception $error) {
                return response()->json([
                    'cod_error' => $error
                ],400);
            }
            return response()->json([
                'status' => 'Vendido com sucesso'
            ],200);
        }
    }

    public function SoldMonth() {
        $dateMonth = date("m");
        $dateYear = date("Y");
        $sold = app('db')->select("SELECT * FROM sold
        INNER JOIN products ON sold.id_product = products.id
        WHERE month(products.created_at) =" . $dateMonth . " AND year(products.created_at) =". $dateYear . ";");
        $sold = collect($sold)->sum('value');
        $trata_preco='R$' . number_format($sold, 2, ',', '.');

        return response()->json($trata_preco ,200);

    }

    public function CountSold() {
        // $products = freddom_fashion_product::all()->sum('value');
        $dateMonth = date("m");
        $dateYear = date("Y");
        $sold = app('db')->select("SELECT * FROM sold
        WHERE month(created_at) =" . $dateMonth . " AND year(created_at) =". $dateYear . ";");
        $sold = collect($sold)->count();

        return response($sold, 200);
    }

    public function GraficSold($year) {
        $valueMounth = [];
        
        for ($i = 1; $i <= 12; $i++) {
            $query = "SELECT products.value FROM sold
                        INNER JOIN products ON sold.id_product = products.id
                        WHERE month(products.created_at) =" . $i . " AND year(products.created_at)=" . $year . ";";
            
            $sold = app('db')->select($query);
            $sold = collect($sold)->count();
            array_push($valueMounth, $sold);
        }

        return response()->json([
            'name' => 'Quantidade Vendida',
            'data' => $valueMounth
        ],200);
    }
}
