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

    public function addNewManagerForm($branch_id){
        $data['branch_id'] = $branch_id;
        $data['employee_id'] = 'EMP-'.$branch_id.'-001';
        $data['title'] = 'New Manager';
        $data['header'] = 'Add Manager For '. $branch_id;
        $data['desc'] = 'Please complete all fields';
        $data['active'] = 'add_branch_form';
        return view('root.add_branch_manager', $data);
    }

    public function addBranchManager(Request $request){
        $request->validate([
            'employee_name' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ]);
        $employee = $this->employee;
        $employee->employee_id = $request['employee_id'];
        $employee->name = $request['employee_name'];
        $employee->password = bcrypt($request['password']);
        $employee->job = 'Manager';
        $employee->branch_id = $request['branch_id'];
        $employee->status = 'active';
        $employee->save();
        return redirect()->route('view_branches');
    }

    public function add(Request $request){
        $request->validate([
            'job' => 'not_in:1',
            'employee_name' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ]);
        $employee = $this->employee;
        $employee->employee_id = $request['employee_id'];
        $employee->name = $request['employee_name'];
        $employee->password = bcrypt($request['password']);
        $employee->job = $request['job'];
        $employee->branch_id = session('branch_id');
        $employee->status = 'active';
        $employee->save();
        return redirect()->route('view_employees');
    }

    public function addManagerForm($branch_id){
        $data['title'] = 'Add Manager';
        $data['active'] = 'view_branches';
        $data['location'] = $this->branch->where('branch_id', $branch_id)->pluck('location')->toArray()[0];
        // $data['employees'] = $this->employee->where('branch_id', $branch_id)->get();
        $data['employees'] = $this->branch->find($branch_id)->employees->where('status', 'active');
        return view('root.add_manager_form', $data);
    }

    public function addManager($branch_id, $employee_id){
        $employee = $this->employee->find($employee_id);
        $employee->job = 'Manager';
        $employee->save();
        return redirect()->route('view_branches');
    }

    public function show(){
        $data['title'] = 'Employees';
        $data['header'] = 'Employees';
        $data['active'] = 'view_employees';
        $data['location'] = $this->branch->find(session('branch_id'))->location;
        $data['employees'] = $this->branch->find(session('branch_id'))->employees->where('status', 'active');
        return view('manager.employees', $data);
    }

    public function addEmployeeForm(){
        $data['title'] = 'Add Employee';
        $data['header'] = 'Add Employee';
        $data['desc'] = 'Please complete all fields';
        $data['active'] = 'add_employee_form';
        $employee_id = '';
        do{
            $employee_id = 'EMP-'.session('branch_id').'-'.str_pad(rand(0, pow(10, 3)-1), 3, '0', STR_PAD_LEFT);
            $employee = $this->employee->find($employee_id);
        }while(sizeof($employee) != 0);
        $data['employee_id'] = $employee_id;
        return view('manager.add_employee', $data);
    }
}
