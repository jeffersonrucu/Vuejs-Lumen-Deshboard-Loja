<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;

// table database
use App\Models\freddom_fashion_product;

class Products extends Controller
{
    // Register product
    public function RegisterProduct(Request $data) {
        $urlImage = null;

        if ($data->file('photo')) {
            // image path
            $path = $_ENV['PATH_IMAGE']; 
            
            // store Image
            // vue js adicionar $file = $data->file('photo');
            $file = $data->file('photo');
            
            // store image name with a random number in front
            $fileName = rand(1, 999) . '_' . $file->getClientOriginalName();
            
            // put everything in tiny
            $fileName = strtolower ($fileName);
            
            // Avoid spaces in the name
            $fileName = str_replace(" ","_",preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities(trim($fileName))));
            
            // New image path
            $filePath = $path. '/products';
            
            // create folder if it doesn't exist
            if (!file_exists($filePath)) {
                mkdir($filePath);
            }
            
            // vue js adicionar $data->file('photo')->move($filePath, $fileName);
            $data->file('photo')->move($filePath, $fileName);
    
            $urlImage = $filePath . '/' . $fileName;
        }

        try {
            freddom_fashion_product::create([
                'barcode' => $data->input('barcode'),
                'name' => $data->input('name'),
                'value' => $data->input('value'),
                'amount' => $data->input('amount'),
                'image' => $urlImage
            ]);
        }   
        catch (Exception $error) {
            return response()->json([
                'error' => 'Erro ao cadastrar produto',
                'cod_error' => $error
            ],400);
        }   
        return response()->json([
            'status' => 'Produto cadastrado com sucesso',
        ],200);
    }

    // Specific product
    public function SpecificProduct($barcode) {
        $product = app('db')->select("SELECT * FROM products WHERE barcode = '" . $barcode . "'");
        $product[0]->image = str_replace('/var/www/html/0_Controle_de_Vendas/', 'http://localhost/0_Controle_de_Vendas/' , $product[0]->image);
        
        try {
            return response()->json([
                'id' => $product[0]->id,
                'barcode' => $product[0]->barcode, 
                'name' => $product[0]->name,
                'value' => $product[0]->value,
                'amount' => $product[0]->amount,
                'image' => $product[0]->image
            ],200);
        }catch (Exception $error) {
            return response()->json([
                'error' => 'Produto não encontrado',
                'cod_error' => $error
            ],400);
        }
    }

    // Modify product
    public function ModifyProduct(Request $data) {
        // validar usuario via token e criar imagem
        try {
            $product = freddom_fashion_product::find($data->id);

            $product->name = $data->name;
            $product->value = $data->value;
            $product->amount = $data->amount;
            $product->save();
        }catch (Exception $error) {
            return response()->json([
                'error' => 'Erro ao modificar dados',
                'cod_error' => $error
            ],400);
        }
        return response()->json([
            'status' => 'Produto modificados com sucesso',
        ],200);
    }

    // Delete product
    public function DeleteProduct(Request $data) {
        $products = freddom_fashion_product::find($data->id);
        $products->delete();
        return response($products, 200);
    }

    public function AllProduct() {
        $products = freddom_fashion_product::orderBy('created_at','desc')->get();
        for ($i = 0; $i < count($products); $i++) {
            $urlImage = $products[$i]->image;
            $products[$i]->image = str_replace('/var/www/html/0_Controle_de_Vendas/', 'http://localhost/0_Controle_de_Vendas/' , $urlImage);
        }
        return response($products, 200);
    }

    public function CountProducts() {
        // $products = freddom_fashion_product::all()->sum('value');
        $products = freddom_fashion_product::count();
        return response($products, 200);
    }
}
