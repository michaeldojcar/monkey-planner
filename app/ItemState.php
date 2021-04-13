<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ItemState
 *
 * @property int $id
 * @property int $item_id
 * @property string $count_type
 * @property int $count
 * @property int|null $place_id
 * @property int|null $box_id
 * @property int $state
 * @property int|null $borrower_user_id
 * @property int|null $borrower_group_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Item $item
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ItemState newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ItemState newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ItemState query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ItemState whereBorrowerGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ItemState whereBorrowerUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ItemState whereBoxId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ItemState whereCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ItemState whereCountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ItemState whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ItemState whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ItemState whereItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ItemState wherePlaceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ItemState whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ItemState whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ItemState extends Model
{
    public function item()
    {
        return $this->belongsTo(Item::class);
    }


    public function item_place()
    {
        return $this->belongsTo(ItemPlace::class, 'place_id');
    }

    public function getStateString()
    {

    }
}
