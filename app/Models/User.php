<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable,HasApiTokens,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function menuIds($userId)
    {
        
        $userRole = new UserRole();
        $roleMenu = new RoleMenu();
        $menu = new Menu();
        $roleIds = $userRole->where('user_id', $userId)->pluck('role_id');
        $menuIds = $roleMenu->whereIn('role_id', $roleIds)->pluck('menu_id')->toArray();
        $menus = $menu->select('id', 'pId', 'name')->get();
        $menuKv = [];
        foreach ($menus as $item) {
            $menuKv[$item->id] = $item;
        }
        $allIds = $menuIds;
        foreach ($menuIds as $menuId) {
            $pIds = $this->findParendIds($menuKv, $menuId);
            if ($pIds) {
                $allIds  =  $allIds + $pIds;
                var_dump($pIds);
            }
        }
        var_dump($allIds);die();
        $priMenus = [];
        foreach ($allIds as $id) {
            $priMenus[] = $menuKv[$id];
        }
        return $priMenus;
    }

    public function findParendIds($menus, $menuId)
    {
        $menuIds = [$menuId];
        if ($menus[$menuId]->pId == 0) {
            return $menuIds;
        } else {
            $menuIds[] = $menus[$menuId]->pId;
            $pIds = $this->findParendIds($menus, $menus[$menuId]->pId);
            
            if ($pIds) {
                $menuIds += $pIds;
            }
            return $menuIds;
        }
    }
}
