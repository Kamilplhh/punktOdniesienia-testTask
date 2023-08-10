<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\FileRepositoryInterface;

class HomeController extends Controller
{
    private FileRepositoryInterface $fileRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(FileRepositoryInterface $fileRepository)
    {
        $this->middleware('auth');
        $this->fileRepository = $fileRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $files = $this->fileRepository->getFiles();
        return view('home', compact('files'));
    }
}
