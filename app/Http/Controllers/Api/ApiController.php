<?php

namespace App\Http\Controllers\Api;

use App\Models\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ApiRequest;

class ApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Api $api)
    {
        $search = $request->input('search');
        
        $api = $api->where(function($query) use ($search){
            if ($search) {
                $query->orWhere('name', 'like', '%' . $search . '%');
                $query->orWhere('route', 'like', '%' . $search . '%');
                $query->orWhere('url', 'like', '%' . $search . '%');
            }
        });
        $list = $api->orderBy('id', 'desc')->paginate($request->input('limit'))->toArray();
        if ($list['data']) {
            $kv = (new Api)->kv();
            foreach ($list['data'] as $k => $item) {
                $list['data'][$k]['pName'] = isset($kv[$item['pId']]) ? $kv[$item['pId']] : '';
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
    public function store(ApiRequest $request, Api $api)
    {
        $validated = $request->validated();
        $api->pId = (int)$request->input('pId');
        $pIds = $request->input('pIds');
        $pIdsArr = $pIds ? $pIds : [];
        $api->pIds = json_encode($pIdsArr);
        $api->name = (string)$request->input('name');
        $api->route = (string)$request->input('route');
        $api->url = (string)$request->input('url');
        $api->save();
        $names = $api->kv([$api->pId]);
        $api->pName = isset($names[$api->pId]) ? $names[$api->pId] : '';
        $api->pIds = json_decode($api->pIds, true);
        return $this->apiSuccess($api);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Api  $api
     * @return \Illuminate\Http\Response
     */
    public function show(Api $api)
    {
        return $this->apiSuccess($api);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Api  $api
     * @return \Illuminate\Http\Response
     */
    public function update(ApiRequest $request, Api $api)
    {
        $validated = $request->validated();
        $api->pId = (int)$request->input('pId');
        $pIds = $request->input('pIds');
        $pIdsArr = $pIds ? $pIds : [];
        $api->pIds = json_encode($pIdsArr);
        $api->name = (string)$request->input('name');
        $api->route = (string)$request->input('route');
        $api->url = (string)$request->input('url');
        $api->save();
        $names = $api->kv([$api->pId]);
        $api->pName = isset($names[$api->pId]) ? $names[$api->pId] : '';
        $api->pIds = json_decode($api->pIds, true);
        return $this->apiSuccess($api);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Api  $api
     * @return \Illuminate\Http\Response
     */
    public function destroy(Api $api)
    {
        $api->delete();
        return $this->apiSuccess($api);
    }
    /**
     * 菜单select框
     *
     * @param Menu $menu
     * @return void
     */
    public function tree(Api $api)
    {
        $rows = $api->apiTree();
        return $this->apiSuccess($rows);
    }
}
