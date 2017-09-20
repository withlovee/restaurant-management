<?php

namespace App\Repositories\Contracts;

interface RestaurantRepositoryInterface
{
	public function updateOrCreate($restaurantData);

	public function getAll();

	public function getByID($id);

	public function delete($id);
}