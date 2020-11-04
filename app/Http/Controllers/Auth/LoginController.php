<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
//    protected $redirectTo = RouteServiceProvider::HOME;
    protected $redirectTo = '/tasks';

//    protected function authenticated(Request $request, $user)
//    {
//        if ( $user->isAdmin() ) {// do your magic here
//            return redirect()->route('tasks.index');
//        }
//
//        return redirect('/home');
//    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->redirectTo = route('tasks.index');
    }

    public function username()
    {
        return 'login'; //or return the field which you want to use.
    }

    protected function authenticated(Request $request, User $user)
    {
        return redirect()->route('tasks.index');
    }
}
