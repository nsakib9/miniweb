<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        // dd($request->getPathInfo());
        $accessToken = $request->access;
        if (!empty($accessToken)) {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $accessToken,
            ])->get(route('authCheck'));

            $auth = $response->json();
            Auth::loginUsingId($auth['id']);
            return $request->getPathInfo();
        }


        if (!$request->expectsJson()) {
            return route('login');
        }
    }
}
