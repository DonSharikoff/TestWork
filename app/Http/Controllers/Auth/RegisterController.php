<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Traits\LoginHelper;
use App\Http\Controllers\Controller;
use App\Service\UserService;
use Illuminate\Http\Request;

class RegisterController extends Controller {

    use LoginHelper;

    /**
     * @var $userService UserService
     */

    private $userService;

    public function __construct(UserService $service) {
        $this->userService = $service;
    }

    public function register(Request $request) {

        try {
            $client = $this->getClient($request);
        } catch(\Exception $exception) {
            return response()->json(['message' => 'Secret or client id has been incorrect'], 422);
        }

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:4', 'confirmed'],
        ]);

        try {
            $this->userService->create($validatedData);
            return $this->login($request, $client);
        } catch(\Exception $exception) {
            return response()->json(['message' => 'User\'s profile is cannot be created'], 422);
        }
    }
}
