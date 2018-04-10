<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BranchController extends Controller
{

    public function showAddBranchForm(){
        $data['title'] = 'Add Branch';
        $data['desc'] = 'Please complete all fields';
        $data['header'] = 'Add Branch';
        $data['active'] = 'add_branch';
        return view('root.add_branch', $data);
    }

    public function add(Request $request){
        
    }

}
