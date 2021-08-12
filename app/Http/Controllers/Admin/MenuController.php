<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use App\Repositories\MenusRepository;
use App\Repositories\ArticlesRepository;
use App\Repositories\PortfolioRepository;
use Gate;
use Menu;
use Arr;
use App\Models\Category;
use App\Http\Requests\MenuRequest;

class MenuController extends AdminController
{
    protected $m_rep;
    public function __construct( MenusRepository $m_rep, ArticlesRepository $a_rep, PortfolioRepository $p_rep ) {
        parent::__construct();
        $this->m_rep = $m_rep;
        $this->a_rep = $a_rep;
        $this->p_rep = $p_rep;

        $this->template = config('settings.theme').'.admin.menus.menus';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::denies('VIEW_ADMIN_MENU')) {
            abort(403);
        }

        $this->tilte = 'Редактирование меню';

        $menus = $this->getMenus();
        $this->content = view(config('settings.theme').'.admin.menus.menus_content')->with('menus', $menus)->render();
        // dd($menus);

        return $this->renderOutput();
    }

    public function getMenus() {
        $menus = $this->m_rep->get();

        if ($menus->isEmpty()) {
            return false;
        }
        return Menu::make('forMenuPath', function ($m) use ($menus) {
            foreach ($menus as $item) {
                if ($item->parent_id == '0') {
                    $m->add($item->title, $item->path)->id($item->id);
                } else {
                    if ($m->find($item->parent_id)) {
                        $m->find($item->parent_id)->add($item->title, $item->path)->id($item->id);
                    }
                }
            }
        });

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->title = 'Новый пункт меню';

        $tmp = $this->getMenus()->roots();
        $menus = $tmp->reduce(function( $returnMenus, $menu ) {

            $returnMenus[$menu->id] = $menu->title;
            return $returnMenus;

        },[0 => 'Родительский пункт меню']);

        $categories = Category::select('title', 'alias', 'parent_id', 'id')->get();
        $list = [];
        $list = Arr::add($list, '0', 'Не используеться');
        $list = Arr::add($list, 'parent', 'Раздел блог');

        foreach ($categories as $category) {
            if ( $category->parent_id == '0' ) {
                $list[$category->tilte] = [];
            } else {
                $list[$categories->where('id', $category->parent_id)->first()->title][$category->alias] = $category->title;
            }
        }

        $articles = $this->a_rep->get();

        $articles = $articles->reduce( function ($returnArtilces, $article) {
            $returnArtilces[$article->alias] = $article->title;
            return $returnArtilces;
        }, [''=>'Не используеться'] );
        // dd($articles);

        $filters = \App\Models\Filter::select('id', 'title', 'alias')->get()->reduce( function ($returnFilters, $filter) {
            $returnFilters[$filter->alias] = $filter->title;
            return $returnFilters;
        }, [''=>'Не используеться','parent'=>'Раздел портфолио'] );

        $portfolios = $this->p_rep->get(['id', 'title', 'alias'])->
        reduce( function ($returnPortfolios, $portfolio) {
            $returnPortfolios[$portfolio->alias] = $portfolio->title;
            return $returnPortfolios;
        }, [''=>'Не используеться'] );

        // dd($portfolios);
        $this->content = view(config('settings.theme').'.admin.menus.menus_create_content')->with(['menus'=>$menus, 'categories'=>$list, 'articles'=>$articles, 'filters'=>$filters, 'portfolios'=>$portfolios])->render();
            
        return $this->renderOutput();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MenuRequest $request)
    {
        $result = $this->m_rep->addMenu($request);

        if (is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }else{
            return redirect()->route('adminIndex')->with($result);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(\App\Models\Menu $menu)
    {
        $this->title = 'Редактирование ссылка - '.$menu->title;
        $type = false;
        $option = false;
        // dd(app('request')->url());
        // dd(app('router')->getRoutes()->match(app('request')->create($menu->path))->parameters());
        $route = app('router')->getRoutes()->match(app('request')->create($menu->path));

        $aliasRoute = $route->getName();
        $parameters = $route->parameters();
        
        if ($aliasRoute == 'articles.index' || $aliasRoute == 'articlesCat') {
            $type = 'blogLink';
            $option = isset($parameters['cat_alias']) ? $parameters['cat_alias'] : 'parent';
            // dd($option);
        }
        else if ($aliasRoute == 'articles.show') {
            $type = 'blogLink';
            $option = isset($parameters['alias']) ? $parameters['alias'] : '';

        }
        else if ($aliasRoute == 'portfolio.index') {
            $type = 'portfolioLink';
            $option = 'parent';
        }
        else if ($aliasRoute == 'portfolio.show') {
            $type = 'portfolioLink';
            $option = isset($parameters['alias']) ? $parameters['alias'] : '';
        }
        else {
            $type = 'customLink';
        }

        $tmp = $this->getMenus()->roots();
        $menus = $tmp->reduce(function( $returnMenus, $menu ) {

            $returnMenus[$menu->id] = $menu->title;
            return $returnMenus;

        },[0 => 'Родительский пункт меню']);

        $categories = Category::select('title', 'alias', 'parent_id', 'id')->get();
        $list = [];
        $list = Arr::add($list, '0', 'Не используеться');
        $list = Arr::add($list, 'parent', 'Раздел блог');

        foreach ($categories as $category) {
            if ( $category->parent_id == '0' ) {
                $list[$category->tilte] = [];
            } else {
                $list[$categories->where('id', $category->parent_id)->first()->title][$category->alias] = $category->title;
            }
        }

        $articles = $this->a_rep->get();

        $articles = $articles->reduce( function ($returnArtilces, $article) {
            $returnArtilces[$article->alias] = $article->title;
            return $returnArtilces;
        }, [''=>'Не используеться'] );
        // dd($articles);

        $filters = \App\Models\Filter::select('id', 'title', 'alias')->get()->reduce( function ($returnFilters, $filter) {
            $returnFilters[$filter->alias] = $filter->title;
            return $returnFilters;
        }, [''=>'Не используеться','parent'=>'Раздел портфолио'] );

        $portfolios = $this->p_rep->get(['id', 'title', 'alias'])->
        reduce( function ($returnPortfolios, $portfolio) {
            $returnPortfolios[$portfolio->alias] = $portfolio->title;
            return $returnPortfolios;
        }, [''=>'Не используеться'] );

        // dd($portfolios);
        $this->content = view(config('settings.theme').'.admin.menus.menus_create_content')->with(['menus'=>$menus, 'categories'=>$list, 'articles'=>$articles, 'filters'=>$filters, 'portfolios'=>$portfolios, 'type'=>$type, 'option'=>$option, 'menu'=>$menu])->render();
            
        return $this->renderOutput();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, \App\Models\Menu $menu )
    {
        $result = $this->m_rep->updateMenu($request, $menu);

        if (is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }else{
            return redirect()->route('adminIndex')->with($result);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(\App\Models\Menu $menu )
    {
        $result = $this->m_rep->destroyMenu($menu);

        if (is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }else{
            return redirect()->route('adminIndex')->with($result);
        }
    }
}
