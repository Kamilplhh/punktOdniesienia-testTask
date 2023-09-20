<?php

namespace App\Http\Controllers;

use App\Models\Contractor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContractorController extends Controller
{
    public function getData()
    {
        $files = Contractor::where('user_id', '=', Auth::id())->get();
        return view('contractors', compact('files'));
    }

    public function addContractor(Request $request){
        $request->validate([
            'contractor' => ['required', 'string', 'max:255'],
            'address1' => ['required', 'string', 'max:255'],
            'address2' => ['required', 'string', 'max:255'],
            'bank' => ['required', 'numeric', 'min:0'],
            'nip' => ['required', 'numeric', 'min:0'],
            'email' => ['required', 'email', 'max:255'],
        ]);
        $request['user_id'] = Auth::id();

        $fileArray = $request->all([]);
        Contractor::create($fileArray);
        return redirect()->back();
    }
    
    public function deleteContractor($id)
    {
        Contractor::destroy($id);
        return redirect()->back();
    }

    public function editContractor(Request $request)
    {
        $request->validate([
            'contractor' => ['string', 'max:255'],
            'address1' => ['string', 'max:255'],
            'address2' => ['string', 'max:255'],
            'bank' => ['numeric', 'min:0'],
            'nip' => ['numeric', 'min:0'],
            'email' => ['email', 'max:255'],
        ]);
        $request['user_id'] = Auth::id();

        $fileArray = $request->all([]);
        Contractor::find($request['id'])->update($fileArray);
        return redirect()->back();
    }

    public function getContractor($id) 
    {
        $contractor = Contractor::where('id', '=', $id)->get();

        return $contractor;
    }
}
