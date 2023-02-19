<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ContactRequest;
use App\Http\Resources\ApplicationResource;
use App\Http\Resources\SliderResource;
use App\Http\Resources\TermsAndConditionResource;
use App\Models\Application;
use App\Models\Slider;
use App\Models\Term;
use App\Models\ContactMessage;

class ApplicationController extends Controller
{
    /**
     * Return application data
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function application()
    {
        $application = Application::first();

        return response()->json(['status' => true, 'message' => trans('api.data_has_been_retrieved_successfully'), 'data' => ($application != null ? new ApplicationResource($application) : [])], 200);
    }

    /**
     * Return Soft Opening
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function softOpening()
    {
        $application = Application::first();

        return response()->json(['status' => true, 'message' => trans('api.skip'), 'data' => ($application->soft_opening == 1 ? true : false)], 200);
    }

    /**
     * Return TermsAndConditions
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function TermsAndConditions()
    {
        $term = Term::first();

        return response()->json(['status' => true, 'message' => trans('api.data_has_been_retrieved_successfully'), 'data' => ($term != null ? new TermsAndConditionResource($term) : [])], 200);
    }

    /**
     * Return sliders data
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function sliders()
    {
        $sliders = Slider::where('status', 1)->latest()->get();

        return response()->json(['status' => true, 'message' => trans('api.data_has_been_retrieved_successfully'), 'data' => SliderResource::collection($sliders)], 200);
    }

    /**
     * Save contact us message
     * 
     * @param \App\Http\Requests\Api\ContactRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function contact(ContactRequest $request)
    {
        ContactMessage::create($request->all());

        return response()->json(['status' => true, 'message' => trans('api.message_sent')], 200);
    }

}