<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use App\Repositories\ArticlesRepository;
use Gate;
use Auth;
use App\Models\Category;
use App\Http\Requests\ArticleRequest;
use App\Models\Article;
class ArticlesController extends AdminController
{
        public function __construct ( ArticlesRepository $a_rep) {
        parent::__construct();

        $this->middleware(function ( $request, $next ) {
            if ( Gate::denies('VIEW_ADMIN_ARTICLES', $this->user) ) {
                abort(403);
            }
            return $next($request);
        });

        $this->a_rep = $a_rep;
        $this->template = config('settings.theme').'.admin.articles';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->title = 'Менеджер статей';
        $articles = $this->getArticles();
        $this->content = view(config('settings.theme').'.admin.articles_content')->with('articles', $articles)->render();
        // dd(view()->exists($this->template));
        // $check = view($this->template)->render();
        // dd($check);
        return $this->renderOutput();
    }

    public function getArticles() {
        $articles = $this->a_rep->get();
        return $articles;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('save', new  \App\Models\Article)) {
            abort(403);
        }
        $this->title = 'Добавить новый материал';
        $categories = Category::select(['id', 'parent_id', 'title', 'alias'])->get();
        $lists = [];
        foreach ($categories as $category) {
            if ($category->parent_id == 0) {
                
                $lists[$category->title] = [];
            } else {

                $lists[$categories->where('id', $category->parent_id)->first()->title][$category->id] = $category->title;
            }
        }
        $this->content = view(config('settings.theme').'.admin.articles_create_content')->with('categories', $lists)->render();
        // dd($lists);
        return $this->renderOutput();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleRequest $request)
    {
        $result = $this->a_rep->addArticle($request);

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
    public function edit( Article $article, Request $request)
    {
        // $article = Article::where('alias', $alias)->first();
        $this->title = 'Редактирование матирала - '.$article->title;
        if ( Gate::denies('edit', new Article) ) {
            abort(403);
        }
        $article->img = json_decode($article->img);

        $categories = Category::select(['id', 'parent_id', 'title', 'alias'])->get();
        $lists = [];
        foreach ($categories as $category) {
            if ($category->parent_id == 0) {
                
                $lists[$category->title] = [];
            } else {

                $lists[$categories->where('id', $category->parent_id)->first()->title][$category->id] = $category->title;
            }
        }

        $this->content = view(config('settings.theme').'.admin.articles_create_content')->with(['categories'=>$lists, 'article'=>$article])->render();

        return $this->renderOutput();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ArticleRequest $request, Article $article)
    {
        $result = $this->a_rep->updateArticle($request, $article);

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
    public function destroy(Article $article)
    {
        // dd($article);
        $result = $this->a_rep->deleteArticle($article);

        if (is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }else{
            return redirect()->route('adminIndex')->with($result);
        }
    }
}
