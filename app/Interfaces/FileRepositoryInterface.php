<?php

namespace App\Interfaces;

interface FileRepositoryInterface
{
    public function getFiles();
    public function createFile(array $file);
}