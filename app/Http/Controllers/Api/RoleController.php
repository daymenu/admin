<?php

namespace App\Http\Controllers\Api;

use App\Models\Role;
use App\Models\MenuApi;
use App\Models\RoleMenu;
use Illuminate\Http\Request;
use App\Http\Requests\RoleRequest;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Role $role)
    {
        $search = $request->input('search');
        if ($search) {
            $role = $role->where('name', 'like', '%' . $search . '%');
        }
        $list = $role->orderBy('id', 'desc')->paginate($request->input('limit'));

        return $this->apiSuccess($list);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request, Role $role)
    {
        $validated = $request->validated();
        $role->name = (string)$request->input('name');
        $menus = $request->input('menuIds');
        $role->save();

        $roleMenu = new RoleMenu();
        $insertData = [];
        if ($menus) {
            foreach ($menus as $menuId) {
                $insertData[] = [
                    'role_id' => $role->id,
                    'menu_id' => $menuId
                ];
            }
        }
        $roleMenu->insert($insertData);
        return $this->apiSuccess($role);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Api  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return $this->apiSuccess($role);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Api  $role
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, Role $role)
    {
        $validated = $request->validated();
        $role->name = (string)$request->input('name');
        $menus = $request->input('menuIds');
        $role->save();
        $roleMenu = new RoleMenu();
        $roleMenu->where('role_id', $role->id)->delete();
        $insertData = [];
        if ($menus) {
            foreach ($menus as $menuId) {
                $insertData[] = [
                    'role_id' => $role->id,
                    'menu_id' => $menuId
                ];
            }
        }
        $roleMenu->insert($insertData);
        return $this->apiSuccess($role);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Api  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return $this->apiSuccess($role);
    }
    /**
     * 菜单对应的API
     *
     * @param Menu $menu
     * @return void
     */
    public function menuIds(Request $request, RoleMenu $roleMenu)
    {
        $id = $request->get('roleId');
        $data = $roleMenu->where('role_id', $id)->pluck('menu_id');
        return $this->apiSuccess($data);
    }

    public function kv(Role $role)
    {
        return $this->apiSuccess($role->kv());
    }
}
