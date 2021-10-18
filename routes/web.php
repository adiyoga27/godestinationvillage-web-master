<?php
use App\Http\Controllers\Api\Front\VillageControllerApi;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Backend\AdminsController;
use App\Http\Controllers\Backend\BankAccountsController;
use App\Http\Controllers\Backend\BlogController;
use App\Http\Controllers\Backend\CategoriesController;
use App\Http\Controllers\Backend\CategoryEventsController;
use App\Http\Controllers\Backend\CategoryHomeStayController;
use App\Http\Controllers\Backend\DiscountMembersController;
use App\Http\Controllers\Backend\EventsController;
use App\Http\Controllers\Backend\HomeController;
use App\Http\Controllers\Backend\HomeStayController;
use App\Http\Controllers\Backend\InstagramController;
use App\Http\Controllers\Backend\MembersController;
use App\Http\Controllers\Backend\OrdersController;
use App\Http\Controllers\Backend\PackagesController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\ReportVillageController;
use App\Http\Controllers\Backend\VillagesController;
use App\Http\Controllers\Front\InvoiceController;
use App\Http\Controllers\Front\OrderController;
use App\Http\Controllers\Front\PageController;
use App\Http\Controllers\Front\ReservationEventController;
use App\Http\Controllers\Front\ReservationHomeStayController;
use App\Http\Controllers\Front\SearchController;
use App\Http\Controllers\MidtransController;
use App\Http\Controllers\OrderEventsController;
use App\Http\Controllers\OrderHomeStayController;
use App\Http\Controllers\TestController;
use App\Models\CategoryHomestay;
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
Route::get('test', [TestController::class, 'postinstagram']);
Route::get('test-homestay', [TestController::class, 'checkHomeStay']);
Route::get('test-package', [TestController::class, 'checkPackage']);

Auth::routes();
Route::get('auth/{provider}', [AuthController::class, 'redirectToProvider']);
Route::get('auth/{provider}/callback', [AuthController::class, 'handleProviderCallback']);

Route::get('/invoice/{id}', [InvoiceController::class , 'index']);
Route::get('/invoice-event/{id}', [InvoiceController::class , 'event']);
Route::get('/invoice-homestay/{id}', [InvoiceController::class , 'homestay']);
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
    Route::get('/paid/{email}',[OrderController::class, 'reservationPaid']);
    // Route::get('/paypal/{email}',[OrderController::class, 'reservationPaypal']);
    // Route::get('/bank/{email}',[OrderController::class, 'reservationBank']);
    Route::get('/cancel/{email}',[OrderController::class, 'reservationCancel']);
});
Route::prefix('reservation-events')->group(function () {
    Route::get('/{email}',[ReservationEventController::class, 'reservation']);
    Route::get('/paid/{email}',[ReservationEventController::class, 'paid']);
    Route::get('/cancel/{email}',[ReservationEventController::class, 'cancel']);
});
Route::prefix('reservation-homestay')->group(function () {
    Route::get('/{email}',[ReservationHomeStayController::class, 'reservation']);
    Route::get('/paid/{email}',[ReservationHomeStayController::class, 'paid']);
    Route::get('/cancel/{email}',[ReservationHomeStayController::class, 'cancel']);
});

Route::prefix('midtrans')->group(function(){
    Route::post('/callbackPayment', [MidtransController::class, 'callbackPayment']);
});
Route::get('/services', [PageController::class, 'services']);
Route::get('/faq', [PageController::class, 'faq']);
Route::get('/contact', [PageController::class, 'contact']);
// Route::get('/homestay', [PageController::class, 'homeStay']);
Route::prefix('events')->group(function () {
    Route::get('/', [PageController::class,'eventsGodevi']);
    Route::get('/{id}', [PageController::class,'detailEvent']);
});
Route::prefix('homestay')->group(function () {
    Route::get('/', [PageController::class,'homeStay']);
    Route::get('/{id}', [PageController::class,'detailHomestay']);
});
Route::get('/category-package/{id}', [PageController::class,'categorypackage']);

//check update
Route::get('/payment/event/{id}', [PageController::class,'paymentEvent']);
Route::get('/payment/event/do_cancel/{id}', [PageController::class,'cancelEvent']);
Route::get('/payment/homestay/{id}', [PageController::class,'paymentHomestay']);
Route::get('/payment/homestay/do_cancel/{id}', [PageController::class,'cancelHomeStay']);
Route::get('/payment/package/{id}', [PageController::class,'payment']);
Route::get('/payment/package/do_cancel/{id}', [PageController::class,'cancel']);



