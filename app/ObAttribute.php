<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObAttribute extends Model
{
    use HasFactory;

    public const ATTRIBUTE_TYPE_STRING = 'string';
    public const ATTRIBUTE_TYPE_TEXT = 'text';
    public const ATTRIBUTE_TYPE_DATETIME = 'datetime';
    public const ATTRIBUTE_TYPE_DATETIME_RANGE = 'datetime_range';
    public const ATTRIBUTE_TYPE_RELATION_FREE = 'relation_free';
    public const ATTRIBUTE_TYPE_RELATION_TYPED = 'relation_typed';
    public const ATTRIBUTE_TYPE_ASSIGN = 'user_assign';
    public const ATTRIBUTE_TYPE_ASSIGN_MULTIPLE = 'user_assign_multiple';
    public const ATTRIBUTE_TYPE_IMAGE = 'image';
    public const ATTRIBUTE_TYPE_GALLERY = 'gallery';


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
