<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemPlace extends Model
{
    use HasFactory;

    public function item_states()
    {
        return $this->hasMany(ItemState::class, 'place_id');
    }


    public function group()
    {
        return $this->belongsTo(Group::class);
    }


    public function parent_item_place()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function item_places()
    {
        return $this->hasMany(self::class, 'parent_id');
    }
}
