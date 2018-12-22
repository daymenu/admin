<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;
use App\Http\Requests\UsersPut;
use App\Http\Requests\UsersPost;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, User $user)
    {
        $search = $request->input('search');
        $user->where(function($query) use ($search){
            if ($search) {
                $query->where('name', 'like', '%' . $search . '%');
                $query->where('email', 'like', '%' . $search . '%');
            }
        });
        $list = $user->orderBy('id', 'desc')->paginate($request->input('limit'));
        return $this->apiSuccess($list);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsersPost $request, User $user)
    {
        $validated = $request->validated();
        $user->nick_name = (string)$request->input('nick_name');
        $user->name = (string)$request->input('name');
        $user->email = (string)$request->input('email');
        $user->user_name = (string)$request->input('user_name');
        $user->password = (string)$request->input('password');
        $user->save();

        $roles = $request->input('roles');
        if ($roles) {
            $userRole = new UserRole();
            $insertData = [];
            foreach ($roles as $roleId) {
                $insertData[] = [
                    'user_id' => $user->id,
                    'role_id' => $roleId
                ];
            }
            $userRole->insert($insertData);
        }
        return $this->apiSuccess($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user, UserRole $userRole)
    {
        $roles = $userRole->where('user_id', $user->id)->select('role_id')->get()->toArray();
        if ($user) {
            $user->roles = array_column($roles, 'role_id');
            $user->roles = array_map(function($id){return (string)$id;}, $user->roles);
        }
        return $this->apiSuccess($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UsersPut $request, User $user)
    {
        $validated = $request->validated();
        $user->nick_name = (string)$request->input('nick_name');
        $user->name = (string)$request->input('name');
        $user->email = (string)$request->input('email');
        $user->user_name = (string)$request->input('user_name');
        if ($request->input('password')) {
            $user->password = (string)$request->input('password');
        }
        $user->save();

        $userRole = new UserRole();
        $userRole->where('user_id', $user->id)->delete();
        $roles = $request->input('roles');
        if ($roles) {
            $insertData = [];
            foreach ($roles as $roleId) {
                $insertData[] = [
                    'user_id' => $user->id,
                    'role_id' => $roleId
                ];
            }
            $userRole->insert($insertData);
        }

        return $this->apiSuccess($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if($user){
            $user->delete();
            return $this->apiSuccess();
        }else{
            return $this->apiFaild('用户不存在');
        }
    }

    /**
     * 获取当前登录用户的信息
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function info(Request $request)
    {
        return $this->apiSuccess($request->user());
    }
}
