<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Relation extends Model
{
    use HasFactory;

    public function child_obs()
    {
        return $this->belongsToMany(Ob::class, 'ob_ob', 'relation', 'child_ob');
    }
}
