<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ApiRequest;
use App\Models\LoginRecord;
use App\Models\User;

class LoginRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, LoginRecord $loginRecord)
    {
        $serach = $request->input('search');
        $startTime = $request->input('startTime');
        $endTime = $request->input('endTime');

        $user = (new User())->getUserByName($serach);
        if ($serach && $user) {
            $loginRecord = $loginRecord->where('adminId', $user->id);
        } else if ($serach && !$user) {
            $loginRecord = $loginRecord->where('adminId', false);
        }
        if ($startTime) {
            $loginRecord = $loginRecord->where('created_at', '>', $startTime);
        }
        if ($endTime) {
            $loginRecord = $loginRecord->where('created_at', '<', $endTime);
        }
        $list = $loginRecord->orderBy('id', 'desc')->paginate($request->input('limit'))->toArray();
        
        if ($list['data']) {
            $kv = (new User())->kUser();
            foreach ($list['data'] as $k => $item) {
                $list['data'][$k]['userName'] = isset($kv[$item['adminId']]) ? $kv[$item['adminId']]->user_name : '';
                $list['data'][$k]['email'] = isset($kv[$item['adminId']]) ? $kv[$item['adminId']]->email : '';
                $list['data'][$k]['name'] = isset($kv[$item['adminId']]) ? $kv[$item['adminId']]->name : '';
                $list['data'][$k]['ip'] = long2ip($item['ip']);
            }
        }
        return $this->apiSuccess($list);
    }
}