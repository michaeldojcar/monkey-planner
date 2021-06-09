<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObAttribute extends Model
{
    use HasFactory;

    public function getValueForOb(Ob $ob)
    {
        return AttributeValue::where('ob_attribute_id', $this->id)
            ->where('ob_id', $ob->id)
            ->firstOrNew()->value;
    }


    public function getRelationData(Ob $ob)
    {
        return AttributeRelation::where('ob_attribute_id', $this->id)
            ->where('ob_id', $ob->id)
            ->get();
    }
}
