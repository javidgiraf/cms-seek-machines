<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SellmachineController;
use App\Http\Controllers\BuyerRequestController;
use App\Http\Controllers\MembershipPlanController;
use App\Http\Controllers\SubscriptionController;
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

Route::get('/', [LoginController::class, 'showLoginForm']);
Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/clear-cache', function () {
    Artisan::call('optimize:clear');
    return "All Cache is cleared";
    // return view('cache');
})->name('cache.clear');

Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
});

Route::group(['middleware' => ['auth']], function () { //'permission'
    Route::resource('brands', BrandController::class);
    Route::resource('countries', CountryController::class);
    Route::resource('blogs', BlogController::class);
    Route::resource('banners', BannerController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('roles', RolesController::class);
    Route::resource('permissions', PermissionsController::class);
    Route::resource('admins', AdminController::class);
    Route::resource('customers', CustomerController::class);
    Route::resource('sellmachines', SellmachineController::class);
    Route::resource('buyerrequests', BuyerRequestController::class);

    Route::delete('sellMachineImage/{id}', [SellmachineController::class, 'deletesellMachineImage'])
        ->name('sellmachine.imagedelete');
    Route::get('active', [SellmachineController::class, 'active'])
        ->name('sellmachines.active');
    Route::get('pending', [SellmachineController::class, 'pending'])
        ->name('sellmachines.pending');
    Route::get('inactive', [SellmachineController::class, 'inactive'])
        ->name('sellmachines.inactive');

    Route::delete('/deleteSpecification/{id}', [SellMachineController::class, 'deleteSpecifications'])
        ->name('sellmachine.specdelete');

    Route::resource('memberships', MembershipPlanController::class);
    Route::resource('subscriptions', SubscriptionController::class);
});
