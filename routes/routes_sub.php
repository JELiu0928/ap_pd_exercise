<?php

use App\Http\Controllers\Fantasy as Fantasy;
use App\Http\Controllers\Front\HomeController;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;

$all = function () {
    Route::get('/', [Fantasy\BasicController::class, 'prefixBranch']);
    Route::group(['prefix' => '/{locale}'], function () {
        Route::group(['prefix' => '/'], function () {
            Route::match(['get', 'post'], '/', [HomeController::class, 'index']);
            Route::match(['get', 'post'], '/branchTest', [HomeController::class, 'index']);
        });
    });
};

//分站開啟設定
$isBranch = Config::get('cms.setBranchs', false);
if ($isBranch) {
    $branchUrlInDomain = Config::get('cms.branchUrlInDomain', false);
    if($branchUrlInDomain){
        // 網址型態  分站.domain.com
        Route::domain('{subdomain}.{branch}.{domain_list}')->group($all);
    }else{
        // 網址型態  domain.com/分站
        Route::domain('{branch}.{domain_list}')->group(function () use ($all) {
            Route::group(['prefix' => '/{branch_url}'], $all);
        });
    }
} else {
    Route::domain('{branch}.{domain_list}')->group($all);
}
