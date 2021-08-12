<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\SliderRepository;
use App\Repositories\PortfolioRepository;
use App\Repositories\ArticlesRepository;
use Illuminate\Support\Arr;
use Config;
use Auth;
class IndexController extends SiteController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct (SliderRepository $s_rep, PortfolioRepository $p_rep, ArticlesRepository $a_rep) {
        parent::__construct( new \App\Repositories\MenusRepository(new \App\Models\Menu) );

        $this->template = config('settings.theme').'.index';
        $this->bar = 'right';

        $this->s_rep = $s_rep;
        $this->p_rep = $p_rep;
        $this->a_rep = $a_rep;
    }


    public function index()
    {
        // dump(Auth::user());
        $sliderItems = $this->getSliders();
        // dd($sliderItems);
        $sliders = view(config('settings.theme').'.sliders')->with('sliders', $sliderItems)->render();
        $this->vars = Arr::add($this->vars, 'sliders', $sliders);

        $portfolioItems = $this->getPortfolio();
        // dd($portfolioItems);
        $content = view(config('settings.theme').'.content')->with('portfolios', $portfolioItems)->render();
        $this->vars = Arr::add($this->vars, 'content', $content);

        $articles = $this->getArticles();
        // dd($articles);
        $this->contentRightBar = view(config('settings.theme').'.indexBar')->with('articles', $articles)->render();

        $this->keywords = 'Home Page';
        $this->meta_desc = 'Home Page';
        $this->title = 'Home Page';

        return $this->renderOutput();
    }

    private function getArticles () {
        $articles = $this->a_rep->get('*', Config::get('settings.home_articles_count'));

        return $articles;
    }

    private function getPortfolio() {
        $portfolio = $this->p_rep->get('*', Config::get('settings.home_port_count'));
        return $portfolio;
    }

    private function getSliders() {
        $sliders = $this->s_rep->get();
        if ($sliders->isEmpty()) {
            return false;
        }else {
            $sliders->transform( function($item, $key) {
                $item->img = Config::get('settings.slider_path')."/".$item->img;
                return $item;
            } );
        }
        // dd($sliders);
        return $sliders;
    }




}
