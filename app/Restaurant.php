<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    /**
     * Get the list of restaurants
     */
    public function categories()
    {
        return $this->belongsToMany('App\Category')->using('App\RestaurantCategory');
    }
}
