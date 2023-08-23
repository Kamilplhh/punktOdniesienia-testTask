<?php

namespace App\Http\Controllers;

use App\Models\Scan;
use Illuminate\Http\Request;

class ScanController extends Controller
{
    public function getData(){
        $data = Scan::get();

        $response['data'] = $data;

        return response()->json($response);
    }

    public function addScanner(Request $request){
        $request->validate([
            'priceText' => ['nullable', 'string', 'max:255'],
            'timeText' => ['nullable', 'string', 'max:255'],
            'bankText' => ['nullable', 'string', 'max:255'],
        ]);

        $fileArray = $request->all([]);
        Scan::create($fileArray);
        return redirect()->back();
    }
}
