<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subtag extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

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
