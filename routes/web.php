<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
    
// });



Route::group(['middleware' => 'guest'], function () {
    Route::get('/', 'Auth\LoginController@showLoginForm');
});


//Authentication routes
// Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::get('/register', 'Auth\RegisterController@showRegistrationForm');
Route::post('/register', 'Auth\RegisterController@register')->name('register');

Route::middleware('auth')->group(function(){

    Route::group(['middleware' => 'App\Http\Middleware\RootMiddleware'], function(){
        //home
        Route::get('/root/home', 'ContentController@showHome')->name('root_home');
        //branch
        Route::get('/add/branch', 'BranchController@showAddBranchForm')->name('add_branch_form');
        Route::post('/add/branch', 'BranchController@add')->name('add_branch');
        Route::get('/edit/branch/{branch_id}', 'BranchController@showEditBranchForm')->name('edit_branch_form');
        Route::post('/edit/branch', 'BranchController@editBranch')->name('edit_branch');
        Route::get('/branches', 'BranchController@show')->name('view_branches');
        //manager
        Route::get('/branch/{branch_id}/add/manager', 'EmployeeController@addManagerForm')->name('show_add_manager_form');
        Route::get('/branch/{branch_id}/add/manager/{employee_id}', 'EmployeeController@addManager')->name('add_manager');
        Route::get('/branch/{branch_id}/edit/manager', 'BranchController@changeManagerForm')->name('change_manager_form');
        Route::post('/branch/{branch_id}/edit/manager', 'BranchController@changeManager')->name('change_manager');
        Route::get('/{branch_id}/add/manager', 'EmployeeController@addNewManagerForm')->name('add_new_manager_form');        
        Route::post('/{branch_id}/add/manager', 'EmployeeController@addBranchManager')->name('add_new_manager');        
    });

    Route::group(['middleware' => 'App\Http\Middleware\ManagerMiddleware'], function(){
        //home
        Route::get('/manager/home', 'ContentController@showHome')->name('manager_home');
        //employees
        Route::get('/employees', 'EmployeeController@show')->name('view_employees');
        Route::get('/add/employee', 'EmployeeController@addEmployeeForm')->name('add_employee_form');
        Route::post('/add/employee', 'EmployeeController@add')->name('add_employee');
        //reports
        Route::get('/view/reports', 'ReportController@view')->name('view_reports');
        Route::post('/reports/{report_type}', 'ReportController@makeReport')->name('make_report');
        //meals
        Route::get('/meals', 'MealController@view')->name('view_meals');
        Route::get('/delete/meal/{branch_id}/{meal_id}', 'MealController@delete')->name('delete_meal');
        Route::get('/add/meal', 'MealController@addMealForm')->name('add_meal_form');
        Route::post('/add/meal', 'MealController@add')->name('add_meal');
        Route::get('/change/status/{branch_id}/{meal_id}', 'MealController@changeStatus')->name('change_status');
        Route::get('/edit/meal/{meal_id}', 'MealController@editMealForm')->name('edit_meal_form');
        Route::post('/edit/meal', 'MealController@edit')->name('edit_meal');
        //tables
        Route::get('/add/table', 'TableController@add')->name('add_table');        
        Route::get('/delete/table/{branch_id}/{table_id}', 'TableController@delete')->name('delete_table');
        //expenses
        Route::get('/expenses', 'ExpenseController@show')->name('view_expenses');
        Route::get('/add/expense', 'ExpenseController@addExpenseForm')->name('add_expense_form');
        Route::post('/add/expense', 'ExpenseController@add')->name('add_expense');
        //branch
        Route::get('/branch/picture', 'BranchController@showBranchPicture')->name('show_branch_picture');
        Route::post('/branch/edit/picture', 'BranchController@editPicture')->name('edit_picture');
        Route::get('/clear/picture/branch/{branch_id}', 'BranchController@clearPicture')->name('clear_picture');
    });

    Route::group(['middleware' => 'App\Http\Middleware\CashierMiddleware'], function(){
        //home
        Route::get('/cashier/home', 'ContentController@showHome')->name('tables');
        //order
        Route::get('/add/order/{table_id}', 'OrderController@addOrderForm')->name('add_order_form');
        Route::post('/add/order/{table_id}', 'OrderController@add')->name('add_order');
        Route::get('/edit/order/{table_id}', 'OrderController@editOrderForm')->name('edit_order_form');
        Route::post('/edit/order/{order_id}/{table_id}', 'OrderController@editOrder')->name('edit_order');
        Route::get('/{table_id}/invoice', 'OrderController@getInvoice')->name('invoice');
        Route::get('/pay/{order_id}', 'OrderController@pay')->name('final_payment');
        //phone order
        Route::get('/phone/orders', 'PhoneOrderController@show')->name('view_phone_orders');
        Route::get('/add/phone/order/{type}', 'PhoneOrderController@addPhoneOrderForm')->name('add_phone_order_form');
        Route::post('/add/phone/order', 'PhoneOrderController@add')->name('add_phone_order');
        Route::get('/phone/{order_id}/invoice', 'PhoneOrderController@invoice')->name('phone_order_invoice');
        Route::get('/pay/phone/{order_id}', 'PhoneOrderController@pay')->name('final_phone_payment'); 
        //app order
        Route::get('/app/orders', 'AppOrderController@show')->name('view_app_orders');    
        Route::post('/rider/order/{order_id}', 'AppOrderController@assignRider')->name('assign_rider');    
    });

    Route::group(['middleware' => 'App\Http\Middleware\StockMgrMiddleware'], function(){
        //home
        Route::get('/stockmgr/home', 'ContentController@showHome')->name('stockMgr_home');
        //stocks
        Route::get('/stocks', 'StockController@view')->name('view_stocks');
        Route::get('add/stock', 'StockController@addStockForm')->name('add_stock_form');
        Route::post('add/stock', 'StockController@add')->name('add_stock');
        Route::post('/stock/{stock_id}/{type}', 'StockController@edit')->name('change_stocks');
    });
    
});

Route::get('/forbidden', function(){
    return view('403');
})->name('403');

Route::get('/test', function(){
    return view('test');
})->name('test');

Route::get('/test2', function(){
    return view('modal_test');
});

// Auth::routes();

