<?php

namespace App\Http\Controllers;

use App\Models\Scan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScanController extends Controller
{
    public function getData()
    {
        $data = Scan::where([
            ['user_id', '=', 1],
            ['user_id', '=', Auth::id()]
        ])->get();
        $response['data'] = $data;

        return response()->json($response);
    }

    public function addScanner(Request $request)
    {
        $request->validate([
            'contractorText' => ['nullable', 'string', 'max:255'],
            'addressText' => ['nullable', 'string', 'max:255'],
            'bankText' => ['nullable', 'string', 'max:255'],
            'nipText' => ['nullable', 'string', 'max:255'],
            'priceText' => ['nullable', 'string', 'max:255'],
        ]);
        $request['user_id'] = Auth::id();
        
        $fileArray = $request->all([]);
        Scan::create($fileArray);
        return redirect()->back();
    }

    public function userWords()
    {
        $scans = Scan::where('user_id', '=', 1)->orWhere('user_id', '=', Auth::id())->get();

        return view('dictionary', compact('scans'));
    }
}
