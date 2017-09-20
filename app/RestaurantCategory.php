<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class RestaurantCategory extends Pivot
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'restaurants_categories';
}