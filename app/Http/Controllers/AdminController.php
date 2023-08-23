<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Interfaces\AdminRepositoryInterface;
use App\Models\Scan;

class AdminController extends Controller
{
    private AdminRepositoryInterface $adminRepository;

    public function __construct(AdminRepositoryInterface $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }

    public function getUsers()
    {
        $scans = Scan::get();
        $users = $this->adminRepository->getAllUsers();
        return view('admin', compact('users', 'scans'));
    }

    public function deleteUser($id)
    {
        $this->adminRepository->deleteUser($id);
        return redirect()->back();
    }
}
