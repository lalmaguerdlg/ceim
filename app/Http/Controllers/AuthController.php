<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\DB;
use App\Repositories\ScopesRepository;

class AuthController extends Controller
{
    use AuthenticatesUsers;

    protected function sendLoginResponse(Request $request)
    {
        //$request->session()->regenerate();

        $this->clearLoginAttempts($request);

        return $this->authenticated($request, $this->guard()->user())
                ?: redirect()->intended($this->redirectPath());
    }

    protected function authenticated(\Illuminate\Http\Request $request, $user)
    {
        $scopes_repository = new ScopesRepository();
        $scopes_collection = $scopes_repository->getUniqueScopesForUser($user);
        
        $scopes = [];
        foreach($scopes_collection as $scope) {
            $scopes[] = $scope->scope;
        }
        
        $scope_names = implode(' ', $scopes);

        $new_request = Request::create(config('services.passport.login_endpoint'), 'POST', [
            'grant_type' => 'password',
            'client_id' => config('services.passport.client_id'),
            'client_secret' => config('services.passport.client_secret'),
            'username' => $request->email,
            'password' => $request->password,
            'scope' => $scope_names,
        ]);

        $response = app()->handle($new_request);

        $code = $response->status();

        if($code == 200) {
            return $response;
        }
        else {
            return $response;
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

        $rol_alumno = \App\Auth\Rol::where('rol', 'alumno')->first();

        $new_user = \App\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $new_user->save();
        $new_user->roles()->attach($rol_alumno);

        return $new_user;
    }

    public function logout(Request $request) 
    {
        //$this->guard()->logout();

        // auth()->user()->tokens->each(function ($token, $key) {
        //     $token->revoke();
        // });
        auth()->user()->token()->revoke();

        return response()->json('Logged out successfully', 200);
    }

}
