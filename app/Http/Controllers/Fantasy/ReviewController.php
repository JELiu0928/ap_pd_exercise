<?php

namespace App\Http\Controllers\Fantasy;

use App\Models\Basic\FantasyUsers;
use Config;
use Session;
use View;

class ReviewController extends BackendController
{

    public function __construct()
    {
        parent::__construct();
        View::share('unitTitle', 'Cms');
        View::share('unitSubTitle', 'Content Management System');
        View::share('FantasyUser', session('fantasy_user'));
        View::share('FantasyUsersList', []);
        // .test可以切換帳號
        if (config('cms.localhost_autoLogin')) {
            // $FantasyUsersList =  $FantasyUsersList = FantasyUsers::get()->toArray() : [];
            View::share('FantasyUsersList', FantasyUsers::all());
        }
    }
    public function index()
    {
        if (!empty(session('fantasy_user'))) {
            $ReviewNotify = M('ReviewNotify')::whereJsonContains('admins', session('fantasy_user')['id'])->get();
            return View::make(
                'Fantasy.review.index',
                [
                    'ReviewNotify' => $ReviewNotify,
                    'cmsMenuList' => [],
                ]
            );
        }
    }
    public function track()
    {
        if (!empty(session('fantasy_user'))) {
            $ReviewNotify = M('ReviewNotify')::where('user_id', session('fantasy_user')['id'])->get();
            return View::make(
                'Fantasy.review.index',
                [
                    'ReviewNotify' => $ReviewNotify,
                    'cmsMenuList' => [],
                ]
            );
        }
    }
}