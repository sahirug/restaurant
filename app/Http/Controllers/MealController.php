<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Meal;

class MealController extends Controller
{
    protected $meal;

    public function __construct(Meal $meal){
        $this->meal = $meal;
    }

    public function addMealForm(){
        $data['title'] = 'Add Meal';
        $data['header'] = 'Add Meal';
        $data['desc'] = 'Please complete all fields';
        $data['active'] = 'view_meals';
        $meal_id = '';
        do{
            $meal_id = str_pad(rand(0, pow(10, 3)-1), 3, '0', STR_PAD_LEFT);
            $meal = $this->meal->where('meal_id', $meal_id)->where('branch_id', session('branch_id'))->get();
        }while(sizeof($meal) != 0);
        $data['meal_id'] = $meal_id;        
        return view('manager.add_meal', $data);
    }

    public function add(Request $request){
        $request->validate([
            'name' => 'required|string|min:5',
            'unit_price' => 'required|numeric'
        ]);
        $meal = $this->meal;
        $meal->meal_id = $request['meal_id'];
        $meal->name = $request['name'];
        $meal->unit_price = $request['unit_price'];
        $meal->status = 'available';
        $meal->branch_id = session('branch_id');
        $meal->save();
        return redirect()->route('view_meals');
    }

    public function view(){
        $data['title'] = 'Meals';
        $data['header'] = 'Menu Items';
        $data['active'] = 'view_meals';
        $data['meals'] = $this->meal->where('branch_id', session('branch_id'))->get();
        return view('manager.meal', $data);
    }

    public function changeStatus($branch_id, $meal_id){
        $meal = $this->meal->where('meal_id', $meal_id)->where('branch_id', $branch_id)->first();
        if($meal->status == 'unavailable'){
            $meal->status = 'available';
        }else{
            $meal->status = 'unavailable';
        }
        $meal->save();
        return redirect()->route('view_meals');
    }

    public function editMealForm($meal_id){
        $data['title'] = 'Edit Meal';
        $data['desc'] = 'Please complete all fields';
        $data['active'] = 'view_meals';
        $meal = $this->meal->where('meal_id', $meal_id)->where('branch_id', session('branch_id'))->first();
        $data['header'] = ucwords($meal->name) . ' - Edit';
        $data['meal'] = $meal;
        return view('manager.edit_meal', $data);
    }

    public function edit(Request $request){
        $request->validate([
            'name' => 'required|string|min:5',
            'unit_price' => 'required|numeric'
        ]);
        $meal = $this->meal->where('meal_id', $request['meal_id'])->where('branch_id', session('branch_id'))->first();
        $meal->name = $request['name'];
        $meal->unit_price = $request['unit_price'];
        $meal->save();
        return redirect()->route('view_meals');
    }

    public function delete($branch_id, $meal_id){
        $this->meal->where('meal_id', $meal_id)->where('branch_id', $branch_id)->delete();
        return redirect()->route('view_meals');
    }
}
