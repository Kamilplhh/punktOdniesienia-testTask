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

    public function addScanner(){
        
    }
}
