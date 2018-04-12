<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Branch;
use Illuminate\Support\Facades\DB;

class BranchController extends Controller
{

    protected $branch;

    public function __construct(Branch $branch){
        $this->branch = $branch;
    }

    public function showAddBranchForm(){
        $data['title'] = 'Add Branch';
        $data['desc'] = 'Please complete all fields';
        $data['header'] = 'Add Branch';
        $data['active'] = 'add_branch_form';
        return view('root.add_branch', $data);
    }

    public function add(Request $request){
        $request->validate([
            'branch_id' => 'required|regex:/^[a-zA-Z]+$/u|unique:branches',
            'location' => 'required|min:5',
        ]);
        $branch = $this->branch;
        $branch->branch_id = $request['branch_id'];
        $branch->lat = $request['lat'];
        $branch->lng = $request['lng'];
        $branch->location = $request['location'];
        $branch->save();
        return redirect()->route('view_branches');
    }

    public function show(){
        $data['title'] = 'Branches';
        $data['box_title'] = 'Branches';
        $data['active'] = 'view_branches';
        $data['branches'] = $this->branch->all();
        $branches = $this->branch->all();
        $i = 0;
        foreach($branches as $branch){
            $manager = DB::table('employees')
                ->join('branches', 'employees.branch_id', '=', 'branches.branch_id')
                ->select('employees.name', 'employees.employee_id')
                ->where('employees.job', '=', 'Manager')
                ->where('employees.branch_id', '=', $branch->branch_id)
                ->get();
            $name = $manager->toArray();
            $data['branches'][$i]['branch_id'] = $branch->branch_id;
            $data['branches'][$i]['lat'] = $branch->lat;
            $data['branches'][$i]['lng'] = $branch->lng;
            $data['branches'][$i]['location'] = $branch->location;
            if(sizeof($manager->toArray()) > 0){
                $data['branches'][$i]['manager'] = $manager->toArray()[0]->name;
                $data['branches'][$i]['manager_id'] = $manager->toArray()[0]->employee_id;
            }else{
                $data['branches'][$i]['manager'] = null;
                $data['branches'][$i]['manager_id'] = null;                
            }
            $i++;
        }
        // $hi = $data['branches']->toArray()[0]['manager'][0]->name;
        // dd($data['branches']->toArray());
        // dd($data['managers'][0]->toArray()[0]->name);
        
        return view('root.view_branches', $data);
    }

    public function showEditBranchForm($branch_id){
        $data['title'] = 'Edit Branch';
        $data['desc'] = 'Please complete all fields';
        $data['header'] = 'Edit Branch';
        $data['active'] = 'view_branches';
        $data['branch'] = $this->branch->find($branch_id);
        if($data['branch'] == null ){
            return dd('an error occurred');
        }
        return view('root.edit_branch', $data);
    }

    public function editBranch(Request $request){
        $request->validate([
            'location' => 'required|min:5',
            'contact' => 'required|numeric',
        ]);
        $branch = $this->branch->find($request['branch_id']);
        $branch->lat = $request['lat'];
        $branch->lng = $request['lng'];
        $branch->location = $request['location'];
        $branch->save();
        return redirect()->route('view_branches');
    }

}
