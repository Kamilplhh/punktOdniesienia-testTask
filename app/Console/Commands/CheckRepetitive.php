<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Interfaces\FileRepositoryInterface;

class CheckRepetitive extends Command
{
    private FileRepositoryInterface $fileRepository;

    public function __construct(FileRepositoryInterface $fileRepository)
    {
        parent::__construct();
        $this->fileRepository = $fileRepository;
    }
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:repetitive';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for repetetive files';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->fileRepository->checkRepetitive();
    }
}
