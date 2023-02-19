<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\DeleteAddressRequest;
use App\Models\Address;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreAddressRequest;
use App\Http\Requests\Api\UpdateAddressRequest;
use App\Http\Resources\AddressResource;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    /**
     * Return Address
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        switch ($request->type) {
            case 'reception':
                $addresses = Address::where('client_id', $request->user()->id)->where('type', 0)->orderBy('id', 'DESC')->get();
                break;
            case 'sending':
                $addresses = Address::where('client_id', $request->user()->id)->where('type', 1)->orderBy('id', 'DESC')->get();
                break;
            default:
                $addresses = Address::where('client_id', $request->user()->id)->orderBy('id', 'DESC')->get();
        }

        return response()->json(['status' => true, 'message' => trans('api.data_has_been_retrieved_successfully'), 'data' => AddressResource::collection($addresses)], 200);
    }

    /**
     * Store Client Address
     *
     * @param \App\Http\Requests\Api\StoreAddressRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreAddressRequest $request)
    {
        $address = Address::create(array_merge($request->only('details', 'lat', 'lng', 'type'), ['client_id' => $request->user()->id, 'status' => 1]));

        return response()->json(['status' => true, 'message' => trans('api.data_has_been_retrieved_successfully'), 'data' => new AddressResource($address)], 200);
    }

    /**
     * Show Address Details
     *
     * @param \App\Models\Address $address
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Address $address)
    {
        return response()->json(['status' => true, 'message' => trans('api.data_has_been_retrieved_successfully'), 'data' => new AddressResource($address)], 200);
    }

     /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Api\UpdateAddressRequest  $request
     * @param  \App\Models\Address $address
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateAddressRequest $request, Address $address)
    {
        $address->fill($request->only('details', 'lat', 'lng', 'type', 'status'));
        $address->save();

        return response()->json(['status' => true, 'message' => trans('api.data_has_been_retrieved_successfully'), 'data' => new AddressResource($address)], 200);
    }

    /**
     * Delete Address
     * @param \App\Http\Requests\Api\DeleteAddressRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(DeleteAddressRequest $request)
    {
        Address::where('id', $request->address_id)->delete();

        return response()->json(['status' => true, 'message' => trans('api.addresss_deleted_successfully')], 200);
    }
}
