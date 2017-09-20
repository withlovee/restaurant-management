<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'categories';

    /**
     * Get the list of restaurants
     */
    public function restaurants()
    {
        return $this->belongsToMany('App\Restaurant')->using('App\RestaurantCategory');
    }
}
