<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return response()->json( $validator->errors(), 400);       
        }
   
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('EscapeRooms')->plainTextToken; 
            $success['name'] =  $user->name;
   
            return response()->json($success);
        } 
        else{ 
            return response()->json(['Unauthorised.', ['error'=>'Invalide Credentials']], 403);
        } 
    }
}
