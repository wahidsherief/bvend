<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Admin;
use App\Manager;
use App\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

use Auth;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin');  
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data, $table)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'. $table],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    public function showAdminRegisterForm()
    {
        return view('auth.admin.register', ['url' => 'admin']);
    }

    public function showManagerRegisterForm()
    {
        return view('auth.manager.register', ['url' => 'manager']);
    }

    public function showVendorRegisterForm()
    {
        return view('auth.vendor.register', ['url' => 'vendor']);
    }

    public function showUserRegisterForm()
    {
        return view('auth.user_register', ['url' => 'user']);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function createAdmin(Request $request)
    {
        // dd($request->all());

        $this->validator($request->all(), 'admins')->validate();
        $admin = Admin::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'phone' => "01554666333",
            'image' => "test image",
            'password' => Hash::make($request['password']),
        ]);
        
        return redirect()->route('admin.login');
    }
    
    protected function createManager(Request $request)
    {
        $this->validator($request->all(), 'managers')->validate();
        $admin = Manager::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'phone' => "01554666333",
            'image' => "test image",
            'password' => Hash::make($request['password']),
        ]);
        return redirect()->route('manager.login');
    }

    protected function createVendor(Request $request)
    {
        $this->validator($request->all(), 'vendors')->validate();
        $vendor = Vendor::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'phone' => "01554666333",
            'image' => "test image",
            'password' => Hash::make($request['password']),
        ]);
        
        return redirect()->route('vendor.login');
    }
}
