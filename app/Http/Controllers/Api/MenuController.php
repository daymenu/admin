<?php

namespace App\Http\Controllers\Api;

use App\Models\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\MenuRequest;
use DB;

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
        if ($search) {
            $menu = $menu->where('name', 'like', '%' . $search . '%');
        }
        $list = $menu->orderBy('id', 'desc')->paginate($request->input('limit'))->toArray();
        $kv = $menu->kv();
        foreach ($list['data'] as $k => $item) {
            $list['data'][$k]['pName'] = isset($kv[$item['pId']]) ? $kv[$item['pId']] : '一级菜单';
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
        $menu->name = (string)$request->input('name');
        $menu->title = (string)$request->input('title');
        $menu->save();
        $names = $menu->kv([$menu->pId]);
        $menu->pName = isset($names[$menu->pId]) ? $names[$menu->pId] : '一级菜单';
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
        $menu->name = (string)$request->input('name');
        $menu->title = (string)$request->input('title');
        $menu->save();
        $names = $menu->kv([$menu->pId]);
        $menu->pName = isset($names[$menu->pId]) ? $names[$menu->pId] : '一级菜单';
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
    public function menuSelect(Menu $menu)
    {
        $menuRows = $menu->menuTree();
        return $this->apiSuccess($menuRows);
    }

}