Route::get('/payment/{id}', [PageController::class,'payment']);
Route::get('/payment-detail/{id}', [PageController::class,'detailPayment']);
Route::get('/payment-confirm/{id}', [PageController::class,'confirmPayment']);
Route::get('/do_cancel/{id}', [PageController::class,'cancel']);
Route::get('user/register', [PageController::class, 'register']);
Route::get('/term', [PageController::class,'term']);
Route::get('/our-team', [PageController::class,'ourteam']);
Route::get('/our-partner', [PageController::class,'ourpartner']);
Route::get('/blog', [PageController::class,'blog']);
Route::get('/blog/{id}', [PageController::class,'detailpost']);
Route::get('/blog-mobile', [PageController::class,'blog_mobile']);
Route::get('/blog-mobile/{id}', [PageController::class,'detailpost_mobile']);
Route::get('/search', [SearchController::class,'searchHome']);
//paypal payment
Route::get('payment/pay/paypal-payment', [OrderController::class, 'paypalPayment']);
Route::post('payment/pay/bank-payment', [OrderController::class, 'bankPayment']);
Route::post('payment/pay/confirm-payment', [OrderController::class, 'confirmPayment']);
Route::get('/pay/{id}', [PaymentController::class, 'vtweb']);
Route::post('/vt-notif', [PaymentController::class, 'notification']);
Route::group(['middleware' => ['auth']], function () {
    Route::prefix('bookingEvents')->group(function () {
        Route::get('/{id}', [PageController::class, 'bookingEvents']);
        Route::post('/sendEvent',[OrderEventsController::class, 'sendEvent']);
    });
    Route::prefix('bookingHomeStay')->group(function () {
        Route::get('/{id}', [PageController::class, 'bookingHomeStay']);
        Route::post('/sendHomeStay',[OrderHomeStayController::class, 'sendHomeStay']);
    });
    Route::prefix('account')->group(function () {
        Route::get('/',[PageController::class, 'account']);
        Route::post('/{id}',[PageController::class, 'accountUpdate']);
    });
    Route::prefix('booking')->group(function () {
        Route::get('/{id}', [PageController::class, 'booking']);
        Route::post('/send',[OrderController::class, 'send']);
        Route::post('/sendEvent',[OrderController::class, 'sendEvent']);
    });
});
Route::group(['prefix' => 'administrator', 'middleware' => ['auth', 'role:admin|village']], function () {
     Route::resource('bank-account', BankAccountsController::class, ['names' => 'bank_account']);
    Route::resource('blog', BlogController::class);
    Route::resource('instagram', InstagramController::class);

    Route::resource('category', CategoriesController::class);
    Route::resource('category-event', CategoryEventsController::class);
    Route::resource('discount-member', DiscountMembersController::class, ['names' => 'discount_member']);
    Route::resource('order', OrdersController::class, ['names' => 'order']);
    Route::get('order/{id}/change-status/{status}', [
        'as' => 'order.change_status',
        'uses' => 'OrdersController@change_status'
    ]);
    Route::resource('order-event', OrderEventsController::class, ['names' => 'order-event']);
    Route::get('order-event/{id}/change-status/{status}', [
        'as' => 'order-event.change_status',
        'uses' => 'OrderEventsController@change_status'
    ]);
    // Route::get('order-event/{id}/change-status/{status}', [OrderEventsController::class, 'change_status']);
    Route::resource('category-events', CategoryEventsController::class);
    Route::resource('events', EventsController::class);
    Route::resource('homestay', HomeStayController::class);
    Route::resource('category-homestay', CategoryHomeStayController::class);
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
    Route::prefix('report')->group(function () {
        Route::get('/villages', [ReportVillageController::class, 'index'])->name('report.village');
        Route::get('/villages/order', [ReportVillageController::class, 'get_order'])->name('report_village.get_order');
        Route::get('/villages/order/export', [
            'as'   => 'report_village.export_xls',
            'uses' => 'ReportVillageController@export_xls'
        ]);
        Route::get('/villages/packages', [ReportVillageController::class, 'get_package'])->name('report_village.get_package');
        Route::get('/event', [ReportVillageController::class, 'index'])->name('report.village');
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
