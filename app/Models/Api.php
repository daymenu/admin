<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Api extends Model
{
    use SoftDeletes;


    public function kv($ids = [])
    {
        if ($ids) {
            $this->whereIn('id', $ids);
        }
        $data = $this->select('id', 'name')->get();
        $kv = [];
        if ($data) {
            foreach ($data as $item) {
                $kv[$item->id] = $item->name;
            }
        }
        return $kv;
    }

    public function apiTree()
    {
        $rows = $this->select('id', 'pId', 'name')->get();
        $nodes = [];
        foreach ($rows as $item) {
            $nodes[$item->pId][] = $item;
        }

        return $this->tree($nodes);
    }

    public function tree($rowsKv, $pId = 0)
    {
        $tree = [];
        if (empty($rowsKv[$pId])) {
            return $tree;
        }
        foreach ($rowsKv[$pId] as $id => $item) {
            if (isset($rowsKv[$item->id])) {
                $item->children = $this->tree($rowsKv, $item->id);
            }
            $tree[] = $item;
        }
        return $tree;
    }
}
