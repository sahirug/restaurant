<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Expenses;

class ExpenseController extends Controller
{
    protected $expense;
    public function __construct(Expenses $expense){
        $this->expense = $expense;
    }

    public function addExpenseForm(){
        $data['title'] = 'Add Expense';
        $data['header'] = 'New Meal';
        $data['desc'] = 'Please complete all fields';
        $data['active'] = 'view_expenses';
        $count = $this->expense->all()->count();
        $count++;
        $data['expense_id'] = 'EXP-'. session('branch_id'). '-' . str_pad($count, 3, '0', STR_PAD_LEFT);
        return view('manager.add_expense', $data);
    }    

    public function add(Request $request){
        $request->validate([
            'type' => 'not_in:1',
            'notes' => 'max:150',
            'amount' => 'required|numeric',
        ]);
        $expense = $this->expense;
        $expense->expense_id = $request['expense_id'];
        $expense->expense_date = date('Y/m/d');
        $expense->type = $request['type'];
        $expense->notes = $request['notes'];
        $expense->amount = $request['amount'];
        $expense->branch_id = session('branch_id');
        $expense->save();
        return redirect()->route('view_expenses');
    }

    public function show(){
        $data['title'] = 'Expenses';
        $data['header'] = 'New Meal';
        $data['active'] = 'view_expenses';
        $data['expenses'] = $this->expense->where('branch_id', session('branch_id'))->get();
        return view('manager.view_expenses', $data);

    }
}
