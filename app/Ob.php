<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ob extends Model
{
    use HasFactory;

    public function parents()
    {

    }


    public function childs()
    {
        return $this->belongsToMany(Ob::class, 'ob_ob', 'parent_ob', 'child_ob');
    }


    public function child_relations()
    {
        return $this->belongsToMany(Relation::class, 'ob_ob', 'relation', 'parent_ob')
            ->distinct();
    }
}
