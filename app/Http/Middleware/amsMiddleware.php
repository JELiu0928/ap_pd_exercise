<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redirect;

class amsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = session('fantasy_user');

        if (!empty($user['ams']) && !empty($user['ams']['is_active'])) {
            return $next($request);
        }

        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) and $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
            return response('', 403);
        } else {
            return Redirect::to(url("Fantasy"));
        }
    }
}
