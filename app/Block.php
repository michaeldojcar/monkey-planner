<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Block
 * 
 * Blok informací.
 * Přiřazený ke skupině nebo k události.
 *
 * @package App
 * @property int                             $id
 * @property int|null                        $parent_block_id
 * @property string                          $title
 * @property string|null                     $content
 * @property int|null                        $group_id
 * @property int|null                        $event_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Block|null            $childBlocks
 * @property-read \App\Group|null            $group
 * @property-read \App\Block                 $parentBlock
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Block whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Block whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Block whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Block whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Block whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Block whereParentBlockId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Block whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Block whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int                             $highlighted
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Block whereHighlighted($value)
 * @property-read \App\Event|null $event
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Block newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Block newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Block query()
 */
class Block extends Model
{
    protected $fillable
        = [
            'title',
            'content',
        ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Nadřazený blok, jehož je tento blok součástí.
     */
    public function parentBlock()
    {
        return $this->hasOne(Block::class, 'parent_block_id');
    }

    /**
     * Bloky obsažené v tomto bloku.
     */
    public function childBlocks()
    {
        return $this->belongsTo(Block::class, 'parent_block_id');
    }
}
