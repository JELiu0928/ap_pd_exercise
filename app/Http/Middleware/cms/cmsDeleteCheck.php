<?php

namespace App\Http\Middleware\cms;

use Closure;
use Illuminate\Support\Facades\Redirect;

class cmsDeleteCheck
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
        $model = $request->menu_id ?? 0;

        $user = session()->get('fantasy_user');

        if (empty($user['cms']) || empty($user['cms'][$request->branch]) ||
            empty($user['cms'][$request->branch][$request->locale]) ||
            empty($user['cms'][$request->branch][$request->locale][$model]) ||
            empty($user['cms'][$request->branch][$request->locale][$model][2])
        ) {
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) and $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
                return response('', 403);
            } else {
                return Redirect::to(url("Fantasy/Cms/{$request->branch}/{$request->locale}"));
            }
        } else {
            return $next($request);
        }
    }
}
