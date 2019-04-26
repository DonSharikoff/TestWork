<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Service\UserService;
use Illuminate\Http\Request;

class UserController extends Controller {

    /**
     * @var $userService UserService
     */

    private $userService;

    public function __construct(UserService $service) {
        $this->userService = $service;
    }

    public function user() {
        return response()->json(auth()->user());
    }

    public function all() {
        return response()->json($this->userService->getAll());
    }

    public function imgUpdate(Request $request) {

        $request->validate(['img' => ['image']]);

        try {
            $path = explode('/', $request->file('img')->store('public/img'));
            $path[0] = 'storage';
            $this->userService->updateCurrentUserImg(implode('/', $path));
            return response()->json();
        } catch(\Exception $exception) {
            return response()->json(['message' => 'User\'s image is cannot be updated'], 422);
        }
    }

    public function userUpdate(Request $request) {

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            ]);

        try {
            $this->userService->updateCurrentUserInfo($validatedData);
            return response()->json();
        } catch(\Exception $exception) {
            return response()->json(['message' => 'User\'s profile is cannot be updated'], 422);
        }
    }
}
