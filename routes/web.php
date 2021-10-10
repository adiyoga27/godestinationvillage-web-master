<?php

use App\Http\Controllers\Api\Front\VillageControllerApi;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Backend\AdminsController;
use App\Http\Controllers\Backend\BankAccountsController;
use App\Http\Controllers\Backend\BlogController;
use App\Http\Controllers\Backend\CategoriesController;
use App\Http\Controllers\Backend\CategoryEventsController;
use App\Http\Controllers\Backend\DiscountMembersController;
use App\Http\Controllers\Backend\EventsController;
use App\Http\Controllers\Backend\HomeController;
use App\Http\Controllers\Backend\MembersController;
use App\Http\Controllers\Backend\OrdersController;
use App\Http\Controllers\Backend\PackagesController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\ReportVillageController;
use App\Http\Controllers\Backend\VillagesController;
use App\Http\Controllers\Front\OrderController;
use App\Http\Controllers\Front\PageController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpKernel\Profiler\Profile;

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
Auth::routes();


Route::get('locale/{locale}', function ($locale) {
    Session::put('locale', $locale);
    App::setLocale($locale);
    // dd($locale);
    return redirect()->back();
});

Route::get('/', [PageController::class, 'index']);

Route::get('/administrator/login',  [LoginController::class, 'authenticated']);

Route::get('/user/login', [LoginController::class, 'authenticated']);







//Customer Page

Route::get('/company-profile', [PageController::class, 'companyprofile']);
Route::prefix('village')->group(function () {
    Route::get('/',[PageController::class, 'village']);
    Route::get('/{id}',[PageController::class, 'detailVillage']);
});
Route::prefix('tour-packages')->group(function () {
    Route::get('/',[PageController::class, 'tourpackages']);
    Route::get('/{id}',[PageController::class, 'detailtour']);
});


Route::prefix('reservation')->group(function () {
    Route::get('/{email}',[PageController::class, 'reservation']);
    Route::get('/paid/{email}',[PageController::class, 'reservationPaid']);
    Route::get('/paypal/{email}',[PageController::class, 'reservationPaypal']);
    Route::get('/bank/{email}',[PageController::class, 'reservationBank']);
    Route::get('/cancel/{email}',[PageController::class, 'reservationCancel']);
});

Route::prefix('booking')->group(function () {
    Route::get('/booking/{id}', [OrderController::class, 'booking']);
    Route::post('/booking/send',[OrderController::class, 'send']);
    Route::post('/booking/sendEvent',[OrderController::class, 'sendEvent']);
});




Route::get('/services', [PageController::class, 'services']);
Route::get('/faq', [PageController::class, 'faq']);
Route::get('/contact', [PageController::class, 'contact']);
Route::get('/homestay', 'Front\PageController@homeStay');
Route::get('/events', 'Front\PageController@eventsGodevi');
Route::get('/category-package/{id}', 'Front\PageController@categorypackage');









Route::get('/payment/{id}', 'Front\PageController@payment');
Route::get('/payment-detail/{id}', 'Front\PageController@detailPayment');
Route::get('/payment-confirm/{id}', 'Front\PageController@confirmPayment');


Route::get('/do_cancel/{id}', 'Front\PageController@cancel');




Route::get('user/register', 'Front\PageController@register');



Route::get('/term', 'Front\PageController@term');

Route::get('/our-team', 'Front\PageController@ourteam');

Route::get('/our-partner', 'Front\PageController@ourpartner');

Route::get('/blog', 'Front\PageController@blog');

Route::get('/blog/{id}', 'Front\PageController@detailpost');

Route::get('/blog-mobile', 'Front\PageController@blog_mobile');

Route::get('/blog-mobile/{id}', 'Front\PageController@detailpost_mobile');

//search

Route::get('/search', 'Front\SearchController@searchHome');



Route::get('/invoice/{id}', 'Front\InvoiceController@index');







//paypal payment

