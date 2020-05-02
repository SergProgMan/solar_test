<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Comment
 * @package App
 * @property int  $id
 * @property int  $parent_id
 * @property string $content
 * @property Carbon $updated_at
 * @property Carbon $created_at
 */
class Comment extends Model
{
    protected $fillable = ['content', 'parent_id'];

    public function comments(){
        return $this->hasMany('App\Comment', 'id', 'parent_id');
    }
}
