<?php

namespace App\Repositories;

use App\Interfaces\AdminRepositoryInterface;
use App\Models\User;

class AdminRepository implements AdminRepositoryInterface 
{
    public function getAllUsers()
    {
        return User::where('id', '>', 1)->get();
    }

    public function deleteUser($userId) 
    {
        User::destroy($userId);
    }

}