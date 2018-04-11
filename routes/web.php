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
        Route::get('/root/home', 'ContentController@showHome')->name('root_home');
        Route::get('/add/branch', 'BranchController@showAddBranchForm')->name('add_branch_form');
        Route::post('/add/branch', 'BranchController@add')->name('add_branch');
        Route::get('/branches', 'BranchController@show')->name('view_branches');
        Route::get('/branch/{branch_id}/add/manager', 'EmployeeController@addManagerForm')->name('show_add_manager_form');
        Route::get('/branch/{branch_id}/add/manager/{employee_id}', 'EmployeeController@addManager')->name('add_manager');
    });

    Route::group(['middleware' => 'App\Http\Middleware\ManagerMiddleware'], function(){
        Route::get('/manager/home', 'ContentController@showHome')->name('manager_home');
        Route::get('/add/employee', 'EmployeeController@add')->name('add_employee');
        Route::get('/view/reports', 'ReportController@view')->name('view_reports');
    });

    Route::group(['middleware' => 'App\Http\Middleware\CashierMiddleware'], function(){
        Route::get('/cashier/home', 'ContentController@showHome')->name('cashier_home');
    });

    Route::group(['middleware' => 'App\Http\Middleware\StockMgrMiddleware'], function(){
        Route::get('/stockmgr/home', 'ContentController@showHome')->name('stockmgr_home');
    });
    
});

Route::get('/forbidden', function(){
    return view('403');
})->name('403');

Route::get('/test', function(){
    return view('test');
});

Route::get('/test2', function(){
    return view('modal_test');
});

// Auth::routes();

