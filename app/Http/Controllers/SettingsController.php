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
            // 'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore(Auth::id())],
            'company' => ['required', 'string', 'max:255'],
            'icon' => ['nullable', 'mimes:jpg,png', 'max:1024'],
            'emailto' => ['nullable', 'string', 'max:255'],
            'invoiceEmail' => ['nullable', 'string', 'max:255'],
            'emailPort' => ['nullable', 'string', 'max:255'],
        ]);
        if (isset($request['icon'])) {
            $file = $request->file('icon');
            $fileName = strval(rand()) . $request->file('icon')->getClientOriginalName();
            $request->files->remove('icon');
            $request['logo'] = $fileName;
            
            $file->move('uploads/logo', $fileName);
        }

        if (strlen($request['password']) > 0) {
            $request->validate([
                'password' => ['string', 'min:8']
            ]);
            $request['password'] = Hash::make($request['password']);
        } else {
            $request->request->remove('password');
        }

        if (strlen($request['emailPassword']) > 0) {
            $request->validate([
                'emailPassword' => ['string']
            ]);
        } else {
            $request->request->remove('emailPassword');
        }

        $fileArray = $request->all([]);
        user::find(Auth::id())->update($fileArray);

        return redirect()->back();
    }
}
