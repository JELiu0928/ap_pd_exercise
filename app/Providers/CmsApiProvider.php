<?php

namespace App\Providers;

use App\Services\Cms\CmsManager;
use Illuminate\Support\ServiceProvider;

class CmsApiProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */

    public function boot()
    {
        // 呼叫函數開始註冊 API，起始資料夾為 app_path('Cms/Api/')
        $files = glob(app_path('Cms/Api/') . '*');
        $this->registerApisInFolder($files);
    }

    function registerApisInFolder($folderPath) {

        foreach ($folderPath as $file) {
            if (is_file($file)) {

                $ex = explode('/',dirname($file));
                $dir = $ex[count($ex)-1] == "Api" ? '\App\Cms\Api\\'.str_replace(".php","",basename($file)) : '\App\Cms\Api\\'.$ex[count($ex)-1].'\\'.str_replace(".php","",basename($file));
                CmsManager::registerApi($dir);

            } else if(is_dir($file)) {
            $dir_file = glob($file . '/*');
            // 如果是資料夾，則遞迴進入下一層資料夾
            $this->registerApisInFolder($dir_file);
            }
        }
    }
}
