<?php

namespace App\Repositories;

use App\Models\Menu;
use Gate;
use Auth;

class MenusRepository extends Repository 
{
	public function __construct ( Menu $menu ) {
		$this->model = $menu;
	}

	public function destroyMenu($menu) {
		if (Gate::denies('destroy', $this->model)) {
			abort(403);
		}
		if ($menu->delete()) {
			return ['status'=>"Ссылка удалена"];
		}
	}

	public function updateMenu ($request, $menu) {
		// dd(Gate::denies('save', $this->model));
		if (Gate::denies('save', $this->model)) {
			abort(403);
		}

		$data = $request->only('type', 'title', 'parent_id');

		if (empty($data)) {
			return ['error'=>"Нет данных"];
		}
		// dd($request->all());
		switch($data['type']) {
			case 'customLink':
				$data['path'] = $request->input('custom_link');
			break;

			case 'blogLink':
				if ($request->input('category_alias')) {
					if ($request->input('category_alias') == 'parent') {
						$data['path'] = route('articles.index');
					}
					else {
						$data['path'] = route('articlesCat', ['cat_alias'=> $request->input('category_alias')]);
					}
				}

				else if ( $request->input('article_alias') ) {
					$data['path'] = route('articles.show', ['alias'=> $request->input('article_alias') ]);
				}
			break;

			case 'portfolioLink':
				if ($request->input('filter_alias')) {
					if ($request->input('filter_alias') == 'parent') {
						$data['path'] = route('portfolio.index');
					}
				}
				else if ($request->input('portfolio_alias')) {
					$data['path'] = route('portfolio.show',['alias'=>$request->input('portfolio_alias')]);
				}
			break;
			default:
			if(empty($data['path'])){
				return back()->with('error', 'Путь на ссылку не сформирован');
			}
		}
		// dd($data);
		unset($data['type']);

		if($menu->fill($data)->update()) {
			return ['status'=>'Ссылка обновлена'];
		}
		dd($data);
	}

	public function addMenu ($request) {
		// dd(Gate::denies('save', $this->model));
		if (Gate::denies('save', $this->model)) {
			abort(403);
		}

		$data = $request->only('type', 'title', 'parent_id');

		if (empty($data)) {
			return ['error'=>"Нет данных"];
		}
		// dd($request->all());
		switch($data['type']) {
			case 'customLink':
				$data['path'] = $request->input('custom_link');
			break;

			case 'blogLink':
				if ($request->input('category_alias')) {
					if ($request->input('category_alias') == 'parent') {
						$data['path'] = route('articles.index');
					}
					else {
						$data['path'] = route('articlesCat', ['cat_alias'=> $request->input('category_alias')]);
					}
				}

				else if ( $request->input('article_alias') ) {
					$data['path'] = route('articles.show', ['alias'=> $request->input('article_alias') ]);
				}
			break;

			case 'portfolioLink':
				if ($request->input('filter_alias')) {
					if ($request->input('filter_alias') == 'parent') {
						$data['path'] = route('portfolio.index');
					}
				}
				else if ($request->input('portfolio_alias')) {
					$data['path'] = route('portfolio.show',['alias'=>$request->input('portfolio_alias')]);
				}
			break;
			default:
			if(empty($data['path'])){
				return back()->with('error', 'Путь на ссылку не сформирован');
			}
		}
		// dd($data);
		unset($data['type']);
		if($this->model->fill($data)->save()) {
			return ['status'=>'Ссылка добавлена'];
		}
		dd($data);
	}
}