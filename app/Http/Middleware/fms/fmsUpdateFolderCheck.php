<?php

namespace App\Http\Middleware\fms;

use App\Models\Basic\Fms\FmsFile;
use App\Models\Basic\Fms\Fmsfolder;
use Closure;

class fmsUpdateFolderCheck
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

        // 最高權限者
        if (!empty($user['ams']) && !empty($user['ams']['is_folder'])) {
            return $next($request);
        }

        $folderId = $request->id;

        $folder = Fmsfolder::where('id', $folderId)->where('is_delete', 0)->with('top_folder')->first();

        do {
            if ($folder->is_private && $folder->create_id !== $user['id'] && !in_array((string) $user['id'], json_decode($folder->can_use, true) ?? [])) {
                return response('', 403);
            }
            $folder = $folder->top_folder;
        } while ($folder !== null);

        return $next($request);
    }
}