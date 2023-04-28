<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    
    /**
     * @OA\Post(
     *     path="/login",
     *     operationId="login",
     *     tags={"Login"},
     *     summary="Login service",
     *     description="Authentication with credential to have JWT token",
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", example="test@test.com"),
     *             @OA\Property(property="password", type="string", example="mysecurepassword")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Unauthorised"
     *     )
     * )
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
   
            return response()->json($success,201);
        } 
        else{ 
            return response()->json(['Unauthorised.', ['error'=>'Invalide Credentials']], 403);
        } 
    }

    public function unauthorized()
    {
        return response()->json([
            "error"=> "Unauthorized",
            "message"=> "You must be authenticated to access this resource"
        ],401);
    }

}
