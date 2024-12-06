<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redirect;

class cmsMiddleware
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
        $menu_id = $request->menuId;
        $user = session()->get('fantasy_user');
        if (!isset($user['cms'][$request->branch][$request->locale][$menu_id])) {
            return Redirect::to("Fantasy/blockade");
        } else if(array_sum($user['cms'][$request->branch][$request->locale][$menu_id]) == 0) {
            foreach($user['cms'][$request->branch][$request->locale] as $menu_id => $role){
                if(intval($menu_id) > 0 && array_sum($role) > 0){
                   return Redirect::to("Fantasy/Cms/{$request->branch}/{$request->locale}/unit/{$menu_id}");
                }
            }
            return Redirect::to("Fantasy/blockade");
        } else {
            return $next($request);
        }
    }
}
