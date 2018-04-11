<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Branch;
use App\Employee;

class EmployeeController extends Controller
{

    protected $branch, $employee;

    public function __construct(Branch $branch, Employee $employee){
        $this->branch = $branch;
        $this->employee = $employee;
    }

    public function add(){
        
    }

    public function addManagerForm($branch_id){
        $data['title'] = 'Add Manager';
        $data['active'] = 'view_branches';
        $data['location'] = $this->branch->where('branch_id', $branch_id)->pluck('location')->toArray()[0];
        $data['employees'] = $this->employee->where('branch_id', $branch_id)->get();
        return view('root.add_manager_form', $data);
    }

    public function addManager($branch_id, $employee_id){
        $employee = $this->employee->find($employee_id);
        $employee->job = 'Manager';
        $employee->save();
        return redirect()->route('view_branches');
    }
}
