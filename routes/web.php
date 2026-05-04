<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('auth')->group(function() {

    Route::prefix('brands')->controller(\App\Http\Controllers\Product\BrandController::class)->name('brand.')->group(function () {

        Route::get('/list', 'list')->name('list')->middleware(['permission:brand.view']);
        Route::post('store', 'store')->name('store')->middleware(['permission:brand.add']);
        Route::get('edit/{id}', 'edit')->name('edit')->middleware(['permission:brand.edit']);
        Route::post('update/{id}', 'update')->name('update')->middleware(['permission:brand.edit']);
        Route::get('delete/{id}','delete')->name('delete')->middleware(['permission:brand.delete']);
    });

    Route::prefix('vendors')->controller(\App\Http\Controllers\Invoice\VendorController::class)->name('vendor.')->group(function () {

        Route::get('/list', 'list')->name('list')->middleware(['permission:vendor.view']);
        Route::post('store', 'store')->name('store')->middleware(['permission:vendor.add']);
        Route::get('edit/{id}', 'edit')->name('edit')->middleware(['permission:vendor.edit']);
        Route::post('update/{id}', 'update')->name('update')->middleware(['permission:vendor.edit']);
        Route::get('delete/{id}','delete')->name('delete')->middleware(['permission:vendor.delete']);
    });

    Route::prefix('products')->controller(\App\Http\Controllers\Product\ProductController::class)->name('product.')->group(function () {
        Route::get('/list', 'list')->name('list')->middleware(['permission:product.view']);
        Route::get('/add', 'addproduct')->name('add')->middleware(['permission:product.add']);
        Route::post('store', 'store')->name('store')->middleware(['permission:product.add']);
        Route::get('edit/{id}', 'edit')->name('edit')->middleware(['permission:product.edit']);
        Route::post('update/{id}', 'update')->name('update')->middleware(['permission:product.edit']);
        Route::get('delete-variation','deletevariation')->name('variation.delete')->middleware(['permission:product.delete']);
        Route::get('delete/{id}','delete')->name('delete')->middleware(['permission:product.delete']);
    });

    Route::prefix('product/items')->name('productitem.')->group(function () {

        Route::controller(\App\Http\Controllers\Product\ProductItemController::class)->group(function (){
            Route::get('list/{id}', 'list')->name('list')->middleware(['permission:product_item.view']);
            Route::get('edit/{id}', 'edit')->name('edit')->middleware(['permission:product_item.edit']);
            Route::post('update/{id}', 'update')->name('update')->middleware(['permission:product_item.edit']);
            Route::get('delete/{id}','delete')->name('delete')->middleware(['permission:product_item.delete']);
            Route::get('delete-invoice-item/{id}','deleteInvoiceItem')->name('invoice.item.delete')->middleware(['permission:product_item.delete']);
            Route::get('get-employee','getemployee')->name('get.employee')->middleware(['permission:assign_employee']);
            Route::post('assign-employee','assignemployee')->name('assign.employee')->middleware(['permission:assign_employee']);
        });

        Route::prefix('history')->controller(\App\Http\Controllers\Product\ProductHistoryController::class)->name('history.')->group(function (){
            Route::get('list/{id}', 'list')->name('list')->middleware(['permission:product_item_history.view']);
            Route::post('store', 'store')->name('store')->middleware(['permission:product_item_history.add']);
            Route::get('edit', 'edit')->name('edit')->middleware(['permission:product_item_history.edit']);
            Route::post('update/{id}', 'update')->name('update')->middleware(['permission:product_item_history.edit']);
            Route::get('delete/{id}', 'delete')->name('delete')->middleware(['permission:product_item_history.delete']);
        });
    });

    Route::prefix('invoices')->controller(\App\Http\Controllers\Invoice\InvoiceController::class)->name('invoice.')->group(function () {
        Route::get('/list', 'list')->name('list')->middleware(['permission:invoice.view']);
        Route::get('/add', 'addinvoicelist')->name('add')->middleware(['permission:invoice.add']);
        Route::post('store', 'store')->name('store')->middleware(['permission:invoice.add']);
        Route::get('edit/{id}','edit')->name('edit')->middleware(['permission:invoice.edit']);
        Route::post('update/{id}', 'update')->name('update')->middleware(['permission:invoice.edit']);
        Route::get('delete/{id}','delete')->name('delete')->middleware(['permission:invoice.delete']);
        Route::get('get-product-price', 'getproductprice')->name('get.product.price')->middleware(['permission:invoice.add|invoice.edit']);
    });

    Route::prefix('profile')->controller(\App\Http\Controllers\System\ProfileController::class)->name('profile.')->group(function () {
        Route::get('/', 'list')->name('list')->middleware(['permission:profile.view']);
        Route::post('edit-profile/{id}', 'editprofile')->name('edit.profile')->middleware(['permission:profile.edit']);
    });

});



Route::get('/', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'create'])
    ->name('login');

Route::get('/', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'create'])
    ->middleware('guest')
    ->name('home');

//Route::middleware('auth')->group(function () {
//    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
//});

Route::get('/dashboard', function () {
    return abort(404);
    return view('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';
