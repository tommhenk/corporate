<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Arr;
use Menu;
use Session;
use Gate;
class AdminController extends Controller
{
    protected $p_rep;
    protected $a_rep;
    protected $user;
    protected $template;
    protected $content;
    protected $title;
    protected $vars;

    public function __construct () {
        $this->user = Auth::user();
        $this->middleware(function ($request, $next){
            if (!Auth::user()) {
                abort(403);
            }
            return $next($request);
        });
    }

    public function renderOutput () {
        $this->vars = Arr::add($this->vars, 'title', $this->title);

        $menu = $this->getMenu();
        $navigation = view(config('settings.theme').'.admin.navigation')->with('menu', $menu)->render();
        $this->vars = Arr::add($this->vars, 'navigation', $navigation);

        if ($this->content) {

            $this->vars = Arr::add($this->vars, 'content', $this->content);

        }

        $footer = view(config('settings.theme').'.admin.footer')->render();
        $this->vars = Arr::add($this->vars, 'footer', $footer);
        // dump();
        return view($this->template)->with($this->vars);
    }

    public function getMenu () {
        return Menu::make('adminMenu', function ($menu) {
            if (Gate::allows('VIEW_ADMIN_ARTICLES')) {
                $menu->add('Статьи', ['route' => 'admin_articles_index']);
            }
            if (Gate::allows('VIEW_ADMIN_PORTFOLIOS')) {
                $menu->add('Портфолио', ['route' => 'admin_portfolio_index']);
            }
            
            if (Gate::allows('VIEW_ADMIN_MENU')) {
                $menu->add('Меню', ['route' => 'admin_menu_index']);
            }

            if (Gate::allows('EDIT_USERS')) {
                $menu->add('Пользователи', ['route' => 'admin_users_index']);
            }

            if (Gate::allows('EDIT_USERS')) {
                $menu->add('Привелегии', ['route' => 'admin_permission_index']);
            }

        });
    }
}
