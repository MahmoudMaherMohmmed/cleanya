<?php

namespace App\Http\Controllers\Api;

use App\Models\Service;
use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceResource;

class ServiceController extends Controller
{
    /**
     * Return Services
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $services = Service::with('clothes')->latest()->get();

        return response()->json(['status' => true, 'message' => trans('api.data_has_been_retrieved_successfully'), 'data' => ServiceResource::collection($services)], 200);
    }

    /**
     * Show Service Details
     *
     * @param \App\Models\Service $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Service $service)
    {
        return response()->json(['status' => true, 'message' => trans('api.data_has_been_retrieved_successfully'), 'data' => new ServiceResource($service)], 200);
    }
}
