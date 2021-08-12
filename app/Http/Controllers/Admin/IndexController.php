<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use Auth;
use Gate;
class IndexController extends AdminController
{
    public function __construct () {
        parent::__construct();

        $this->middleware(function ( $request, $next ) {
            if ( Gate::denies('VIEW_ADMIN', Auth::user()) ) {
                abort(403);
            }
            return $next($request);
        });


        $this->template = config('settings.theme').'.admin.index';
    }

    public function index () {
        $this->title = 'Панель администратора';


        return $this->renderOutput();
    }
}
