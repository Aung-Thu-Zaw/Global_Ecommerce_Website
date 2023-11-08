<?php

use App\Http\Controllers\Admin\AdminBrandController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminCollectionController;
use App\Http\Controllers\Admin\AdminCouponController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminDashboardNotificationController;
use App\Http\Controllers\Admin\AdminFlashSaleController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminWebControlArea\FaqCategories\AdminFaqCategoryController;
use App\Http\Controllers\Admin\AdminWebControlArea\FaqCategories\AdminFaqSubCategoryController;
use App\Http\Controllers\Admin\AdminWebControlArea\Faqs\AdminFaqController;
use App\Http\Controllers\Admin\AdminWebControlArea\SiteSettings\AdminSeoSettingController;
use App\Http\Controllers\Admin\AdminWebControlArea\SiteSettings\AdminWebsiteSettingController;
use App\Http\Controllers\Admin\AdminWebControlArea\WebsitePages\AdminPrivacyPolicyController;
use App\Http\Controllers\Admin\AdminWebControlArea\WebsitePages\AdminTermsAndConditionsController;
use App\Http\Controllers\Admin\Auth\AdminAuthController;
use App\Http\Controllers\Admin\AuthorityManagements\AdminRoleInPermissionController;
use App\Http\Controllers\Admin\AuthorityManagements\RolesAndPermissions\AdminPermissionController;
use App\Http\Controllers\Admin\AuthorityManagements\RolesAndPermissions\AdminRoleController;
use App\Http\Controllers\Admin\Banners\AdminCampaignBannerController;
use App\Http\Controllers\Admin\Banners\AdminProductBannerController;
use App\Http\Controllers\Admin\Banners\AdminSliderBannerController;
use App\Http\Controllers\Admin\BlogManagements\AdminBlogCategoryController;
use App\Http\Controllers\Admin\BlogManagements\AdminBlogCommentController;
use App\Http\Controllers\Admin\BlogManagements\AdminBlogPostController;
use App\Http\Controllers\Admin\ContactServices\Chats\AdminChatController;
use App\Http\Controllers\Admin\ContactServices\Chats\AdminChatFolderController;
use App\Http\Controllers\Admin\Dashboard\AdminSocialTrafficController;
use App\Http\Controllers\Admin\FromTheSubmitters\AdminSubscriberController;
use App\Http\Controllers\Admin\FromTheSubmitters\AdminSuggestionController;
use App\Http\Controllers\Admin\FromTheSubmitters\AdminWebsiteFeedbackController;
use App\Http\Controllers\Admin\OrderManagements\CancelOrderManage\AdminApprovedCancelOrderController;
use App\Http\Controllers\Admin\OrderManagements\CancelOrderManage\AdminRequestedCancelOrderController;
use App\Http\Controllers\Admin\OrderManagements\OrderManage\AdminConfirmedOrderController;
use App\Http\Controllers\Admin\OrderManagements\OrderManage\AdminDeliveredOrderController;
use App\Http\Controllers\Admin\OrderManagements\OrderManage\AdminPendingOrderController;
use App\Http\Controllers\Admin\OrderManagements\OrderManage\AdminProcessingOrderController;
use App\Http\Controllers\Admin\OrderManagements\OrderManage\AdminShippedOrderController;
use App\Http\Controllers\Admin\OrderManagements\ReturnOrderManage\AdminApprovedReturnOrderController;
use App\Http\Controllers\Admin\OrderManagements\ReturnOrderManage\AdminRefundedReturnOrderController;
use App\Http\Controllers\Admin\OrderManagements\ReturnOrderManage\AdminRequestedReturnOrderController;
use App\Http\Controllers\Admin\ReviewManagements\AdminProductReviewController;
use App\Http\Controllers\Admin\ReviewManagements\AdminShopReviewController;
use App\Http\Controllers\Admin\ShippingAreas\AdminCityController;
use App\Http\Controllers\Admin\ShippingAreas\AdminCountryController;
use App\Http\Controllers\Admin\ShippingAreas\AdminRegionController;
use App\Http\Controllers\Admin\ShippingAreas\AdminTownshipController;
use App\Http\Controllers\Admin\UserManagements\AdminManageController;
use App\Http\Controllers\Admin\UserManagements\AdminRegisteredAccountController;
use App\Http\Controllers\Admin\UserManagements\AdminSellerManageController;
use App\Http\Controllers\MultiImageController;
use Illuminate\Support\Facades\Route;

Route::get('/admin/login', [AdminAuthController::class, 'login'])
    ->middleware('guest')
    ->name('admin.login');

