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

    /**
     * get nested comments
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments(){
        return $this->hasMany('App\Comment', 'parent_id', 'id');
    }

    /**
     * get recursive all sub comments of this comment
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function childrenComments(){
        return $this->hasMany('App\Comment', 'parent_id', 'id')->with('childrenComments');
    }

    /**
     * get array of comments with nested comments
     * @return mixed
     */
    public static function allRootCommentsWithChildren()
    {
        return self::whereNull('parent_id')->with('childrenComments')->get()->toArray();
    }
}
