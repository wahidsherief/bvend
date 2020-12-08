<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

class ManagerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:manager');    
    }

    public function dashboard()
    {
    	return view('manager.dashboard');
    }
}
