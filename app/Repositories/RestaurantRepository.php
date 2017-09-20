<?php

namespace App\Repositories;

use App\Repositories\Contracts\RestaurantRepositoryInterface;
use App\Restaurant;

class RestaurantRepository implements RestaurantRepositoryInterface
{

    /**
     * Create or update restaurant and categories to the database
     *
     * @param  array  $restaurantData
     * @return Restaurant
     */
    public function updateOrCreate($restaurantData)
    {
        // if (isset($restaurantData))
        $condition = [
            'id' => $restaurantData['id']
        ];

        return Restaurant::updateOrCreate($condition, $restaurantData);
    }
    
    /**
     * Create restaurant and categories to the database
     *
     * @return array
     */
    public function getAll()
    {
        return Restaurant::all();
    }

    /**
     * Return one restaurant by ID
     *
     * @param  int  $id
     * @return Restaurant
     */
    public function getByID($id)
    {
        return Restaurant::find($id);
    }

    /**
     * Return one restaurant by ID
     *
     * @param  int  $id
     * @return int
     */
    public function delete($id)
    {
        return Restaurant::destroy($id);
    }

}