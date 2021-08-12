<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\PortfolioRepository;
use App\Repositories\ArticlesRepository;
use App\Repositories\CommentsRepository;

use App\Models\Category;

use Illuminate\Support\Arr;
use Config;

// use App\Models\Article;


class ArticlesController extends SiteController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct ( CommentsRepository $c_rep, PortfolioRepository $p_rep, ArticlesRepository $a_rep) {
        parent::__construct( new \App\Repositories\MenusRepository(new \App\Models\Menu) );

        $this->template = config('settings.theme').'.articles.articles';
        $this->bar = 'right';

        $this->p_rep = $p_rep;
        $this->a_rep = $a_rep;
        $this->c_rep = $c_rep;
    }


    public function index($cat_alias = false)
    {

        $articles = $this->getArticles($cat_alias);
        // dd($articles[0]->category);
        $content = view(config('settings.theme').'.articles.articles_content')->with('articles', $articles)->render();
        $this->vars = Arr::add($this->vars, 'content', $content);

        $comments = $this->getComments(config('settings.resent_comments'));
        $portfolios = $this->getPortfolios(config('settings.resent_portfolios'));
        // dd($portfolios);
        $this->contentRightBar = view(config('settings.theme').'.articles.articlesBar')->with(['comments'=>$comments, 'portfolios' => $portfolios]);

        $this->keywords = 'Articles Page';
        $this->meta_desc = 'Articles Page';
        $this->title = 'Articles Page';

        return $this->renderOutput();
    }

    public function getComments ( $take ) {
        $comments = $this->c_rep->get('*', $take);
        if ($comments) {
            $comments->load('user', 'article');
        }
        return $comments;
    } 

    public function getPortfolios ( $take ) {
        $portfolios = $this->p_rep->get('*', $take);

        return $portfolios;
    }

    public function getArticles($alias = false) {
        $where = false;
        if($alias) {
            $id = Category::select('id')->where('alias', $alias)->first()->id;
            // dd($id);
            $where = ['category_id', $id];
        }


        $articles = $this->a_rep->get('*', false, true, $where);
        if ($articles) {
            $articles->load('user', 'category','comments');
        }
        return $articles;
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
        
        $comments = $this->getComments(config('settings.resent_comments'));
        $portfolios = $this->getPortfolios(config('settings.resent_portfolios'));
        // dd($portfolios);
        $this->contentRightBar = view(config('settings.theme').'.articles.articlesBar')->with(['comments'=>$comments, 'portfolios' => $portfolios]);
        // dd($alias);
        if (!is_object($alias)) {
            return back();
        }
        $article = $this->a_rep->one($alias->alias, ['comments'=>true]);
        // dd($alias);
        if ($article) {
            $article->img = json_decode($article->img);
        }
        // dd($article->comments->groupBy('parent_id'));
        $content = view(config('settings.theme').'.article.article_content')->with('article', $article)->render();

        $this->vars = Arr::add($this->vars, 'content', $content);

        $this->keywords = $article->keywords ? $article->keywords : '';
        $this->meta_desc = $article->meta_desc ? $article->meta_desc : '';
        $this->title = $article->tilte ? $article->title : '';

        return $this->renderOutput();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($alias)
    {

        
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
