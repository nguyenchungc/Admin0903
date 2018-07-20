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
//     return view('welcome');
// });

// Route::match(['get','post'],'login',"AdminController@login");

Route::get('login',"AdminController@getLogin")->name('getlogin');
Route::post('admin-login',"AdminController@postLogin")->name('login');

Route::get('register',"AdminController@getRegister")->name('get-register');
Route::post('register',"AdminController@postRegister")->name('register');

Route::group(['prefix'=>'admin','middleware'=>'checkAdminLogin'],function(){

    //admin/logout
    Route::get('logout',"AdminController@getLogout")->name('logout');

    // admin
    Route::get('/',"AdminController@getHome")->name('home');

    //admin/update-bill-2
    Route::get('update-bill-{id}',"AdminController@getUpdateBill");

    //admin/bills-0
    Route::get('bills-{status?}',"AdminController@getBillsByStatus")->name('bills');


    // admin/add-product
    Route::get('add-product',"AdminController@getAddProduct")->name('addProduct');


    // Route::get('test',function(){
    //     $a = \App\Categories::with('cate')->where('id_parent',null)->get();
    //     dd($a);
    // });
});
