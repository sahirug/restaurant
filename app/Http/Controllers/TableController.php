<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Table;

class TableController extends Controller
{

    protected $table;

    public function __construct(Table $table)
    {
        $this->table = $table;
    }

    public function add(){
        $table_id = '';
        do{
            $table_id = str_pad(rand(0, pow(10, 3)-1), 3, '0', STR_PAD_LEFT);
            $table = $this->table->where('table_id', $table_id)->where('branch_id', session('branch_id'))->first();
        }while(sizeof($table) != 0);
        $table = $this->table;
        $table->table_id = $table_id;
        $table->branch_id = session('branch_id');
        $table->status = 'available';
        $table->save();
        return redirect()->route('manager_home');
    }

    public function delete($branch_id, $table_id){
        // dd($table_id . ' ' . $branch_id);
        $table = $this->table->where('table_id', $table_id)->where('branch_id', $branch_id)->delete();
        return redirect()->route('manager_home');
    }
}
