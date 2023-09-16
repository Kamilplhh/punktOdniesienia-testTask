<?php

namespace App\Repositories;

use App\Interfaces\FileRepositoryInterface;
use App\Models\File;
use Illuminate\Support\Facades\Auth;

class FileRepository implements FileRepositoryInterface
{
    public function getFiles()
    {
        return File::where('user_id', '=', Auth::id())->get();
    }

    public function createFile(array $file)
    {
        return File::create($file);
    }

    public function deleteFile($fileId) 
    {
        File::destroy($fileId);
    }
}

