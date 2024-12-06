<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \App\Http\Middleware\AddHeaders::class,
        // \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            // \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \App\Http\Middleware\RedirectOldMiddleware::class,
        ],

        'api' => [
            'throttle:60,1',
            'bindings',
            'jwt',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        // 'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'branch' => \App\Http\Middleware\BranchMiddleware::class,
        'member' => \App\Http\Middleware\Member::class,
        'canPreview' => \App\Http\Middleware\canPreview::class,
        'cmsMiddleware' => \App\Http\Middleware\cmsMiddleware::class,
        'cmsCreateCheck' => \App\Http\Middleware\cms\cmsCreateCheck::class,
        'cmsEditCheck' => \App\Http\Middleware\cms\cmsEditCheck::class,
        'cmsDeleteCheck' => \App\Http\Middleware\cms\cmsDeleteCheck::class,
        'amsMiddleware' => \App\Http\Middleware\amsMiddleware::class,
        'amsUpdateCheck' => \App\Http\Middleware\ams\amsUpdateCheck::class,
        'amsViewCheck' => \App\Http\Middleware\ams\amsViewCheck::class,
        'fmsMiddleware' => \App\Http\Middleware\fmsMiddleware::class,
        'fmsUpdateFileCheck' => \App\Http\Middleware\fms\fmsUpdateFileCheck::class,
        'fmsUpdateFolderCheck' => \App\Http\Middleware\fms\fmsUpdateFolderCheck::class,
        'fmsDeleteCheck' => \App\Http\Middleware\fms\fmsDeleteCheck::class,
        'jwt' => \App\Http\Middleware\JwtMiddleware::class,
    ];
}
