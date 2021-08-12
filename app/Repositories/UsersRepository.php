<?php

namespace App\Repositories;

use App\Models\User;
use Gate;
use Auth;

class UsersRepository extends Repository 
{
	public function __construct ( User $user ) {
		$this->model = $user;
	}

	public function destroyUser($user) {
		if (Gate::denies('destroy', $this->model)) {
			abort(403);
		}

		$user->roles()->detach();
		if ($user->delete()) {
			return ['status'=>"Пользователь удален"];
		}
	}

	public function updateUser ($request, $user) {
		// dd(Gate::denies('save', $this->model));
		if (Gate::denies('save', $this->model)) {
			abort(403);
		}

		$data = $request->all();

		if (empty($data)) {
			return ['error'=>"Нет данных"];
		}
		if (isset($data['password'])) {
			$data['password'] = bcript($data['password']);
		}else{
			$data['password'] = $user->password;
		}

		$user->fill($data)->update();
		$user->roles()->sync($data['role_id']);
		return ['status'=>"Пользователь  изменен"];
	}

	public function addUser ($request) {
		// dd(Gate::denies('save', $this->model));
		if (Gate::denies('save', $this->model)) {
			abort(403);
		}

		$data = $request->all();

		if (empty($data)) {
			return ['error'=>"Нет данных"];
		}
		
		$user = $this->model->create([
			'name'=>$data['name'],
			'login'=>$data['login'],
			'email'=>$data['email'],
			'password'=>bcrypt($data['password']),
		]);
		if ($user) {
			$user->roles()->attach($data['role_id']);
		}
		return ['status'=>"Пользователь добавлен"];
	}
}