<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Contracts\RestaurantRepositoryInterface;

class HomeController extends Controller
{
    /**
     * Wrapper to the restaurant data
     *
     * @var RestaurantRepositoryInterface
     */
    private $restaurantRepo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(RestaurantRepositoryInterface $restaurantRepo)
    {
        $this->restaurantRepo = $restaurantRepo;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Return JSON of all restaurants
     *
     * @return \Illuminate\Http\Response
     */
    public function getRestaurants()
    {
        $restaurants = $this->restaurantRepo->getAllWithCategories();
        return response()->json([
            'restaurants' => $restaurants
        ]);
    }
}
