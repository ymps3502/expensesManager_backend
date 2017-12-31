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
     * Bill 和 Tag 為一對一關係
     *
     * @return HasOne
     */
    public function tag() {
        return $this->hasOne('App\Tag');
    }

    /**
     * Bill 和 SubTag 為一對一關係
     *
     * @return HasOne
     */
    public function subtag() {
        return $this->hasOne('App\SubTag');
    }
}
