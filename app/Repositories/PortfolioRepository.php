<?php

namespace App\Repositories;

use App\Models\Portfolio;
use Gate;
use Image;
use Config;
use Str;
class PortfolioRepository extends Repository 
{
	public function __construct ( Portfolio $sportfolio ) {
		$this->model = $sportfolio;
	}

	public function one ($alias, $attr = []) {
		$portfolio = parent::one($alias, $attr);

		if ($portfolio && $portfolio->img) {
            $portfolio->img = json_decode($portfolio->img);
        }
        return $portfolio;
	}

	public function deletePortfolio($portfolio) {
		if ( Gate::denies('edit', $portfolio) ) {
			abort(403);
		}

		if ($portfolio->delete()) {
			return ['status'=>'Материал удален'];
		}
	}

	public function addPortfolio( $request ) {
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
				save(public_path().'/'.config('settings.theme').'/images/projects/'.$obj->path);

				$img->fit(Config::get('settings.portfolios_img')['max']['width'], 
					Config::get('settings.portfolios_img')['max']['height'])->
				save(public_path().'/'.config('settings.theme').'/images/projects/'.$obj->max);

				$img->fit(Config::get('settings.portfolios_img')['mini']['width'], 
					Config::get('settings.portfolios_img')['mini']['height'])->
				save(public_path().'/'.config('settings.theme').'/images/projects/'.$obj->mini);

				$data['img'] = json_encode($obj);
				$this->model->fill($data);
				if ($this->model->save()) {
					return ['status'=>'Материал добавлен'];
				}
			}
		}
	}

	public function updatePortfolio( $request, $portfolio ){
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
		if ( isset($res->id) && $res->id != $portfolio->id) {
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
				save(public_path().'/'.config('settings.theme').'/images/projects/'.$obj->path);

				$img->fit(Config::get('settings.portfolios_img')['max']['width'], 
					Config::get('settings.portfolios_img')['max']['height'])->
				save(public_path().'/'.config('settings.theme').'/images/projects/'.$obj->max);

				$img->fit(Config::get('settings.portfolios_img')['mini']['width'], 
					Config::get('settings.portfolios_img')['mini']['height'])->
				save(public_path().'/'.config('settings.theme').'/images/projects/'.$obj->mini);

				$data['img'] = json_encode($obj);
				
			}
		}

		$portfolio->fill($data);
		if ($portfolio->update()) {
			return ['status'=>'Материал отредактирован'];
		}
	}
}