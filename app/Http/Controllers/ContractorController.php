<?php

namespace App\Http\Controllers;

use App\Models\Contractor;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContractorController extends Controller
{
    public function getData()
    {
        $objects = File::where('user_id', '=', Auth::id())->whereNotNull('contractor_id')->get('contractor_id');
        $files = [];
        foreach ($objects as $object) {
            $data = Contractor::where('id', '=', $object->contractor_id)->get();
            array_push($files, $data);
        }
        return view('contractors', compact('files'));
    }
}
