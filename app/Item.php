<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Item
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int|null $owner_user_id
 * @property int|null $owner_group_id
 * @property int|null $home_place_id
 * @property int|null $home_box_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\ItemState[] $item_states
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Item newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Item newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Item query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Item whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Item whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Item whereHomeBoxId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Item whereHomePlaceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Item whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Item whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Item whereOwnerGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Item whereOwnerUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Item whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Item extends Model
{
    public function item_states()
    {
        return $this->hasMany(ItemState::class);
    }
}
