<?php

namespace App\Http\Controllers\Auth;

use DB;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\TblCustomers;
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

    public function username()
    {
        //dd();
        return 'UserName';
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */ 
    public function __construct()
    {
        //DB::setDefaultConnection('sqlsrv3');
        $this->middleware('guest')->except('logout');
    }

    // Override the showLoginForm method to store the intended URL
    public function showLoginForm()
    {
        if (!auth()->check()) {
            session(['url.intended' => url()->previous()]);
        }

        return view('auth.login'); // Update this with your login view path
    }
}
