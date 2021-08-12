<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Admin\AdminController;
use App\Repositories\UsersRepository;
use App\Repositories\RoleRepository;
use Gate;
use Auth;
use App\Models\Category;
use App\Models\Article;

class UsersController extends AdminController
{
    protected $u_rep;
    protected $rol_rep;

    public function __construct ( UsersRepository $u_rep, RoleRepository $rol_rep ) {
        parent::__construct();

        $this->middleware(function ( $request, $next ) {
            if ( Gate::denies('ADMIN_USERS') ) {
                abort(403);
            }
            return $next($request);
        });

        $this->u_rep = $u_rep;
        $this->rol_rep = $rol_rep;
        $this->template = config('settings.theme').'.admin.users.users';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::denies('ADMIN_USERS')) {
            abort(403);
        }

        $users = $this->getUsers();
        $this->content = view(config('settings.theme').'.admin.users.users_index_content')->with('users', $users)->render();

        return $this->renderOutput();
    }

    public function getUsers() {
        $users = $this->u_rep->get();
        if ($users) {
            $users->load('roles');
        }
        if($users){
            $users->transform(function($us, $ind){
                // dd($us->roles);
                if ($us->roles) {
                    
                    $str = '';
                    foreach ($us->roles as $role) {
                        $str .= $role->name.', ';
                    }
                    $str = trim($str, ', ');
                    $us->roles = $str;
                }
                
                return $us;
            });
        }
        return $users;
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('EDIT_USERS')) {
            abort(403);
        }
        $this->title = 'Добавить нового пользователя';
        $roles = $this->getRoles();
        
        $this->content = view(config('settings.theme').'.admin.users.users_create_content')->with('roles', $roles)->render();

        

        return $this->renderOutput();
    }

    public function getRoles() {
        $rolesCollection = $this->rol_rep->get();
        
        $roles = $rolesCollection->reduce(function ($returnRoles, $role){
            $returnRoles[$role->id] = $role->name;
            return $returnRoles;
        }, []);
        return $roles;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $result = $this->u_rep->addUser($request);

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
    public function edit(\App\Models\User $user)
    {
        if (Gate::denies('EDIT_USERS')) {
            abort(403);
        }
        $this->title = 'Добавить нового пользователя';
        $roles = $this->getRoles();
        // dd($user->roles->first());
        $this->content = view(config('settings.theme').'.admin.users.users_create_content')->with(['roles' => $roles, 'user'=>$user])->render();

        

        return $this->renderOutput();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, \App\Models\User $user)
    {
        $result = $this->u_rep->updateUser($request, $user);

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
    public function destroy(\App\Models\User $user)
    {
        $result = $this->u_rep->destroyUser($user);

        if (is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }else{
            return redirect()->route('adminIndex')->with($result);
        }
    }
}
