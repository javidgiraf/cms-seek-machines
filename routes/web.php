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
use App\Http\Controllers\TranscationController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\BoostAdPackageController;
use App\Http\Controllers\SeekAgentController;
use App\Http\Controllers\QuoterequestController;
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
    Route::resource('settings', SettingController::class);
    Route::resource('seekagent', SeekAgentController::class);
    Route::resource('quoterequests', QuoterequestController::class);
    Route::get('boost-ads', [BoostAdPackageController::class, 'list'])->name('boost-ad-list');
    Route::get('boost-ads/{id}', [BoostAdPackageController::class, 'show'])->name('boost-ad-view');

    Route::post('brand/updatestatus', [BrandController::class, 'updateStatus'])
        ->name('brand.updatestatus');
        // Reports
    Route::get('package-report', [ReportController::class, 'packageReport'])->name('package-report');
    Route::get('/package-view/{plan_id}/{start_date?}/{end_date?}', [ReportController::class, 'packageDetail'])->name('package-view');
    Route::get('verification-report', [ReportController::class, 'VerificationAdsReport'])->name('verification-report');
    Route::get('buyers-report', [ReportController::class, 'BuyersReport'])->name('buyers-report');
    Route::get('hot-deals', [ReportController::class, 'HotDeals'])->name('hot-deals');
    Route::get('hot-deals-view', [ReportController::class, 'HotDealDetails'])->name('hot-deals-view');
    Route::get('machines-report', [ReportController::class, 'MachinesList'])->name('machine-report');
    Route::resource('boost-ad-packages', BoostAdPackageController::class);

        // end
    Route::post('customer/updatestatus', [CustomerController::class, 'updateStatus'])
        ->name('customer.updatestatus');

    Route::delete('sellMachineImage/{id}', [SellmachineController::class, 'deletesellMachineImage'])
        ->name('sellmachine.imagedelete');

    Route::put('changestatus/{id}', [SellmachineController::class, 'changestatus'])
        ->name('sellmachines.changestatus');

    Route::delete('/deleteSpecification/{id}', [SellMachineController::class, 'deleteSpecifications'])
        ->name('sellmachine.specdelete');
    Route::get('active', [SellmachineController::class, 'active'])
        ->name('sellmachines.active');
    Route::get('view/{id}', [SellmachineController::class, 'view'])
        ->name('sellmachines.view');
    Route::get('pending', [SellmachineController::class, 'pending'])
        ->name('sellmachines.pending');
    Route::get('inactive', [SellmachineController::class, 'inactive'])
        ->name('sellmachines.inactive');

    Route::get('success', [SellmachineController::class, 'adVerificationSuccess'])
        ->name('adverifications.success');
    Route::get('verification-view/{id}', [SellmachineController::class, 'adVerificationView'])
        ->name('adverifications.verfication-view');
    Route::get('failed', [SellmachineController::class, 'adVerificationFailed'])
        ->name('adverifications.failed');
    Route::get('verification-pending', [SellmachineController::class, 'adVerificationPending'])
        ->name('adverifications.verification-pending');
    Route::put('verification-status-update/{id}', [SellmachineController::class, 'verificationStatusUpdate'])
        ->name('adverifications.verification-status-update');

    Route::get('banner-active', [BannerController::class, 'active'])
        ->name('banners.active');
    Route::get('onreview', [BannerController::class, 'onreview'])
        ->name('banners.onreview');
    Route::get('banner-inactive', [BannerController::class, 'inactive'])
        ->name('banners.inactive');

    Route::get('banner-view/{id}', [BannerController::class, 'view'])
        ->name('banners.view');

    Route::put('banner-changestatus/{id}', [BannerController::class, 'changestatus'])
        ->name('banners.changestatus');

    Route::resource('memberships', MembershipPlanController::class);
    Route::resource('subscriptions', SubscriptionController::class);

    Route::post('subscriptions/updatecount', [SubscriptionController::class, 'updateViewCount'])
        ->name('subscriptions.count');

    Route::get('verify', [TranscationController::class, 'verifyAdTransaction'])
        ->name('transactions.verify');
    Route::get('boostads', [TranscationController::class, 'boostAdTransaction'])
        ->name('transactions.boostads');
    Route::get('transaction-subscriptions', [TranscationController::class, 'subscriptionTransaction'])
        ->name('transactions.subscriptions');
    Route::get('machine-reports', [ReportController::class, 'machineReport'])
        ->name('reports.machine');

});
