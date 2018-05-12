<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PdfReport;
use App\AppOrder;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    protected $order;
    public function __construct(AppOrder $order){
        $this->order = $order;
    }

    public function view(){
        $data['title'] = 'Branch Reports';
        $data['header'] = 'Generate Reports';
        $data['active'] = 'view_reports';
        return view('manager.reports', $data);
    }

    public function makeReport(Request $request, $report_type){
        if($report_type == 'orders'){
            $request->validate([
                'order_type' => 'not_in:1'
            ]);
        }

        $dates = explode(" - ", $request->date_range);
        $start_date = str_replace('/', '-', $dates[0]);
        $end_date = str_replace('/', '-', $dates[1]);

        $table = '';
        $title = '';

        $date_column = '';
        $columns = [];

        $orderBy_id = '';
        $cost_column = '';

        if($report_type == 'orders'){
            $table = $request->order_type;
            $cost_column = 'Total Cost';
            $orderBy_id = 'order_id';
            $date_column = 'order_date';
            switch($table){
                case 'app_orders':
                    $title = 'Orders made using Mobile Application';
                    break;
                case 'inhouse_orders':
                    $title = 'In-House Orders';
                    break;    
                case 'phone_orders':
                    $title = 'Deliveries and Takeaways';
                    break;    
            }
            $columns = [           
                'Order ID' => 'order_id',
                'Date' => 'order_date',            
                'Total Cost' => 'tot_cost',
            ];
        }else if($report_type == 'expenses'){
            $table = 'expenses';
            $date_column = 'expense_date';
            $orderBy_id = 'expense_id';
            $cost_column = 'Expense Cost';
            $title = 'Expense Report';            
            $columns = [           
                'Expense ID' => 'expense_id',
                'Date' => 'expense_date',
                'Type' => 'type',            
                'Expense Cost' => 'amount',
            ];            
        }else if($report_type == 'meals'){

        }

        $order = DB::table($table)
                    ->select('*')
                    ->where($date_column, '>=', $start_date)
                    ->where($date_column, '<=', $end_date)
                    ->where('branch_id', '=', session('branch_id'))
                    ->orderBy($orderBy_id);

        $meta = [
            'Between ' => $start_date . ' To ' . $end_date,
            'Sort By' => 'Date'
        ];

        return PdfReport::of($title, $meta, $order, $columns)
                ->editColumn($cost_column, [
                    'class' => 'right bold'
                ])
                ->limit(100)
                ->showTotal([
                    $cost_column => 'point'
                ])
                ->setCss([
                    '.head-content' => 'border-width: 1px',
                ])->stream();
    }
}
