<?php

namespace App\Interfaces;

interface FileRepositoryInterface
{
    public function getFiles();
    public function createFile(array $file);
    public function deleteFile($fileId);
    public function updateFile(array $file, $fileId);
    public function checkRepetitive();
    public function removeRepetetive($fileId);
}