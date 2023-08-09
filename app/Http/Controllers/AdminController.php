<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Interfaces\AdminRepositoryInterface;

class AdminController extends Controller
{
    private AdminRepositoryInterface $adminRepository;

    public function __construct(AdminRepositoryInterface $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }

    public function getUsers()
    {
        $users = $this->adminRepository->getAllUsers();
        return view('admin', compact('users'));
    }

    public function deleteUser($id)
    {
        $this->adminRepository->deleteUser($id);
        return redirect()->back();
    }
}
