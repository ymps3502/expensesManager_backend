<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Tag 和 subtag 為一對多關係
     *
     * @return hasMany
     */
    public function subtag()
    {
        return $this->hasMany('App\Subtag');
    }

    /**
     * Tag 和 Bill 為一對多關係
     * 
     * @return hasMany
     */
    public function bill()
    {
        return $this->hasMany('App\Bill');
    }

    /**
     * Tag 和 Bill 為一對多關係
     * 
     * @return hasManyThrough
     */
    public function hasManyThroughBill()
    {
        return $this->hasManyThrough('App\Subtag', 'App\Bill');
    }
}
