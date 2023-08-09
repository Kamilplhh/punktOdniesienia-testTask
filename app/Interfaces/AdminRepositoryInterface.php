<?php

namespace App\Interfaces;

interface AdminRepositoryInterface
{
    public function getAllUsers();
    public function deleteUser($userId);
}