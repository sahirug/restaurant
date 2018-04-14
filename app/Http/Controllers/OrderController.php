<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Meal;
use App\InhouseOrder;
use Illuminate\Support\Facades\DB;
use App\Table;

class OrderController extends Controller
{
    protected $meal, $order, $table; 
    public function __construct(Meal $meal, InhouseOrder $order, Table $table){
        $this->meal = $meal;
        $this->order = $order;
        $this->table = $table;
    }

    public function addOrderForm($table_id){
        $data['title'] = 'New Order';
        $data['header'] = 'Add order - Table#' . $table_id;
        $data['active'] = 'tables';
        $data['table_id'] = $table_id;
        $data['meals'] = $this->meal->where('branch_id', session('branch_id'))->where('status', 'available')->get();
        return view('cashier.add_order', $data);
    }

    public function add(Request $request, $table_id){
        $meal_id_array = $request['meal_id'];
        $meal_name_array = $request['meal_name'];
        $qty_array = $request['qty'];
        $order = $this->order;
        $tot_price = 0.00;
        for($i = 0; $i < sizeof($request['meal_id']); $i++){
            $meal = $this->meal->where('meal_id', $meal_id_array[$i])->where('branch_id', session('branch_id'))->first();
            $tot_price = $tot_price +  ($meal->unit_price * $qty_array[$i]);
        }
        $count = $order->where('branch_id', session('branch_id'))->count();
        $order_id = 'ORD-'.session('branch_id').'-'.str_pad(++$count, 3, '0', STR_PAD_LEFT);
        $order->order_id = $order_id;
        $order->order_date = date('Y/m/d');
        $order->tot_cost = $tot_price;
        $order->employee_id = session('employee_id');
        $order->table_id = $table_id;
        $order->branch_id = session('branch_id');
        $order->status = 'unpaid';
        $order->save();//untests
        $table = $this->table->where('table_id', $table_id)->where('branch_id', session('branch_id'))->first();
        $table->status = 'occupied';
        $table->save();
        for($i = 0; $i < sizeof($request['meal_id']); $i++){
            DB::table('meal_order')->insert([
                'meal_id' => $meal_id_array[$i],
                'order_id' => $order_id,
                'qty' => $qty_array[$i],
            ]);
        }
        return redirect()->route('tables');
    }

    public function editOrderForm($table_id){
        $order = $this->order;
        $order_id = $order->where('table_id', $table_id)->where('status', 'unpaid')->pluck('order_id')[0];
        $data['title'] = 'New Order';
        $data['header'] = 'Edit order - Table#' . $table_id;
        $data['active'] = 'tables';
        $data['table_id'] = $table_id;
        $data['order_id'] = $order_id;
        $data['meals'] = $this->meal->where('branch_id', session('branch_id'))->where('status', 'available')->get();
        return view('cashier.edit_order', $data);
    }

    public function editOrder(Request $request, $order_id, $table_id){
        $meal_id_array = $request['meal_id'];
        $meal_name_array = $request['meal_name'];
        $qty_array = $request['qty'];
        $order = $this->order;
        $tot_price = 0.00;
        for($i = 0; $i < sizeof($request['meal_id']); $i++){
            $meal = $this->meal->where('meal_id', $meal_id_array[$i])->where('branch_id', session('branch_id'))->first();
            $tot_price = $tot_price +  ($meal->unit_price * $qty_array[$i]);
        }
        $order = $order->where('order_id', $order_id)->first();
        $order->tot_cost = $order->tot_cost + $tot_price;
        $order->save();
        for($i = 0; $i < sizeof($request['meal_id']); $i++){
            $meal_order = DB::table('meal_order')
                ->where('meal_id', $meal_id_array[$i])
                ->where('order_id', $order_id)
                ->get();
            if(sizeof($meal_order) > 0){
                $new_qty = $meal_order->toArray()[0]->qty + $qty_array[$i];
                DB::table('meal_order')
                    ->where('meal_id', $meal_id_array[$i])
                    ->where('order_id', $order_id)
                    ->update([
                        'qty' => $new_qty
                    ]);
            }else{
                DB::table('meal_order')->insert([
                    'meal_id' => $meal_id_array[$i],
                    'order_id' => $order_id,
                    'qty' => $qty_array[$i],
                ]);
            }     
        }
        return redirect()->route('tables');
    }

    public function getInvoice($table_id){
        $data['title'] = 'Invoice';
        $data['active'] = 'tables';
        $data['order_items'] = [];

        $order = $this->order;
        $meal = $this->meal;

        $order_id = $order->where('table_id', $table_id)->where('status', 'unpaid')->pluck('order_id');

        if(!(sizeof($order_id))){
            dd('error');
        }

        $order_id = $order_id[0];

        $tot_price = $order->where('order_id', $order_id)->first()->tot_cost;
        $data['order_id'] = $order_id;
        $data['tot_cost'] = $tot_price;

        $meal_items = DB::table('meal_order')
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
        return view('cashier.invoice', $data);
    }

    public function pay($order_id){
        $order = $this->order->where('order_id', $order_id)->first();
        $table_id = $order->table_id;
        DB::table('tables')
                    ->where('table_id', $table_id)
                    ->where('branch_id', session('branch_id'))
                    ->update([
                        'status' => 'available'
                    ]);
        $order->status = 'paid';
        $order->save();
        return redirect()->route('tables');            
    }
}
// $order->meals()->attach($meal->meal_id, ['qty' => $qty_array[$i]]);