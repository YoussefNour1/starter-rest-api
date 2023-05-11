<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function register(Request $request){
        $fields = $request->validate(
            [
                'name'=>'required|string',
                'email'=>'required|string|unique:users,email',
                'password'=>'required|string|confirmed',
                'contact_person_phone_number'=>'required'
            ]
        );

        $user = User::create(
            [
                'name'=>$fields['name'],
                'email'=>$fields['email'],
                'password'=>bcrypt($fields['password']),
                'contact_person_phone_number'=>$fields['contact_person_phone_number']
            ]
        );

        $token = $user->createToken('myapp')->plainTextToken;
        $user->remember_token = $token;
        $user->save();
        $response =['user'=>$user, 'token'=>$token];
        return response($response, 201);
    }

    public function login(Request $request){
        $fields = $request->validate(
            [
                'email'=>'required|string|email',
                'password'=>'required|string',
            ]
        );

        $user = User::where('email', $fields['email'])->first();
        // check password
        if (!$user || !Hash::check($fields['password'], $user->password)){
            return response([
                "message" => "email and password didn't match"
            ], 401);
        }
        $token = $user->createToken('myapp')->plainTextToken;
        $user->remember_token = $token;
        $user->save();
        $response =['user'=>$user, 'token'=>$token];
        return response($response, 200);
    }

    public function logout(Request $request){
        auth()->user()->tokens()->delete();

        return response([
            "message" => 'user logged out'
        ], 200);
    }
}
