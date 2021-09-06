<?php
use Illuminate\Http\Request;

//Route::get('company', 'CompanyController@index');
//Route::post('company', 'CompanyController@store');
//Route::post('company/create', 'CompanyController@storeapi');

Route::get('get_product_category', 'ProductsController@getCategories');
Route::post('get_product_category_content/{id}', 'ProductsController@getCategoryContent');
Route::post('get_product_details', 'ProductsController@getProductDetails');

Route::post('get_delivery_cost', 'ProductsController@getDeliveryCost');
Route::post('get_delivery_price', 'ShopController@getdeliveryprice');

Route::post('add_to_cart', 'ShopController@postToCart');
Route::post('update_cart', 'ShopController@updateCart');
Route::post('delete_cart_item', 'ShopController@destroyCart');
Route::post('get_item', 'ShopController@getitemdetail');
Route::post('load_cites', 'ShopController@loadcities');
Route::post('redeem_cart', 'ShopController@redeemcart');

Route::post('add_wishlist_item', 'WishlistController@create_wishlist');
Route::post('delete_wishlist_item', 'WishlistController@delete_wishlist_item');

Route::post('load_more_catalogue_items', 'ShopController@loadMoreItems');
Route::post('sort_catalogue_items', 'ShopController@sortItems');
Route::post('sort_filter_catalogue_items', 'ShopController@sort_filterItems');
Route::post('sort_catalogue_search_items', 'ShopController@sortSearchItems');
Route::post('filter_catalogue_search_items', 'ShopController@filterSearchItems');
Route::post('sort_catalogue_items_delivery', 'ShopController@filterItems');

Route::post('sort_experience_items', 'ExperienceController@sortItems');
Route::post('sort_experience_items_delivery', 'ExperienceController@filterItems');
Route::get('load_more_experience_items', 'ExperienceController@loadMoreItems');

Route::post('load_more_cinema_items', 'CinemaController@loadMoreItems');

Route::get('airports/{search}', 'FlightController@getairports');

Route::post('get_order', 'OrderController@getOrderId');
Route::post('add_order_address', 'OrderController@addorderaddress');
Route::get('get_order_address/{id}', 'OrderController@getOrderAddress');
Route::post('update_order_address/{id}', 'OrderController@updateorderaddress');
Route::post('delete_order_address/{id}', 'OrderController@deleteorderaddress');

Route::post('discountoffer', 'DiscountController@get_discount_offer');
Route::get('discountstate/{state_id}', 'DiscountController@state_partner');
Route::get('discountstate', 'DiscountController@all_state_partner');

Route::post('odiscountoffer', 'OutdiscountController@get_discount_offer');
Route::get('odiscountstate/{state_id}', 'OutdiscountController@state_partner');
Route::get('odiscountstate', 'OutdiscountController@all_state_partner');


Route::get('appcurrencyinternal', 'CompanyController@currency');

Route::get('getcities/{id}', 'ExperienceController@getCities');

Route::post('redeem_uber', 'VouchersController@uberRedeem');
Route::post('redeem_bill', 'BillsController@redeemBill');
Route::post('validate_code', 'BillsController@validateCode');

Route::post('meals/redeem', 'MealsController@redeemMeals');
Route::post('meals/postcart', 'MealsController@postToCart');

Route::post('redeem_event', 'EventsController@redeem');
Route::post('checkout_experience', 'ExperienceController@redeemExperience');
Route::post('redeem_movie', 'CinemaController@redeem');
Route::get('food/state/cities/{id}', 'FoodController@getStateCities');
Route::get('food/states', 'FoodController@getStates');
Route::get('food/restaurants/featured', 'FoodController@getFeaturedRestaurants');
Route::get('food/restaurants/{id}', 'FoodController@getRestaurantsByLocation');
Route::get('food/restaurant/{id}/food', 'FoodController@getFoodByRestaurant');
Route::post('food/price', 'FoodController@confirmPrice');
Route::post('food/redeem', 'FoodController@redeem');

//External APIs
/**
 * @param Request $request
 * @return bool
 */

//Get Clients with their Companies

//Route::group(['middleware' => 'extaccess'], function () {
//
////    Customers Area
//    Route::post('customer/list', 'ApiController@getCustomers');
//    Route::post('customer/status', 'ApiController@postCustomerStatus');
//    Route::post('member/create', 'ApiController@MemberCreate');
//    Route::post('member/create/queue', 'ApiController@QueueCreateMember');
//    Route::post('member/update', 'ApiController@MemberUpdate');
////Route::post('customer/account', 'ApiController@getCustomerAccount');
//
//    //Orders
//    Route::post('customer/order/list', 'ApiController@getCustomerOrder');
//    Route::post('customer/order', 'ApiController@getOrderItems');
//    Route::post('company/order/list', 'ApiController@getCompanyOrder');
//    Route::post('order/close', 'ApiController@closeOrder');
//
////    Transactions Area
//    Route::get('transaction/list', 'ApiController@getTransactions');
//    Route::post('customer/transaction/list', 'ApiController@customerTransactions');
//    Route::post('company/transaction/list', 'ApiController@getCompanyTransaction');
//
//
//
//    Route::post('company/create', 'ApiController@CreateCompany');
//    Route::post('company/customer/list', 'ApiController@getCompanyCustomers');
//    Route::post('company/customer/show', 'ApiController@getCompanyCustomer');
//    Route::post('company/show', 'ApiController@getCompanyData');
//
//
//    Route::post('appcurrency', 'ApiController@appCurrency');
//    Route::post('appcurrency/update', 'ApiController@updateCurrency');
//    Route::post('appcurrency/convert', 'ApiController@convertCurrency');
//    Route::post('appcurrency/delete', 'ApiController@deleteSetting');
//
//    //Accounts
//    Route::post('customer/account/credit', 'ApiController@customerCredit');
//    Route::post('customer/account/debit', 'ApiController@customerDebit');
//    Route::post('customer/account/total', 'ApiController@customerAccountTotal');
//    Route::post('customer/account/credit/total', 'ApiController@getMemberPointTotalCredit');
//    Route::post('customer/account/debit/total', 'ApiController@getMemberPointTotalDebit');
//    Route::get('customer/list/account', 'ApiController@getCustomersPlusAccount');
//});
