<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Contracts\RestaurantRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RestaurantController extends Controller
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
     * @param  RestaurantRepositoryInterface $restaurantRepo
     * @return void
     */
    public function __construct(RestaurantRepositoryInterface $restaurantRepo)
    {
        $this->middleware('auth');
        $this->restaurantRepo = $restaurantRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function index($id = null)
    {
        $restaurant = $this->restaurantRepo->getByID($id);

        // Cannot find the restaurant by the ID, redirect user to main page
        if ($id !== null && $restaurant == null) {
            return redirect()->action('Admin\RestaurantController@index');
        }

        $restaurants = $this->restaurantRepo->getAll();
        return view('admin.restaurant.index', [
            'restaurants' => $restaurants,
            'restaurant' => $restaurant,
            'selected_id' => $id
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id = null)
    {
        //TODO: check duplicate name?
        //TODO: check if the user has authorization to update this restaurant
        $this->validator($request->all())->validate();

        $this->restaurantRepo->updateOrCreate([
            'id' => $id,
            'name' => $request->name,
            'address' => $request->address,
            'lat' => $request->lat,
            'lng' => $request->lng,
            'owner_id' => Auth::id()
        ]);

        $name = $request->name;

        $this->setStoreStatus($request, $id, $name);

        return redirect()->action('Admin\RestaurantController@index', ['id' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //TODO: check if the user has authorization to delete this restaurant
        $result = $this->restaurantRepo->delete($id);

        if ($result) {
            $request->session()->flash('main-status', "Restaurant removed.");
            return response()->json([
                'status' => 'success'
            ]);
        } else {
            return response()->json([
                'status' => 'error'
            ], 400);
        }

    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    private function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
        ]);
    }

    /**
     * Create a flash message saying whether the restaurant is 
     * successfully created or updated
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @param  string  $name
     */
    private function setStoreStatus(Request $request, $id, $name)
    {
        $status = 'created';

        if ($id !== null) // Updating existing restaurant 
        {
            $status = 'updated';
        }
        
        $request->session()->flash('status', "Restaurant \"${name}\" is successfully ${status}!");
    }
}
