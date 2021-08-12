<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Str;
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'site',
        'login'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function articles () {
        return $this->hasMany(Article::class);
    }

    public function comments () {
        return $this->hasMany(Comment::class);
    }

    public function roles() {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    public function hasRole ($name, $require = false) {
        if ( is_array($name) ) {
            foreach ($name as $rol) {
                $rolName = $this->hasRole($rol);
                if ($rolName && !$require) {
                    return true;
                } else if (!$rolName && $require) {
                    return $false;
                }
            }
            return $require;
        } else {
            foreach($this->roles as $rol) {
                if (Str::is($name, $rol->name)) {
                    return true;
                }
            }
            return false;
        }
    }

    public function canDo($permission, $require = false) {

        if ( is_array($permission) ) {
            foreach ($permission as $permName) {
                $permName = $this->canDo($permName);
                if ($permName && !$require) {
                    return true;
                } else if (!$permName && $require) {
                    return false;
                }
            }
            return $require;
        } else {

            foreach ($this->roles as $role) {

                foreach($role->perms as $perm) {
                    if ( Str::is($permission, $perm->name) ) {
                        return true;
                    }
                }
            }
        }
    }
}
