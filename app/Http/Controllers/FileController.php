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
            'date' => ['required', 'date'],
            'bank' => ['required', 'string'],
        ]);
        
        $file = $request->file('fileScan');
        $fileName = $request->file('fileScan')->getClientOriginalName();
        $file->move('uploads/file', $fileName);

        if(isset($request['paid'])){
            $request['paid'] = 1;
        }else {
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
        ]);
        $parser = new \Smalot\PdfParser\Parser(); 

        $file = $request->file('fileScan');
        $pdf = ($parser->parseFile($file))->getText(); 
        echo $pdf;

        if(isset($request['paid'])){
            $request['paid'] = 1;
        }else {
            $request['paid'] = 0;
        }

        $fileArray = $request->all([]);


        return view('upload', compact('pdf'));
    }
}
