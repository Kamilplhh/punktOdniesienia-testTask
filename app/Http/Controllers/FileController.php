<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\FileRepositoryInterface;
use Illuminate\Support\Facades\Auth;


class FileController extends Controller
{
    private FileRepositoryInterface $fileRepository;

    public function __construct(FileRepositoryInterface $fileRepository)
    {
        $this->fileRepository = $fileRepository;
    }

    public function scanUpload(Request $request)
    {
        $request->validate([
            'fileScan' => ['required', 'mimes:jpg,png', 'max:10240'],
            'title' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'bank' => ['required', 'numeric', 'min:0'],
            'nip' => ['required', 'numeric', 'min:0'],
            'invoice_number' => ['required', 'string', 'max:255'],
            'date' => ['required', 'date'],
            'adress' => ['required', 'string', 'max:255'],
            'recipient' => ['required', 'string', 'max:255'],
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
        $fileArray['paid'] = intval($fileArray['paid']);
        $fileArray['price'] = floatval($fileArray['price']);

        $this->fileRepository->createFile($fileArray);
    }
}
