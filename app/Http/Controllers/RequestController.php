<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RegistrationRequest;

class RequestController extends Controller
{
    public function renderRequestForm()
    {
        return view('request.request_form');
    }

    public function saveRequest(Request $request)
    {
        $registrationRequest = new RegistrationRequest;
        $saved = $registrationRequest->saveRequest($request);
        if ($saved) {
            return view('request.request_form')->with('success', 'Your request has been submitted');
        } else {
            return view('request.request_form')->with('status', 'error');
        }
    }

    public function requests()
    {
        $requests = RegistrationRequest::where('is_approved', '=', 0)->get();
        return view('request.requests', compact('requests'));
    }

    public function showRequest($id)
    {
        $request = RegistrationRequest::where('id', $id)->first();
        return view('request.request', compact('request'));
    }

    public function showRequestApprove($id)
    {
        $vendor = RegistrationRequest::where('id', $id)->first();
        return view('request.approve', compact('vendor'));
    }

    public function vendorRequestDestroy($id)
    {
        $vendor_request = RegistrationRequest::findOrFail($id);
        $vendor_request->delete();
        return redirect()->route('vendor.registration.request')->with('success', 'Request Removed successfully');
    }
}
