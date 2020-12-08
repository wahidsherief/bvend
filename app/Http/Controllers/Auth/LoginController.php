<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Cache;
use Auth;
use App\User;
use Illuminate\Support\Facades\Http;
use Validator;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:admin')->except('logout');
        $this->middleware('guest:vendor')->except('logout');
        $this->middleware('guest:manager')->except('logout');
    }

    public function showAdminLoginForm()
    {
        return view('auth.admin.login', ['url' => 'admin']);
    }

    public function loginAdmin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
            return redirect()->route('admin.dashboard');
        }
        return back()->withInput($request->only('email', 'remember'))->withErrors([
            'password' => 'Incorrect password!'
        ]);
    }

    public function showManagerLoginForm()
    {
        return view('auth.manager.login', ['url' => 'manager']);
    }

    public function loginManager(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (Auth::guard('manager')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
            return redirect()->route('manager.dashboard');
        }
        return back()->withInput($request->only('email', 'remember'))->withErrors([
            'password' => 'Incorrect credentials!'
        ]);
    }

    public function showVendorLoginForm()
    {
        return view('auth.vendor.login', ['url' => 'vendor']);
    }

    public function loginVendor(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (Auth::guard('vendor')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
            return redirect()->route('vendor_dashboard');
        }
        return back()->withInput($request->only('email', 'remember'))->withErrors([
            'password' => 'Incorrect credentials!'
        ]);
    }

    public function showSendOTPForm()
    {
        return view('auth.send_otp', ['url' => 'user']);
    }

    public function sendOTP(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|min:11|max:11'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $user = User::firstOrCreate(['mobile' => $request->mobile]);
        // $user->bkash_agreement_id ? $response['bkash_agreement_id'] = true : $response['bkash_agreement_id'] = false;
        // $success['token'] = $user->createToken('Bvend')->accessToken;
        $otp = rand(1000, 9999);
        $expiresAt = now()->addMinutes(3);

        if ($user && $otp) {
            Cache::put($user->mobile, $otp, $expiresAt);
            $message = 'Bvend verification code : ' . $otp;
            $url = 'https://sms.greenweb.com.bd/api.php?token=3f659bc939d1b29d13cd93b318133a07&to=' . $user->mobile . '&message=' . $message;
            $response = Http::timeout(30)->get($url);
            return $response;
        }
    }

    public function submitOTP(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => 'required',
            'otp' => 'required|min:4|max:4'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $mobile = $request->mobile;
        $otp = Cache::get($mobile);
        $response = [];
        if ($otp == $request->otp) {
            $user = User::where(['mobile' => $mobile])->first();
            $user->bkash_agreement_id ? $response['bkash_agreement_id'] = true : $response['bkash_agreement_id'] = false;
            $response['id'] = $user->id;
            $response['mobile'] = $user->mobile;

            return response()->json($response);

        /* this will be applied when use tokenized authorization
        if (Auth::attempt(['mobile' => $mobile])) {
            Cache::forget($mobile);
            $user = Auth::user();
            $success['token'] = $user->createToken('Bvend')->accessToken;
            return response()->json(['response' => $response, 'success' => $success], 200);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
        */
        } else {
            return response()->json('fail', 401);
        }
    }

    public function login()
    {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('MyApp')->accessToken;
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }

    public function logout(Request $request)
    {
        $redirect = null;
        if (Auth::guard('admin')->check()) {
            $redirect = 'admin/login';
        } elseif (Auth::guard('vendor')->check()) {
            $redirect = 'vendor/login';
        } elseif (Auth::guard('manager')->check()) {
            $redirect = 'manager/login';
        } else {
            $redirect = '/home';
        }

        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect($redirect);
    }
}