Route::middleware(['admin', 'verified', 'user.role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Dashboard Section
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Dashboard Notification
        Route::controller(AdminDashboardNotificationController::class)
            ->prefix('/notifications')
            ->name('notifications.')
            ->group(function () {
                Route::patch('/{notification_id}/read', 'reatNotification')->name('read');
                Route::patch('/read-all', 'markAllAsRead')->name('read-all');
            });

        // Dashboard Social Traffics
        Route::controller(AdminSocialTrafficController::class)
            ->prefix('/social-traffics')
            ->name('social-traffics.')
            ->group(function () {
                Route::post('/change-target', 'changeTarget')->name('change.target');
                Route::post('/{social_traffic}/increment-visitors', 'incrementActualVisitors')->name('increment.visitors');
            });

        // Admin Brands Operations
        Route::resource('brands', AdminBrandController::class)->except(['show']);
        Route::controller(AdminBrandController::class)
            ->prefix('/brands/trash')
            ->name('brands.')
            ->group(function () {
                Route::delete('/destroy/selected', 'destroySelected')->name('destroy.selected');
                Route::delete('/destroy/all', 'destroyAll')->name('destroy.all');
                Route::get('/', 'trashed')->name('trashed');
                Route::post('/{id}/restore', 'restore')->name('restore');
                Route::post('/restore/selected', 'restoreSelected')->name('restore.selected');
                Route::post('/restore/all', 'restoreAll')->name('restore.all');
                Route::delete('/{id}/force-delete', 'forceDelete')->name('force-delete');
                Route::delete('/force-delete/selected', 'forceDeleteSelected')->name('force-delete.selected');
                Route::delete('/force-delete/all', 'forceDeleteAll')->name('force-delete.all');
            });

        // Admin Collections Operations
        Route::resource('collections', AdminCollectionController::class)->except(['show']);
        Route::controller(AdminCollectionController::class)
            ->prefix('/collections/trash')
            ->name('collections.')
            ->group(function () {
                Route::delete('/destroy/selected', 'destroySelected')->name('destroy.selected');
                Route::delete('/destroy/all', 'destroyAll')->name('destroy.all');
                Route::get('/', 'trashed')->name('trashed');
                Route::post('/{id}/restore', 'restore')->name('restore');
                Route::post('/restore/selected', 'restoreSelected')->name('restore.selected');
                Route::post('/restore/all', 'restoreAll')->name('restore.all');
                Route::delete('/{id}/force-delete', 'forceDelete')->name('force-delete');
                Route::delete('/force-delete/selected', 'forceDeleteSelected')->name('force-delete.selected');
                Route::delete('/force-delete/all', 'forceDeleteAll')->name('force-delete.all');
            });

        // Admin Collections Operations
        Route::resource('categories', AdminCategoryController::class)->except(['show']);
        Route::controller(AdminCategoryController::class)
            ->prefix('/categories/trash')
            ->name('categories.')
            ->group(function () {
                Route::delete('/destroy/selected', 'destroySelected')->name('destroy.selected');
                Route::delete('/destroy/all', 'destroyAll')->name('destroy.all');
                Route::get('/', 'trashed')->name('trashed');
                Route::post('/{id}/restore', 'restore')->name('restore');
                Route::post('/restore/selected', 'restoreSelected')->name('restore.selected');
                Route::post('/restore/all', 'restoreAll')->name('restore.all');
                Route::delete('/{id}/force-delete', 'forceDelete')->name('force-delete');
                Route::delete('/force-delete/selected', 'forceDeleteSelected')->name('force-delete.selected');
                Route::delete('/force-delete/all', 'forceDeleteAll')->name('force-delete.all');
            });




        // Admin Products Section
        Route::controller(AdminProductController::class)
            ->prefix('/products')
            ->name('products.')
            ->group(function () {
                Route::get('/', 'index')
                    ->middleware('permission:product.menu')
                    ->name('index');
                Route::get('/{product}/details', 'show')
                    ->middleware('permission:product.detail')
                    ->name('show');
                Route::get('/create', 'create')
                    ->middleware('permission:product.add')
                    ->name('create');
                Route::post('/', 'store')
                    ->middleware('permission:product.add')
                    ->name('store');
                Route::get('/{product}/edit', 'edit')
                    ->middleware('permission:product.edit')
                    ->name('edit');
                Route::post('/{product}', 'update')
                    ->middleware('permission:product.edit')
                    ->name('update');
                Route::patch('/{product}/status', 'handleStatus')
                    ->middleware('permission:product.control')
                    ->name('handle.status');
                Route::delete('/{product}', 'destroy')
                    ->middleware('permission:product.delete')
                    ->name('destroy');
                Route::get('/trash', 'trash')
                    ->middleware('permission:product.trash.list')
                    ->name('trash');
                Route::post('/trash/{trash_product_id}/restore', 'restore')
                    ->middleware('permission:product.trash.restore')
                    ->name('trash.restore');
                Route::delete('/trash/{trash_product_id}/force-delete', 'forceDelete')
                    ->middleware('permission:product.trash.delete')
                    ->name('trash.force.delete');
                Route::delete('/trash/permanently-delete', 'permanentlyDelete')
                    ->middleware('permission:product.trash.delete')
                    ->name('trash.permanently.delete');
            });
        Route::delete('products/{product_id}/images/{image_id}', [MultiImageController::class, 'destroy'])->name('image.destroy');

        // Admin Coupons Section
        Route::controller(AdminCouponController::class)
            ->prefix('/coupons')
            ->name('coupons.')
            ->group(function () {
                Route::get('/', 'index')
                    ->middleware('permission:coupon.menu')
                    ->name('index');
                Route::get('/create', 'create')
                    ->middleware('permission:coupon.add')
                    ->name('create');
                Route::post('/', 'store')
                    ->middleware('permission:coupon.add')
                    ->name('store');
                Route::get('/{coupon}/edit', 'edit')
                    ->middleware('permission:coupon.edit')
                    ->name('edit');
                Route::patch('/{coupon}', 'update')
                    ->middleware('permission:coupon.edit')
                    ->name('update');
                Route::delete('/{coupon}', 'destroy')
                    ->middleware('permission:coupon.delete')
                    ->name('destroy');
                Route::get('/trash', 'trash')
                    ->middleware('permission:coupon.trash.list')
                    ->name('trash');
                Route::post('/trash/{trash_coupon_id}/restore', 'restore')
                    ->middleware('permission:coupon.trash.restore')
                    ->name('trash.restore');
                Route::delete('/trash/{trash_coupon_id}/force-delete', 'forceDelete')
                    ->middleware('permission:coupon.trash.delete')
                    ->name('trash.force.delete');
                Route::delete('/trash/permanently-delete', 'permanentlyDelete')
                    ->middleware('permission:coupon.trash.delete')
                    ->name('trash.permanently.delete');
            });

        // Admin Flash Sales Section
        Route::controller(AdminFlashSaleController::class)
            ->prefix('/flash-sales')
            ->name('flash-sales.')
            ->group(function () {
                Route::get('/edit', 'edit')
                    ->middleware('permission:flash-sale.edit')
                    ->name('edit');
                Route::patch('/{flash_sale}', 'update')
                    ->middleware('permission:flash-sale.edit')
                    ->name('update');
                Route::post('/add-product', 'addFlashSaleProduct')
                    ->middleware('permission:flash-sale.edit')
                    ->name('add-product');
                Route::delete('/{flash_sale_product_id}/remove-product', 'removeFlashSaleProduct')
                    ->middleware('permission:flash-sale.edit')
                    ->name('remove-product');
            });

        // ========== Admin Banners Section ==========

        // Admin Slider Banners Section
        Route::controller(AdminSliderBannerController::class)
            ->prefix('/slider-banners')
            ->name('slider-banners.')
            ->group(function () {
                Route::get('/', 'index')
                    ->middleware('permission:banner.menu')
                    ->name('index');
                Route::get('/create', 'create')
                    ->middleware('permission:banner.add')
                    ->name('create');
                Route::post('/', 'store')
                    ->middleware('permission:banner.add')
                    ->name('store');
                Route::get('/{slider_banner}/edit', 'edit')
                    ->middleware('permission:banner.edit')
                    ->name('edit');
                Route::post('/{slider_banner}', 'update')
                    ->middleware('permission:banner.edit')
                    ->name('update');
                Route::delete('/{slider_banner}', 'destroy')
                    ->middleware('permission:banner.delete')
                    ->name('destroy');
                Route::patch('/{slider_banner}/show', 'handleShow')
                    ->middleware('permission:banner.control')
                    ->name('show');
                Route::patch('/{slider_banner}/hide', 'handleHide')
                    ->middleware('permission:banner.control')
                    ->name('hide');
                Route::get('/trash', 'trash')
                    ->middleware('permission:banner.trash.list')
                    ->name('trash');
                Route::post('/trash/{trash_slider_banner_id}/restore', 'restore')
                    ->middleware('permission:banner.trash.restore')
                    ->name('trash.restore');
                Route::delete('/trash/{trash_slider_banner_id}/force-delete', 'forceDelete')
                    ->middleware('permission:banner.trash.delete')
                    ->name('trash.force.delete');
                Route::delete('/trash/permanently-delete', 'permanentlyDelete')
                    ->middleware('permission:banner.trash.delete')
                    ->name('trash.permanently.delete');
            });

        // Admin Product Banners Section
        Route::controller(AdminProductBannerController::class)
            ->prefix('/product-banners')
            ->name('product-banners.')
            ->group(function () {
                Route::get('/', 'index')
                    ->middleware('permission:banner.menu')
                    ->name('index');
                Route::get('/create', 'create')
                    ->middleware('permission:banner.add')
                    ->name('create');
                Route::post('/', 'store')
                    ->middleware('permission:banner.add')
                    ->name('store');
                Route::get('/{product_banner}/edit', 'edit')
                    ->middleware('permission:banner.edit')
                    ->name('edit');
                Route::post('/{product_banner}', 'update')
                    ->middleware('permission:banner.edit')
                    ->name('update');
                Route::delete('/{product_banner}', 'destroy')
                    ->middleware('permission:banner.delete')
                    ->name('destroy');
                Route::patch('/{product_banner}/show', 'handleShow')
                    ->middleware('permission:banner.control')
                    ->name('show');
                Route::patch('/{product_banner}/hide', 'handleHide')
                    ->middleware('permission:banner.control')
                    ->name('hide');
                Route::get('/trash', 'trash')
                    ->middleware('permission:banner.trash.list')
                    ->name('trash');
                Route::post('/trash/{trash_product_banner_id}/restore', 'restore')
                    ->middleware('permission:banner.trash.restore')
                    ->name('trash.restore');
                Route::delete('/trash/{trash_product_banner_id}/force-delete', 'forceDelete')
                    ->middleware('permission:banner.trash.delete')
                    ->name('trash.force.delete');
                Route::delete('/trash/permanently-delete', 'permanentlyDelete')
                    ->middleware('permission:banner.trash.delete')
                    ->name('trash.permanently.delete');
            });

        // Admin Campaign Banners Section
        Route::controller(AdminCampaignBannerController::class)
            ->prefix('/campaign-banners')
            ->name('campaign-banners.')
            ->group(function () {
                Route::get('/', 'index')
                    ->middleware('permission:banner.menu')
                    ->name('index');
                Route::get('/create', 'create')
                    ->middleware('permission:banner.add')
                    ->name('create');
                Route::post('/', 'store')
                    ->middleware('permission:banner.add')
                    ->name('store');
                Route::get('/{campaign_banner}/edit', 'edit')
                    ->middleware('permission:banner.edit')
                    ->name('edit');
                Route::post('/{campaign_banner}', 'update')
                    ->middleware('permission:banner.edit')
                    ->name('update');
                Route::delete('/{campaign_banner}', 'destroy')
                    ->middleware('permission:banner.delete')
                    ->name('destroy');
                Route::get('/trash', 'trash')
                    ->middleware('permission:banner.trash.list')
                    ->name('trash');
                Route::patch('/{campaign_banner}/show', 'handleShow')
                    ->middleware('permission:banner.control')
                    ->name('show');
                Route::patch('/{campaign_banner}/hide', 'handleHide')
                    ->middleware('permission:banner.control')
                    ->name('hide');
                Route::post('/trash/{trash_campaign_banner_id}/restore', 'restore')
                    ->middleware('permission:banner.trash.restore')
                    ->name('trash.restore');
                Route::delete('/trash/{trash_campaign_banner_id}/force-delete', 'forceDelete')
                    ->middleware('permission:banner.trash.delete')
                    ->name('trash.force.delete');
                Route::delete('/trash/permanently-delete', 'permanentlyDelete')
                    ->middleware('permission:banner.trash.delete')
                    ->name('trash.permanently.delete');
            });

        Route::controller(AdminCountryController::class)
            ->prefix('/countries')
            ->name('countries.')
            ->group(function () {
                Route::get('/', 'index')
                    ->middleware('permission:shipping-area.menu')
                    ->name('index');
                Route::get('/create', 'create')
                    ->middleware('permission:shipping-area.add')
                    ->name('create');
                Route::post('/', 'store')
                    ->middleware('permission:shipping-area.add')
                    ->name('store');
                Route::get('/{country}/edit', 'edit')
                    ->middleware('permission:shipping-area.edit')
                    ->name('edit');
                Route::patch('/{country}', 'update')
                    ->middleware('permission:shipping-area.edit')
                    ->name('update');
                Route::delete('/{country}', 'destroy')
                    ->middleware('permission:shipping-area.delete')
                    ->name('destroy');
                Route::get('/trash', 'trash')
                    ->middleware('permission:shipping-area.trash.list')
                    ->name('trash');
                Route::post('/trash/{trash_country_id}/restore', 'restore')
                    ->middleware('permission:shipping-area.trash.restore')
                    ->name('trash.restore');
                Route::delete('/trash/{trash_country_id}/force-delete', 'forceDelete')
                    ->middleware('permission:shipping-area.trash.delete')
                    ->name('trash.force.delete');
                Route::delete('/trash/permanently-delete', 'permanentlyDelete')
                    ->middleware('permission:shipping-area.trash.delete')
                    ->name('trash.permanently.delete');
            });

        Route::controller(AdminRegionController::class)
            ->prefix('/regions')
            ->name('regions.')
            ->group(function () {
                Route::get('/', 'index')
                    ->middleware('permission:shipping-area.menu')
                    ->name('index');
                Route::get('/create', 'create')
                    ->middleware('permission:shipping-area.add')
                    ->name('create');
                Route::post('/', 'store')
                    ->middleware('permission:shipping-area.add')
                    ->name('store');
                Route::get('/{region}/edit', 'edit')
                    ->middleware('permission:shipping-area.edit')
                    ->name('edit');
                Route::patch('/{region}', 'update')
                    ->middleware('permission:shipping-area.edit')
                    ->name('update');
                Route::delete('/{region}', 'destroy')
                    ->middleware('permission:shipping-area.delete')
                    ->name('destroy');
                Route::get('/trash', 'trash')
                    ->middleware('permission:shipping-area.trash.list')
                    ->name('trash');
                Route::post('/trash/{trash_region_id}/restore', 'restore')
                    ->middleware('permission:shipping-area.trash.restore')
                    ->name('trash.restore');
                Route::delete('/trash/{trash_region_id}/force-delete', 'forceDelete')
                    ->middleware('permission:shipping-area.trash.delete')
                    ->name('trash.force.delete');
                Route::delete('/trash/permanently-delete', 'permanentlyDelete')
                    ->middleware('permission:shipping-area.trash.delete')
                    ->name('trash.permanently.delete');
            });

        Route::controller(AdminCityController::class)
            ->prefix('/cities')
            ->name('cities.')
            ->group(function () {
                Route::get('/', 'index')
                    ->middleware('permission:shipping-area.menu')
                    ->name('index');
                Route::get('/create', 'create')
                    ->middleware('permission:shipping-area.add')
                    ->name('create');
                Route::post('/', 'store')
                    ->middleware('permission:shipping-area.add')
                    ->name('store');
                Route::get('/{city}/edit', 'edit')
                    ->middleware('permission:shipping-area.edit')
                    ->name('edit');
                Route::patch('/{city}', 'update')
                    ->middleware('permission:shipping-area.edit')
                    ->name('update');
                Route::delete('/{city}', 'destroy')
                    ->middleware('permission:shipping-area.delete')
                    ->name('destroy');
                Route::get('/trash', 'trash')
                    ->middleware('permission:shipping-area.trash.list')
                    ->name('trash');
                Route::post('/trash/{trash_city_id}/restore', 'restore')
                    ->middleware('permission:shipping-area.trash.restore')
                    ->name('trash.restore');
                Route::delete('/trash/{trash_city_id}/force-delete', 'forceDelete')
                    ->middleware('permission:shipping-area.trash.delete')
                    ->name('trash.force.delete');
                Route::delete('/trash/permanently-delete', 'permanentlyDelete')
                    ->middleware('permission:shipping-area.trash.delete')
                    ->name('trash.permanently.delete');
            });

        Route::controller(AdminTownshipController::class)
            ->prefix('/townships')
            ->name('townships.')
            ->group(function () {
                Route::get('/', 'index')
                    ->middleware('permission:shipping-area.menu')
                    ->name('index');
                Route::get('/create', 'create')
                    ->middleware('permission:shipping-area.add')
                    ->name('create');
                Route::post('/', 'store')
                    ->middleware('permission:shipping-area.add')
                    ->name('store');
                Route::get('/{township}/edit', 'edit')
                    ->middleware('permission:shipping-area.edit')
                    ->name('edit');
                Route::patch('/{township}', 'update')
                    ->middleware('permission:shipping-area.edit')
                    ->name('update');
                Route::delete('/{township}', 'destroy')
                    ->middleware('permission:shipping-area.delete')
                    ->name('destroy');
                Route::get('/trash', 'trash')
                    ->middleware('permission:shipping-area.trash.list')
                    ->name('trash');
                Route::post('/trash/{trash_township_id}/restore', 'restore')
                    ->middleware('permission:shipping-area.trash.restore')
                    ->name('trash.restore');
                Route::delete('/trash/{trash_township_id}/force-delete', 'forceDelete')
                    ->middleware('permission:shipping-area.trash.delete')
                    ->name('trash.force.delete');
                Route::delete('/trash/permanently-delete', 'permanentlyDelete')
                    ->middleware('permission:shipping-area.trash.delete')
                    ->name('trash.permanently.delete');
            });

        // ******************** Admin Dashboard Order Managements ********************

        // ========== Admin Order Manage Section ==========

        // Admin Pending Orders Section
        Route::controller(AdminPendingOrderController::class)
            ->prefix('/order-manage/pending-orders')
            ->name('orders.pending.')
            ->group(function () {
                Route::get('/', 'index')
                    ->middleware('permission:order-manage.menu')
                    ->name('index');
                Route::get('/{order}', 'show')
                    ->middleware('permission:order-manage.detail')
                    ->name('show');
                Route::patch('/{order}', 'update')
                    ->middleware('permission:order-manage.control')
                    ->name('update');
            });

        // Admin Confirmed Orders Section
        Route::controller(AdminConfirmedOrderController::class)
            ->prefix('/order-manage/confirmed-orders')
            ->name('orders.confirmed.')
            ->group(function () {
                Route::get('/', 'index')
                    ->middleware('permission:order-manage.menu')
                    ->name('index');
                Route::get('/{order}', 'show')
                    ->middleware('permission:order-manage.detail')
                    ->name('show');
                Route::patch('/{order}', 'update')
                    ->middleware('permission:order-manage.control')
                    ->name('update');
            });

        // Admin Processing Orders Section
        Route::controller(AdminProcessingOrderController::class)
            ->prefix('/order-manage/processing-orders')
            ->name('orders.processing.')
            ->group(function () {
                Route::get('/', 'index')
                    ->middleware('permission:order-manage.menu')
                    ->name('index');
                Route::get('/{order}', 'show')
                    ->middleware('permission:order-manage.detail')
                    ->name('show');
                Route::patch('/{order}', 'update')
                    ->middleware('permission:order-manage.control')
                    ->name('update');
            });

        // Admin Shipped Orders Section
        Route::controller(AdminShippedOrderController::class)
            ->prefix('/order-manage/shipped-orders')
            ->name('orders.shipped.')
            ->group(function () {
                Route::get('/', 'index')
                    ->middleware('permission:order-manage.menu')
                    ->name('index');
                Route::get('/{order}', 'show')
                    ->middleware('permission:order-manage.detail')
                    ->name('show');
                Route::patch('/{order}', 'update')
                    ->middleware('permission:order-manage.control')
                    ->name('update');
            });

        // Admin Delivered Orders Section
        Route::controller(AdminDeliveredOrderController::class)
            ->prefix('/order-manage/delivered-orders')
            ->name('orders.delivered.')
            ->group(function () {
                Route::get('/', 'index')
                    ->middleware('permission:order-manage.menu')
                    ->name('index');
                Route::patch('/{order}', 'show')
                    ->middleware('permission:order-manage.detail')
                    ->name('show');
            });

        // ========== Admin Return Order Section ==========

        // Admin Requested Return Orders Section
        Route::controller(AdminRequestedReturnOrderController::class)
            ->prefix('/return-order-manage/requested-return')
            ->name('return-orders.requested.')
            ->group(function () {
                Route::get('/', 'index')
                    ->middleware('permission:return-order-manage.menu')
                    ->name('index');
                Route::get('/{order}', 'show')
                    ->middleware('permission:return-order-manage.detail')
                    ->name('show');
                Route::patch('/{order}', 'update')
                    ->middleware('permission:return-order-manage.control')
                    ->name('update');
            });

        // Admin Approved Return Orders Section
        Route::controller(AdminApprovedReturnOrderController::class)
            ->prefix('/return-order-manage/approved-return')
            ->name('return-orders.approved.')
            ->group(function () {
                Route::get('/', 'index')
                    ->middleware('permission:return-order-manage.menu')
                    ->name('index');
                Route::get('/{order}', 'show')
                    ->middleware('permission:return-order-manage.detail')
                    ->name('show');
                Route::patch('/{order}', 'update')
                    ->middleware('permission:return-order-manage.control')
                    ->name('update');
            });

        // Admin Refunded Return Orders Section
        Route::controller(AdminRefundedReturnOrderController::class)
            ->prefix('/return-order-manage/refunded-return')
            ->name('return-orders.refunded.')
            ->group(function () {
                Route::get('/', 'index')
                    ->middleware('permission:return-order-manage.menu')
                    ->name('index');
                Route::get('/{order}', 'show')
                    ->middleware('permission:return-order-manage.detail')
                    ->name('show');
            });

        // ========== Admin Cancel Orders Section ==========

        // Admin Requested Cancel Orders Section
        Route::controller(AdminRequestedCancelOrderController::class)
            ->prefix('/cancel-order-manage/requested-cancel')
            ->name('cancel-orders.requested.')
            ->group(function () {
                Route::get('/', 'index')
                    ->middleware('permission:cancel-order-manage.menu')
                    ->name('index');
                Route::get('/{order}', 'show')
                    ->middleware('permission:cancel-order-manage.detail')
                    ->name('show');
                Route::patch('/{order}', 'update')
                    ->middleware('permission:cancel-order-manage.control')
                    ->name('update');
            });

        // Admin Approved Cancel Orders Section
        Route::controller(AdminApprovedCancelOrderController::class)
            ->prefix('/cancel-order-manage/approved-cancel')
            ->name('cancel-orders.approved.')
            ->group(function () {
                Route::get('/', 'index')
                    ->middleware('permission:cancel-order-manage.menu')
                    ->name('index');
                Route::get('/{order}', 'show')
                    ->middleware('permission:cancel-order-manage.detail')
                    ->name('show');
            });

        // ******************** Admin Dashboard Review Managements ********************

        // Admin Product Reviews Section
        Route::controller(AdminProductReviewController::class)
            ->prefix('/product-reviews')
            ->name('product-reviews.')
            ->group(function () {
                Route::get('/', 'index')
                    ->middleware('permission:product-review.menu')
                    ->name('index');
                Route::get('/{product_review}/details', 'show')
                    ->middleware('permission:product-review.detail')
                    ->name('show');
                Route::patch('/{product_review}', 'update')
                    ->middleware('permission:product-review.control')
                    ->name('update');
                Route::delete('/{product_review}', 'destroy')
                    ->middleware('permission:product-review.delete')
                    ->name('destroy');
                Route::get('/trash', 'trash')
                    ->middleware('permission:product-review.trash.list')
                    ->name('trash');
                Route::post('/trash/{trash_product_review_id}/restore', 'restore')
                    ->middleware('permission:product-review.trash.restore')
                    ->name('trash.restore');
                Route::delete('/trash/{trash_product_review_id}/force-delete', 'forceDelete')
                    ->middleware('permission:product-review.trash.delete')
                    ->name('trash.force.delete');
                Route::delete('/trash/permanently-delete', 'permanentlyDelete')
                    ->middleware('permission:product-review.trash.delete')
                    ->name('trash.permanently.delete');
            });

        // Admin Shop Reviews Section
        Route::controller(AdminShopReviewController::class)
            ->prefix('/shop-reviews')
            ->name('shop-reviews.')
            ->group(function () {
                Route::get('/', 'index')
                    ->middleware('permission:shop-review.menu')
                    ->name('index');
                Route::get('/{shop_review}/details', 'show')
                    ->middleware('permission:shop-review.detail')
                    ->name('show');
                Route::patch('/{shop_review}', 'update')
                    ->middleware('permission:shop-review.control')
                    ->name('update');
                Route::delete('/{shop_review}', 'destroy')
                    ->middleware('permission:shop-review.delete')
                    ->name('destroy');
                Route::get('/trash', 'trash')
                    ->middleware('permission:shop-review.trash.list')
                    ->name('trash');
                Route::post('/trash/{trash_shop_review_id}/restore', 'restore')
                    ->middleware('permission:shop-review.trash.restore')
                    ->name('trash.restore');
                Route::delete('/trash/{trash_shop_review_id}/force-delete', 'forceDelete')
                    ->middleware('permission:shop-review.trash.delete')
                    ->name('trash.force.delete');
                Route::delete('/trash/permanently-delete', 'permanentlyDelete')
                    ->middleware('permission:shop-review.trash.delete')
                    ->name('trash.permanently.delete');
            });

        // ******************** Admin Dashboard User Managements ********************

        // Admin Seller Manage Section
        Route::controller(AdminSellerManageController::class)
            ->prefix('/seller-manage')
            ->name('seller-manage.')
            ->group(function () {
                Route::get('/', 'index')
                    ->middleware('permission:seller-manage.menu')
                    ->name('index');
                Route::get('/{user}/details', 'show')
                    ->middleware('permission:seller-manage.detail')
                    ->name('show');
                Route::patch('/{user}', 'update')
                    ->middleware('permission:seller-manage.control')
                    ->name('update');
                Route::delete('/{user}', 'destroy')
                    ->middleware('permission:seller-manage.delete')
                    ->name('destroy');
                Route::get('/trash', 'trash')
                    ->middleware('permission:seller-manage.trash.list')
                    ->name('trash');
                Route::post('/trash/{trash_seller_id}/restore', 'restore')
                    ->middleware('permission:seller-manage.trash.restore')
                    ->name('trash.restore');
                Route::delete('/trash/{trash_seller_id}/force-delete', 'forceDelete')
                    ->middleware('permission:seller-manage.trash.delete')
                    ->name('trash.force.delete');
                Route::delete('/trash/permanently-delete', 'permanentlyDelete')
                    ->middleware('permission:seller-manage.trash.delete')
                    ->name('trash.permanently.delete');
            });

        // Admin Registered Account Section
        Route::controller(AdminRegisteredAccountController::class)
            ->prefix('/registered-accounts')
            ->name('registered-accounts.')
            ->group(function () {
                Route::get('/', 'index')
                    ->middleware('permission:registered-account.menu')
                    ->name('index');
                Route::get('/{user}/details', 'show')
                    ->middleware('permission:registered-account.detail')
                    ->name('show');
                Route::delete('/{user}', 'destroy')
                    ->middleware('permission:registered-account.delete')
                    ->name('destroy');
                Route::get('/trash', 'trash')
                    ->middleware('permission:registered-account.trash.list')
                    ->name('trash');
                Route::post('/trash/{trash_user_id}/restore', 'restore')
                    ->middleware('permission:registered-account.trash.restore')
                    ->name('trash.restore');
                Route::delete('/trash/{trash_user_id}/force-delete', 'forceDelete')
                    ->middleware('permission:registered-account.trash.delete')
                    ->name('trash.force.delete');
                Route::delete('/trash/permanently-delete', 'permanentlyDelete')
                    ->middleware('permission:registered-account.trash.delete')
                    ->name('trash.permanently.delete');
            });

        // Admin Admin Manage Section
        Route::controller(AdminManageController::class)
            ->prefix('/admin-manage')
            ->name('admin-manage.')
            ->group(function () {
                Route::get('/', 'index')
                    ->middleware('permission:admin-manage.menu')
                    ->name('index');
                Route::get('/{user}/details', 'show')
                    ->middleware('permission:admin-manage.detail')
                    ->name('show');
                Route::get('/create', 'create')
                    ->middleware('permission:admin-manage.add')
                    ->name('create');
                Route::post('/', 'store')
                    ->middleware('permission:admin-manage.add')
                    ->name('store');
                Route::get('/{user}/edit', 'edit')
                    ->middleware('permission:admin-manage.edit')
                    ->name('edit');
                Route::post('/{user}', 'update')
                    ->middleware('permission:admin-manage.edit')
                    ->name('update');
                Route::delete('/{user}', 'destroy')
                    ->middleware('permission:admin-manage.delete')
                    ->name('destroy');
                Route::get('/trash', 'trash')
                    ->middleware('permission:admin-manage.trash.list')
                    ->name('trash');
                Route::post('/trash/{trash_admin_id}/restore', 'restore')
                    ->middleware('permission:admin-manage.trash.restore')
                    ->name('trash.restore');
                Route::delete('/trash/{trash_admin_id}/force-delete', 'forceDelete')
                    ->middleware('permission:admin-manage.trash.delete')
                    ->name('trash.force.delete');
                Route::delete('/trash/permanently-delete', 'permanentlyDelete')
                    ->middleware('permission:admin-manage.trash.delete')
                    ->name('trash.permanently.delete');
            });

        // ******************** Admin Dashboard Authority Managements ********************

        // ========== Admin Roles And Permissions Section ==========

        // Admin Roles Section
        Route::controller(AdminRoleController::class)
            ->prefix('/roles-and-permissions/roles')
            ->name('roles.')
            ->group(function () {
                Route::get('/', 'index')
                    ->middleware('permission:role-and-permission.menu')
                    ->name('index');
                Route::get('/create', 'create')
                    ->middleware('permission:role-and-permission.add')
                    ->name('create');
                Route::post('/', 'store')
                    ->middleware('permission:role-and-permission.add')
                    ->name('store');
                Route::get('/{role}/edit', 'edit')
                    ->middleware('permission:role-and-permission.edit')
                    ->name('edit');
                Route::patch('/{role}', 'update')
                    ->middleware('permission:role-and-permission.edit')
                    ->name('update');
                Route::delete('/{role}', 'destroy')
                    ->middleware('permission:role-and-permission.delete')
                    ->name('destroy');
                Route::get('/trash', 'trash')
                    ->middleware('permission:role-and-permission.trash.list')
                    ->name('trash');
                Route::post('/trash/{trash_role_id}/restore', 'restore')
                    ->middleware('permission:role-and-permission.trash.restore')
                    ->name('trash.restore');
                Route::delete('/trash/{trash_role_id}/force-delete', 'forceDelete')
                    ->middleware('permission:role-and-permission.trash.delete')
                    ->name('trash.force.delete');
                Route::delete('/trash/permanently-delete', 'permanentlyDelete')
                    ->middleware('permission:role-and-permission.trash.delete')
                    ->name('trash.permanently.delete');
            });

        // Admin Permissions Section
        Route::get('/roles-and-permissions/permissions', [AdminPermissionController::class, 'index'])
            ->middleware('permission:role-and-permission.menu')
            ->name('permissions.index');

        // Admin Role In Permissions Section
        Route::controller(AdminRoleInPermissionController::class)
            ->prefix('/role-in-permissions')
            ->name('role-in-permissions.')
            ->group(function () {
                Route::get('/', 'index')
                    ->middleware('permission:role-in-permissions.menu')
                    ->name('index');
                Route::get('/create', 'create')
                    ->middleware('permission:role-in-permissions.add')
                    ->name('create');
                Route::post('/', 'store')
                    ->middleware('permission:role-in-permissions.add')
                    ->name('store');
                Route::get('/{role}/edit', 'edit')
                    ->middleware(['permission:role-in-permissions.edit', 'restrict.superadmin.data'])
                    ->name('edit');
                Route::patch('/{role}', 'update')
                    ->middleware(['permission:role-in-permissions.edit', 'restrict.superadmin.data'])
                    ->name('update');
                Route::delete('/{role}', 'destroy')
                    ->middleware(['permission:role-in-permissions.delete', 'restrict.superadmin.data'])
                    ->name('destroy');
            });

        // ******************** Admin Dashboard Blog Managements ********************

        // Admin Blog Categories Section
        Route::controller(AdminBlogCategoryController::class)
            ->prefix('/blogs/categories')
            ->name('blogs.categories.')
            ->group(function () {
                Route::get('/', 'index')
                    ->middleware('permission:blog-category.menu')
                    ->name('index');
                Route::get('/create', 'create')
                    ->middleware('permission:blog-category.add')
                    ->name('create');
                Route::post('/', 'store')
                    ->middleware('permission:blog-category.add')
                    ->name('store');
                Route::get('/{blog_category}/edit', 'edit')
                    ->middleware('permission:blog-category.edit')
                    ->name('edit');
                Route::post('/{blog_category}', 'update')
                    ->middleware('permission:blog-category.edit')
                    ->name('update');
                Route::delete('/{blog_category}', 'destroy')
                    ->middleware('permission:blog-category.delete')
                    ->name('destroy');
                Route::get('/trash', 'trash')
                    ->middleware('permission:blog-category.trash.list')
                    ->name('trash');
                Route::post('/trash/{trash_blog_category_id}/restore', 'restore')
                    ->middleware('permission:blog-category.trash.restore')
                    ->name('trash.restore');
                Route::delete('/trash/{trash_blog_category_id}/force-delete', 'forceDelete')
                    ->middleware('permission:blog-category.trash.delete')
                    ->name('trash.force.delete');
                Route::delete('/trash/permanently-delete', 'permanentlyDelete')
                    ->middleware('permission:blog-category.trash.delete')
                    ->name('trash.permanently.delete');
            });

        // Admin Blog Posts Section
        Route::controller(AdminBlogPostController::class)
            ->prefix('/blogs/posts')
            ->name('blogs.posts.')
            ->group(function () {
                Route::get('/', 'index')
                    ->middleware('permission:blog-post.menu')
                    ->name('index');
                Route::get('/create', 'create')
                    ->middleware('permission:blog-post.add')
                    ->name('create');
                Route::post('/', 'store')
                    ->middleware('permission:blog-post.add')
                    ->name('store');
                Route::get('/{blog_post}/edit', 'edit')
                    ->middleware('permission:blog-post.edit')
                    ->name('edit');
                Route::post('/{blog_post}', 'update')
                    ->middleware('permission:blog-post.edit')
                    ->name('update');
                Route::delete('/{blog_post}', 'destroy')
                    ->middleware('permission:blog-post.delete')
                    ->name('destroy');
                Route::get('/trash', 'trash')
                    ->middleware('permission:blog-post.trash.list')
                    ->name('trash');
                Route::post('/trash/{trash_blog_post_id}/restore', 'restore')
                    ->middleware('permission:blog-post.trash.restore')
                    ->name('trash.restore');
                Route::delete('/trash/{trash_blog_post_id}/force-delete', 'forceDelete')
                    ->middleware('permission:blog-post.trash.delete')
                    ->name('trash.force.delete');
                Route::delete('/trash/permanently-delete', 'permanentlyDelete')
                    ->middleware('permission:blog-post.trash.delete')
                    ->name('trash.permanently.delete');
            });

        // Admin Blog Comments Section
        Route::controller(AdminBlogCommentController::class)
            ->prefix('/blogs/comments')
            ->name('blogs.comments.')
            ->group(function () {
                Route::get('/', 'index')
                    ->middleware('permission:blog-comment.menu')
                    ->name('index');
                Route::delete('/{blog_comment}', 'destroy')
                    ->middleware('permission:blog-comment.delete')
                    ->name('destroy');
                Route::get('/trash', 'trash')
                    ->middleware('permission:blog-comment.trash.list')
                    ->name('trash');
                Route::post('/trash/{trash_blog_comment_id}/restore', 'restore')
                    ->middleware('permission:blog-comment.trash.restore')
                    ->name('trash.restore');
                Route::delete('/trash/{trash_blog_comment_id}/force-delete', 'forceDelete')
                    ->middleware('permission:blog-comment.trash.delete')
                    ->name('trash.force.delete');
                Route::delete('/trash/permanently-delete', 'permanentlyDelete')
                    ->middleware('permission:blog-comment.trash.delete')
                    ->name('trash.permanently.delete');
            });

        // ******************** Admin Dashboard Admin Web Control Area ********************

        // ========== Admin Settings Section ==========

        // Admin Website Settings Section
        Route::controller(AdminWebsiteSettingController::class)
            ->prefix('/settings/website-settings')
            ->name('website-settings.')
            ->group(function () {
                Route::get('/', 'edit')
                    ->middleware('permission:setting.menu')
                    ->name('edit');
                Route::post('/{website_setting}', 'update')
                    ->middleware('permission:setting.edit')
                    ->name('update');
            });

        // Admin Seo Setting Section
        Route::controller(AdminSeoSettingController::class)
            ->prefix('/settings/seo-settings')
            ->name('seo-settings.')
            ->group(function () {
                Route::get('/', 'edit')
                    ->middleware('permission:setting.menu')
                    ->name('edit');
                Route::patch('/{seo_setting}', 'update')
                    ->middleware('permission:setting.edit')
                    ->name('update');
            });

        // ========== Admin Pages Section ==========

        // Admin Privacy And Policy Section
        Route::controller(AdminPrivacyPolicyController::class)
            ->prefix('/pages/privacy-policy')
            ->name('pages.privacy-policy.')
            ->group(function () {
                Route::get('/', 'edit')
                    ->middleware('permission:page.menu')
                    ->name('edit');
                Route::patch('/{page}', 'update')
                    ->middleware('permission:page.edit')
                    ->name('update');
            });

        // Admin Terms And Conditions Section
        Route::controller(AdminTermsAndConditionsController::class)
            ->prefix('/pages/terms-and-conditions')
            ->name('pages.terms-and-conditions.')
            ->group(function () {
                Route::get('/', 'edit')
                    ->middleware('permission:page.menu')
                    ->name('edit');
                Route::patch('/{page}', 'update')
                    ->middleware('permission:page.edit')
                    ->name('update');
            });

        // ========== Admin Faq Categories Section ==========

        // Admin Faq Category Section
        Route::controller(AdminFaqCategoryController::class)
            ->prefix('/faq-categories/categories')
            ->name('faq-categories.categories.')
            ->group(function () {
                Route::get('/', 'index')
                    ->middleware('permission:faq-category.menu')
                    ->name('index');
                Route::get('/create', 'create')
                    ->middleware('permission:faq-category.add')
                    ->name('create');
                Route::post('/', 'store')
                    ->middleware('permission:faq-category.add')
                    ->name('store');
                Route::get('/{faq_category}/edit', 'edit')
                    ->middleware('permission:faq-category.edit')
                    ->name('edit');
                Route::patch('/{faq_category}', 'update')
                    ->middleware('permission:faq-category.edit')
                    ->name('update');
                Route::delete('/{faq_category}', 'destroy')
                    ->middleware('permission:faq-category.delete')
                    ->name('destroy');
                Route::get('/trash', 'trash')
                    ->middleware('permission:faq-category.trash.list')
                    ->name('trash');
                Route::post('/trash/{trash_faq_category_id}/restore', 'restore')
                    ->middleware('permission:faq-category.trash.restore')
                    ->name('trash.restore');
                Route::delete('/trash/{trash_faq_category_id}/force-delete', 'forceDelete')
                    ->middleware('permission:faq-category.trash.delete')
                    ->name('trash.force.delete');
                Route::delete('/trash/permanently-delete', 'permanentlyDelete')
                    ->middleware('permission:faq-category.trash.delete')
                    ->name('trash.permanently.delete');
            });

        // Admin Faq Sub Category Section
        Route::controller(AdminFaqSubCategoryController::class)
            ->prefix('/faq-categories/sub-categories')
            ->name('faq-categories.sub-categories.')
            ->group(function () {
                Route::get('/', 'index')
                    ->middleware('permission:faq-category.menu')
                    ->name('index');
                Route::get('/create', 'create')
                    ->middleware('permission:faq-category.add')
                    ->name('create');
                Route::post('/', 'store')
                    ->middleware('permission:faq-category.add')
                    ->name('store');
                Route::get('/{faq_sub_category}/edit', 'edit')
                    ->middleware('permission:faq-category.edit')
                    ->name('edit');
                Route::patch('/{faq_sub_category}', 'update')
                    ->middleware('permission:faq-category.edit')
                    ->name('update');
                Route::delete('/{faq_sub_category}', 'destroy')
                    ->middleware('permission:faq-category.delete')
                    ->name('destroy');
                Route::get('/trash', 'trash')
                    ->middleware('permission:faq-category.trash.list')
                    ->name('trash');
                Route::post('/trash/{trash_faq_sub_category_id}/restore', 'restore')
                    ->middleware('permission:faq-category.trash.restore')
                    ->name('trash.restore');
                Route::delete('/trash/{trash_faq_sub_category_id}/force-delete', 'forceDelete')
                    ->middleware('permission:faq-category.trash.delete')
                    ->name('trash.force.delete');
                Route::delete('/trash/permanently-delete', 'permanentlyDelete')
                    ->middleware('permission:faq-category.trash.delete')
                    ->name('trash.permanently.delete');
            });

        // Admin Faqs Section
        Route::controller(AdminFaqController::class)
            ->prefix('/faqs')
            ->name('faqs.')
            ->group(function () {
                Route::get('/', 'index')
                    ->middleware('permission:faq.menu')
                    ->name('index');
                Route::get('/create', 'create')
                    ->middleware('permission:faq.add')
                    ->name('create');
                Route::post('/', 'store')
                    ->middleware('permission:faq.add')
                    ->name('store');
                Route::get('/{faq}/edit', 'edit')
                    ->middleware('permission:faq.edit')
                    ->name('edit');
                Route::patch('/{faq}', 'update')
                    ->middleware('permission:faq.edit')
                    ->name('update');
                Route::delete('/{faq}', 'destroy')
                    ->middleware('permission:faq.delete')
                    ->name('destroy');
                Route::get('/trash', 'trash')
                    ->middleware('permission:faq.trash.list')
                    ->name('trash');
                Route::post('/trash/{trash_faq_id}/restore', 'restore')
                    ->middleware('permission:faq.trash.restore')
                    ->name('trash.restore');
                Route::delete('/trash/{trash_faq_id}/force-delete', 'forceDelete')
                    ->middleware('permission:faq.trash.delete')
                    ->name('trash.force.delete');
                Route::delete('/trash/permanently-delete', 'permanentlyDelete')
                    ->middleware('permission:faq.trash.delete')
                    ->name('trash.permanently.delete');
            });

        // ******************** Admin Dashboard SupportContactService ********************

        // Admin Chats Section
        Route::controller(AdminChatController::class)
            ->prefix('/live-chats')
            ->name('live-chats.')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/chat/{live_chat:uuid}', 'show')->name('show');
                Route::patch('/{live_chat}/pinned', 'pinnedChat')->name('pinned');
                Route::patch('/{live_chat}/delete-for-myself', 'deleteForMyself')->name('delete-for-myself');
                Route::delete('/{live_chat}', 'destroy')->name('destroy');
                Route::patch('/{live_chat}/handle-chat-with-folder', 'handleChatWithFolder')->name('handle-chat-with-folder');
                Route::patch('/{live_chat}/archived', 'archivedChat')->name('archived');
            });

        Route::controller(AdminChatFolderController::class)
            ->prefix('/live-chats/folders')
            ->name('live-chats.folders.')
            ->group(function () {
                Route::post('/', 'store')->name('store');
                Route::delete('/{chat_folder}', 'destroy')->name('destroy');
            });

        // ******************** Admin Dashboard From The Submitters ********************

        // Admin Subscribers Section
        Route::controller(AdminSubscriberController::class)
            ->prefix('/subscribers')
            ->name('subscribers.')
            ->group(function () {
                Route::get('/', 'index')
                    ->middleware('permission:subscriber.menu')
                    ->name('index');
                Route::delete('/{subscriber}', 'destroy')
                    ->middleware('permission:subscriber.delete')
                    ->name('destroy');
                Route::get('/trash', 'trash')
                    ->middleware('permission:subscriber.trash.list')
                    ->name('trash');
                Route::post('/trash/{trash_subscriber_id}/restore', 'restore')
                    ->middleware('permission:subscriber.trash.restore')
                    ->name('trash.restore');
                Route::delete('/trash/{trash_subscriber_id}/force-delete', 'forceDelete')
                    ->middleware('permission:subscriber.trash.delete')
                    ->name('trash.force.delete');
                Route::delete('/trash/permanently-delete', 'permanentlyDelete')
                    ->middleware('permission:subscriber.trash.delete')
                    ->name('trash.permanently.delete');
            });

        // Admin Suggestions Section
        Route::controller(AdminSuggestionController::class)
            ->prefix('/suggestions')
            ->name('suggestions.')
            ->group(function () {
                Route::get('/', 'index')
                    ->middleware('permission:suggestion.menu')
                    ->name('index');
                Route::get('/{suggestion}/details', 'show')
                    ->middleware('permission:suggestion.detail')
                    ->name('show');
                Route::delete('/{suggestion}', 'destroy')
                    ->middleware('permission:suggestion.delete')
                    ->name('destroy');
                Route::get('/trash', 'trash')
                    ->middleware('permission:suggestion.trash.list')
                    ->name('trash');
                Route::post('/trash/{trash_suggestion_id}/restore', 'restore')
                    ->middleware('permission:suggestion.trash.restore')
                    ->name('trash.restore');
                Route::delete('/trash/{trash_suggestion_id}/force-delete', 'forceDelete')
                    ->middleware('permission:suggestion.trash.delete')
                    ->name('trash.force.delete');
                Route::delete('/trash/permanently-delete', 'permanentlyDelete')
                    ->middleware('permission:suggestion.trash.delete')
                    ->name('trash.permanently.delete');
            });

        // Admin Website Feedbacks Section
        Route::controller(AdminWebsiteFeedbackController::class)
            ->prefix('/website-feedbacks')
            ->name('website-feedbacks.')
            ->group(function () {
                Route::get('/', 'index')
                    ->middleware('permission:website-feedback.menu')
                    ->name('index');
                Route::get('/{website_feedback}/details', 'show')
                    ->middleware('permission:website-feedback.detail')
                    ->name('show');
                Route::delete('/{website_feedback}', 'destroy')
                    ->middleware('permission:website-feedback.delete')
                    ->name('destroy');
                Route::get('/trash', 'trash')
                    ->middleware('permission:website-feedback.trash.list')
                    ->name('trash');
                Route::post('/trash/{trash_website_feedback_id}/restore', 'restore')
                    ->middleware('permission:website-feedback.trash.restore')
                    ->name('trash.restore');
                Route::delete('/trash/{trash_website_feedback_id}/force-delete', 'forceDelete')
                    ->middleware('permission:website-feedback.trash.delete')
                    ->name('trash.force.delete');
                Route::delete('/trash/permanently-delete', 'permanentlyDelete')
                    ->middleware('permission:website-feedback.trash.delete')
                    ->name('trash.permanently.delete');
            });
    });
