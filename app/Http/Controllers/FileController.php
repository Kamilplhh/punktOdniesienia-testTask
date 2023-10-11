<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\FileRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use File;
use App\Models\Scan;

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
        if ($request['contractor_id'] > 0) {
            $request->request->remove('email');
            $request->request->remove('contractor');
            $request->request->remove('address1');
            $request->request->remove('address2');
            $request->request->remove('bank');
            $request->request->remove('nip');
        }
        $latest = $this->fileRepository->getLatest();
        $request['parentId'] = $latest['id'] + 1;

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
            'price' => ['required', 'numeric', 'min:0'],
        ]);

        $file = $request->file('fileScan');   
        $parser = new \Smalot\PdfParser\Parser();
        $pdf = ($parser->parseFile($file))->getText();
        $pdf = str_replace(' ', '', $pdf);
        
        $fileName = strval(rand()) . $request->file('fileScan')->getClientOriginalName();
        $file->move('uploads/file', $fileName);

        $request['file'] = $fileName;
        $request['user_id'] = Auth::id();
        $request['type'] = 'draft';
        $request['paid'] = intval($request['paid']);

        $request['contractor'] = '';
        $request['address1'] = '';
        $request['bank'] = null;
        $request['nip'] = null;

        $objects = Scan::where([
            ['user_id', '=', 1],
            ['user_id', '=', Auth::id()]
        ])->get();

        foreach ($objects as $key => $object) {
            if (isset($object['contractorText'])) {
                $text = $object['contractorText'];
                if (preg_match("/$text/", $pdf)) {
                    $result = preg_split('/[A-Z]/', substr($pdf, strpos($pdf, $text) + strlen($text)));
                    $request['contractor'] = $result[0];
                }
            }
            if (isset($object['addressText'])) {
                $text = $object['addressText'];
                if (preg_match("/$text/", $pdf)) {
                    $result = preg_split('/[A-Z]/', substr($pdf, strpos($pdf, $text) + strlen($text)));
                    $request['address1'] = $result[0];
                }
            }
            if (isset($object['bankText'])) {
                $text = $object['bankText'];
                if (preg_match("/$text/", $pdf)) {
                    $request['bank'] = intval(substr($pdf, strpos($pdf, $text) + strlen($text), 26));
                }
            }
            if (isset($object['nipText'])) {
                $text = $object['nipText'];
                if (preg_match("/$text/", $pdf)) {
                    $request['nip'] = intval(substr($pdf, strpos($pdf, $text) + strlen($text), 10));
                }
            }
        }

        $fileArray = $request->all([]);
        $this->fileRepository->createFile($fileArray);
        return redirect()->back();
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
        if ($request['contractor_id'] > 0) {
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

    public function removeRepetetive($id){
        $this->fileRepository->removeRepetetive($id);
        return redirect()->back();
    }
}
