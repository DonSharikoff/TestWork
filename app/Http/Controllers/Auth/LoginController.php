<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\LoginHelper;
use Illuminate\Http\Request;

class LoginController extends Controller {

    use LoginHelper;

    public function auth(Request $request) {

        try {
            $client = $this->getClient($request);
        } catch(\Exception $exception) {
            return response()->json(['message' => 'Secret or client id has been incorrect'], 422);
        }

        return $this->login($request, $client);
    }

    public function logout() {
        try {
            auth()->user()->getToken()->delete();
            return response()->json();
        } catch(\Exception $exception) {
            return response()->json(['message' => 'Failed'], 400);
        }
    }
}
