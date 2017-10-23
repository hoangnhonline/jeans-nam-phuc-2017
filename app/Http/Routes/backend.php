<?php
// Authentication routes...
Route::get('backend/login', ['as' => 'backend.login-form', 'uses' => 'Backend\UserController@loginForm']);
Route::post('backend/login', ['as' => 'backend.check-login', 'uses' => 'Backend\UserController@checkLogin']);
Route::get('backend/logout', ['as' => 'backend.logout', 'uses' => 'Backend\UserController@logout']);
Route::group(['namespace' => 'Backend', 'prefix' => 'backend', 'middleware' => 'isAdmin'], function()
{    
    Route::get('dashboard', ['as' => 'dashboard.index', 'uses' => "SettingsController@dashboard"]);
    Route::post('save-content', ['as' => 'save-content', 'uses' => "SettingsController@saveContent"]);
    Route::group(['prefix' => 'compare'], function () {
        Route::get('/', ['as' => 'compare.index', 'uses' => 'CompareController@index']);
    });
    Route::group(['prefix' => 'settings'], function () {
        Route::get('/', ['as' => 'settings.index', 'uses' => 'SettingsController@index']);
        Route::post('/update', ['as' => 'settings.update', 'uses' => 'SettingsController@update']);
        Route::get('/noti', ['as' => 'settings.noti', 'uses' => 'SettingsController@noti']);        
        Route::post('/storeNoti', ['as' => 'settings.store-noti', 'uses' => 'SettingsController@storeNoti']);
    });
    Route::group(['prefix' => 'report'], function () {
        Route::get('/', ['as' => 'report.index', 'uses' => 'ReportController@index']);     
        Route::post('/search-price-other-site', ['as' => 'crawler.search-price-other-site', 'uses' => 'CompareController@search']);
    });
    Route::group(['prefix' => 'thong-so'], function () {
        Route::get('/', ['as' => 'thong-so.index', 'uses' => 'ThongSoController@index']);
        Route::get('/create', ['as' => 'thong-so.create', 'uses' => 'ThongSoController@create']);
        Route::post('/store', ['as' => 'thong-so.store', 'uses' => 'ThongSoController@store']);
        Route::get('{id}/edit',   ['as' => 'thong-so.edit', 'uses' => 'ThongSoController@edit']);       
        Route::get('{id}/destroy', ['as' => 'thong-so.destroy', 'uses' => 'ThongSoController@destroy']);
        Route::post('/update', ['as' => 'thong-so.update', 'uses' => 'ThongSoController@update']);
    });
    Route::group(['prefix' => 'menu'], function () {
        Route::get('/', ['as' => 'menu.index', 'uses' => 'MenuController@index']);
        Route::get('/create', ['as' => 'menu.create', 'uses' => 'MenuController@create']);
        Route::post('/store', ['as' => 'menu.store', 'uses' => 'MenuController@store']);
        Route::post('/store-order', ['as' => 'menu.store-order', 'uses' => 'MenuController@storeOrder']);
        Route::get('{id}/edit',   ['as' => 'menu.edit', 'uses' => 'MenuController@edit']); 
         Route::get('load-create',   ['as' => 'menu.load-create', 'uses' => 'MenuController@loadCreate']);       
        Route::get('{id}/destroy', ['as' => 'menu.destroy', 'uses' => 'MenuController@destroy']);
    });
    Route::group(['prefix' => 'bao-gia'], function () {
        Route::get('/', ['as' => 'bao-gia.index', 'uses' => 'BaoGiaController@index']);
        Route::get('/create', ['as' => 'bao-gia.create', 'uses' => 'BaoGiaController@create']);
        Route::post('/store', ['as' => 'bao-gia.store', 'uses' => 'BaoGiaController@store']);      
        Route::get('{id}/edit',   ['as' => 'bao-gia.edit', 'uses' => 'BaoGiaController@edit']);       
        Route::get('{id}/destroy', ['as' => 'bao-gia.destroy', 'uses' => 'BaoGiaController@destroy']);
    });
    Route::group(['prefix' => 'cate-type'], function () {
        Route::get('/', ['as' => 'cate-type.index', 'uses' => 'CateTypeController@index']);
        Route::get('/create', ['as' => 'cate-type.create', 'uses' => 'CateTypeController@create']);
        Route::post('/store', ['as' => 'cate-type.store', 'uses' => 'CateTypeController@store']);
        Route::get('{id}/edit',   ['as' => 'cate-type.edit', 'uses' => 'CateTypeController@edit']);
        Route::post('/update', ['as' => 'cate-type.update', 'uses' => 'CateTypeController@update']);
        Route::get('{id}/destroy', ['as' => 'cate-type.destroy', 'uses' => 'CateTypeController@destroy']);
    });
    Route::group(['prefix' => 'member'], function () {
        Route::get('/', ['as' => 'member.index', 'uses' => 'MemberController@index']);
        Route::get('/create', ['as' => 'member.create', 'uses' => 'MemberController@create']);
        Route::post('/store', ['as' => 'member.store', 'uses' => 'MemberController@store']);
        Route::get('{id}/edit',   ['as' => 'member.edit', 'uses' => 'MemberController@edit']);
        Route::post('/update', ['as' => 'member.update', 'uses' => 'MemberController@update']);
        Route::get('{id}/destroy', ['as' => 'member.destroy', 'uses' => 'MemberController@destroy']);
    });
    Route::group(['prefix' => 'work-group'], function () {
        Route::get('/', ['as' => 'work-group.index', 'uses' => 'WorkGroupController@index']);
        Route::get('/create', ['as' => 'work-group.create', 'uses' => 'WorkGroupController@create']);
        Route::post('/store', ['as' => 'work-group.store', 'uses' => 'WorkGroupController@store']);
        Route::get('{id}/edit',   ['as' => 'work-group.edit', 'uses' => 'WorkGroupController@edit']);
        Route::post('/update', ['as' => 'work-group.update', 'uses' => 'WorkGroupController@update']);
        Route::get('{id}/destroy', ['as' => 'work-group.destroy', 'uses' => 'WorkGroupController@destroy']);
    });
    Route::group(['prefix' => 'district'], function () {
        Route::get('/', ['as' => 'district.index', 'uses' => 'DistrictController@index']);
        Route::get('/create', ['as' => 'district.create', 'uses' => 'DistrictController@create']);
        Route::post('/store', ['as' => 'district.store', 'uses' => 'DistrictController@store']);
        Route::get('{id}/edit',   ['as' => 'district.edit', 'uses' => 'DistrictController@edit']);
        Route::post('/update', ['as' => 'district.update', 'uses' => 'DistrictController@update']);
        Route::get('{id}/destroy', ['as' => 'district.destroy', 'uses' => 'DistrictController@destroy']);
    });
    
    Route::group(['prefix' => 'cart-product'], function () {
        Route::get('/', ['as' => 'cart-product.index', 'uses' => 'CartProductController@index']);
        Route::get('/create', ['as' => 'cart-product.create', 'uses' => 'CartProductController@create']);
        Route::post('/store', ['as' => 'cart-product.store', 'uses' => 'CartProductController@store']);
        Route::get('{id}/edit',   ['as' => 'cart-product.edit', 'uses' => 'CartProductController@edit']);

        Route::post('/update', ['as' => 'cart-product.update', 'uses' => 'CartProductController@update']);
        Route::get('{id}/destroy', ['as' => 'cart-product.destroy', 'uses' => 'CartProductController@destroy']);
    });
    Route::group(['prefix' => 'user-work'], function () {
        Route::get('/', ['as' => 'user-work.index', 'uses' => 'UserWorkController@index']);
        Route::get('/create', ['as' => 'user-work.create', 'uses' => 'UserWorkController@create']);
        Route::post('/store', ['as' => 'user-work.store', 'uses' => 'UserWorkController@store']);
        Route::get('{id}/edit',   ['as' => 'user-work.edit', 'uses' => 'UserWorkController@edit']);
        Route::post('/update', ['as' => 'user-work.update', 'uses' => 'UserWorkController@update']);
        Route::get('{id}/destroy', ['as' => 'user-work.destroy', 'uses' => 'UserWorkController@destroy']);
    });
    Route::group(['prefix' => 'pages'], function () {
        Route::get('/', ['as' => 'pages.index', 'uses' => 'PagesController@index']);
        Route::get('/create', ['as' => 'pages.create', 'uses' => 'PagesController@create']);
        Route::post('/store', ['as' => 'pages.store', 'uses' => 'PagesController@store']);
        Route::get('{id}/edit',   ['as' => 'pages.edit', 'uses' => 'PagesController@edit']);
        Route::post('/update', ['as' => 'pages.update', 'uses' => 'PagesController@update']);
        Route::get('{id}/destroy', ['as' => 'pages.destroy', 'uses' => 'PagesController@destroy']);
    });
    Route::group(['prefix' => 'custom-link'], function () {
        Route::get('/', ['as' => 'custom-link.index', 'uses' => 'CustomLinkController@index']);
        Route::get('/create', ['as' => 'custom-link.create', 'uses' => 'CustomLinkController@create']);
        Route::post('/store', ['as' => 'custom-link.store', 'uses' => 'CustomLinkController@store']);
        Route::get('{id}/edit',   ['as' => 'custom-link.edit', 'uses' => 'CustomLinkController@edit']);
        Route::post('/update', ['as' => 'custom-link.update', 'uses' => 'CustomLinkController@update']);
        Route::get('{id}/destroy', ['as' => 'custom-link.destroy', 'uses' => 'CustomLinkController@destroy']);
    });
    Route::group(['prefix' => 'color'], function () {
        Route::get('/', ['as' => 'color.index', 'uses' => 'ColorController@index']);
        Route::get('/create', ['as' => 'color.create', 'uses' => 'ColorController@create']);
        Route::post('/store', ['as' => 'color.store', 'uses' => 'ColorController@store']);
        Route::get('{id}/edit',   ['as' => 'color.edit', 'uses' => 'ColorController@edit']);
        Route::post('/update', ['as' => 'color.update', 'uses' => 'ColorController@update']);
        Route::get('{id}/destroy', ['as' => 'color.destroy', 'uses' => 'ColorController@destroy']);
    });
    Route::group(['prefix' => 'customernoti'], function () {
        Route::get('/', ['as' => 'customernoti.index', 'uses' => 'CustomerNotificationController@index']);
        Route::get('/create', ['as' => 'customernoti.create', 'uses' => 'CustomerNotificationController@create']);
        Route::post('/store', ['as' => 'customernoti.store', 'uses' => 'CustomerNotificationController@store']);
        Route::get('{id}/edit',   ['as' => 'customernoti.edit', 'uses' => 'CustomerNotificationController@edit']);
        Route::post('/update', ['as' => 'customernoti.update', 'uses' => 'CustomerNotificationController@update']);
        Route::get('{id}/destroy', ['as' => 'customernoti.destroy', 'uses' => 'CustomerNotificationController@destroy']);
    });
    Route::group(['prefix' => 'info-seo'], function () {
        Route::get('/', ['as' => 'info-seo.index', 'uses' => 'InfoSeoController@index']);
        Route::get('/create', ['as' => 'info-seo.create', 'uses' => 'InfoSeoController@create']);
        Route::post('/store', ['as' => 'info-seo.store', 'uses' => 'InfoSeoController@store']);
        Route::get('{id}/edit',   ['as' => 'info-seo.edit', 'uses' => 'InfoSeoController@edit']);
        Route::post('/update', ['as' => 'info-seo.update', 'uses' => 'InfoSeoController@update']);
        Route::get('{id}/destroy', ['as' => 'info-seo.destroy', 'uses' => 'InfoSeoController@destroy']);
    });
    Route::group(['prefix' => 'newsletter'], function () {
        Route::get('/', ['as' => 'newsletter.index', 'uses' => 'NewsletterController@index']);
        Route::post('/store', ['as' => 'newsletter.store', 'uses' => 'NewsletterController@store']);
        Route::get('{id}/edit',   ['as' => 'newsletter.edit', 'uses' => 'NewsletterController@edit']);
        Route::get('/export',   ['as' => 'newsletter.export', 'uses' => 'NewsletterController@download']);
        Route::post('/update', ['as' => 'newsletter.update', 'uses' => 'NewsletterController@update']);
        Route::get('{id}/destroy', ['as' => 'newsletter.destroy', 'uses' => 'NewsletterController@destroy']);
    });
    Route::group(['prefix' => 'customer'], function () {
        Route::get('/', ['as' => 'customer.index', 'uses' => 'CustomerController@index']);
        Route::post('/store', ['as' => 'customer.store', 'uses' => 'CustomerController@store']);
        Route::get('{id}/edit',   ['as' => 'customer.edit', 'uses' => 'CustomerController@edit']);
        Route::get('/export',   ['as' => 'customer.export', 'uses' => 'CustomerController@download']);
        Route::post('/update', ['as' => 'customer.update', 'uses' => 'CustomerController@update']);
        Route::get('{id}/destroy', ['as' => 'customer.destroy', 'uses' => 'CustomerController@destroy']);
    });
    Route::group(['prefix' => 'contact'], function () {
        Route::get('/', ['as' => 'contact.index', 'uses' => 'ContactController@index']);
        Route::post('/store', ['as' => 'contact.store', 'uses' => 'ContactController@store']);
        Route::get('{id}/edit',   ['as' => 'contact.edit', 'uses' => 'ContactController@edit']);
        Route::get('/export',   ['as' => 'contact.export', 'uses' => 'ContactController@download']);
        Route::post('/update', ['as' => 'contact.update', 'uses' => 'ContactController@update']);
        Route::get('{id}/destroy', ['as' => 'contact.destroy', 'uses' => 'ContactController@destroy']);
    });
    
    Route::group(['prefix' => 'cate-parent'], function () {
        Route::get('/', ['as' => 'cate-parent.index', 'uses' => 'CateParentController@index']);
        Route::get('/create', ['as' => 'cate-parent.create', 'uses' => 'CateParentController@create']);
        Route::get('/thuoc-tinh', ['as' => 'cate-parent.thuoc-tinh', 'uses' => 'CateParentController@thuocTinh']);
        Route::get('/edit-thuoc-tinh', ['as' => 'cate-parent.edit-thuoc-tinh', 'uses' => 'CateParentController@editThuocTinh']);
        Route::get('/list-thuoc-tinh', ['as' => 'cate-parent.list-thuoc-tinh', 'uses' => 'CateParentController@listThuocTinh']);
        Route::post('/store-thuoc-tinh', ['as' => 'cate-parent.store-thuoc-tinh', 'uses' => 'CateParentController@storeThuocTinh']);
        Route::post('/update-thuoc-tinh', ['as' => 'cate-parent.update-thuoc-tinh', 'uses' => 'CateParentController@updateThuocTinh']);
        Route::post('/store', ['as' => 'cate-parent.store', 'uses' => 'CateParentController@store']);
        Route::get('{id}/edit',   ['as' => 'cate-parent.edit', 'uses' => 'CateParentController@edit']);
        Route::post('/update', ['as' => 'cate-parent.update', 'uses' => 'CateParentController@update']);
        Route::get('{id}/destroy', ['as' => 'cate-parent.destroy', 'uses' => 'CateParentController@destroy']);
        Route::get('{id}/destroy-thuoc-tinh', ['as' => 'cate-parent.destroyThuocTinh', 'uses' => 'CateParentController@destroyThuocTinh']);
    });
   
    Route::group(['prefix' => 'thong-so'], function () {
        Route::get('/', ['as' => 'thong-so.index', 'uses' => 'ThongSoController@index']);
        Route::get('/create', ['as' => 'thong-so.create', 'uses' => 'ThongSoController@create']);
        Route::post('/store', ['as' => 'thong-so.store', 'uses' => 'ThongSoController@store']);

        Route::get('{id}/edit',   ['as' => 'thong-so.edit', 'uses' => 'ThongSoController@edit']);
        Route::post('/update', ['as' => 'thong-so.update', 'uses' => 'ThongSoController@update']);
        Route::get('{id}/destroy', ['as' => 'thong-so.destroy', 'uses' => 'ThongSoController@destroy']);
       
    });
    
    Route::group(['prefix' => 'cate'], function () {
        Route::get('/', ['as' => 'cate.index', 'uses' => 'CateController@index']);
        Route::get('/create/', ['as' => 'cate.create', 'uses' => 'CateController@create']);
        Route::post('/store', ['as' => 'cate.store', 'uses' => 'CateController@store']);
        Route::get('{id}/edit',   ['as' => 'cate.edit', 'uses' => 'CateController@edit']);
        Route::post('/update', ['as' => 'cate.update', 'uses' => 'CateController@update']);
        Route::get('{id}/destroy', ['as' => 'cate.destroy', 'uses' => 'CateController@destroy']);
    });
    Route::group(['prefix' => 'banner'], function () {
        Route::get('/', ['as' => 'banner.index', 'uses' => 'BannerController@index']);
        Route::get('/create/', ['as' => 'banner.create', 'uses' => 'BannerController@create']);
        Route::get('/list', ['as' => 'banner.list', 'uses' => 'BannerController@lists']);
        Route::post('/store', ['as' => 'banner.store', 'uses' => 'BannerController@store']);
        Route::get('/edit',   ['as' => 'banner.edit', 'uses' => 'BannerController@edit']);
        Route::post('/update', ['as' => 'banner.update', 'uses' => 'BannerController@update']);
        Route::get('{id}/destroy', ['as' => 'banner.destroy', 'uses' => 'BannerController@destroy']);
    });
    Route::group(['prefix' => 'product'], function () {
        Route::get('/', ['as' => 'product.index', 'uses' => 'ProductController@index']); 
        Route::get('/kygui', ['as' => 'product.kygui', 'uses' => 'ProductController@kygui']);        
        Route::get('/ajax-get-detail-product', ['as' => 'ajax-get-detail-product', 'uses' => 'ProductController@ajaxDetail']);        
        Route::get('/create/', ['as' => 'product.create', 'uses' => 'ProductController@create']);        
        Route::post('/store', ['as' => 'product.store', 'uses' => 'ProductController@store']);        
        Route::post('/store-image', ['as' => 'product.store-image', 'uses' => 'ProductController@storeImage']);        
        Route::get('{id}/edit',   ['as' => 'product.edit', 'uses' => 'ProductController@edit']);
        Route::post('/update', ['as' => 'product.update', 'uses' => 'ProductController@update']);       
        Route::post('/save-order-hot', ['as' => 'product.save-order-hot', 'uses' => 'ProductController@saveOrderHot']);       
        Route::get('{id}/destroy', ['as' => 'product.destroy', 'uses' => 'ProductController@destroy']);
        Route::get('/ajax-get-tien-ich', ['as' => 'product.ajax-get-tien-ich', 'uses' => 'ProductController@ajaxGetTienIch']);
        Route::get('image/{product_id}/{color_id}',   ['as' => 'product.image', 'uses' => 'ProductController@imageOfColor']);
        Route::get('/remove-img', ['as' => 'product.remove-img', 'uses' => 'ProductController@deleteImg']);  
        
    });
    Route::group(['prefix' => 'inventory'], function () {
        Route::get('/', ['as' => 'inventory.index', 'uses' => 'InventoryController@index']);
        Route::post('/store', ['as' => 'inventory.store', 'uses' => 'InventoryController@store']);        
        Route::get('{id}/edit',   ['as' => 'inventory.edit', 'uses' => 'InventoryController@edit']);
        Route::get('/export',   ['as' => 'inventory-export', 'uses' => 'InventoryController@export']);
        Route::post('/update', ['as' => 'inventory.update', 'uses' => 'InventoryController@update']);       
        Route::get('{id}/destroy', ['as' => 'inventory.destroy', 'uses' => 'InventoryController@destroy']);
        Route::get('/remove-img', ['as' => 'inventory.remove-img', 'uses' => 'InventoryController@deleteImg']);
    });
     Route::group(['prefix' => 'cate-parent'], function () {
        Route::get('/', ['as' => 'cate-parent.index', 'uses' => 'CateParentController@index']);
        Route::get('/create', ['as' => 'cate-parent.create', 'uses' => 'CateParentController@create']);
        Route::get('/thuoc-tinh', ['as' => 'cate-parent.thuoc-tinh', 'uses' => 'CateParentController@thuocTinh']);
        Route::get('/edit-thuoc-tinh', ['as' => 'cate-parent.edit-thuoc-tinh', 'uses' => 'CateParentController@editThuocTinh']);
        Route::get('/list-thuoc-tinh', ['as' => 'cate-parent.list-thuoc-tinh', 'uses' => 'CateParentController@listThuocTinh']);
        Route::post('/store-thuoc-tinh', ['as' => 'cate-parent.store-thuoc-tinh', 'uses' => 'CateParentController@storeThuocTinh']);
        Route::post('/update-thuoc-tinh', ['as' => 'cate-parent.update-thuoc-tinh', 'uses' => 'CateParentController@updateThuocTinh']);
        Route::post('/store', ['as' => 'cate-parent.store', 'uses' => 'CateParentController@store']);
        Route::get('{id}/edit',   ['as' => 'cate-parent.edit', 'uses' => 'CateParentController@edit']);
        Route::post('/update', ['as' => 'cate-parent.update', 'uses' => 'CateParentController@update']);
        Route::get('{id}/destroy', ['as' => 'cate-parent.destroy', 'uses' => 'CateParentController@destroy']);
        Route::get('{id}/destroy-thuoc-tinh', ['as' => 'cate-parent.destroyThuocTinh', 'uses' => 'CateParentController@destroyThuocTinh']);
    });
      Route::group(['prefix' => 'order'], function () {
        Route::get('/', ['as' => 'orders.index', 'uses' => 'OrderController@index']);
        Route::post('/update', ['as' => 'orders.update', 'uses' => 'OrderController@update']);
        Route::get('/{order_id}/chi-tiet', ['as' => 'order.detail', 'uses' => 'OrderController@orderDetail']);
        Route::post('/delete-order-detail', ['as' => 'order.detail.delete', 'uses' => 'OrderController@orderDetailDelete']);
    });
       Route::group(['prefix' => 'size'], function () {
        Route::get('/', ['as' => 'size.index', 'uses' => 'SizeController@index']);
        Route::get('/create', ['as' => 'size.create', 'uses' => 'SizeController@create']);
        Route::post('/store', ['as' => 'size.store', 'uses' => 'SizeController@store']);
        Route::get('{id}/edit',   ['as' => 'size.edit', 'uses' => 'SizeController@edit']);
        Route::post('/update', ['as' => 'size.update', 'uses' => 'SizeController@update']);
        Route::get('{id}/destroy', ['as' => 'size.destroy', 'uses' => 'SizeController@destroy']);
    });
     Route::post('/tmp-upload', ['as' => 'image.tmp-upload', 'uses' => 'UploadController@tmpUpload']);
    Route::post('/tmp-upload-multiple', ['as' => 'image.tmp-upload-multiple', 'uses' => 'UploadController@tmpUploadMultiple']);    
    Route::post('/change-value', ['as' => 'change-value', 'uses' => 'GeneralController@changeValue']);
    Route::post('/cap-nhat-thu-tu', ['as' => 'cap-nhat-thu-tu', 'uses' => 'GeneralController@updateOrderList']);        
    Route::post('/update-order', ['as' => 'update-order', 'uses' => 'GeneralController@updateOrder']);
    Route::post('/ck-upload', ['as' => 'ck-upload', 'uses' => 'UploadController@ckUpload']);
    Route::post('/get-slug', ['as' => 'get-slug', 'uses' => 'GeneralController@getSlug']);    

     Route::group(['prefix' => 'articles-cate'], function () {
        Route::get('/', ['as' => 'articles-cate.index', 'uses' => 'ArticlesCateController@index']);
        Route::get('/create', ['as' => 'articles-cate.create', 'uses' => 'ArticlesCateController@create']);
        Route::post('/store', ['as' => 'articles-cate.store', 'uses' => 'ArticlesCateController@store']);
        Route::get('{id}/edit',   ['as' => 'articles-cate.edit', 'uses' => 'ArticlesCateController@edit']);
        Route::post('/update', ['as' => 'articles-cate.update', 'uses' => 'ArticlesCateController@update']);
        Route::get('{id}/destroy', ['as' => 'articles-cate.destroy', 'uses' => 'ArticlesCateController@destroy']);
    });
    Route::group(['prefix' => 'tag'], function () {
        Route::get('/', ['as' => 'tag.index', 'uses' => 'TagController@index']);
        Route::get('/create', ['as' => 'tag.create', 'uses' => 'TagController@create']);
        Route::post('/store', ['as' => 'tag.store', 'uses' => 'TagController@store']);
        Route::post('/ajaxSave', ['as' => 'tag.ajax-save', 'uses' => 'TagController@ajaxSave']);  
        Route::get('/ajax-list', ['as' => 'tag.ajax-list', 'uses' => 'TagController@ajaxList']);      
        Route::get('{id}/edit',   ['as' => 'tag.edit', 'uses' => 'TagController@edit']);
        Route::post('/update', ['as' => 'tag.update', 'uses' => 'TagController@update']);
        Route::get('{id}/destroy', ['as' => 'tag.destroy', 'uses' => 'TagController@destroy']);
    });
    Route::group(['prefix' => 'account'], function () {
        Route::get('/', ['as' => 'account.index', 'uses' => 'AccountController@index']);
        Route::get('/change-password', ['as' => 'account.change-pass', 'uses' => 'AccountController@changePass']);
        Route::post('/store-password', ['as' => 'account.store-pass', 'uses' => 'AccountController@storeNewPass']);
        Route::get('/update-status/{status}/{id}', ['as' => 'account.update-status', 'uses' => 'AccountController@updateStatus']);
        Route::get('/create', ['as' => 'account.create', 'uses' => 'AccountController@create']);
        Route::post('/store', ['as' => 'account.store', 'uses' => 'AccountController@store']);
        Route::get('{id}/edit',   ['as' => 'account.edit', 'uses' => 'AccountController@edit']);
        Route::post('/update', ['as' => 'account.update', 'uses' => 'AccountController@update']);
        Route::get('{id}/destroy', ['as' => 'account.destroy', 'uses' => 'AccountController@destroy']);
    });
    Route::group(['prefix' => 'articles'], function () {
        Route::get('/', ['as' => 'articles.index', 'uses' => 'ArticlesController@index']);
        Route::get('/create', ['as' => 'articles.create', 'uses' => 'ArticlesController@create']);
        Route::post('/store', ['as' => 'articles.store', 'uses' => 'ArticlesController@store']);
        Route::get('{id}/edit',   ['as' => 'articles.edit', 'uses' => 'ArticlesController@edit']);
        Route::post('/update', ['as' => 'articles.update', 'uses' => 'ArticlesController@update']);
        Route::get('{id}/destroy', ['as' => 'articles.destroy', 'uses' => 'ArticlesController@destroy']);
    });    
    Route::group(['prefix' => 'services'], function () {
        Route::get('/', ['as' => 'services.index', 'uses' => 'ServicesController@index']);
        Route::get('/create', ['as' => 'services.create', 'uses' => 'ServicesController@create']);
        Route::post('/store', ['as' => 'services.store', 'uses' => 'ServicesController@store']);
        Route::get('{id}/edit',   ['as' => 'services.edit', 'uses' => 'ServicesController@edit']);
        Route::post('/update', ['as' => 'services.update', 'uses' => 'ServicesController@update']);
        Route::get('{id}/destroy', ['as' => 'services.destroy', 'uses' => 'ServicesController@destroy']);
    });   
});