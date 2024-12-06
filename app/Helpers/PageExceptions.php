<?php

if (!function_exists('error404')) {
    function error404(string $redirectPath = '', Exception $exception = null)
    {
        if (preg_match('/\.[^\.\/]+$/', $_SERVER['SCRIPT_URL'])) {
            return response('file not find.', 404);
        }

        if ((isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') && !empty($exception)) {
            $isAdmin = session()->has('fantasy_user');
            return response($isAdmin ? $exception->getMessage() : '', 404);
        }

        return response(view('errors.404', [
            'redirect' => url($redirectPath ?: app()->getLocale()),
        ])->render(), 404);

    }
}

if (!function_exists('error500')) {
    function error500(Exception $exception = null)
    {
        if ((isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') && !empty($exception)) {
            $isAdmin = session()->has('fantasy_user');
            return response($isAdmin ? $exception->getMessage() : '', $isAdmin ? 417 : 500);
        }

        return response(view('errors.500', [
            'redirect' => url(app()->getLocale()),
        ])->render(), 500);
    }
}
