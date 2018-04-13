<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Branch;

class ContentController extends Controller
{

    protected $branch;

    public function __construct(Branch $branch){
        $this->branch = $branch;
    }

    public function showHome(){
        $data['title'] = 'Home';
        $data['header'] = 'Dashboard';
        $data['active'] = lcfirst(session('job')) . '_home';
        switch(session('job')){
            case 'Root':
                return view('root.home', $data);
                break;
            case 'Manager':
                $data['tables'] = $this->getTables();
                // dd(sizeof($data['tables']));
                return view('manager.home', $data);
                break;
            case 'StockMgr': 
                return view('stockMgr.home', $data);
                break;
            case 'Cashier': 
                return view('cashier.home', $data);
                break;
        }
    }

    public function getTables(){
        $branch = $this->branch->find(session('branch_id'));
        return $branch->tables;
    }
}
