<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ob extends Model
{
    use HasFactory;

    public function type()
    {
        return $this->belongsTo(ObType::class, 'ob_type');
    }

    public function parents()
    {

    }


    public function childs()
    {
        return $this->belongsToMany(Ob::class, 'ob_ob', 'parent_ob', 'child_ob');
    }
}
