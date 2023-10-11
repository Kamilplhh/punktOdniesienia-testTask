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

    public function updateFile(array $file, $fileId)
    {
        File::find($fileId)->update($file);
    }

    public function getLatest()
    {
        $latest = File::orderBy('id', 'DESC')->first();
        return $latest;
    }

    public function removeRepetetive($fileId)
    {
        $parent = File::where('id', '=', $fileId)->value('parentId');
        File::destroy($fileId);
        File::where('parentId', '=', $parent)->update(['cycleFrequency' => 0]);
    }

    public function checkRepetitive()
    {
        date_default_timezone_set('Europe/Warsaw');
        $date = date("Y-m-d");
        $files = File::where('type', '=', 'avg_pace')->orderBy('addDate', 'DESC')->get();
        $parentArray = [];

        foreach ($files as $file) {
            if (!in_array($file->parentId, $parentArray)) {
                array_push($parentArray, $file->parentId);
                if ($file->cycleFrequency == 1) {
                    $file->addDate = $date;
                    $fileArray = $file->toArray();
                    File::create($fileArray);
                } elseif ($file->cycleFrequency == 2) {
                    if (abs(strtotime($file->addDate) - strtotime($date)) >= 604800) {
                        $file->addDate = $date;
                        $fileArray = $file->toArray();
                        File::create($fileArray);
                    }
                } elseif ($file->cycleFrequency == 3) {
                    if (abs(strtotime($file->addDate) - strtotime($date)) >= 2629743) {
                        $file->addDate = $date;
                        $fileArray = $file->toArray();
                        File::create($fileArray);
                    }
                } elseif ($file->cycleFrequency == 4) {
                    if (abs(strtotime($file->addDate) - strtotime($date)) >= 31556926) {
                        $file->addDate = $date;
                        $fileArray = $file->toArray();
                        File::create($fileArray);
                    }
                }
            }
        }
    }
}
