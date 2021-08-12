<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Controllers\Admin\AdminController;
use App\Repositories\PermissionRepository;
use App\Repositories\RoleRepository;
use Gate;
use Auth;

class PermissionController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $per_rep;
    protected $rol_rep;
    public function __construct(PermissionRepository $per_rep, RoleRepository $rol_rep) {
        parent::__construct();

        $this->middleware(function ($request, $next) {
            // dd(Auth::user());
            if (Gate::denies('EDIT_USERS', Auth::user())) {
                abort(403);
            }
            return $next($request);
        });
        $this->per_rep = $per_rep;
        $this->rol_rep = $rol_rep;
        $this->template = config('settings.theme').'.admin.permissions.permissions';
    }

    public function index()
    {
        $this->title = 'Менеджер привелегий пользователя';
        $roles = $this->getRoles();
        $permissions = $this->getPermissions();

        $this->content = view(config('settings.theme').'.admin.permissions.permissions_content')->with(['roles'=>$roles, 'perms'=>$permissions])->render();
        // dd($permissions);

        return $this->renderOutput();
    }

    public function getRoles() {
        $roles = $this->rol_rep->get();
        return $roles;
    }

    public function getPermissions() {
        $permissions = $this->per_rep->get();
        return $permissions;
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
        $result = $this->per_rep->changePermission($request);

        if (is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }

        return back()->with($result);
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
