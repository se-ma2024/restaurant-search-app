<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\RestaurantController;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;


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
            $apiEndpoint = 'http://webservice.recruit.co.jp/hotpepper/gourmet/v1/';
            $api_key = config('services.hotpepper.api_key');
            $params = [
                'key' => $api_key,
                'keyword' => $keyword,
                'range' => $range,
                'count' => 100,
                'format' => "json",
            ];
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

    public function show($id, Request $request)
    {
        $keyword = $request->input('keyword');
        $apiEndpoint = 'http://webservice.recruit.co.jp/hotpepper/gourmet/v1/';
        $apiKey = config('services.hotpepper.api_key');
        $params = [
            'key' => $apiKey,
            'id' => $id,
            'format' => 'json',
        ];
        $response = Http::get($apiEndpoint, $params);
        $restaurant = $response->json()['results']['shop'][0];
        return view('restaurant_detail', ['restaurant' => $restaurant, 'keyword' => $keyword]);
    }
};
