<?php

namespace App\Http\Middleware\ams;

use App\Models\Basic\FantasyUsers;
use Closure;
use Illuminate\Http\Request;

class amsUpdateCheck
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
        $result = false;
        $freshUser = '';
        switch ($action) {
            case 'fantasy-account':
                $id = isset($request->amsData) ? $request->amsData['id'] : $request->id;
                $result = !empty($user['ams']['is_fantasy']) && (intval($user['ams']['a_or_m']) === 1 || !$this->isAdmin($id));
                $freshUser = $id;
                break;
            case 'ams-manager':
                $id = isset($request->amsData) ? $request->amsData['user_id'] : $request->id;
                $result = !empty($user['ams']['is_ams']) && (intval($user['ams']['a_or_m']) === 1 || !$this->isAdmin($id));
                $freshUser = $id;
                break;
            case 'template-manager':
                $result = !empty($user['ams']['is_cover_page']);
                break;
            case 'template-setting':
                $result = !empty($user['ams']['is_cms_template']);
                break;
            case 'cms-manager':
                $id =  $request->id ?? $request->amsData['user_id'];
                $result = !empty($user['ams']['is_cms_template_ma']);
                $freshUser = $id;
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
        }

        if (!$result) {
            return response('', 403);
        }

        if (!empty($freshUser)) {
            FantasyUsers::where('id', $freshUser)->update(['session_keys' => json_encode([])]);
        }

        return $next($request);

    }

    protected function isAdmin($id)
    {
        return FantasyUsers::where('id', $id)->whereHas(
            'amsRole', function ($q) {
                $q->where('a_or_m', 1);
            })->count() === 1;
    }
}
