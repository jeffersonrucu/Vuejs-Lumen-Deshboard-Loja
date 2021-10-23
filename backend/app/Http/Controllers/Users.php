<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;

// table database
use App\Models\freddom_fashion_users;


class Users extends Controller
{
    // Register User
    public function RegisterUser(Request $data) {

        try {
            freddom_fashion_users::create([
                'name' => $data->name, 
                'email' => $data->email,
                'password' => app('hash')->make($data->password),
            ]);
        }catch(Exception $error){
            return response()->json([
                'error' => 'Erro ao cadastrar usuario',
                'cod_error' => $error
            ],400);
        }       
        return response()->json([
            'status' => $data->name . ' Cadastrado com sucesso',
        ],200);
    }
}
