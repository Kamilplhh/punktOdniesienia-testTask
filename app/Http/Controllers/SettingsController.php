<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;


class SettingsController extends Controller
{
    public function profileUpdate(Request $request)
    {
        $request->validate([
            'logo' => ['nullable', 'mimes:jpg,png', 'max:1024'],
            'company' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore(Auth::id())],
            'emailto' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        if(isset($request['logo'])){
            $file = $request->file('logo');
            $fileName = $request->file('logo')->getClientOriginalName();

            $file->move('uploads/logo',$fileName);
        } else {
            $fileName = "";
        }
        
        user::where('id', Auth::id())->update([
            'logo' => $fileName,
            'company' => $request['company'],
            'name' => $request['name'],
            'email' => $request['email'],
            'emailfrom' => (trim($request['company']) . '@domain.com'),
            'emailto' => $request['emailto'],
            'password' => Hash::make($request['password']),
        ]);

        return redirect()->back();
    }
}
