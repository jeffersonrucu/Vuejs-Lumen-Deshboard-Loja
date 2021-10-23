<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;

// table database
use App\Models\freddom_fashion_clients;

class Clients extends Controller
{

    // Register
    public function RegisterClient(Request $data) {
        try {
            freddom_fashion_clients::create([
                'name' => $data->name,
                'email' => $data->email,
                'cell_phone' => $data->cell_phone
            ]);
        }   
        catch (Exception $error) {
            return response()->json([
                'error' => 'Erro ao cadastrar cliente',
                'cod_error' => $error
            ],400);
        }   
        return response()->json([
            'status' => 'Cliente cadastrado com sucesso',
        ],200);
    }

    // Get All
    public function AllClients() {
        $clients = freddom_fashion_clients::orderBy('created_at','desc')->get();
        return response($clients, 200);
    }

    // Specific client
    public function SpecificClient(Request $data) {
        $product = freddom_fashion_clients::find($data->id);
        
        try {
            return response()->json($product, 200);
        }catch (Exception $error) {
            return response()->json([
                'error' => 'Produto não encontrado',
                'cod_error' => $error
            ],400);
        }
    }

    // edit
    public function ModifyClient(Request $data) {
        try {
            $client = freddom_fashion_clients::find($data->id);

            $client->email = $data->email;
            $client->cell_phone = $data->cell_phone;
            $client->save();
        }catch (Exception $error) {
            return response()->json([
                'error' => 'Erro ao modificar dados',
                'cod_error' => $error
            ],400);
        }
        return response()->json([
            'status' => 'Cliente modificados com sucesso',
        ],200);
    }

    // Delete product
    public function DeleteClient(Request $data) {
        $client = freddom_fashion_clients::find($data->id);
        $client->delete();
        return response($client, 200);
    }

    public function CountClients() {
        // $products = freddom_fashion_product::all()->sum('value');
        $clients = freddom_fashion_clients::count();
        return response($clients, 200);
    }
}
