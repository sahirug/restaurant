<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AppOrder;
use App\Employee;
use App\AppUser;

class AppOrderController extends Controller
{

    protected $app_order, $employee, $app_user;

    public function __construct(AppOrder $app_order, Employee $employee, AppUser $app_user){
        $this->app_order = $app_order;
        $this->employee = $employee;
        $this->app_user = $app_user;
    }

    public function show(){
        $data['title'] = 'App Orders';
        $data['header'] = 'App Orders';
        $data['active'] = 'view_app_orders';
        $app_orders = $this->app_order->where('branch_id', session('branch_id'))->where('status', 'unpaid')->get();
        $app_orders = sizeof($app_orders) == 0 ? null : $app_orders;
        $completed_app_orders = $this->app_order->where('branch_id', session('branch_id'))->where('status', 'paid')->get();        
        // $completed_app_orders = sizeof($completed_app_orders) == 0 ? null : $completed_app_orders;
        $i = 0;
        foreach($app_orders as $order){
            $app_orders[$i]->customer = $this->app_user->find($order->app_user_id);
            $i++;
        }
        $i = 0;
        foreach($completed_app_orders as $order){
            $completed_app_orders[$i]->customer = $this->app_user->find($order->app_user_id);
            $i++;
        }
        // dd($app_orders);
        $data['app_orders'] = $app_orders;
        $data['completed_app_orders'] = $completed_app_orders;
        $data['riders'] = $this->employee->where('job', 'Rider')->get();
        return view('cashier.app_orders', $data);   
    }

    public function assignRider(Request $request, $order_id){
        $rider_id = $request['rider'];
        $app_order = $this->app_order->find($order_id);
        $app_order->rider = $rider_id;
        $app_order->save();
        return redirect()->route('view_app_orders');
    }
}
