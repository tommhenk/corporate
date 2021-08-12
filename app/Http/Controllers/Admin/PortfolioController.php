<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use App\Repositories\PortfolioRepository;
use Gate;
use Auth;
use App\Models\Category;
use App\Http\Requests\PortfolioRequest;
use App\Models\Portfolio;

class PortfolioController extends AdminController
{
    public function __construct ( PortfolioRepository $p_rep) {
        parent::__construct();

        $this->middleware(function ( $request, $next ) {
            if ( Gate::denies('VIEW_ADMIN_PORTFOLIOS', $this->user) ) {
                abort(403);
            }
            return $next($request);
        });

        $this->p_rep = $p_rep;
        $this->template = config('settings.theme').'.admin.portfolios.portfolios';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->title = 'Менеджер портфолио';
        $portfolios = $this->getPortfolios();
        $this->content = view(config('settings.theme').'.admin.portfolios.portfolio_index_content')->with('portfolios', $portfolios)->render();
        return $this->renderOutput();
    }

    public function getPortfolios(){
        $portfolios = $this->p_rep->get();
        return $portfolios;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('EDIT_PORTFOLIOS') && Gate::denies('add', new Portfolio )) {
            adbort(403);
        }
        $this->title = 'Добавить новый материал';
        $filters = \App\Models\Filter::select(['id', 'title', 'alias'])->get();

        $lists = [];
        foreach ($filters as $filter) {
            $lists[$filter->id] = $filter->title;
        }
        // dd($lists);
        // dd(view(config('settings.theme').'.admin.portfolios.portfolios_create_content')->with('filters', $lists)->render());
        $this->content = view(config('settings.theme').'.admin.portfolios.portfolios_create_content')->with('filters', $lists)->render();
        // dd($lists);
        return $this->renderOutput();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PortfolioRequest $request)
    {
        $result = $this->p_rep->addPortfolio($request);

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
    public function edit( Portfolio $portfolio)
    {
        if (Gate::denies('EDIT_PORTFOLIOS') && Gate::denies('add', new Portfolio )) {
            adbort(403);
        }
        $this->title = 'Редактирование материал - '.$portfolio->title;
        $filters = \App\Models\Filter::select(['id', 'title', 'alias'])->get();

        $lists = [];
        foreach ($filters as $filter) {
            $lists[$filter->id] = $filter->title;
        }

        if (is_string($portfolio->img) && is_object(json_decode($portfolio->img)) && (json_last_error() == JSON_ERROR_NONE)) {
            $portfolio->img = json_decode($portfolio->img);
        }


        $this->content = view(config('settings.theme').'.admin.portfolios.portfolios_create_content')->with(['filters'=> $lists, 'portfolio'=>$portfolio])->render();
        // dd($lists);
        return $this->renderOutput();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PortfolioRequest $request, Portfolio $portfolio)
    {
        $result = $this->p_rep->updatePortfolio($request, $portfolio);

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
    public function destroy( Portfolio $portfolio)
    {
        $result = $this->p_rep->deletePortfolio($portfolio);

        if (is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }else{
            return redirect()->route('adminIndex')->with($result);
        }
    }
}
