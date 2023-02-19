<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CityResource;
use App\Models\City;

class CityController extends Controller
{
    /**
     * Return Cities 
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $cities = City::where('status', 1)->latest()->get();

        return response()->json(['status' => true, 'message' => trans('api.data_has_been_retrieved_successfully'), 'data' => CityResource::collection($cities)], 200);
    }
}
