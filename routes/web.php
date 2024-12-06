<?php

use App\Http\Controllers\Fantasy\AmsController;
use App\Http\Controllers\Fantasy\ams\AmsManagerController;
use App\Http\Controllers\Fantasy\ams\CmsManagerController;
use App\Http\Controllers\Fantasy\ams\CmsOverviewController;
use App\Http\Controllers\Fantasy\ams\CrsOverviewController;
use App\Http\Controllers\Fantasy\ams\CrsTemplateController;
use App\Http\Controllers\Fantasy\ams\FantasyAccountController;
use App\Http\Controllers\Fantasy\ams\FmsManagerController;
use App\Http\Controllers\Fantasy\ams\LogController;
use App\Http\Controllers\Fantasy\ams\TemplateManagerController;
use App\Http\Controllers\Fantasy\ams\TemplateSettingController;
use App\Http\Controllers\Fantasy\ams\WebsiteRedirectController;
use App\Http\Controllers\Fantasy\AuthController;
use App\Http\Controllers\Fantasy\BasicController;
use App\Http\Controllers\Fantasy\CmsController;
use App\Http\Controllers\Fantasy\ExcelController;
use App\Http\Controllers\Fantasy\FantasyController;
use App\Http\Controllers\Fantasy\FmsController;
use App\Http\Controllers\Fantasy\ItsController;
use App\Http\Controllers\Fantasy\PhotosController;
use App\Http\Controllers\Fantasy\ReviewController;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request as Request;
use Illuminate\Support\Facades\Route;
use Mews\Captcha\CaptchaController;
use App\Http\Controllers\Fantasy\SitemapController;
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

