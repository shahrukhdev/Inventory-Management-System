<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::name('admin.')->group(function() {

Route::prefix('user')->controller(\App\Http\Controllers\System\UserController::class)->middleware(['auth', 'role:Super Admin'])->name('user.')->group(function () {

    Route::get('list', 'list')->name('list')->middleware(['permission:users.view']);
    Route::get('detail/{id}', 'detail')->name('detail')->middleware(['permission:users.edit']);
    Route::post('add', 'add')->name('add')->middleware(['permission:users.add']);
    Route::post('update', 'update')->name('update')->middleware(['permission:users.edit']);
    Route::get('delete/{id}', 'delete')->name('delete')->middleware(['permission:users.delete']);
    Route::post('assign_role1', 'assign_role1')->name('assign_role1');
    Route::get('disable/login/{id}', 'disable_enable_login')->name('disable_enable_login');
});

Route::prefix('role')->controller(\App\Http\Controllers\System\RolesController::class)->middleware(['auth', 'role:Super Admin'])->name('role.')->group(function () {

    Route::get('list', 'list')->name('list')->middleware(['permission:roles.view']);
    Route::post('create', 'create')->name('create')->middleware(['permission:roles.add']);
    Route::post('update', 'update')->name('update')->middleware(['permission:roles.edit']);
    Route::get('delete/{id}', 'delete')->name('delete')->middleware(['permission:roles.delete']);
});

Route::prefix('permission')->controller(\App\Http\Controllers\System\PermissionsController::class)->middleware(['auth', 'role:Super Admin'])->name('permission.')->group(function () {

    Route::get('list', 'list')->name('list')->middleware(['permission:permissions.view']);
    Route::post('create', 'create')->name('create')->middleware(['permission:permissions.add']);
    Route::post('update', 'update')->name('update')->middleware(['permission:permissions.edit']);
    Route::get('delete/{id}', 'delete')->name('delete')->middleware(['permission:permissions.delete']);
    Route::post('add_module', 'add_module')->name('add_module')->middleware(['permission:permissions.add|permissions.edit']);
});

Route::prefix('departments')->controller(\App\Http\Controllers\System\DepartmentController::class)->middleware(['auth', 'role:Super Admin'])->name('department.')->group(function () {

    Route::get('/list', 'list')->name('list')->middleware(['permission:department.view']);
    Route::post('store', 'store')->name('store')->middleware(['permission:department.add']);
    Route::get('edit/{id}', 'edit')->name('edit')->middleware(['permission:department.edit']);
    Route::post('update/{id}', 'update')->name('update')->middleware(['permission:department.edit']);
    Route::get('delete/{id}','delete')->name('delete')->middleware(['permission:department.delete']);
});


});

