<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\MyEmail;
use Illuminate\Support\Facades\Mail;
use File;

class PHPMailerController extends Controller
{
    public function sendEmail(Request $request)
    {
        $objects = $request['files'];

        $zip = new \ZipArchive();
        $fileName = strval(rand()) . 'invoices.zip';
        if ($zip->open('uploads/zips/' . $fileName, \ZipArchive::CREATE) == TRUE) {
            $files = File::files('uploads/file');
            foreach ($files as $key => $value) {
                $relativeName = basename($value);
                foreach ($objects as $object) {
                    if ($relativeName = $object) {
                        $zip->addFile($value, $relativeName);
                    }
                }
            }
            $zip->close();
        }
        $path = 'uploads/zips/' . $fileName;

        $recipientEmail = $request['email'];
        Mail::to($recipientEmail)->send(new MyEmail($path));
    }
}
