<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
// use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
// use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
// use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (Throwable $e, $request) {
            return $this->handleException($request, $e);
        });
        // $this->reportable(function (Throwable $e) {
        //     //
        // });
    }

    private function handleException($request, Throwable $exception)
    {
        dd($exception);
        if ($request['domain_list'] === 'wdd.idv.tw') {
            $megs = [];
            $megs[] = $exception->getMessage();
            $megs[] = $exception->getFile() . '(' . $exception->getLine() . '):';
            foreach (preg_split('/#[0-9]+(?=(\s))/', $exception->getTraceAsString()) as $key => $line) {
                if ($key > 0) {
                    $megs[] = $line . "#{$key}";
                }
            };
            return response(implode('<br>', $megs), 417);
        }

        $LockUrl = parse_url('//' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
        $LockUrlStr = (isset($LockUrl['path']) && !empty($LockUrl['path'])) ? $LockUrl['path'] : '';
        $LockUrlStr .= (isset($LockUrl['query']) && !empty($LockUrl['query'])) ? '?' . $LockUrl['query'] : '';
        $autoredirect = config('models.Autoredirect')::whereRaw("REPLACE(REPLACE(REPLACE(REPLACE(old_url, '" . request()->getHost() . "', ''),'http://',''),'https://',''),'www.','') = '" . $LockUrlStr . "'")->first();
        if (!empty($autoredirect)) {
            if ($autoredirect['active301']) {
                return redirect($autoredirect->new_url, 301);
            }
            return redirect($autoredirect->new_url, 302);
        }

        switch (true) {
            case $exception instanceof NotFoundHttpException:
                return response()->json([
                    'message' => 'Http not found.',
                ], 404);
            case $exception instanceof MethodNotAllowedHttpException:
                return response()->json([
                    'message' => 'Method not allowed.',
                ], 405);
            case $exception instanceof UnauthorizedHttpException:
                return response()->json([
                    'message' => 'Unauthorized.',
                ], 401);
        }

        return redirect(url(''));
    }
}
