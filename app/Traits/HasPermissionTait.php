<?php
namespace App\Trait;
use App\Models\Persmission;
use App\Models\Role;
use App\Models\User;


trait HasPermissionTait
{
    public function getAllPermissions($permission){

        //get permission
        return Persmission::whereIn('slug', $permission)->get();
    }

    //check permission
    public function hasPermission($permission)
    {
        return (bool) $this->permission->where('slug', $permission->slug)->count();
    }

    public function hasRole($roles)
    {
        foreach($roles as $role)
        {
            if($this->roles->contains('slug' ,$slug)){
                return true;
            }
            return false;
        }
    }

    public function hasPermissionTo($permission)
    {
        return $this->hasPermissionThroughRole($permission) || $this->hasPermission($permission);

    }
    public function givePermission($permission)
    {
        $permission = $this->getAllPermissions($permission);

        if($permission == null )
        {
            return $this;
        }
        $this->permission()->saveMany($permission);
        return $this; 
    }


    public function hasPermissionThroughRole($permission)
    {
        foreach ($permission->roles as $role)
        {
            if($this->roles->containes($role))
            {
                return true;
            }
            return false;
        }
    }

    public function permission()
    {
        return $this->belongsTomany(Persmission::class, 'users_permisions');
    }

    public function roles()
    {
        return $this->belongsTomany(Role::class, 'roles_permissions');
    }

}
