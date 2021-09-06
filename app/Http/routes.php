<?php
Route::get('test1', 'OutdiscountController@get_token');

//Route::get('/', 'HomeController@index');
Route::get('home', 'HomeController@index');
Route::get('/', 'ShopController@index');
Route::get('username/reset', 'Auth\AuthController@showResetEmailForm');
Route::post('username/retrieve', 'Auth\AuthController@retrieveUsername');
Route::get('catalogue', 'ShopController@index');
Route::get('catalogue/{category}', 'ShopController@getCategoryItems');
Route::get('catalogue/product/{slug?}', 'ShopController@getSingleItem');

Route::get('outdiscount', 'OutdiscountController@index');

Route::get('test_234', 'TestController@test');

Route::get('no_content', function (){
    return view('errors.no_content');
})->name('no_content');

Route::get('no_result', function (){
    return view('errors.no_search_result');
})->name('no_result');

Route::get('no_results', function (){
    return view('errors.no_search_result_with_categories');
})->name('no_results');

Route::get('no_content_with_categories', function (){
    return view('errors.no_content_with_categories');
})->name('no_content_with_categories');

Route::get('/error', function (){
    return view('errors.networkfail');
});

Route::get('search', 'ShopController@search');

//Security
Route::get('security/change_password', 'Auth\AuthController@changePassword');
Route::post('security/change_password', 'AccountsController@changePasswordAction')->name('change_password_action');
Route::get('security', 'Auth\AuthController@security');
Route::get('resetpassword', 'AccountsController@showResetPasswordView');
Route::post('reset_password_without_token', 'AccountsController@validatePasswordRequest');
Route::post('reset_password_with_token', 'AccountsController@resetPassword');



//Cinemas
Route::get('cinemas', 'CinemaController@index');
Route::get('cinemas/{cinema}', 'CinemaController@getMoviesByCinema');
Route::get('movie/{code}', 'CinemaController@view');
Route::get('events', 'EventsController@index');

Route::get('wishlist', 'WishlistController@list_wishlist_request');

//Fuel vouchers
Route::get('fuel_vouchers', 'FuelVouchersController@index');
Route::post('get_fuel_vouchers', 'FuelVouchersController@getVouchers');
Route::post('redeem_fuel_voucher', 'FuelVouchersController@redeem');

//Uber vouchers
Route::get('uber_vouchers', 'VouchersController@uberIndex');

//Flight Tickets
Route::get('flight', 'FlightController@index');
Route::post('flight/search', 'FlightController@search');
Route::post('flight/details', 'FlightController@details');

//Bills and Airtime
Route::get('bills', 'BillsController@index');
Route::get('bills/{id}', 'BillsController@getPaymentVendors');
Route::post('redeem_bill', 'BillsController@redeemBill');

//Discounts
Route::get('discount', 'DiscountController@index');

//Terms and Condition
Route::get('terms', 'TermsController@index');
Route::get('blank_terms', 'TermsController@blank_terms');


Route::get('firstlogin', 'UserController@firsttimepage');
Route::post('firsttimelogin', 'UserController@firstTimeLogin');

//Returns Policy
Route::get('returns', 'ReturnsController@index');

//Meals
Route::get('meals', 'MealsController@index');
Route::get('food', 'FoodController@index');


Route::get('food/restaurant/{name}', 'FoodController@getRestaurant');
Route::get('meals/{name}', 'MealsController@getMeals');

Route::get('faqs', function () {
    return view('pages.faqs');
});




//Experiemce
Route::get('experiences', 'ExperienceController@index');
Route::get('get_experience_availabilities/{id}', 'ExperienceController@get_experience_availabilities');
Route::get('get_experience_booking_form/{id}', 'ExperienceController@get_experience_booking_form');
//Route::get('experiences/category', 'ExperienceController@expericenceCategories');
Route::get('experiences/{id}', 'ExperienceController@getExpericences');
Route::get('experiences_search', 'ExperienceController@expericences');
Route::get('experience/{slug?}', 'ExperienceController@getSingleItem');
Route::post('experience/checkout', 'ExperienceController@redeemExperience')->name('checkout_experience');

Route::post('contact', 'CommonController@sendContactEmail');

Route::group(['middleware'=> 'auth'], function (){

    Route::get('contact', 'CommonController@contactView');



//Route::get('catalogue/category/{slug?}', 'ShopController@getCategoryItems');

    Route::get('cart', 'ShopController@getCart');
    Route::get('checkout', 'ShopController@checkout');

    Route::get('profile', function () {
        return view('pages.profile');
    });

    Route::post('profile','Auth\AuthController@update')->name('update_member_profile');
    Route::get('statement', 'OrderController@statement');
    Route::get('orders', 'OrderController@index');
    Route::get('order/{id}', 'OrderController@getOrderItems');
    Route::get('ordercomplete/{id}', 'OrderController@orderComplete')->name('ordercomplete');

    //Add to cart
    Route::post('add_to_cart', 'ShopController@postToCart')->name('add_to_cart');

    //Update Cart
    Route::post('update_cart', 'ShopController@updateCart');

    Route::post('update_order_address/{id}', 'OrderController@updateorderaddress');
    Route::post('add_order_address', 'OrderController@addorderaddress');

});



Route::auth();


