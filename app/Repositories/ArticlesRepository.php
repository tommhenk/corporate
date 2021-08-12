<?php

namespace App\Repositories;

use App\Models\Article;
use Gate;
use Image;
use Str;
use Config;
class ArticlesRepository extends Repository 
{
	public function __construct ( Article $articles ) {
		$this->model = $articles;
	}

	public function one($alias, $attr = []){
		$article = parent::one($alias, $attr);

		if ($article && !empty($attr)) {
			$article->load('comments');
			$article->comments->load('user');
		}
		return $article;
	}

	public function deleteArticle($article) {
		if ( Gate::denies('destroy', $article) ) {
			abort(403);
		}

		$article->comments()->delete();

		if ($article->delete()) {
			return ['status'=>'Материал удален'];
		}
	}

	public function updateArticle( $request, $article ){
		if ( Gate::denies('edit', $this->model) ) {
			abort(403);
		}
		$data = $request->except('_token', 'img', '_method');

		if (empty($data)) {
				return ['error'=>'нет данных'];
		}

		if ( empty($data['alias']) ) {
			$data['alias'] = $this->transliterate($data['title']);
		}
		// dd($request);
		$res = $this->one($data['alias'], false);
		if ( isset($res->id) && $res->id != $article->id) {
			$request->merge(['alias' => $data['alias']]);

			$request->flash();
			return ['error' => 'Данный псевдоним уже используеться'];
		}

		if ($request->hasFile('img')) {
			$image = $request->file('img');

			if ($image->isValid()) {
				$str = Str::random(8);
				$obj = new \stdClass;

				$obj->mini = $str.'_mini.jpg';
				$obj->max = $str.'_max.jpg';
				$obj->path = $str.'.jpg';

				$img = Image::make($image);

				$img->fit(Config::get('settings.image')['width'], 
					Config::get('settings.image')['height'])->
				save(public_path().'/'.config('settings.theme').'/images/articles/'.$obj->path);

				$img->fit(Config::get('settings.articles_img')['max']['width'], 
					Config::get('settings.articles_img')['max']['height'])->
				save(public_path().'/'.config('settings.theme').'/images/articles/'.$obj->max);

				$img->fit(Config::get('settings.articles_img')['mini']['width'], 
					Config::get('settings.articles_img')['mini']['height'])->
				save(public_path().'/'.config('settings.theme').'/images/articles/'.$obj->mini);

				$data['img'] = json_encode($obj);
				
			}
		}

		$article->fill($data);
		if ($article->update()) {
			return ['status'=>'Материал добавлен'];
		}
	}

	public function addArticle( $request ) {
		if ( Gate::denies('save', $this->model) ) {
			abort(403);
		}
		$data = $request->except('_token', 'img');

		if (empty($data)) {
				return ['error'=>'нет данных'];
		}

		if ( empty($data['alias']) ) {
			$data['alias'] = $this->transliterate($data['title']);
		}
		// dd($request);
		if ($this->one($data['alias'], false)) {
			$request->merge(['alias' => $data['alias']]);

			$request->flash();
			return ['error' => 'Данный псевдоним уже используеться'];
		}

		if ($request->hasFile('img')) {
			$image = $request->file('img');

			if ($image->isValid()) {
				$str = Str::random(8);
				$obj = new \stdClass;

				$obj->mini = $str.'_mini.jpg';
				$obj->max = $str.'_max.jpg';
				$obj->path = $str.'.jpg';

				$img = Image::make($image);

				$img->fit(Config::get('settings.image')['width'], 
					Config::get('settings.image')['height'])->
				save(public_path().'/'.config('settings.theme').'/images/articles/'.$obj->path);

				$img->fit(Config::get('settings.articles_img')['max']['width'], 
					Config::get('settings.articles_img')['max']['height'])->
				save(public_path().'/'.config('settings.theme').'/images/articles/'.$obj->max);

				$img->fit(Config::get('settings.articles_img')['mini']['width'], 
					Config::get('settings.articles_img')['mini']['height'])->
				save(public_path().'/'.config('settings.theme').'/images/articles/'.$obj->mini);

				$data['img'] = json_encode($obj);
				$this->model->fill($data);
				if ($request->user()->articles()->save($this->model)) {
					return ['status'=>'Материал добавлен'];
				}
			}
		}
	}
}