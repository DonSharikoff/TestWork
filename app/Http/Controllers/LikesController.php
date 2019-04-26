<?php

namespace App\Http\Controllers;


use App\Service\LikesService;
use Illuminate\Http\Request;

class LikesController extends Controller {

    /**
     * @var $likesService LikesService
     */

    private $likesService;

    public function __construct(LikesService $service) {
        $this->likesService = $service;
    }

    public function user() {
        return response()->json(auth()->user()->load('getLikes'));
    }

    public function save(Request $request) {
        $validatedData = $request->validate([
            'target' => ['required', 'Numeric', 'exists:users,id'],
        ]);
        try {
            $this->likesService->create($validatedData['target']);
            return response()->json();
        } catch(\Exception $exception) {
            return response()->json(['message' => 'Error with like']);
        }
    }

}
