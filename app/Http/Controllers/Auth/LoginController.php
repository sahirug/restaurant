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
        if($user->toArray()['status'] !== 'active'){
            Auth::logout();
            return redirect('/');
        }
        $job = $user->toArray()['job'];
        $employee_id = $user->toArray()['employee_id'];
        $name = $user->toArray()['name'];
        $branch_id = $user->toArray()['branch_id'];
        $request->session()->put('job', $job);
        $request->session()->put('employee_id', $employee_id);
        $request->session()->put('name', $name);
        $request->session()->put('branch_id', $branch_id);
        $sidebar_items = [];

        if ( $job == 'Root' ) {
            $sidebar_items = [
                // 0 => ['Home', 'fa fa-home', 'root_home'],
                1 => ['View Branches', 'fa fa-building', 'view_branches'],
                2 => ['Add Branch', 'fa fa-plus', 'add_branch_form'],                
            ];
            $request->session()->put('sidebar_items', $sidebar_items);
            return redirect()->route('root_home');
        }else if( $job == 'Manager' ) {
            $sidebar_items = [
                0 => ['Home', 'fa fa-home', 'manager_home'],
                1 => ['Employees', 'fa fa-users', 'view_employees'], 
                2 => ['Reports', 'fa fa-file', 'view_reports'], 
                3 => ['Stats', 'fa fa-line-chart', 'view_graph_form'], 
                4 => ['Menu', 'fa fa-cutlery', 'view_meals'],                 
                5 => ['Expenses', 'fa fa-money', 'view_expenses'],               
                6 => ['Branch Picture', 'fa fa-picture-o', 'show_branch_picture'],               
            ];
            $request->session()->put('sidebar_items', $sidebar_items);
            return redirect()->route('manager_home');
        }else if( $job == 'StockMgr' ) {
            $sidebar_items = [
                0 => ['Home', 'fa fa-home', 'stockMgr_home'],
                1 => ['Stocks', 'fa fa-bar-chart', 'view_stocks']
            ];
            $request->session()->put('sidebar_items', $sidebar_items);
            return redirect()->route('stockMgr_home');
        }else if( $job == 'Cashier' ) {
            $sidebar_items = [
                0 => ['Tables', 'fa fa-users', 'tables'], 
                1 => ['Phone Orders', 'fa fa-phone', 'view_phone_orders'],
                2 => ['App Orders', 'fa fa-mobile', 'view_app_orders'] 
            ];
            $request->session()->put('sidebar_items', $sidebar_items);
            return redirect()->route('tables');
        }
    }
}
