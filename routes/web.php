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
    Route::get('delete-Product-{id}',"AdminController@getDeleteProduct")->name('deleteProduct');
    

    Route::group(['middleware'=>'isadmin'],function(){
        Route::get('update-product-{id}',"AdminController@getUpdateProduct")->name('updateProduct');
        Route::post('update-product-{id}',"AdminController@postUpdateProduct")->name('updateProduct');
    });

    Route::get('add-product',"AdminController@getAddProduct")->name('addProduct');
    Route::post('add-product',"AdminController@postAddProduct")->name('addProduct');

    Route::get('list-product-{idType}',"AdminController@getlistProduct")->name('listProduct');
    //admin/select-level-two duong link
    route::get('select-level-two',"AdminController@getlevelTwo")->name('getl2');
});
