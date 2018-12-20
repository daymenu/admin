<?php

namespace App\Http\Controllers\Api;

use App\Models\Role;
use Illuminate\Http\Request;
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
    public function store(ApiRequest $request, Api $api)
    {
        $validated = $request->validated();
        $api->name = (string)$request->input('name');
        $menus = $request->input('menus');
        $api->save();
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
        $api->name = (string)$request->input('name');
        $menus = $request->input('menus');
        $api->save();
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
}
