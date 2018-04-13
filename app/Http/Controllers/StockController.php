<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Stock;

class StockController extends Controller
{
    protected $stock;

    public function __construct(Stock $stock){
        $this->stock = $stock;
    }

    public function view(){
        $data['title'] = 'Stocks';
        $data['header'] = 'Items in stock';
        $data['active'] = 'view_stocks';
        $stocks = $this->stock->where('branch_id', session('branch_id'))->get();
        $data['stocks'] = [];
        foreach($stocks as $stock){
            $refill = ($stock->qty - $stock->minimum_level) < 0 ? true : false;
            $stock = 
            [
                'stock_id' => $stock->stock_id,
                'name' => $stock->name,
                'branch_id' => $stock->branch_id,
                'qty' => $stock->qty,
                'units' => $stock->units,
                'refill' => $refill
            ];
            array_push($data['stocks'], $stock);
        }
        return view('stockMgr.stocks', $data);
    }

    public function edit(Request $request, $stock_id, $type){
        $stock = $this->stock->where('stock_id', $stock_id)->where('branch_id', session('branch_id'))->first();
        
        if($type == 'add'){
            $this->validateAdd($request, $stock);
            $stock->qty = $stock->qty + $request['qty'];
        }else{
            $this->validateMinus($request, $stock);
            $stock->qty = $stock->qty - $request['qty'];
        }
        $stock->save();
        return redirect()->route('view_stocks');
    }

    public function validateMinus(Request $request, $stock){
        $request->validate([
            'qty' => 'required|numeric|max:'.$stock->qty
        ]);
    }

    public function validateAdd(Request $request){
        $request->validate([
            'qty' => 'required|numeric'
        ]);
    }
}
