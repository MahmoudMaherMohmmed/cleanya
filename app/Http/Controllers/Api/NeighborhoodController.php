<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Neighborhood;
use Illuminate\Support\Str;

class NeighborhoodController extends Controller
{
    public function check(Request $request)
    {
        $Validated = Validator::make($request->all(), [
            'lat' => 'required',
            'lng' => 'required',
        ]);

        if ($Validated->fails())
            return response()->json($Validated->messages(), 403);

        $neighborhood_name = get_neighborhood_name_multi_language_check_api($request->lat, $request->lng);
        $neighborhood_slug = Str::slug($neighborhood_name['en']);

        //check if neighborhood already exists
        $neighborhood = Neighborhood::where('slug', $neighborhood_slug)->first();
        if ($neighborhood) {
            return response()->json(['message' => trans('api.neighborhood_already_exists')], 200);
        }

        return response()->json(['message' => trans('api.neighborhood_not_exists')], 403);
    }


}
