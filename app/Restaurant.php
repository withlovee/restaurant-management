<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'address', 'lat', 'lng', 'owner_id'];

    /**
     * Get the list of restaurants
     */
    public function categories()
    {
        return $this->belongsToMany('App\Category')->using('App\RestaurantCategory');
    }

    /**
     * Get owner information
     */
    public function owner()
    {
        return $this->belongsTo('App\User');
    }
}
