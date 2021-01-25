<?php

namespace App\Contracts\Repository;

use Illuminate\Support\Collection;


interface UserRepositoryContract {
    public function getUsersForSelection() : Collection;
}
