<?php

use App\Http\Controllers\Fantasy as Fantasy;
use App\Http\Controllers\Fantasy\CmsController;
use App\Http\Controllers\Front\Daily\DailyAccountController;
use App\Http\Controllers\Front\Daily\DailyApiController;
use App\Http\Controllers\Front\Daily\DailyArticleController;
use App\Http\Controllers\Front\Daily\DailyProjectController;
use App\Http\Controllers\Front\Daily\DailyUnitController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\LineNotify\LineNotifyController;
use App\Http\Controllers\Front\TestController;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\ProductController;
use App\Http\Controllers\Front\ProductAggridController;
use App\Http\Controllers\LeonBuilder\LeonBuilderController;

$all = function () {
    //Leon開發
    Route::group(['prefix' => '/leon'], function () {
        Route::get('/', [LeonBuilderController::class, 'index']);
        Route::match(['get', 'post'], '/autorun', [LeonBuilderController::class, 'autorun']);
        Route::match(['get', 'post'], '/menu', [LeonBuilderController::class, 'menu']);
        Route::match(['get', 'post'], '/database', [LeonBuilderController::class, 'database']);
        Route::match(['get', 'post'], '/database/add/{id?}', [LeonBuilderController::class, 'database_add']);
        Route::match(['get', 'post'], '/database/edit/{id}', [LeonBuilderController::class, 'database_edit']);
        Route::match(['get', 'post'], '/LangData', [LeonBuilderController::class, 'LangData']);
        Route::match(['get', 'post'], '/HtmltoBlade', [LeonBuilderController::class, 'HtmltoBlade']);
        Route::match(['get', 'post'], '/BladelangUI', [LeonBuilderController::class, 'BladelangUI']);
        Route::match(['get', 'post'], '/Sitemap', [LeonBuilderController::class, 'Sitemap']);
    });
    Route::group(['prefix' => 'api'], function () {
        Route::match(['post', 'get'], '/', [DailyApiController::class, 'index']);
        Route::match(['post', 'get'], 'getToken', [DailyApiController::class, 'getToken']);
        Route::post('revokeToken', [DailyApiController::class, 'revokeToken']);

        Route::match(['post', 'get'], 'getTokenExpir', [DailyApiController::class, 'getTokenExpir']);
        Route::post('RefreshToken', [DailyApiController::class, 'RefreshToken']);

        Route::group(['prefix' => '/account', 'middleware' => 'api'], function () {
            Route::post('register', [DailyAccountController::class, 'create']);
            Route::put('{account_id}/edit', [DailyAccountController::class, 'edit']);
            Route::delete('{account_id}/delete', [DailyAccountController::class, 'delete']);
            Route::match(['get', 'post'], 'show/{action?}', [DailyAccountController::class, 'index']);
        });

        Route::group(['prefix' => '/show', 'middleware' => 'api'], function () {
            Route::match(['post', 'get'], 'article/{article_id?}', [DailyArticleController::class, 'index']);
            Route::match(['post', 'get'], 'project/{project_id?}', [DailyProjectController::class, 'index']);
            Route::match(['post', 'get'], 'unit/{unit_id?}', [DailyUnitController::class, 'index']);
        });

        Route::group(['prefix' => '/create', 'middleware' => 'api'], function () {
            Route::post('article', [DailyArticleController::class, 'create']);
            Route::post('project', [DailyProjectController::class, 'create']);
            Route::post('unit', [DailyUnitController::class, 'create']);
        });

        Route::group(['prefix' => '/edit', 'middleware' => 'api'], function () {
            Route::put('{id}/article', [DailyArticleController::class, 'edit']);
            Route::put('{id}/unit', [DailyUnitController::class, 'edit']);
            Route::put('{id}/project', [DailyProjectController::class, 'edit']);
        });

        Route::group(['prefix' => '/delete', 'middleware' => 'api'], function () {
            Route::delete('{id}/article', [DailyArticleController::class, 'delete']);
            Route::delete('{id}/unit', [DailyUnitController::class, 'delete']);
            Route::delete('{id}/project', [DailyProjectController::class, 'delete']);
        });

    })->middleware('api');

    Route::get('/', [Fantasy\BasicController::class, 'prefixBranch']);
    Route::group(['prefix' => '/{locale}'], function () {
        Route::group(['prefix' => '/'], function () {
            Route::get('article/video/{id?}', [CmsController::class, 'article_video']);
            Route::match(['get', 'post'], '/', [HomeController::class, 'index']);
            Route::match(['get', 'post'], '/article/{class}/{two}/{three}', [EsgController::class, 'article_detail'])->defaults(
                'sitemap',
                [
                    'param' => '{class}',
                    'col' => 'url_name',
                    'model' => 'Datalist',
                    'pk' => 'id',
                    'with' =>
                        [
                            'is_multiple' => true,
                            'fk' => 'parent_id',
                            'param' => '{two}',
                            'col' => 'img_row',
                            'model' => 'Datalist_content',
                            'pk' => 'id',
                            'with' =>
                                ['is_multiple' => true, 'fk' => 'second_id', 'param' => '{three}', 'col' => 'image', 'model' => 'Datalist_content_img', 'pk' => 'id']
                        ],
                ]
            );
            Route::match(['get', 'post'], '/test', [TestController::class, 'test']);
            Route::match(['get', 'post'], '/testLock', [TestController::class, 'lock']);
            Route::match(['get', 'post'], '/testPlus', [TestController::class, 'plus']);
            Route::match(['get', 'post'], '/linePay', [TestController::class, 'linePay']);
            Route::match(['get', 'post'], '/linePayCallBackConfirm', [TestController::class, 'linePayCallBackConfirm']);
            Route::match(['get', 'post'], '/linePayCallBackCancel', [TestController::class, 'linePayCallBackCancel']);
            Route::match(['get', 'post'], '/linePayDetail', [TestController::class, 'linePayDetail']);
            Route::match(['get', 'post'], '/linePayCheck', [TestController::class, 'linePayCheck']);
            Route::match(['get', 'post'], '/linePayConfirm', [TestController::class, 'linePayConfirm']);
            Route::match(['get', 'post'], '/linePayRefund', [TestController::class, 'linePayRefund']);
            Route::match(['get', 'post'], '/ECPay', [TestController::class, 'ECPay']);
            Route::match(['get', 'post'], '/testTable/{formID}', [TestController::class, 'testTable']);
            Route::match(['get', 'post'], '/testTableSave', [TestController::class, 'testTableSave']);

            Route::group(['prefix' => '/linenotify'], function () {
                Route::get('/', [LineNotifyController::class, 'index']);
                Route::get('getToken', [LineNotifyController::class, 'getToken']);
                Route::get('sendMessage', [LineNotifyController::class, 'sendMessage']);
                Route::get('status', [LineNotifyController::class, 'status']);
            });
            Route::group(['prefix' => '/product'], function () {
                Route::get('/', [ProductController::class, 'index']);
                Route::get('/{categoryURL}', [ProductController::class, 'list']);
                Route::get('/{categoryURL}/{productURL}', [ProductController::class, 'detail']);
                Route::get('/{categoryURL}/{productURL}/2', [ProductController::class, 'detail2']);
                // Route::get('sendMessage',[LineNotifyController::class, 'sendMessage']);
                // Route::get('status',[LineNotifyController::class, 'status']);
            });
            // ag-grid
            Route::group(['prefix' => '/Ajax'], function () {
                Route::group(['prefix' => '/cms'], function () {
                    // Route::post('/getItemSpecificationCmsView', [AggridController::class, 'itemSpecificationCmsView'])->middleware(['auth']);
                    // Route::post('/getItemOverviewSpecificationCmsView', [AggridController::class, 'itemOverviewSpecificationCmsView'])->middleware(['auth']);
                    // Route::post('/getItemOrderingSpecificationCmsView', [AggridController::class, 'itemOrderingSpecificationCmsView'])->middleware(['auth']);
                    // Route::post('/getItemOptionalSpecificationCmsView', [AggridController::class, 'itemOptionalSpecificationCmsView'])->middleware(['auth']);

                    // Route::post('/itemSpecification', [AggridController::class, 'itemSpecification'])->middleware(['auth']);
                    // Route::post('/itemOverviewSpecification', [AggridController::class, 'itemOverviewSpecification'])->middleware(['auth']);
                    // Route::post('/itemOrderingSpecification', [AggridController::class, 'itemOrderingSpecification'])->middleware(['auth']);
                    // Route::post('/itemOptionalSpecification', [AggridController::class, 'itemOptionalSpecification'])->middleware(['auth']);

                    Route::post('/getItemSpecificationCmsView', [ProductAggridController::class, 'itemSpecificationCmsView'])->middleware(['auth']);
                    Route::post('/updateSpecificationInfo', [ProductAggridController::class, 'updateSpecificationInfo'])->middleware(['auth']); //操作需要登入

                });
            });
        });
    });
};

Route::domain('{branch}.{domain_list}')->group($all);
