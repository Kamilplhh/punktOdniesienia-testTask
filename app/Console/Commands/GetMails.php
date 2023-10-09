<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Webklex\IMAP\Facades\Client;
use App\Models\User;
use App\Models\Contractor;
use App\Interfaces\FileRepositoryInterface;

class GetMails extends Command
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
    protected $signature = 'get:mails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get files from received mails';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $users = User::whereNotNull('invoiceEmail')->get();

        foreach ($users as $key => $user) {
            $username = $user['invoiceEmail'];
            $password = $user['emailPassword'];

            // Set up dynamic IMAP configuration.
            $config = [
                'host' => 'mail.example.com',
                'port' => 993,
                'encryption' => 'ssl',
                'validate_cert' => true,
                'username' => $username,
                'password' => $password,
            ];

            $mailbox = Client::account('dynamic_account')
                ->setConfig($config);

            $mailbox->connect();


            $messages = $mailbox->searchMessages(['date' => now()->format('Y-m-d')]);

            foreach ($messages as $message) {
                // Process only emails with PDF attachments.
                if ($this->hasPdfAttachment($message)) {
                    $attachments = $message->getAttachments();

                    foreach ($attachments as $attachment) {
                        if ($attachment->getMimeType() === 'application/pdf') {
                            // Save the PDF attachment to a directory.
                            $pdfFilename = strval(rand()) . $attachment->getName();
                            $pdfContent = $attachment->getContent();

                            // Save the PDF to the directory.
                            file_put_contents('uploads/file', $pdfContent);

                            $data = array(
                                'email' => $message->getFrom()[0]['mail'],
                                'title' => $message->getSubject(),
                                'file' => $pdfFilename,
                                'content' => $message->getHTMLBody(),
                                'type' => 'mail',
                                'user_id' => $user['id'],
                            );

                            $contractors = Contractor::get();
                            foreach ($contractors as $key => $contractor) {
                                $emailArray = array(
                                    $contractor['email'],
                                    $contractor['email1'],
                                    $contractor['email2'],
                                    $contractor['email3'],
                                    $contractor['email4'],
                                );

                                if(in_array($message->getFrom()[0]['mail'], $emailArray)){
                                    unset($data['email']);
                                    $data['contractor_id'] = $contractor['id'];
                                    break;
                                }
                            }

                            $this->fileRepository->createFile($data);
                        }
                    }
                }
            }

            $mailbox->disconnect();
        }
    }

    protected function hasPdfAttachment($message)
    {
        foreach ($message->getAttachments() as $attachment) {
            if ($attachment->getMimeType() === 'application/pdf') {
                return true;
            }
        }

        return false;
    }
}
