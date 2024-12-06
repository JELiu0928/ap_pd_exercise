<?php

namespace App\Http\Middleware\ams;

use App\Http\Controllers\BaseFunctions;
use Closure;

class amsViewCheck
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
        $action = preg_replace('/.*\//', '', url()->current());
        $user = session()->get('fantasy_user');
        switch ($action) {
            case 'fantasy-account':
                $result = !empty($user['ams']['is_fantasy']);
                break;
            case 'ams-manager':
                $result = !empty($user['ams']['is_ams']);
                break;
            case 'template-manager':
                $result = !empty($user['ams']['is_cover_page']);
                break;
            case 'template-setting':
                $result = !empty($user['ams']['is_cms_template']);
                break;
            case 'cms-manager':
                $result = !empty($user['ams']['is_cms_template_ma']);
                break;
            case 'crs-template':
                $result = !empty($user['ams']['is_cms_template_setting']);
                break;
            case 'autoredirect':
                $result = !empty($user['ams']['is_autoredirect']);
                break;
            case 'log':
                $result = !empty($user['ams']['is_log']);
                break;
            default:
                $result = false;
                break;
        }
        if ($result) {
            return $next($request);
        } else {
            return redirect()->to(BaseFunctions::b_url('Fantasy'));
        }
    }
}
