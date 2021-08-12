<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Str;

class Role extends Model
{
    use HasFactory;

    public function users () {
        return $this->belongsToMany(User::class, 'role_user');
    }

    public function perms () {
        return $this->belongsToMany(Permission::class, 'permission_role');
    }

    public function savePermission( $inputPermission ) {
        if (!empty($inputPermission)) {
            $this->perms()->sync($inputPermission);
        } else {
            $this->perms()->detach();
        }
        return true;
    }

    public function hasPermission ($name, $require = false) {
        if ( is_array($name) ) {
            foreach ($name as $perm) {
                $permName = $this->hasPermission($perm);
                if ($permName && !$require) {
                    return true;
                } else if (!$permName && $require) {
                    return $false;
                }
            }
            return $require;
        } else {
            foreach($this->perms as $permission) {
                if (Str::is($name, $permission->name)) {
                    return true;
                }
            }
            return false;
        }
    }
}
