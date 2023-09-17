<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
            'company' => ['required', 'string', 'max:255'],
            'logo' => ['nullable', 'mimes:jpg,png', 'max:1024'],
            'emailto' => ['required', 'string', 'email', 'max:255'],
            'invoiceemail' => ['nullable', 'string', 'email', 'max:255'],
            'emailpassword' => ['nullable', 'string', 'max:255'],
            'emailport' => ['nullable', 'string', 'max:255'],
        ]);
    }
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        if(isset($data['logo'])){
            $file = $data['logo'];
            $fileName = $data['logo']->getClientOriginalName();

            $file->move('uploads/logo',$fileName);
        } else {
            $fileName = "";
        }

        return User::create([
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'company' => $data['company'],
            'logo' => $fileName,
            'emailTo' => $data['emailto'],
            'invoiceEmail' => $data['invoiceemail'],
            'emailPassword' => $data['emailpassword'],
            'emailPort' => $data['emailport'],
        ]);
    }
}
