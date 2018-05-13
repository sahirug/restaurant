<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Meal;
use App\InhouseOrder;
use App\AppOrder;
use App\PhoneOrder;
use App\Expenses;

class GraphController extends Controller
{
    protected $meal, $inhouse_order, $phone_order, $app_order, $expenses;
    public function __construct(Meal $meal, InhouseOrder $inhouse_order, PhoneOrder $phone_order, AppOrder $app_order, Expenses $expenses){
        $this->meal = $meal;
        $this->inhouse_order = $inhouse_order;
        $this->phone_order = $phone_order;
        $this->app_order = $app_order;
        $this->expenses = $expenses;
    }

    public function view(){
        $meal_ids = DB::table('meals')
                        ->select('meal_id')
                        ->where('branch_id', '=', session('branch_id'))
                        ->get()
                        ->toArray();
        $inhouse_meal_frequency = DB::table('meal_order')
                                    ->select(DB::raw('meal_id, count(meal_id) as meal_count'))
                                    ->groupBy('meal_id')
                                    ->get()
                                    ->toArray();
        $phone_meal_frequency = DB::table('meals_phone_order')
                                    ->select(DB::raw('meal_id, count(meal_id) as meal_count'))
                                    ->groupBy('meal_id')
                                    ->get()
                                    ->toArray();
        $app_meal_frequency = DB::table('meals_app_order')
                                    ->select(DB::raw('meal_id, count(meal_id) as meal_count'))
                                    ->groupBy('meal_id')
                                    ->get()
                                    ->toArray();
        for($i = 0; $i < sizeof($meal_ids); $i++){
            $meal_ids[$i] = $meal_ids[$i]->meal_id;
        }
        for($i = 0; $i < sizeof($inhouse_meal_frequency); $i++){
            $inhouse_meal_frequency[$i] = array($this->get_meal_name($inhouse_meal_frequency[$i]->meal_id), $inhouse_meal_frequency[$i]->meal_count);
        }
        for($i = 0; $i < sizeof($phone_meal_frequency); $i++){
            $phone_meal_frequency[$i] = array($this->get_meal_name($phone_meal_frequency[$i]->meal_id), $phone_meal_frequency[$i]->meal_count);            
        }
        for($i = 0; $i < sizeof($app_meal_frequency); $i++){
            $app_meal_frequency[$i] = array($this->get_meal_name($app_meal_frequency[$i]->meal_id), $app_meal_frequency[$i]->meal_count);            
        }
        
        $tot_inhouse_sum = $this->inhouse_order->where('branch_id', session('branch_id'))->sum('tot_cost');
        $tot_phone_sum = $this->phone_order->where('branch_id', session('branch_id'))->sum('tot_cost');
        $tot_app_sum = $this->app_order->where('branch_id', session('branch_id'))->sum('tot_cost');

        $tot_expenses = DB::table('expenses')
                            ->select(DB::raw('type, SUM(amount) as tot_amount'))
                            ->where('branch_id', session('branch_id'))
                            ->groupBy('type')
                            ->get()
                            ->toArray();
        
        for($i = 0; $i < sizeof($tot_expenses); $i++){
            $tot_expenses[$i] = array($tot_expenses[$i]->type, $tot_expenses[$i]->tot_amount);
        }

        $data['title'] = 'Branch Stats';
        $data['header'] = 'View Stats';
        $data['active'] = 'view_graph_form';

        $data['inhouse_meals'] = $inhouse_meal_frequency;
        $data['phone_meals'] = $phone_meal_frequency;
        $data['app_meals'] = $app_meal_frequency;
        
        $data['tot_inhouse'] = $tot_inhouse_sum;
        $data['tot_phone'] = $tot_phone_sum;
        $data['tot_app'] = $tot_app_sum;

        $data['tot_expenses'] = $tot_expenses;
        
        return view('manager.stats', $data);
    }

    public function get_meal_name($meal_id){
        $meal = $this->meal;
        $meal = $meal->where('meal_id', $meal_id)->first();
        return $meal->name;
    }
}