$fantasy = function () {
    Route::get('envRsaKeyCreate', [FantasyController::class, 'envRsaKeyCreate'])->middleware(['auth']);
    Route::get('uploadDesignToS3', [FantasyController::class, 'uploadDesignToS3'])->middleware(['auth']);
    Route::get('loadS3AllFile', [FantasyController::class, 'loadS3AllFile'])->middleware(['auth']);
    Route::get('replaceDatabaseStr', [FantasyController::class, 'replaceDatabaseStr'])->middleware(['auth']);
    Route::get('importSql', [FantasyController::class, 'importSql'])->middleware(['auth']);
    Route::get('exportSql', [FantasyController::class, 'exportSql'])->middleware(['auth']);
    Route::any('importExcel', [FantasyController::class, 'importExcel'])->middleware(['auth']);
    Route::get('exportExcel', [FantasyController::class, 'exportExcel'])->middleware(['auth']);
    Route::get('uploadDesign', [FantasyController::class, 'uploadDesign'])->middleware(['auth']);
    // 下面的是會以資料夾分層來上傳(FMS裡面看起來會跟切版的IMG裡面一樣)，fms跟upload裡面的資料夾都會自己建，不需要先建立
    Route::get('uploadDesign2', [FantasyController::class, 'uploadDesignWithFolder'])->middleware(['auth']);
    // 清理CACAHE用，有需要再打開
    Route::get('cleared', [FantasyController::class, 'cleared']);
    Route::get('/autositemapMain',[FantasyController::class, 'autositemapMain']);
    Route::get('/autositemapSub',[FantasyController::class, 'autositemapSub']);
    Route::get('autositemap', [FantasyController::class, 'autositemap']);
    Route::post('autositemap/auto', [FantasyController::class, 'autositemapauto']);
    Route::post('autositemap/creat', [FantasyController::class, 'autositemapcreat']);
    Route::get('/newSiteMap',[SitemapController::class, 'generate']);

    // 驗證碼
    Route::get('captcha/{config?}', [CaptchaController::class, 'getCaptcha']);
    Route::get('download/{idorname}', [FantasyController::class, 'download']);
    /*後台*/
    Route::group(['prefix' => '/auth'], function () {
        Route::post('/status', [AuthController::class, 'status']);
        Route::get('/login/{user_id?}', [AuthController::class, 'getLogin']);
        Route::post('/login', [AuthController::class, 'postLogin']);
        Route::get('/logout', [AuthController::class, 'postLogout']);
    });

    Route::group(['prefix' => '/Fantasy', 'middleware' => 'auth'], function () {

        Route::get('/', [FantasyController::class, 'index']);
        Route::get('/blockade',[FantasyController::class,'blockade']);
        Route::get('/fetch-change-pwd-view', function(){
            return view('Fantasy.cms_view.includes.change_PWD')->render();
        });
        Route::post('/change-pwd-send',[FantasyController::class,'changePWD']);
        Route::get('/{branch}/{locale}/Excel/{name}', [ExcelController::class, 'export']);
        Route::group(['prefix' => '/Color'], function () {
            Route::get('/', [FantasyController::class, 'color']);
        });
        /*Photos管理*/
        Route::group(['prefix' => '/Photos'], function () {
            Route::get('/', [PhotosController::class, 'index']);
        });

        /*its管理*/
        Route::group(['prefix' => '/Its'], function () {
            Route::get('/', [ItsController::class, 'index']);
            Route::get('/key', [ItsController::class, 'key']);
            Route::get('/menu', [ItsController::class, 'menu']);
            Route::get('/file', [ItsController::class, 'file']);
            Route::get('/option', [ItsController::class, 'option']);
        });

        /*cms管理*/
        Route::group(['prefix' => '/Cms'], function () {

            /*不分分館or品牌總覽基本設定*/
            Route::get('/', [CmsController::class, 'refixBranch']);

            /*分館+語系*/
            Route::group(['prefix' => '/{branch}'], function () {
                Route::group(['prefix' => '/{locale}'], function () {
                    Route::get('/', [CmsController::class, 'index']);


                    Route::group(['middleware' => 'cmsMiddleware'], function () {
                        Route::group(['prefix' => 'unit'], function () {
                            Route::get('/', [CmsController::class, 'index']);
                            Route::get('/{menuId}/{dataId?}', [CmsController::class, 'unit']);
                            Route::post('/{menuId}/{dataId?}', [CmsController::class, 'showUnit']);
                            Route::put('/{menuId}', [CmsController::class, 'updateUnit']);
                            Route::options('/{menuId}', [CmsController::class, 'copyUnit']);
                            Route::delete('/{menuId}', [CmsController::class, 'deleteUnit']);
                        });
                        Route::group(['prefix' => 'edit'], function () {
                            Route::post('/{menuId}/{dataId?}', [CmsController::class, 'edit']);
                            Route::put('/{menuId}', [CmsController::class, 'updateEdit']);
                        });
                        Route::group(['prefix' => 'export'], function () {
                            Route::post('/{menuId}', [ExcelController::class, 'output']);
                        });
                    });
                });
                Route::get('/', [CmsController::class, 'refixLocale']);
            });
        });
        Route::group(['prefix' => '/Review'], function () {
            Route::get('/', [ReviewController::class, 'index']);
            Route::get('/track', [ReviewController::class, 'track']);
        });
        /*Fms*/
        Route::group(['prefix' => '/Fms', 'middleware' => 'fmsMiddleware'], function () {
            Route::get('/{folder_id?}', [FmsController::class, 'index']);
        });

        /*AMS*/
        Route::group(['prefix' => '/Ams', 'middleware' => 'amsMiddleware'], function () {
            Route::get('/', [AmsController::class, 'index']);
            Route::get('/sidebar', [AmsController::class, 'sidebar']); //更新Ams選單用
            Route::group(['middleware' => 'amsViewCheck'], function () {
                Route::get('/ams-manager', [AmsManagerController::class, 'index']);
                Route::get('/fantasy-account', [FantasyAccountController::class, 'index']);
                Route::get('/template-manager', [TemplateManagerController::class, 'index']);
                Route::get('/template-setting', [TemplateSettingController::class, 'index']);
                Route::get('/cms-manager', [CmsManagerController::class, 'index']);
                Route::get('/crs-template', [CrsTemplateController::class, 'index']);
                Route::get('/cms-overview', [CmsOverviewController::class, 'index']);
                Route::get('/crs-overview', [CrsOverviewController::class, 'index']);
                Route::get('/fms-folder', [FmsManagerController::class, 'index']);
                Route::get('/autoredirect', [WebsiteRedirectController::class, 'index']);
                Route::get('/log/{date?}', [LogController::class, 'index']);
            });
        });

        Route::group(['prefix' => '/Ajax', 'middleware' => 'amsMiddleware'], function () {
            Route::get('/member-list/{key}', [AmsController::class, 'member']);
            Route::get('/ams-information/{type}/{id}', [AmsController::class, 'edit']);
            Route::post('/cms-manager/{branch_unit_id}', [CmsManagerController::class, 'changeBranch']);
            Route::group(['middleware' => 'amsUpdateCheck'], function () {
                Route::group(['prefix' => '/ams-update'], function () {
                    Route::post('/ams-manager', [AmsManagerController::class, 'update']);
                    Route::post('/fantasy-account', [FantasyAccountController::class, 'update']);
                    Route::post('/template-manager', [TemplateManagerController::class, 'update']);
                    Route::post('/template-setting', [TemplateSettingController::class, 'update']);
                    Route::post('/cms-manager', [CmsManagerController::class, 'update']);
                    Route::post('/crs-template', [CrsTemplateController::class, 'update']);
                    Route::post('/cms-overview', [CmsOverviewController::class, 'update']);
                    Route::post('/crs-overview', [CrsOverviewController::class, 'update']);
                    Route::post('/fms-folder', [FmsManagerController::class, 'update']);
                    Route::post('/autoredirect', [WebsiteRedirectController::class, 'update']);
                    Route::post('/log', [LogController::class, 'update']);
                });

                Route::group(['prefix' => '/ams-delete'], function () {
                    Route::get('/ams-manager', [AmsManagerController::class, 'delete']);
                    Route::get('/fantasy-account', [FantasyAccountController::class, 'delete']);
                    Route::get('/template-manager', [TemplateManagerController::class, 'delete']);
                    Route::get('/template-setting', [TemplateSettingController::class, 'delete']);
                    Route::get('/cms-manager', [CmsManagerController::class, 'delete']);
                    Route::get('/crs-template', [CrsTemplateController::class, 'delete']);
                    Route::get('/cms-overview', [CmsOverviewController::class, 'delete']);
                    Route::get('/crs-overview', [CrsOverviewController::class, 'delete']);
                    Route::get('/fms-folder', [FmsManagerController::class, 'delete']);
                    Route::get('/autoredirect', [WebsiteRedirectController::class, 'delete']);
                    Route::get('/log', [LogController::class, 'delete']);
                });
            });
            Route::group(['prefix' => '/index-reset'], function () {
                Route::get('/ams-manager', [AmsManagerController::class, 'reset']);
                Route::get('/fantasy-account', [FantasyAccountController::class, 'reset']);
                Route::get('/template-manager', [TemplateManagerController::class, 'reset']);
                Route::get('/template-setting', [TemplateSettingController::class, 'reset']);
                Route::get('/cms-manager', [CmsManagerController::class, 'reset']);
                Route::get('/crs-template', [CrsTemplateController::class, 'reset']);
                Route::get('/cms-overview', [CmsOverviewController::class, 'reset']);
                Route::get('/crs-overview', [CrsOverviewController::class, 'reset']);
                Route::get('/fms-folder', [FmsManagerController::class, 'reset']);
                Route::get('/autoredirect', [WebsiteRedirectController::class, 'reset']);
                Route::get('/log', [LogController::class, 'reset']);
            });
        });
        /*分館+語系*/
        Route::group(['prefix' => '/{branch}'], function () {
            Route::group(['prefix' => '/{locale}'], function () {
                /*Ajax*/
                Route::group(['prefix' => '/Ajax'], function () {
                    /*Get*/
                    Route::post('/Search', [BasicController::class, 'selectSearch']);
                    Route::get('/check-auth', [AuthController::class, 'checkAuth']);
                    Route::group(['prefix' => '/', 'middleware' => 'cmsCreateCheck'], function () {
                        Route::get('/add-new/{model}', [BasicController::class, 'createData']);
                        Route::get('/clone-array/{model}', [BasicController::class, 'cloneDataArray']);
                        //Route::get('/edit-content/{model}/0', [BasicController::class, 'getEditContent']);
                    });

                    Route::group(['middleware' => 'cmsDeleteCheck'], function () {
                        Route::get('/delete-array/{model}', [BasicController::class, 'deleteDataArray']);
                    });
                    Route::get('/data-info/{model}/{id}', [BasicController::class, 'getInformation']);
                    Route::get('/edit-content', [BasicController::class, 'getEditContent']);
                    Route::get('/notify-admin/{model}', [BasicController::class, 'notify_admin']);
                    Route::get('/radio-switch/{model}/{id}', [BasicController::class, 'radioSwitch']);
                    Route::get('/relate-select/{parent_model}/{model}/{id}', [BasicController::class, 'relateSelect']);
                    Route::get('/table-reset/{model}/{page}', [BasicController::class, 'tableReset']);
                    Route::get('/fms-lbox/{type}/{key}/{id}', [FmsController::class, 'f_lbox']);
                    Route::get('/fms-lbox-full/{type}/{key}/{id}', [FmsController::class, 'f_lbox_full']);
                    Route::get('/fms-sort', [FmsController::class, 'fms_sort']);
                    Route::get('/file-new', [FmsController::class, 'file_new']);
                    Route::get('/file-search', [FmsController::class, 'file_search']);
                    Route::get('/file-lbox-table/{list_type}/{first}/{second}/{third}/{type}', [FmsController::class, 'get_file_folder']);
                    Route::get('/file-lbox-sidebar/{first}/{second}/{third}', [FmsController::class, 'get_fms_sidebar']);
                    Route::get('/file-detail/{file_id}', [FmsController::class, 'get_file_detail']);
                    Route::get('/file-edit/{file_id}/{is_delete}', [FmsController::class, 'get_file_edit']);
                    Route::get('/folder-detail/{folder_type}/{folder_id}', [FmsController::class, 'get_folder_detail']);
                    Route::get('/folder-edit/{folder_id}/{nowFolderID}', [FmsController::class, 'get_folder_edit']);
                    Route::get('/folder-edit-new/{parent_id}/{id?}', [FmsController::class, 'get_folder_edit_new']);
                    Route::get('/db-lbox', [BasicController::class, 'db_lbox']);
                    Route::get('/by-data/{type}/{model}', [CmsController::class, 'getBydata']);

                    /*Post*/
                    Route::post('/copyThree', [BasicController::class, 'copyThree']);
                    Route::post('/copySon', [BasicController::class, 'copySon']);
                    Route::post('/verify', [BasicController::class, 'verifyData']);
                    Route::post('/update', [BasicController::class, 'updateData']);

                    Route::group(['middleware' => 'fmsDeleteCheck'], function () {
                        Route::get('/file-exchange', [FmsController::class, 'get_file_exchange']);
                    });
                    Route::group(['middleware' => 'fmsUpdateFileCheck'], function () {
                        Route::post('/post-edit-files', [FmsController::class, 'postEditFiles']);
                        Route::post('/post-edit-files-chunk', [FmsController::class, 'postEditFilesChunk']);
                    });
                    Route::group(['middleware' => 'fmsUpdateFolderCheck'], function () {
                        Route::post('/post-edit-folder-new', [FmsController::class, 'postEditFolderNew']);
                    });

                    Route::post('/post-files-fms', [FmsController::class, 'postFilesFms']);
                    Route::post('/post-files-fms-chunk', [FmsController::class,'postFilesFmsChunk']);
                    // 沒看到這支function
                    // Route::post('/fms-file-delete', [FmsController::class,'deleteFiles']);
                    Route::post('/post-new-folder', [FmsController::class, 'postNewFolder']);
                    Route::post('/post-name-folder', [FmsController::class, 'postNameFolder']);
                    Route::post('/post-delete-folder', [FmsController::class, 'postDeleteFolder']);
                    Route::post('/post-delete-files', [FmsController::class, 'postDeleteFiles']);
                    Route::post('/post-edit-folder', [FmsController::class, 'postEditFolder']);
                    Route::post('/post-edit-folder-delete', [FmsController::class, 'postEditDelete']);
                    Route::post('/post-download-files', [FmsController::class, 'postDownloadFiles']);
                    Route::post('/getSontableMultiImage', [FmsController::class, 'getSontableMultiImage']);
                    Route::post('/post-edit-files-exchange', [FmsController::class, 'postEditFilesExchange']);
                    Route::post('/message', [CmsController::class, 'postMessage']);
                });
            });
        });
    });
};

if (strpos(request()->header('User-Agent'), 'Trident')) {
    return Redirect::to('404/stop-ie.html')->send();
}
/*後台END*/

// 合法語系
$localeList = array_keys(config('cms.langArray', []));
$localeListNew = [];
foreach($localeList as $val){
    $localeListNew[] = 'preview_' . $val;
}
$localeList = implode('|', array_merge($localeList,$localeListNew));
Route::pattern('locale', $localeList);
Route::pattern('branch', '(.*)');
Route::pattern('domain_list', 'test|test.com|wdd.idv.tw|com.tw|com|tw');
Route::domain('{branch}.{domain_list}')->group($fantasy);

// 未批配轉址到首頁
// Route::fallback(function () {
//     return redirect('/',302);
// });
