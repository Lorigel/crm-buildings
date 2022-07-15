<?php

use App\Models\Role;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return redirect('login');
});

//routes for auth users
Route::middleware('auth')->group(function() {
    //edit profile
    Route::get('edit-profile',  'App\Http\Controllers\Dashboard\UserController@editProfile')->name('user.edit');
    Route::post('user-update', 'App\Http\Controllers\Dashboard\UserController@update')->name('user.update');

    Route::group(['prefix' => 'dashboard'], function(){
        Route::get('/', 'App\Http\Controllers\Dashboard\Dashboard@index')->name('dashboard');

        //agents
        Route::middleware('role:' . implode(',', Role::agents()))->group(function () {
            Route::group(['prefix' => 'contracts'], function(){
                Route::get('/', 'App\Http\Controllers\Dashboard\ContractController@list')->name('contract.list');
                Route::get('/{id}/details', 'App\Http\Controllers\Dashboard\ContractController@view')->name('contract.single');
                Route::get('/create', 'App\Http\Controllers\Dashboard\ContractController@new')->name('contract.new');
                Route::post('/create', 'App\Http\Controllers\Dashboard\ContractController@create')->name('contract.create');
            });

            Route::middleware('role:technic')->group(function () {
                Route::post('/{id}/technic-update-documents', 'App\Http\Controllers\Dashboard\ContractController@updateTechnicDocuments')->name('contract.technic.documents');
            });

            Route::middleware('role:company')->group(function () {
                Route::post('/{id}/upload-invoice', 'App\Http\Controllers\Dashboard\ContractController@uploadInvoice')->name('contract.invoice.upload');
            });
        });

        Route::middleware('role:admin,master')->group(function () {
            Route::group(['prefix' => 'contracts'], function(){
                Route::get('/{id}/edit', 'App\Http\Controllers\Dashboard\ContractController@edit')->name('contract.edit');
                Route::post('/{id}/edit', 'App\Http\Controllers\Dashboard\ContractController@update')->name('contract.update');
                Route::get('/{id}/profit', 'App\Http\Controllers\Dashboard\ContractController@profitDetails')->name('contract.profit');
            });
        });


        Route::middleware('role:admin,master,supervisor')->group(function () {
            Route::group(['prefix' => 'users'], function(){
                Route::get('/', 'App\Http\Controllers\Dashboard\UserController@list')->name('users');
                Route::get('{id}/edit', 'App\Http\Controllers\Dashboard\UserController@editProfile');
            });
        });

        //admin and master
        Route::middleware('role:admin,master')->group(function () {
            Route::group(['prefix' => 'users'], function(){
                //add new user
                Route::get('new-user',  'App\Http\Controllers\Dashboard\UserController@new')->name('user.new');
                Route::post('add-user',  'App\Http\Controllers\Dashboard\UserController@add')->name('user-add');
                //import
                Route::get('import', 'App\Http\Controllers\Dashboard\UserController@import')->name('users.import');
                Route::post('import', 'App\Http\Controllers\Dashboard\UserController@handleImport')->name('users.handle-import');
                //see relations
                Route::get('list', 'App\Http\Controllers\Dashboard\UserController@viewRelated')->name('user.list');
                Route::get('listing', 'App\Http\Controllers\Dashboard\UserController@orgcharts')->name('user.listing');
                //delete user
                Route::post('delete/{id}', 'App\Http\Controllers\Dashboard\UserController@delete');
            });
        });
    });
});


//public
Route::get('reset-password-from-invite',  'App\Http\Controllers\Dashboard\UserController@acceptInvitation');
Route::post('set-password',  'App\Http\Controllers\Dashboard\UserController@setPassword')->name('password.set');
//get users by role
Route::post('show-assigned-to', 'App\Http\Controllers\Dashboard\UserController@showAssignedTo');

require __DIR__.'/auth.php';
