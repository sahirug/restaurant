<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Meal;
use App\Employee;
use App\InhouseOrder;
use App\PhoneOrder;
use Illuminate\Support\Facades\DB;

class PhoneOrderController extends Controller
{

    protected $meal, $employee, $inhouse_order, $phone_order;
    public function __construct(Meal $meal, Employee $employee, InhouseOrder $inhouse_order, PhoneOrder $phone_order){
        $this->meal = $meal;
        $this->employee = $employee;
        $this->inhouse_order = $inhouse_order;
        $this->phone_order = $phone_order;
    }

    public function addPhoneOrderForm($type){
        $data['title'] = 'New Order';
        $data['header'] = 'Add Phone order';
        $data['active'] = 'view_phone_orders';
        $data['meals'] = $this->meal->where('branch_id', session('branch_id'))->where('status', 'available')->get();
        if($type == 'delivery'){
            $data['delivery'] = 1;
            $data['riders'] = $this->employee->where('job', 'Rider')->where('branch_id', session('branch_id'))->get();
        }        
        return view('cashier.add_phone_order', $data);
    }

    public function add(Request $request){        
        $count = $this->getCount();
        $order_id = 'ORD-'.session('branch_id').'-'.str_pad(++$count, 3, '0', STR_PAD_LEFT);

        $meal_id_array = $request['meal_id'];
        $meal_name_array = $request['meal_name'];
        $qty_array = $request['qty'];

        $phone_order = $this->phone_order;
        $tot_price = 0.00;
        for($i = 0; $i < sizeof($request['meal_id']); $i++){
            $meal = $this->meal->where('meal_id', $meal_id_array[$i])->where('branch_id', session('branch_id'))->first();
            $tot_price = $tot_price +  ($meal->unit_price * $qty_array[$i]);
        }
        $phone_order->order_id = $order_id;
        $phone_order->order_date = date('Y/m/d');
        $phone_order->tot_cost = $tot_price;
        $phone_order->employee_id = session('employee_id');
        $phone_order->branch_id = session('branch_id');
        $phone_order->status = 'unpaid';
        $phone_order->customer_contact = $request['contact'];
        $phone_order->rider_id = $request['rider'];
        $phone_order->customer_address = $request['customer_address'];
        $phone_order->save();//untests
        
        for($i = 0; $i < sizeof($request['meal_id']); $i++){
            DB::table('meals_phone_order')->insert([
                'meal_id' => $meal_id_array[$i],
                'order_id' => $order_id,
                'qty' => $qty_array[$i],
            ]);
        }
        return redirect()->route('view_phone_orders');
    }

    public function show(){
        $data['title'] = 'Phone Orders';
        $data['header'] = 'Phone Orders';
        $data['active'] = 'view_phone_orders';
        $data['phone_orders'] = $this->phone_order->where('branch_id', session('branch_id'))->where('status', 'unpaid')->get();
        $data['phone_orders'] = sizeof($data['phone_orders']) == 0 ? null : $data['phone_orders'];
        $data['completed_phone_orders'] = $this->phone_order->where('branch_id', session('branch_id'))->where('status', 'paid')->get();        
        $data['completed_phone_orders'] = sizeof($data['completed_phone_orders']) == 0 ? null : $data['completed_phone_orders'];
        return view('cashier.phone_orders', $data);
    }

    public function invoice($order_id){
        $data['title'] = 'Invoice';
        $data['active'] = 'view_phone_orders';
        $data['order_items'] = [];

        $phone_order = $this->phone_order;
        $meal = $this->meal;
        $phone_order = $phone_order->where('order_id', $order_id)->first();
        $tot_price = $phone_order->tot_cost;
        $type = $phone_order->rider_id == null ? 'takeaway' : 'delivery' ;
        $data['order_id'] = $order_id;
        $data['tot_cost'] = $tot_price;

        $meal_items = DB::table('meals_phone_order')
                ->where('order_id', $order_id)
                ->get();

        $i = 0;        

        foreach($meal_items as $meal_item){
            $meal_id = $meal_item->meal_id;
            $meal = $meal->where('meal_id', $meal_id)->where('branch_id', session('branch_id'))
                    ->first();
            $unit_price = $meal->unit_price;  
            $name = $meal->name;  
            $data['order_items'][$i]['meal_id'] = $meal_id;
            $data['order_items'][$i]['qty'] = $meal_item->qty;
            $data['order_items'][$i]['unit_price'] = $unit_price;          
            $data['order_items'][$i]['name'] = $name;          
            $data['order_items'][$i]['sub_total'] = $unit_price * $meal_item->qty; 
            $i++;         
        }

        $data['takeaway'] = null;
        $data['delivery'] = null;
        if($type == 'takeaway')
            $data['takeaway'] = 1;
        else
            $data['delivery'] = 1;                
        
        return view('cashier.invoice', $data);
    }

    public function pay($order_id){
        $phone_order = $this->phone_order->where('order_id', $order_id)->first();
        $phone_order->status = 'paid';
        $phone_order->save();
        return redirect()->route('view_phone_orders');       
    }

    public function getCount(){
        $count_in_house_orders = $this->inhouse_order->where('branch_id', session('branch_id'))->count();
        $count_phone_orders = $this->phone_order->where('branch_id', session('branch_id'))->count();
        return ($count_in_house_orders + $count_phone_orders);
    }
}
