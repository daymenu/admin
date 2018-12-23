<?php

namespace App\Http\Controllers\Api;

use App\Models\Menu;
use App\Models\MenuApi;
use Illuminate\Http\Request;
use App\Http\Requests\MenuRequest;
use App\Http\Controllers\Controller;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Menu $menu)
    {
        $search = $request->input('search');
        
        $menuModel = $menu->where(function($query) use ($search){
            if ($search) {
                $query->orWhere('title', 'like', '%' . $search . '%');
                $query->orWhere('name', 'like', '%' . $search . '%');
            }
        });
        $list = $menuModel->orderBy('id', 'desc')->paginate($request->input('limit'))->toArray();
        if ($list['data']) {
            $kv = $menu->kv();
            foreach ($list['data'] as $k => $item) {
                $list['data'][$k]['pName'] = isset($kv[$item['pId']]) ? $kv[$item['pId']] : '一级菜单';
                $list['data'][$k]['pIds'] = json_decode($item['pIds'], true);
            }
        }
        return $this->apiSuccess($list);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MenuRequest $request, Menu $menu)
    {
        $validated = $request->validated();
        $menu->pId = (int)$request->input('pId');
        $pIds = $request->input('pIds');
        $pIdsArr = $pIds ? $pIds : [];
        $menu->pIds = json_encode($pIdsArr);
        $menu->name = (string)$request->input('name');
        $menu->title = (string)$request->input('title');
        $menu->save();
        $names = $menu->kv([$menu->pId]);
        $menu->pName = isset($names[$menu->pId]) ? $names[$menu->pId] : '一级菜单';
        $menu->pIds = json_decode($menu->pIds, true);
        return $this->apiSuccess($menu);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show(Menu $menu)
    {
        return $this->apiSuccess($menu);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(MenuRequest $request, Menu $menu)
    {
        $validated = $request->validated();
        $menu->pId = (int)$request->input('pId');
        $pIds = $request->input('pIds');
        $pIdsArr = $pIds ? $pIds : [];
        $menu->pIds = json_encode($pIdsArr);
        $menu->name = (string)$request->input('name');
        $menu->title = (string)$request->input('title');
        $menu->save();
        $names = $menu->kv([$menu->pId]);
        $menu->pName = isset($names[$menu->pId]) ? $names[$menu->pId] : '一级菜单';
        $menu->pIds = json_decode($menu->pIds, true);
        return $this->apiSuccess($menu);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        $menu->delete();
        return $this->apiSuccess($menu);
    }

    /**
     * 菜单select框
     *
     * @param Menu $menu
     * @return void
     */
    public function tree(Menu $menu)
    {
        $menuRows = $menu->menuTree();
        return $this->apiSuccess($menuRows);
    }

    /**
     * 菜单对应的API
     *
     * @param Menu $menu
     * @return void
     */
    public function apis(Request $request, MenuApi $menuApi)
    {
        $menuId = $request->get('id');
        $apis = $menuApi->where('menu_id', $menuId)->pluck('api_id');
        return $this->apiSuccess($apis);
    }

    /**
     * 菜单对应的API
     *
     * @param Menu $menu
     * @return void
     */
    public function addApis(Request $request, MenuApi $menuApi)
    {
        $menuId = $request->input('menuId');
        $menuApi->where('menu_id', $menuId)->delete();
        $apis = $request->input('apis');
        if ($apis) {
            $insertData = [];
            foreach ($apis as $apiId) {
                $insertData[] = ['menu_id' => $menuId, 'api_id' => $apiId];
            }
            $menuApi->insert($insertData);
        }
        return $this->apiSuccess($apis);
    }
}
