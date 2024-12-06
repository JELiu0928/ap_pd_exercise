<?php

namespace App\Http\Middleware;

use App\Models\Basic\Ams\Autoredirect;
use Closure;
use Session;

class RedirectOldMiddleware
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
        // $serverInfo = $_SERVER;
        // if (strpos($serverInfo['REQUEST_URI'], 'index.php') !== false) {
        // $fullUrl = "{$serverInfo['HTTP_HOST']}{$serverInfo['REQUEST_URI']}";
        // $redirect = Autoredirect::where('old_url', $fullUrl)->first();

        // if ($redirect != null) {
        //     $statusCode = $redirect->is_permanent ? 301 : 302;
        //     return redirect($redirect->new_url, $statusCode);
        // } else {
        //     return redirect("https://{$serverInfo['HTTP_HOST']}");
        // }
        // }

        return $next($request);
    }
}
