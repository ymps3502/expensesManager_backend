<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Bill 屬於 Tag
     *
     * @return belongsTo
     */
    public function tag()
    {
        return $this->belongsTo('App\Tag');
    }

    /**
     * Bill 屬於 subtag
     *
     * @return belongsTo
     */
    public function subtag()
    {
        return $this->belongsTo('App\Subtag');
    }
}
