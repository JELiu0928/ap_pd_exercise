<?php

namespace App\Providers;

use App\Models\Basic\Branch\BranchOrigin;
use App\Models\Test\AForm;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Config;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        $this->mapWebAllRoutes();
        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }

    //載入所有
    protected function mapWebAllRoutes()
    {
        $staticPrefix = request()->server('REQUEST_URI');
        $domain = explode('.',str_replace(["www."], "", request()->server('HTTP_HOST')))[0];
        $subdomainORlocale = urldecode( explode("/", $staticPrefix)[1] ?: $domain);
        //用第一節uri查找有無相符分站資料
        $branch_origin = M('BranchOrigin')::where('is_active', 1)->where('url_title', $subdomainORlocale)->first();
        $branch_origin = (empty($branch_origin)) ? M('BranchOrigin')::where('is_active', 1)->where('url_title', $domain)->first() : $branch_origin;

        //取得所有routes比對
        $all_route_file = scandir(base_path('routes'));

        //取得對應route
        if(!empty($branch_origin)){
            $route_load = collect(Config::get('cms.blade_template'))->where('key',$branch_origin['blade_template'])->first();
            if(!empty($route_load)){
                foreach($all_route_file as $val){
                    if (strstr($val, $route_load['route'])) {
                        Route::middleware('web')->namespace($this->namespace)->group(base_path('routes/' . $val));
                    }
                }
            }
        }

    }
}
