<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;

    public function kv(Array $ids = [])
    {
        if ($ids) {
            $this->whereIn('id', $ids);
        }
        $rows = $this->select('id', 'name')->get();
        $kv = [];
        if ($rows) {
            foreach ($rows as $row) {
                $kv[$row->id] = $row->name;
            }
        }
        return $kv;
    }
}
