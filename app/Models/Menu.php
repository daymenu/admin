<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use SoftDeletes;

    public function kv($ids = [])
    {
        if ($ids) {
            $this->whereIn('id', $ids);
        }
        $data = $this->select('id', 'title')->get();
        $kv = [];
        if ($data) {
            foreach ($data as $item) {
                $kv[$item->id] = $item->title;
            }
        }
        return $kv;
    }

    public function menuTree()
    {
        $menuRows = $this->select('id','pId', 'title')->get();
        $nodes = [];
        foreach($menuRows as $item){
            $nodes[$item->pId][] = $item;
        }

        return $this->tree($nodes);
    }

    public function tree($menus, $pId = 0)
    {
        $tree = [];
        foreach ($menus[$pId] as $id => $item) {
            if (isset($menus[$item->id])) {
                $item->children = $this->tree($menus, $item->id);
            }
            $tree[] = $item;
        }
        return $tree;
    }
}
