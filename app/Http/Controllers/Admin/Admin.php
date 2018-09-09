<?php

namespace App\Http\Controllers\Admin;

use App\Model\Admin\AdminModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Admin extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin/admin/index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Admin\AdminModel  $adminModel
     * @return \Illuminate\Http\Response
     */
    public function show(AdminModel $adminModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Admin\AdminModel  $adminModel
     * @return \Illuminate\Http\Response
     */
    public function edit(AdminModel $adminModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Admin\AdminModel  $adminModel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AdminModel $adminModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Admin\AdminModel  $adminModel
     * @return \Illuminate\Http\Response
     */
    public function destroy(AdminModel $adminModel)
    {
        //
    }
}
