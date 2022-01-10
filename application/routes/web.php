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

// ** SUPPRESS WARNINGS IF PHP VERSION IS ABOVE 7.2 ** //

if (version_compare(PHP_VERSION, '7.2.0', '>=')) {
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
}

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// ** INIT BOOKING ** //
Route::get('/','UserBookingController@loadBooking')->name('index');

// ** AUTHORIZATION ROUTE ** //
Auth::routes();

// ** DASHBOARD ROUTE ** //
Route::get('/home', 'HomeController@index')->name('home');

// ** BOOKING AJAX REQUESTS ** //
Route::post('/get_packages', 'UserBookingController@getPackages')->name('packages');
Route::post('/get_timing_slots', 'UserBookingController@getTimingSlots')->name('slots');
Route::post('/get_update_slots', 'UserBookingController@getUpdateSlots')->name('updateSlots');
Route::post('/remove_session_addon', 'UserBookingController@removeFromList');


// ** USER ROLE ADMIN ROUTES ** //
Route::group(['middleware'=>'admin'], function(){
    Route::resource('/users','AdminUsersController');
    Route::resource('/categories', 'AdminCategoriesController');
    Route::resource('/packages', 'AdminPackagesController');
    Route::resource('/addons', 'AdminAddonsController');
    Route::resource('/settings', 'AdminSettingsController');
    Route::resource('/booking-times', 'AdminBookingTimesController');
    Route::resource('/{id}/booking-slots', 'BookingSlotController');
    Route::resource('/bookings', 'AdminBookingsController');
    Route::resource('/invoices', 'AdminInvoicesController');
    Route::resource('/staff', 'AdminStaffController');
    Route::resource('/cancel-requests', 'CancelRequestController');
    Route::post('/cancel-booking/{id}', 'AdminBookingsController@cancel')->name('cancelBooking');
    Route::patch('/updateBooking/{id}', 'AdminBookingsController@update_booking_time')->name('updateBookingTime');
    // ** DATABASE UPDATE ROUTES ** //
    Route::get('/update-database', 'DatabaseUpdateController@update');
    Route::resource('/coupon-codes', 'AdminCouponCodeController');
    Route::post('/import-coupons', 'AdminCouponCodeController@import')->name('importCoupons');
});

// ** USER ROLE CUSTOMER ROUTES ** //
Route::group(['middleware'=>'customer'], function(){
    Route::get('/customer/bookings', 'UserBookingController@index')->name('customerBookings');
    Route::get('/customer/booking/{id}', 'UserBookingController@show')->name('showBooking');
    Route::get('/customer/invoices', 'CustomerInvoiceController@index')->name('customerInvoices');
    Route::get('/customer/invoice/{id}', 'CustomerInvoiceController@show')->name('showInvoice');
    Route::get('/customer/profile', 'CustomerProfileController@index')->name('customerProfile');
    Route::patch('/customer/{id}', 'CustomerProfileController@update')->name('customerUpdate');
    Route::post('/cancel-request', 'CancelRequestController@store')->name('cancelRequest');
    Route::get('/update-booking/{id}', 'UserBookingController@update')->name('updateBooking');
    Route::patch('/booking/{id}', 'UserBookingController@update_booking')->name('postUpdateBooking');
});

// ** COMMON ROUTES FOR AUTHENTICATED USERS ** //
Route::group(['middleware'=>'authenticated'], function() {
    // ** BOOKING FORM ROUTES ** //
    Route::post('/postStep1', 'UserBookingController@postStep1')->name('postStep1');
    Route::get('/select-booking-time', 'UserBookingController@loadStep2')->name('loadStep2');
    Route::post('/postStep2', 'UserBookingController@postStep2')->name('postStep2');
    Route::get('/select-extra-services', 'UserBookingController@loadStep3')->name('loadStep3');
    Route::post('/postStep3', 'UserBookingController@postStep3')->name('postStep3');
    Route::get('/finalize-booking', 'UserBookingController@loadFinalStep')->name('loadFinalStep');
    Route::post('/verify-promo-code', 'UserBookingController@usePromo')->name('usePromo');
    // ** PAYMENT GATEWAYS ** //
    Route::post('/payWithStripe', 'StripeController@payWithStripe')->name('payWithStripe');
    Route::get('/payWithPaypal', 'PaypalController@payWithPaypal')->name('payWithPaypal');
    Route::get('/pay-after-service', 'OfflinePaymentController@payOffline')->name('payOffline');
    Route::get('/paymentSuccessful', 'PaypalController@paymentSuccessful')->name('paymentSuccessful');
    Route::get('/paymentFailed', 'PaypalController@paymentFailed')->name('paymentFailed');
    // ** BOOKING COMPLETE OR FAILED ROUTES ** //
    Route::get('/thank-you', 'UserBookingController@thankYou')->name('thankYou');
    Route::get('/payment-failed', 'UserBookingController@paymentFailed')->name('paymentFailed');
    // ** AUXILIARY ROUTES  ** //
    Route::resource('/session_addons','SessionAddonsController');
    Route::get('/account-disabled', function (){
        return view('errors.accountDisabled');
    })->name('accountDisabled');
    // ** PASSWORD CHANGE ROUTES ** //
    Route::get('/password/update', 'UserPasswordController@index')->name('changePassword');
    Route::patch('/password/update/{id}', 'UserPasswordController@update')->name('postChangePassword');
});