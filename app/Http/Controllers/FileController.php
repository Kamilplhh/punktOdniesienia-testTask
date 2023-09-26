<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\FileRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use File;

class FileController extends Controller
{
    private FileRepositoryInterface $fileRepository;

    public function __construct(FileRepositoryInterface $fileRepository)
    {
        $this->fileRepository = $fileRepository;
    }

    public function deleteFile($id)
    {
        $this->fileRepository->deleteFile($id);
        return redirect()->back();
    }

    public function scanUpload(Request $request)
    {
        $request->validate([
            'fileName' => ['required', 'mimes:jpg,png', 'max:10240'],
            'title' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
        ]);
        $file = $request->file('fileName');
        $fileName = strval(rand()) . $request->file('fileName')->getClientOriginalName();
        $file->move('uploads/file', $fileName);

        $request['file'] = $fileName;
        $request['user_id'] = Auth::id();
        $request['type'] = 'scan';

        $fileArray = $request->all([]);

        $this->fileRepository->createFile($fileArray);
        return redirect()->back();
    }

    public function addFile(Request $request)
    {
        $request->validate([
            'fileName' => ['required', 'mimes:jpg,png,pdf', 'max:10240'],
            'title' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
        ]);
        if($request['contractor_id'] > 0){
            $request->request->remove('email');
            $request->request->remove('contractor');
            $request->request->remove('address1');
            $request->request->remove('address2');
            $request->request->remove('bank');
            $request->request->remove('nip');
        }
        
        $file = $request->file('fileName');
        $fileName = strval(rand()) . $request->file('fileName')->getClientOriginalName();
        $file->move('uploads/file', $fileName);

        $request['file'] = $fileName;
        $request['user_id'] = Auth::id();
        $request['type'] = 'avg_pace';

        $fileArray = $request->all([]);
        $this->fileRepository->createFile($fileArray);
        return redirect()->back();
    }

    public function pdfUpload(Request $request)
    {
        $request->validate([
            'fileScan' => ['required', 'mimes:pdf', 'max:10240'],
            'title' => ['required', 'string', 'max:255'],
            'adress' => ['required', 'string', 'max:255'],
            'recipient' => ['required', 'string', 'max:255'],
        ]);
        if (!empty($request['bank'])) {
            $request->validate([
                'bank' => ['required', 'numeric', 'min:0'],
                'price' => ['required', 'numeric', 'min:0'],
                'nip' => ['required', 'numeric', 'min:0'],
                'invoice_number' => ['required', 'string', 'max:255'],
                'date' => ['required', 'date'],
            ]);
            $file = $request->file('fileScan');
            $fileName = $request->file('fileScan')->getClientOriginalName();
            $file->move('uploads/file', $fileName);

            if (isset($request['paid'])) {
                $request['paid'] = 1;
            } else {
                $request['paid'] = 0;
            }
            $request['date'] = date("Y-m-d", strtotime($request['date']));
            $request['paymentDate'] = $request['date'];
            $request['file'] = $fileName;
            $request['user_id'] = Auth::id();

            $fileArray = $request->all([]);

            $this->fileRepository->createFile($fileArray);
            return redirect()->back();
        } else {
            $parser = new \Smalot\PdfParser\Parser();

            $file = $request->file('fileScan');
            $pdf = ($parser->parseFile($file))->getText();

            $fileName = $request->file('fileScan')->getClientOriginalName();
            $file->move('uploads/file', $fileName);

            echo '<div class="loader"></div><center><h1>Your file is uploading</h1></center>';
            echo '<div id="textFile" style="display:none !important">' . $pdf;
            if (isset($request['paid'])) {
                echo " Paid ";
            }
            echo " -+=" . $request['title'] . "=+- ";
            echo " -=-" . $request['adress'] . "-=- ";
            echo " +=+" . $request['recipient'] . "+=+ ";
            echo "===" . $fileName . '<div>';
            return view('upload');
        }
    }

    public function sendScan(Request $request)
    {
        $fileArray = $request->post();
        $fileArray['date'] = date("Y-m-d", strtotime($fileArray['date']));
        $fileArray['paymentDate'] = $fileArray['date'];
        $fileArray['user_id'] = Auth::id();
        $fileArray['bank'] = intval($fileArray['bank']);
        $fileArray['paid'] = intval($fileArray['paid']);
        $fileArray['nip'] = intval($fileArray['nip']);
        $fileArray['price'] = floatval($fileArray['price']);

        $this->fileRepository->createFile($fileArray);
    }

    public function downloadAll(Request $request)
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

        return response($fileName);
    }

    public function editFile(Request $request)
    {
        if($request['contractor_id'] > 0){
            $request->request->remove('email');
            $request->request->remove('contractor');
            $request->request->remove('address1');
            $request->request->remove('address2');
            $request->request->remove('bank');
            $request->request->remove('nip');
        }

        $fileArray = $request->all([]);

        $this->fileRepository->updateFile($fileArray, $request['id']);
        return redirect()->back();
    }
}
