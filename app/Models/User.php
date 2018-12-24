<?php

namespace App\Models;

use App\Models\Api;
use App\Models\MenuApi;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens, SoftDeletes;

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

        $allIds = [];
        foreach ($menuIds as $menuId) {
            $allIds[$menuId] = $menuId;
            $pIds = $this->findParendIds($menuKv, $menuId);
            if ($pIds) {
                $allIds = $allIds + $pIds;
            }
        }
        $priMenus = [];
        foreach ($allIds as $id) {
            $priMenus[] = $menuKv[$id]->name;
        }
        return $priMenus;
    }

    public function findParendIds($menus, $menuId)
    {
        $menuIds[$menuId] = $menuId;
        if ($menus[$menuId]->pId == 0) {
            return $menuIds;
        } else {
            $menuIds[$menus[$menuId]->pId] = $menus[$menuId]->pId;
            $pIds = $this->findParendIds($menus, $menus[$menuId]->pId);
            if ($pIds) {
                $menuIds = $menuIds + $pIds;
            }
            return $menuIds;
        }
    }

    public function allMenuIds($userId)
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

        $allIds = [];
        foreach ($menuIds as $menuId) {
            $allIds[$menuId] = $menuId;
            $pIds = $this->findParendIds($menuKv, $menuId);
            if ($pIds) {
                $allIds = $allIds + $pIds;
            }
        }
        return $allIds;
    }

    public function apis($userId)
    {
        $menuIds = $this->allMenuIds($userId);
        $menuApi = new MenuApi();
        $apiIds = $menuApi->whereIn('menu_id', $menuIds)->pluck('api_id');
        $api = new Api();
        return $api->whereIn('id', $apiIds)->pluck('route')->toArray();

    }

    public function kv($ids = [])
    {
        if ($ids) {
            $this->whereIn('id', $ids);
        }
        $data = $this->select('id', 'name')->get();
        $kv = [];
        if ($data) {
            foreach ($data as $item) {
                $kv[$item->id] = $item->name;
            }
        }
        return $kv;
    }

    public function kUser($ids = [])
    {
        if ($ids) {
            $this->whereIn('id', $ids);
        }
        $data = $this->get();
        $kv = [];
        if ($data) {
            foreach ($data as $item) {
                $kv[$item->id] = $item;
            }
        }
        return $kv;
    }

    public function getUserByName($name)
    {
        if (!$name) {
            return false;
        }

        $user = $this->where(function ($query) use ($name) {
            $query->orWhere('user_name', 'like', '%'.$name.'%');
            $query->orWhere('email', 'like', '%'.$name.'%');
        });

        return $user->first();
    }
}
