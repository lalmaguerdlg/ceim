<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //

    function login(Request $request) 
    {
        $http = new \GuzzleHttp\Client;
        try {

            $response = $http->post( config('services.passport.login_endpoint'), [
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => config('services.passport.client_id'),
                    'client_secret' => config('services.passport.secret'),
                    'username' => $request->username,
                    'password' => $request->password
                ]
            ]);
            return $response->getBody();
        } catch(\GuzzleHttp\Exception\BadResponseException $e) {
            if($e->getCode() == 400) {
                return response()->json('Invalid Request. Please enter a username or a password.', $e->getCode());
            } else if($e->getCode() == 401) {
                return response()->json('Invalid Credentials. Please try again.', $e->getCode());
            }

            return response()->json('Something went wrong with the server.', $e->getCode());
        }
    }

    function register(Request $request) 
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        return \App\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
    }
}
