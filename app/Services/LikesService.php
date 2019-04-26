<?php

namespace App\Service;

use App\Models\UserToUserLikes;

class LikesService {

    public function create(int $target): UserToUserLikes {
        return UserToUserLikes::create([
            'owner_id' => auth()->id(),
            'target_id' => $target
        ]);
    }
}
