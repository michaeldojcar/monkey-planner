<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObType extends Model
{
    use HasFactory;

    public function attributes()
    {
        return $this->hasMany(ObAttribute::class);
    }
}
