<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\RestaurantController;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;

class RestaurantController extends Controller
{
    public function index()
    {
        return view('index');
    }
    
    public function search(Request $request)
    {
        try {
            $keyword = $request->input('keyword');
            $range = $request->input('range');
            $latitude = $request->input('latitude');
            $longitude = $request->input('longitude');
            $apiEndpoint = 'http://webservice.recruit.co.jp/hotpepper/gourmet/v1/';
            $api_key = config('services.hotpepper.api_key');
            $params = [
                'key' => $api_key,
                'keyword' => $keyword,
                'range' => $range,
                'count' => 100,
                'format' => "json",
            ];
            if ($latitude && $longitude) {
                $params['lat'] = $latitude;
                $params['lng'] = $longitude;
            }
            $response = Http::get($apiEndpoint, $params);
            $restaurantsData = $response->json()['results']['shop'];
            Paginator::useBootstrap();
            $perPage = 10;
            $currentPage = $request->input('page', 1);
            $pagedData = array_slice($restaurantsData, ($currentPage - 1) * $perPage, $perPage);
            $restaurants = new LengthAwarePaginator($pagedData, count($restaurantsData), $perPage, $currentPage);

            return view('search_results', [
                'keyword' => $keyword,
                'range' => $range,
                'restaurants' => $restaurants,
                'count' => count($restaurantsData),
                'error' => null,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error fetching restaurant data: ' . $e->getMessage());

            return view('search_results', [
                'keyword' => $keyword,
                'range' => $range,
                'restaurants' => null,
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function pickUp(Request $request)
    {
        try {
            $latitude = $request->input('latitude');
            $longitude = $request->input('longitude');
            $apiEndpoint = 'http://webservice.recruit.co.jp/hotpepper/gourmet/v1/';
            $api_key = config('services.hotpepper.api_key');
            $params = [
                'key' => $api_key,
                'count' => 100,
                'format' => "json",
            ];
            if ($latitude && $longitude) {
                $params['lat'] = $latitude;
                $params['lng'] = $longitude;
            }
            $response = Http::get($apiEndpoint, $params);
            $restaurants = $response->json()['results']['shop'];
            $randomIndex = array_rand($restaurants);
            $randomRestaurant = $restaurants[$randomIndex];
            return view('restaurant_detail', ['restaurant' => $randomRestaurant, 'keyword' => null, 'range' => 3]);
        } catch (\Exception $e) {
            \Log::error('Error picking up restaurant: ' . $e->getMessage());
        }
    }

    public function show($id, Request $request)
    {
        try {
            $keyword = $request->input('keyword');
            $range = $request->input('range');
            $apiEndpoint = 'http://webservice.recruit.co.jp/hotpepper/gourmet/v1/';
            $apiKey = config('services.hotpepper.api_key');
            $params = [
                'key' => $apiKey,
                'id' => $id,
                'format' => 'json',
            ];
            $response = Http::get($apiEndpoint, $params);
            $restaurant = $response->json()['results']['shop'][0];
            return view('restaurant_detail', ['restaurant' => $restaurant, 'keyword' => $keyword, 'range' => $range]);
        } catch (\Exception $e) {
            \Log::error('Error fetching restaurant details: ' . $e->getMessage());
        }
    }

    public function saved(Request $request, $restaurantId, $user_id)
    {
        Favorite::toggleFavorite($restaurantId, $user_id);

        return back();
    }

    public function savedList(Request $request)
    {
        try {
            $user_id = Auth::user()->id;
            $savedRestaurants = Favorite::getFavoriteRestaurantIds($user_id);

            $apiEndpoint = 'http://webservice.recruit.co.jp/hotpepper/gourmet/v1/';
            $apiKey = config('services.hotpepper.api_key');
            $params = [
                'key' => $apiKey,
                'id' => $savedRestaurants->implode(','),
                'format' => 'json',
            ];
            $response = Http::get($apiEndpoint, $params);
            $restaurantsData = $response->json()['results']['shop'];
            Paginator::useBootstrap();
            $perPage = 10;
            $currentPage = $request->input('page', 1);
            $pagedData = array_slice($restaurantsData, ($currentPage - 1) * $perPage, $perPage);
            $restaurants = new LengthAwarePaginator($pagedData, count($restaurantsData), $perPage, $currentPage);

            return view('saved_list', ['restaurants' => $restaurants]);
        } catch (\Exception $e) {
            \Log::error('Error fetching favorite restaurant: ' . $e->getMessage());
        }
    }
};
