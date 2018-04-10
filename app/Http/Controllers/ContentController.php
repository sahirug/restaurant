<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContentController extends Controller
{

    public function showHome(){
        $data['title'] = 'Home';
        $data['header'] = 'Dashboard';
        $data['active'] = lcfirst(session('job')) . '_home';
        switch(session('job')){
            case 'Root':
                return view('root.home', $data);
                break;
            case 'Manager':
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
}
