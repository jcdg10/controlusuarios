<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Auth;

class AuthController extends Controller
{
    public function createUser(Request $request)
    {   
        try{

            $validatedUser = Validator::make($request->all(),
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required'
            ]);

            if($validatedUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'Error de validacion',
                    'errors' => $validatedUser->errors()
                ], 401);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Usuario creado',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);

        }   catch (\Throwable $th) {

            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
                'errors' => $validatedUser->errors()
            ], 401);

        }
    }

    public function loginUser(Request $request)
    {   
        try{

            $validatedUser = Validator::make($request->all(),
            [
                'email' => 'required|email',
                'password' => 'required'
            ]);

            if($validatedUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'Error de validacion',
                    'errors' => $validatedUser->errors()
                ], 401);
            }

            if(!Auth::attempt($request->only('email','password'))){
                return response()->json([
                    'status' => false,
                    'message' => 'El email y/o el password son incorrectos',
                    'errors' => $validatedUser->errors()
                ], 401);
            }

            $user = User::where('email', $request->email)->first();

            return response()->json([
                'status' => true,
                'message' => 'Ingresaste correctamente',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);

        }   catch (\Throwable $th) {

            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);

        }
    }
}
