<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your front screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/contractor/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    // public function logout(Request $request)
    // {
    //     dd('Logout called');
    //     if (Auth::guard('contractor')->check()) {
    //         Auth::guard('contractor')->logout();
    //         $redirect = '/contractor/login'; // change as needed
    //     } elseif (Auth::guard('subcontractor')->check()) {
    //         Auth::guard('subcontractor')->logout();
    //         $redirect = '/subcontractor/login'; // change as needed
    //     } else {
    //         Auth::logout();
    //         $redirect = '/login'; // fallback
    //     }

    //     $request->session()->invalidate();
    //     $request->session()->regenerateToken();

    //     return redirect($redirect);
    // }
}
