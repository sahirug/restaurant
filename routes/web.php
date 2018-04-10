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
//     return view('login');
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
    });

    Route::group(['middleware' => 'App\Http\Middleware\ManagerMiddleware'], function(){
        Route::get('/manager/home', 'ContentController@showHome')->name('manager_home');
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

// Auth::routes();

