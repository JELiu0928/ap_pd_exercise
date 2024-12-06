<?php
namespace App\Http\Middleware;

use App;
use App\Http\Controllers\Fantasy\AuthController;
use App\Models\Basic\FantasyUsers;
use Closure;
use Illuminate\Contracts\Auth\Guard;

class Authenticate
{

    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
        //myBackEnd::checkRouteLang();
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (session()->has('fantasy_user') && $user = FantasyUsers::where('id', session('fantasy_user')['id'])->where('is_active', 1)->first()) {

            if (!in_array(session('fantasy_user')['key'], json_decode($user->session_keys, true) ?? [])) {
                AuthController::saveSession($request, $user);
            }
            return $next($request);
        }

        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) and $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
            return response('', 403);
        } else {
            return redirect()->to(url('auth/login'))->send();
        }

    }

}
