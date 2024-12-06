<?php

namespace App\Http\Middleware\fms;

use App\Models\Basic\Fms\FmsFile;
use App\Models\Basic\Fms\Fmsfolder;
use Closure;

class fmsDeleteCheck
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

        $fileIds = array_map(function ($id) {
            return intval($id);
        }, json_decode($request->json_file, true) ?? []);
        $folderIds = array_map(function ($id) {
            return intval($id);
        }, json_decode($request->json_folder, true) ?? []);

        $files = FmsFile::whereIn('id', $fileIds)->where('is_delete', 0)->get();
        $folders = Fmsfolder::whereIn('id', $folderIds)->where('is_delete', 0)->with('top_folder')->get();

        foreach ($files as $file) {
            if ((!empty($file) && $file->is_private && $file->create_id !== $user['id'] && !in_array((string) $user['id'], json_decode($file->can_use, true) ?? []))) {
                return response('', 403);
            }
        }

        foreach ($folders as $folder) {
            do {
                if (!empty($folder) && $folder->is_private && $folder->create_id !== $user['id'] && !in_array((string) $user['id'], json_decode($folder->can_use, true) ?? [])) {
                    return response('', 403);
                }
                $folder = $folder->top_folder;
            } while (!empty($folder));
        }

        return $next($request);
    }
}
