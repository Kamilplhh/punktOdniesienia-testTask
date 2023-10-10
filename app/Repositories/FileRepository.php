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
        $files = File::where('type', '=', 'avg_pace')->get();

        foreach($files as $file){
            if($file->cycleFrequency = 1){
                $file->addDate = $date;
                File::create($file);
            }
            elseif($file->cycleFrequency = 2){
                if(($file->addDate - $date) >= 604800){
                    $file->addDate = $date;
                    File::create($file);
                }
            }
            elseif($file->cycleFrequency = 3){
                if(($file->addDate - $date) >= 15778463){
                    $file->addDate = $date;
                    File::create($file);
                }
            }
            elseif($file->cycleFrequency = 4){
                if(($file->addDate - $date) >= 3155692){
                    $file->addDate = $date;
                    File::create($file);
                }
            }
        }
    }
}
