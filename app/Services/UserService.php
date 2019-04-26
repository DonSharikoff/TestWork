<?php

namespace App\Service;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Collection;

class UserService {

    public function create(array $data): User {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function getAll(): Collection {
        return User::select(['name', 'created_at'])->get();
    }

    public function updateCurrentUserInfo(array $data): User {
        $user = auth()->user();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->save();
        return $user;
    }

    public function updateCurrentUserImg(string $path): User {
        $user = auth()->user();
        $user->img_path = $path;
        $user->save();
        return $user;
    }
}
