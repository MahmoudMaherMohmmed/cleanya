<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\DeleteNotificationRequest;
use App\Http\Resources\NotificationResource;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller
{
    /**
     * Return Notification
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $notifications = Notification::where('client_id', $request->user()->id)->orderBy('id', 'DESC')->get();

        return response()->json(['status' => true, 'message' => trans('api.data_has_been_retrieved_successfully'), 'data' => NotificationResource::collection($notifications)], 200);
    }

    /**
     * Delete Notification
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(DeleteNotificationRequest $request)
    {
        Notification::where('id', $request->notification_id)->where('client_id', $request->user()->id)->delete();

        return response()->json(['status' => true, 'message' => trans('api.notification_deleted_successfully')], 200);
    }
}
