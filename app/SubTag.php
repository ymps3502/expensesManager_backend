<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subtag extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
    protected $dates = ['deleted_at'];

    /**
     * subtag 屬於 Tag
     *
     * @return belongsTo
     */
    public function tag()
    {
        return $this->belongsTo('App\Tag');
    }

    /**
     * subtag 和 Bill 為一對多關係
     * 
     * @return hasMany
     */
    public function bill()
    {
        return $this->hasMany('App\Bill');
    }
}
