<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\PortfolioRepository;

use App\Models\Category;

use Illuminate\Support\Arr;
use Config;

class PortfolioController extends SiteController
{
    public function __construct ( PortfolioRepository $p_rep) {
        parent::__construct( new \App\Repositories\MenusRepository(new \App\Models\Menu) );

        $this->template = config('settings.theme').'.portfolio.portfolio';

        $this->p_rep = $p_rep;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $portfolios = $this->getPortfolios();
        // dd($portfolios);
        $content = view(config('settings.theme').'.portfolio.content_portfolios')->with('portfolios', $portfolios)->render();
        $this->vars = Arr::add($this->vars, 'content', $content);

        $this->keywords = 'Портфолио';
        $this->meta_desc = 'Портфолио';
        $this->title = 'Портфолио';

        return $this->renderOutput();
    }

    protected function getPortfolios($take = false, $paginate = true) {
        $portfolios = $this->p_rep->get('*', $take, $paginate);
        if ($portfolios) {
            $portfolios->load('filter');
        }
        return $portfolios;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($alias)
    {
        $portfolios = $this->getPortfolios(config('settings.other_portfolios'), false);
        $portfolio = $this->p_rep->one($alias);
        
        // dd($portfolio);
        $content = view(config('settings.theme').'.portfolio.content_portfolio')->with(['portfolio'=>$portfolio, 'portfolios'=>$portfolios])->render();

        $this->vars = Arr::add($this->vars, 'content', $content);

        $this->keywords = $portfolio->keywords ? $portfolio->keywords : '';
        $this->meta_desc = $portfolio->meta_desc ? $portfolio->meta_desc : '';
        $this->title = $portfolio->tilte ? $portfolio->title : '';

        return $this->renderOutput();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
