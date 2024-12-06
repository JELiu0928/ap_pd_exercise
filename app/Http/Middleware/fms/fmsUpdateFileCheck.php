<?php

namespace App\Http\Middleware\fms;

use App\Models\Basic\Fms\FmsFile;
use App\Models\Basic\Fms\Fmsfolder;
use Closure;

class fmsUpdateFileCheck
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

        $fileId = $request->id;
        $folderId = $request->folder_id;

        $file = FmsFile::where('id', $fileId)->where('is_delete', 0)->first();
        $folder = Fmsfolder::where('id', $folderId)->where('is_delete', 0)->with('top_folder')->first();

        if ((!empty($file) && $file->is_private && $file->create_id !== $user['id'] && !in_array((string) $user['id'], json_decode($file->can_use, true) ?? []))) {
            return response('', 403);
        }

        do {
            if (!empty($folder) && $folder->is_private && $folder->create_id !== $user['id'] && !in_array((string) $user['id'], json_decode($folder->can_use, true) ?? [])) {
                return response('', 403);
            }
            $folder = $folder->top_folder;
        } while (!empty($folder));

        return $next($request);
    }
}
