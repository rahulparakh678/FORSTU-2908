<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Http\Request;

class MobileVerificationController extends Controller
{
    use RedirectsUsers;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    public function show(Request $request)
    {
        return $request->user()->hasVerifiedMobile()
            ? redirect($this->redirectPath())
            : view('auth.verify-mobile');
    }

    public function verify(Request $request)
    {
        if ($request->user()->markMobileAsVerified()) {
            event(new Verified($request->user()));
        }

        return redirect($this->redirectPath())->with('verified', true);
    }

    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedMobile()) {
            return redirect($this->redirectPath());
        }

        $request->user()->sendMobileVerificationNotification();

        return back()->with('resent', true);
    }

    protected function redirectPath()
    {
        return route('students.home');
    }
}
