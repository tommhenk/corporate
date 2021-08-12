<?php

namespace App\Repositories;
use App\Models\Permission;
use Gate;
class PermissionRepository extends Repository 
{
	protected $rol_rep;
	public function __construct ( Permission $permission, RoleRepository $rol_rep ) {
		$this->model = $permission;

		$this->rol_rep = $rol_rep;
	}

	public function changePermission($request) {
		if (Gate::denies('change', $this->model)) {
			abort(403);
		}

		$data = $request->except('_token');

		$roles = $this->rol_rep->get();

		foreach ($roles as $value) {
			if (isset($data[$value->id])) {
				$value->savePermission($data[$value->id]);
			} else {
				$value->savePermission([]);
			}
		}
		return ['status'=>'Права обновлены'];
	}


}