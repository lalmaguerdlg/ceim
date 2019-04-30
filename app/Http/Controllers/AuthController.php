<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //

    function login(Request $request) 
    {
        $newRequest = Request::create(config('services.passport.login_endpoint'), 'POST', [
            'grant_type' => 'password',
            'client_id' => config('services.passport.client_id'),
            'client_secret' => config('services.passport.client_secret'),
            'username' => $request->username,
            'password' => $request->password
        ]);

        //return response()->json($newRequest);

        $response = app()->handle($newRequest);

        $code = $response->status();

        if($code == 200) {
            return $response;
        }
        else {
            if($code == 400){
                return response()->json([
                    'error' => 'Invalid Request.',
                    'message' => 'Please enter a username or a password.'
                ], $code);
            } else if($code == 401) {
                return response()->json([
                    'error' => 'Unauthorized.',
                    'message' => 'Invalid Credentials. Please try again.'
                ], $code);
            }

            return response()->json([
                'error' => 'Something went wrong with the server.',
                'message' => 'Something went wrong with the server.'
            ], $code);
        }

        //$response = \Illuminate\Support\Facades\Route::dispatch($newRequest);
    
        /*
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
        */
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

    function logout(Request $request) 
    {
        auth()->user()->tokens->each(function ($token, $key) {
            $token->revoke();
        });

        return response()->json('Logged out successfully', 200);
    }
}
