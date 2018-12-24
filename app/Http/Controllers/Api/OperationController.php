<?php

namespace App\Http\Controllers\Api;

use App\Models\Api;
use App\Models\User;
use App\Models\Operation;
use App\Models\LoginRecord;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OperationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Operation $operation)
    {
        $serach = $request->input('search');
        $startTime = $request->input('startTime');
        $endTime = $request->input('endTime');

        $user = (new User())->getUserByName($serach);
        if ($serach && $user) {
            $operation = $operation->where('admin_id', $user->id);
        } else if ($serach && !$user) {
            $operation = $operation->where('admin_id', false);
        }
        if ($startTime) {
            $operation = $operation->where('created_at', '>', $startTime);
        }
        if ($endTime) {
            $operation = $operation->where('created_at', '<', $endTime);
        }
        $list = $operation->orderBy('id', 'desc')->paginate($request->input('limit'))->toArray();

        if ($list['data']) {
            $kv = (new User())->kUser();
            $apiKv = (new Api())->kv();
            foreach ($list['data'] as $k => $item) {
                $list['data'][$k]['userName'] = isset($kv[$item['admin_id']]) ? $kv[$item['admin_id']]->user_name : '';
                $list['data'][$k]['email'] = isset($kv[$item['admin_id']]) ? $kv[$item['admin_id']]->email : '';
                $list['data'][$k]['name'] = isset($kv[$item['admin_id']]) ? $kv[$item['admin_id']]->name : '';
                $opNames = [];
                $opArr = json_decode($item['api_ids'], true);
                foreach ($opArr as $apiId) {
                    if (isset($apiKv[$apiId])) {
                        $opNames[] = $apiKv[$apiId];
                    }

                }
                $list['data'][$k]['operation'] = implode('>', $opNames);
                $list['data'][$k]['ip'] = long2ip($item['ip']);
            }
        }
        return $this->apiSuccess($list);
    }
}