<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginRecord extends Model
{
    public function record($data)
    {
        $iplong = ip2long($data['ip']);
        $this->adminId = $data['adminId'];
        $this->ip = $iplong;

        $ipAddress = new IpAddress();
        $address = $ipAddress->where('start', '<', $iplong)->where('end', '>', $iplong)->first();
        if ($address) {
            $this->address = $address->provice . $address->city . '[' . $address->isp . ']';
        }
        $this->save();
    }
}
