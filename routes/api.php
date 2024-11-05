<?php

use App\Http\Controllers\Api\AuthControllerApi;
use App\Http\Controllers\Api\V2\ArticleController;
use App\Http\Controllers\Api\V2\AuthController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group([
    'middleware' => ['api', 'cors'],
    'prefix'=>'auth'
    ], function(){       
Route::post('/login', [AuthControllerApi::class, 'login']);
Route::post('/registration', [AuthControllerApi::class, 'registration']);
});

Route::get('/pay/{id}', [PaymentController::class, 'pay']);


Route::get('/slider', [PageControllerApi::class, 'slider']);

Route::get('/profile', [ProfileControllerApi::class, 'profile']);

Route::get('/invoice/{id}', [InvoiceControllerApi::class, 'invoice']);

Route::get('/consulting', [ConsultingController::class, 'index']);

Route::group(['prefix'=>'tag'], function(){       
    Route::get('/', [TagControllerApi::class, 'view']);
    Route::get('/{id}', [TagControllerApi::class, 'viewBy']);

});



//FIX
Route::group(['prefix'=>'village'], function(){     
    Route::get('/', [VillageControllerApi::class, 'index']);
    Route::get('/show/{id}', [VillageControllerApi::class, 'show']);
});

Route::group(['prefix'=>'packages'], function(){       
    Route::get('/popular', [PackageControllerApi::class, 'popular']);
    Route::get('/recents', [PackageControllerApi::class, 'recentPackages']);
    Route::get('/best', [PackageControllerApi::class, 'bestPackages']);
    Route::get('/search/{keyword}', [PackageControllerApi::class, 'search']);
    Route::get('/{id}', [PackageControllerApi::class, 'detailPackage']);
});
Route::group(['prefix'=>'blogs'], function(){     
Route::get('/', [BlogControllerApi::class, 'blogs']);
    Route::get('/recents', [BlogControllerApi::class, 'recentBlogs']);
    Route::get('/{id}', [BlogControllerApi::class, 'detailBlogs']);
});

Route::group(['prefix'=>'review'], function(){     
    Route::get('/', [ReviewControllerApi::class, 'index']);
});

Route::group([
    'middleware' => ['api', 'cors'],
    'prefix'=>'transaction'], function(){       
    Route::get('/paid/{email}', [ReservationControllerApi::class, 'reservationPaid']);
    Route::get('/paypal/{email}', [ReservationControllerApi::class, 'reservationPaypal']);
    Route::get('/bank/{email}', [ReservationControllerApi::class, 'reservationBank']);
    Route::get('/cancel/{email}', [ReservationControllerApi::class, 'reservationCancel']);
    Route::get('/unpaid/{email}', [ReservationControllerApi::class, 'reservationUnpaid']);
});

Route::group([
    'middleware' => ['api', 'cors'],
    'prefix'=>'trip'], function(){       
    Route::get('/reservation/{email}', 'Api\Front\PageControllerApi@reservation')->name('trip.reservation');
    Route::get('/reservation/paypal/{email}', 'Api\Front\PageControllerApi@paypal')->name('trip.paypal');
    Route::get('/reservation/bank/{email}', 'Api\Front\PageControllerApi@bank')->name('trip.bank');
    Route::get('/reservation/cancel/{email}', 'Api\Front\PageControllerApi@cancel')->name('trip.cancel');
});

Route::group([
    'middleware' => ['api', 'cors'],
    'prefix'=>'category'], function(){       
    Route::get('/', [CategoryPackageControllerApi::class, 'index']);
    Route::get('/{id}', [CategoryPackageControllerApi::class, 'show']);
});


    Route::group([
            'middleware' => ['api', 'cors','auth:api'],
            'prefix'=>'booking'], function(){       
            Route::get('/{id}', [BookingController::class, 'show']);
            Route::post('/send', [BookingController::class, 'send']);
    });


    Route::group(['prefix'=>'v2'], function(){     
        Route::group([
            'middleware' => ['api', 'cors'],
            'prefix'=>'auth'
            ], function(){       
                Route::post('/login', [AuthController::class, 'login']);
                Route::post('/registration', [AuthController::class, 'registration']);
        });

        Route::group([
            'middleware' => ['api', 'cors'],
            'prefix'=>'blogs'
            ], function(){       
                Route::get('/', [ArticleController::class, 'index']);
                Route::get('/{slug}', [ArticleController::class, 'show']);
        });
    });
    

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


