<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::get('/test', function() {
    return view('frontend.email.thanks');
});
Route::group(['prefix' => 'social-auth'], function () {
    Route::group(['prefix' => 'facebook'], function () {
        Route::get('redirect/', ['as' => 'fb-auth', 'uses' => 'SocialAuthController@redirect']);
        Route::get('callback/', ['as' => 'fb-callback', 'uses' => 'SocialAuthController@callback']);
        Route::post('fb-login', ['as' => 'ajax-login-by-fb', 'uses' => 'SocialAuthController@fbLogin']);
    });

    Route::group(['prefix' => 'google'], function () {
        Route::get('redirect/', ['as' => 'gg-auth', 'uses' => 'SocialAuthController@googleRedirect']);
        Route::get('callback/', ['as' => 'gg-callback', 'uses' => 'SocialAuthController@googleCallback']);
    });

});
Route::group(['prefix' => 'authentication'], function () {
    Route::post('check_login', ['as' => 'auth-login', 'uses' => 'AuthenticationController@checkLogin']);
    Route::post('login_ajax', ['as' =>  'auth-login-ajax', 'uses' => 'AuthenticationController@checkLoginAjax']);
    Route::get('/user-logout', ['as' => 'user-logout', 'uses' => 'AuthenticationController@logout']);
});
Route::group(['namespace' => 'Frontend'], function()
{
    Route::get('code/sang-map/seo-link', ['as' => 'seo-link', 'uses' => 'HomeController@showLink']);   

    Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);
    Route::get('/load-slider', ['as' => 'load-slider', 'uses' => 'HomeController@loadSlider']);
    Route::get('/count-message', ['as' => 'count-message', 'uses' => 'HomeController@getNoti']);
    Route::get('/chuong-trinh-khuyen-mai', ['as' => 'chuong-trinh-khuyen-mai', 'uses' => 'EventController@index']);
    Route::get('event/{slug}', ['as' => 'detail-event', 'uses' => 'EventController@detail']);
   Route::get('may-cu/{slug}', ['as' => 'old-cate', 'uses' => 'OldController@cate']);

    Route::post('/send-contact', ['as' => 'send-contact', 'uses' => 'ContactController@store']);
    Route::post('/set-service', ['as' => 'set-service', 'uses' => 'CartController@setService']);
    
    Route::get('san-pham/{slug}-{id}.html', ['as' => 'product-detail', 'uses' => 'DetailController@index']);
    Route::get('/tin-tuc/{slug}-{id}.html', ['as' => 'news-detail', 'uses' => 'HomeController@newsDetail']);
    
    Route::group(['prefix' => 'thanh-toan'], function () {
        Route::get('thong-tin-thanh-toan', ['as' => 'payment', 'uses' => 'CartController@payment']);
        Route::get('empty-cart', ['as' => 'empty-cart', 'uses' => 'CartController@deleteAll']);
        Route::get('short-cart', ['as' => 'short-cart', 'uses' => 'CartController@shortCart']);
        Route::any('shipping-step-1', ['as' => 'shipping-step-1', 'uses' => 'CartController@shippingStep1']);
        Route::get('shipping-step-2', ['as' => 'shipping-step-2', 'uses' => 'CartController@shippingStep2']);
        Route::get('shipping-step-3', ['as' => 'shipping-step-3', 'uses' => 'CartController@shippingStep3']);
        Route::post('update-product', ['as' => 'update-product', 'uses' => 'CartController@update']);
        Route::get('add-product', ['as' => 'add-product', 'uses' => 'CartController@addProduct']);
        Route::get('success', ['as' => 'success', 'uses' => 'CartController@success']);
        Route::post('save-order', ['as' => 'save-order', 'uses' => 'CartController@saveOrder']);        
        Route::post('save', ['as' => 'save-final', 'uses' => 'CartController@save']);        
    });

    Route::group(['prefix' => 'tai-khoan'], function () {
        Route::get('don-hang-cua-toi', ['as' => 'order-history', 'uses' => 'OrderController@history']);
        Route::get('thong-bao-cua-toi', ['as' => 'notification', 'uses' => 'CustomerController@notification']);
        Route::get('thong-tin-tai-khoan', ['as' => 'account-info', 'uses' => 'CustomerController@accountInfo']);
        Route::get('doi-mat-khau', ['as' => 'change-password', 'uses' => 'CustomerController@changePassword']);
        Route::post('save-new-password', ['as' => 'save-new-password', 'uses' => 'CustomerController@saveNewPassword']);
        Route::get('/chi-tiet-don-hang/{order_id}', ['as' => 'order-detail', 'uses' => 'OrderController@detail']);
        Route::post('/huy-don-hang', ['as' => 'order-cancel', 'uses' => 'OrderController@huy']);
        Route::post('/forget-password', ['as' => 'forget-password', 'uses' => 'CustomerController@forgetPassword']);
        Route::get('/reset-password/{key}', ['as' => 'reset-password', 'uses' => 'CustomerController@resetPassword']);
        Route::post('save-reset-password', ['as' => 'save-reset-password', 'uses' => 'CustomerController@saveResetPassword']);
    });
    Route::get('tag/{slug}', ['as' => 'tag', 'uses' => 'DetailController@tagDetail']);
    Route::get('tin-tuc/{slug}', ['as' => 'news-list', 'uses' => 'NewsController@newsList']);
    Route::get('{slugCateParent}/{slug}/', ['as' => 'cate', 'uses' => 'CateController@child']);
    Route::post('/dang-ki-newsletter', ['as' => 'register.newsletter', 'uses' => 'HomeController@registerNews']);
    Route::get('/cap-nhat-thong-tin', ['as' => 'cap-nhat-thong-tin', 'uses' => 'CartController@updateUserInformation']);  
     Route::get('/get-ivt-of-color', ['as' => 'get-ivt-of-color', 'uses' => 'DetailController@getIvtOfColor']);         
    
    Route::post('/search', ['as' => 'ajax-search', 'uses' => 'HomeController@ajaxSearch']);        
    Route::get('/tin-tuc/{slug}-p{id}.html', ['as' => 'news-detail', 'uses' => 'NewsController@newsDetail']);
    Route::post('/get-district', ['as' => 'get-district', 'uses' => 'DistrictController@getDistrict']);
    Route::post('/get-ward', ['as' => 'get-ward', 'uses' => 'WardController@getWard']);
    Route::post('/customer/update', ['as' => 'update-customer', 'uses' => 'CustomerController@update']);
    Route::post('/customer/register', ['as' => 'register-customer', 'uses' => 'CustomerController@register']);
    Route::post('/customer/register-ajax', ['as' => 'register-customer-ajax', 'uses' => 'CustomerController@registerAjax']);
    Route::post('/customer/checkemail', ['as' => 'checkemail-customer', 'uses' => 'CustomerController@isEmailExist']);    
    Route::get('tim-kiem.html', ['as' => 'search', 'uses' => 'HomeController@search']);
    Route::get('so-sanh.html', ['as' => 'so-sanh', 'uses' => 'CompareController@index']);
    Route::get('lien-he.html', ['as' => 'contact', 'uses' => 'HomeController@contact']);
    Route::get('may-cu-gia-re.html', ['as' => 'old-device', 'uses' => 'HomeController@oldDevice']);
    

    Route::get('{slug}', ['as' => 'cate-parent', 'uses' => 'CateController@parent']);
    Route::get('{slug}.html', ['as' => 'pages', 'uses' => 'HomeController@pages']);

});

