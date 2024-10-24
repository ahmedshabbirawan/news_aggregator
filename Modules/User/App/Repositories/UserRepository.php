<?php

namespace Modules\User\App\Repositories;
use App\Models\User;

class UserRepository
{
    static function createUser(array $data)
    {
        return User::create($data);
    }

}
