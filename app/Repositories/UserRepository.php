<?php

namespace App\Repositories;

use App\Contracts\Repository\UserRepositoryContract;
use App\User;
use Illuminate\Support\Collection;

class UserRepository implements UserRepositoryContract {
    public function getUsersForSelection() : Collection {
        return User::select('id', 'first_name', 'last_name')->get();
    }
}
