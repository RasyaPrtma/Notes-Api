<?php

namespace App\Http\Controllers;

use App\Models\Authentication;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;

class AuthenticationController extends Controller
{
    public function Login(Request $request){
        $validate = Validator::make($request->all(),[
            'email' => 'required|email:rfc',
            'password' => 'required|min:5'
        ],[
            'required' => ':attribute harus terisi',
            'email' => 'format :attribute harus valid',
            'min' => ':attribute minimal 5 karakter'
        ]);
        if($validate->fails()){
            return response()->json([
                'message' => 'Invalid field',
                'errors' => $validate->errors()
            ],400);
        }else{
            $user = User::where('email',$request->email)->first();
            if($user !== null && Hash::check($request->password,$user->password)){
                $token = $user->createToken($user->id)->plainTextToken;
                return response()->json([
                    'message' => 'Login Berhasil',
                    'data' => [
                        'id' => $user->id,
                        'email' => $user->email,
                        'accessToken' => $token
                    ]
                ],200);
            }else{
                return response()->json([
                    'message' => 'Unauthorized'
                ],404);
            }
        }
    }
    public function Registrasi(Request $request){
        $validate = Validator::make($request->all(),[
            'name' => "required|unique:users,name|min:5",
            'email' => 'required|email:rfc|unique:users,email',
            'password' => 'required|min:5'
        ],[
            'required' => ':attribute harus terisi',
            'email' => 'format :attribute harus valid',
            'min' => ':attribute minimal 5 karakter',
            'unique' => ':attribute harus unik',
        ]);
        if($validate->fails()){
            return response()->json([
                'message' => 'Invalid field',
                'errors' => $validate->errors()
            ],400);
        }else{
           $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
            return response()->json([
                'message' => "Registrasi Berhasil",
                'data' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email
                ]
            ],201);
        }
    }
}
