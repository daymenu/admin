<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{
    public function record($data)
    {
        $this->ip = ip2long($data['ip']);
        $this->admin_id = $data['adminId'];
        $api = new Api();
        $current = $api->where('route', $data['route'])->first();
        $pIds = [];
        if($current){
            $pIds = json_decode($current->pIds);
            array_push($pIds, $current->id);
        }
        $this->api_ids = json_encode($pIds);
        $this->save();
    }
}
