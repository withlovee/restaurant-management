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
        $condition = [
            'id' => $restaurantData['id']
        ];

        return Restaurant::updateOrCreate($condition, $restaurantData);
    }
    
    /**
     * Return all restaurants
     *
     * @return array
     */
    public function getAll()
    {
        return Restaurant::all();
    }
    
    /**
     * Return restaurants name, location, address, and categories
     *
     * @return array
     */
    public function getAllWithCategories()
    {
        $results = [];
        $restaurants = Restaurant::all();
        
        foreach ($restaurants as $restaurant) {
            $results[] = [
                'name' => $restaurant->name,
                'lat' => $restaurant->lat,
                'lng' => $restaurant->lng,
                'address' => $restaurant->address
            ];
        }

        return $results;
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