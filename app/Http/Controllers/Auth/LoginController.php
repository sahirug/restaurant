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
        $branch_id = $user->toArray()['branch_id'];
        $request->session()->put('job', $job);
        $request->session()->put('employee_id', $employee_id);
        $request->session()->put('id', $id);
        $request->session()->put('name', $name);
        $request->session()->put('branch_id', $branch_id);
        $sidebar_items = [];

        if ( $job == 'Root' ) {
            $sidebar_items = [
                0 => ['Home', 'fa fa-home'],
                1 => ['Add Branch', 'fa fa-plus'],
                2 => ['View Branches', 'fa fa-building'] 
            ];
            $request->session()->put('sidebar_items', $sidebar_items);
            return redirect()->route('root_home');
        }else if( $job == 'Manager' ) {
            $sidebar_items = [
                0 => ['Home', 'fa fa-home'],
                1 => ['Add Employee', 'fa fa-plus'], 
                2 => ['View Reports', 'fa fa-file'] 
            ];
            $request->session()->put('sidebar_items', $sidebar_items);
            return redirect()->route('manager_home');
        }else if( $job == 'StockMgr' ) {
            $sidebar_items = [
                0 => ['Home', 'fa fa-home'],
                1 => ['Add Branch', 'fa fa-plus'], 
                2 => ['View Branches', 'fa fa-building'] 
            ];
            return redirect()->route('stockmgr_home');
        }else if( $job == 'Cashier' ) {
            $sidebar_items = [
                0 => ['Table', 'fa fa-cutlery'], 
                1 => ['View Branches', 'fa fa-building'] 
            ];
            return redirect()->route('cashier_home');
        }
    }
}
