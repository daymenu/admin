<?php

namespace App\Http\Controllers\Api;

use App\Models\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ApiRequest;
use DB;
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
        DB::enableQueryLog();
        if($search){
            $api = $api->where('name', 'like', '%' . $search . '%');
        }
        $list = $api->paginate($request->input('limit'));
        //dd(DB::getQueryLog());
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
        $api->route = (string)$request->input('route');
        $api->url = (string)$request->input('url');
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
        $api->route = (string)$request->input('route');
        $api->url = (string)$request->input('url');
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