Route::get('payment/pay/paypal-payment', 'Front\OrderController@paypalPayment');
Route::post('payment/pay/bank-payment', 'Front\OrderController@bankPayment');
Route::post('payment/pay/confirm-payment', 'Front\OrderController@confirmPayment');


Route::get('/bookingEvents/{id}', 'Front\PageController@bookingEvents');




Route::get('/reservation/{email}', 'Front\PageController@reservation');

Route::get('/reservation/paid/{email}', 'Front\OrderController@reservationPaid');

Route::get('/reservation/paypal/{email}', 'Front\OrderController@reservationPaypal');

Route::get('/reservation/bank/{email}', 'Front\OrderController@reservationBank');

Route::get('/reservation/cancel/{email}', 'Front\OrderController@reservationCancel');



Route::get('/pay/{id}', [PaymentController::class, 'vtweb']);
Route::post('/vt-notif', [PaymentController::class, 'notification']);


Route::group(['middleware' => ['auth']], function () {

    //reservation

    // Route::get('/reservation', 'Front\PageController@reservation');

    // Route::get('/reservation/paid', 'Front\OrderController@reservationPaid');

    // Route::get('/reservation/paypal', 'Front\OrderController@reservationPaypal');

    // Route::get('/reservation/bank', 'Front\OrderController@reservationBank');

    // Route::get('/reservation/cancel', 'Front\OrderController@reservationCancel');
    
    Route::prefix('account')->group(function () {
        Route::get('/',[PageController::class, 'account']);
        Route::get('/{id}',[PageController::class, 'accountUpdate']);
    });

});

Route::group(['prefix' => 'administrator', 'middleware' => ['auth', 'role:admin|village']], function () {

    Route::resource('bank-account', BankAccountsController::class, ['names' => 'bank_account']);
    Route::resource('blog', BlogController::class);
    Route::resource('category', CategoriesController::class);
    Route::resource('category-event', CategoryEventsController::class);

    Route::resource('discount-member', DiscountMembersController::class, ['names' => 'discount_member']);
    Route::resource('order', OrdersController::class, ['names' => 'order']);
    Route::get('order/{id}/change-status/{status}', [
        'as' => 'order.change_status',
        'uses' => 'OrdersController@change_status'
    ]);

    Route::resource('category-events', CategoryEventsController::class);
    Route::resource('events', EventsController::class);


    Route::resource('package', PackagesController::class);
    Route::prefix('package')->group(function () {
        Route::get('/{id}/orders', [
            'as' => 'package.orders',
            'uses' => 'PackagesController@get_orders'
        ]);
        Route::post('/delete-image', [
            'as' => 'package.delete_image',
            'uses' => 'PackagesController@delete_image'
        ]);
    });


    Route::resource('user-admin', AdminsController::class, ['names' => 'user_admin']);
    Route::resource('user-member', MembersController::class, ['names' => 'user_member']);
    Route::resource('user-village', VillagesController::class, ['names' => 'user_village']);


    Route::get('/dashboard', [HomeController::class, 'index'])->name('home');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/save', [ProfileController::class, 'update'])->name('update_profile');
 

   

    Route::prefix('report/villages')->group(function () {
        Route::get('/', [ReportVillageController::class, 'index'])->name('report.village');
        Route::get('/order', [ReportVillageController::class, 'get_order'])->name('report_village.get_order');
        Route::get('/order/export', [
            'as'   => 'report_village.export_xls',
            'uses' => 'ReportVillageController@export_xls'
        ]);
        Route::get('/packages', [ReportVillageController::class, 'get_package'])->name('report_village.get_package');
    });


    Route::get('user-village/{id}/packages', [
        'as' => 'user_village.packages',
        'uses' => 'VillageDatatableController@get_packages'
    ]);
    Route::get('user-village/{id}/orders', [
        'as' => 'user_village.orders',
        'uses' => 'VillageDatatableController@get_orders'
    ]);

});
