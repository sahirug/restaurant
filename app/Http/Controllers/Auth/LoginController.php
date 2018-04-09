<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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
    }

    public function username(){
        return 'employee_id';
    }

    public function authenticated(Request $request, $user){
        $job = $user->toArray()['job'];
        $employee_id = $user->toArray()['employee_id'];
        $id = $user->toArray()['id'];
        $name = $user->toArray()['name'];
        $request->session()->put('job', $job);
        $request->session()->put('employee_id', $employee_id);
        $request->session()->put('id', $id);
        $request->session()->put('name', $name);
        if ( $job == 'Root' ) {
            return redirect()->route('home');
        }else if( $job == 'Manager' ) {
            return redirect()->route('home');
        }
    }
}
