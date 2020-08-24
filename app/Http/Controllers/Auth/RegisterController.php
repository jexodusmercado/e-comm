<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Http\Request;
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
            'role' => ['required'],
            'company_name' => ['required'],
            'fname' => ['required', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'add1' => ['required', 'string', 'max:255'],
            'barangay' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'prov' => ['required', 'string', 'max:255'],
            'mobile' => ['max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'passwd' => ['required', 'string', 'min:8'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        if($data['role'] == 3){
            $file = $data['photo'];
            $name = uniqid() . '_' . time(). '.' . $file->getClientOriginalExtension();
            $path = public_path() . '/verification';
            $res = $file->move($path, $name);
        }else{
            $name=null;
        }


        return User::create([
            'role' => $data['role'],
            'company_name' => $data['company_name'],
            'verification_id_img' => $name,
            'first_name' => $data['fname'],
            'middle_name' => $data['mname'],
            'last_name' => $data['lname'],
            'address1' => $data['add1'],
            'address2' => $data['add2'],
            'barangay' => $data['barangay'],
            'city' => $data['city'],
            'province' => $data['prov'],
            'mobile_number' => $data['mobile'],
            'email' => $data['email'],
            'password' => Hash::make($data['passwd']),
        ]);
    }

    protected function registered(Request $request, $user)
    {
        if($request->isXmlHttpRequest()){
            return $user;
        }
    }
}
