<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function userEntry(Request $request) {
    $request->mobile = 'da';
    dd($request->all());
    $validator = $this->validate($request->all(), [
            'mobile'   => 'required|min:11|max:11|unique:users',
        ]);

    if ($validator->fails()) {
        $errors = $validator->errors();
        return $errors->toJson();
        } else {
    App\User::create(['mobile' => $request->mobile]); }
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
        
    }

    public function loading()
    {
        return view('loading');
        
    }

    public function terms() {
        return view('terms');
    }

}
