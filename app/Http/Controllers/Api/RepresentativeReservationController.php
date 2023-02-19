<?php

namespace App\Http\Controllers\Api;

use App\Models\Notification;
use App\Models\Reservation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\UpdateReservationStatusRequest;
use App\Http\Resources\RepresentativeReservationResource;

class RepresentativeReservationController extends Controller
{
    /**
     * Reservation update status
     *
     * @param \App\Models\Reservation $reservation
     * @param \App\Http\Requests\Api\UpdateReservationStatusRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateStatus(Reservation $reservation, UpdateReservationStatusRequest $request)
    {
        $reservation->status = $request->status;
        $reservation->save();

        $this->updateReservationStatusNotification($reservation);

        return response()->json(['status' => true, 'message' => trans('api.reservation_status_updated_successfully'), 'data' => new RepresentativeReservationResource($reservation)], 200);
    }

    /**
     * In Receive Reservation
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function InReceive(Request $request)
    {
        $reservations = Reservation::where('representative_id', $request->user()->id)->where('status', 2)->latest()->get();

        return response()->json(['status' => true, 'message' => trans('api.data_has_been_retrieved_successfully'), 'data' => RepresentativeReservationResource::collection($reservations)], 200);
    }

    /**
     * Received Reservation
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function Received(Request $request)
    {
        $reservations = Reservation::where('representative_id', $request->user()->id)->whereIn('status', [3, 4])->latest()->get();

        return response()->json(['status' => true, 'message' => trans('api.data_has_been_retrieved_successfully'), 'data' => RepresentativeReservationResource::collection($reservations)], 200);
    }

    /**
     * In Delivery Reservation
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function InDelivery(Request $request)
    {
        $reservations = Reservation::where('representative_id', $request->user()->id)->where('status', 5)->latest()->get();

        return response()->json(['status' => true, 'message' => trans('api.data_has_been_retrieved_successfully'), 'data' => RepresentativeReservationResource::collection($reservations)], 200);
    }

    /**
     * Delivered Reservation
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function Delivered(Request $request)
    {
        $reservations = Reservation::where('representative_id', $request->user()->id)->where('status', 6)->latest()->get();

        return response()->json(['status' => true, 'message' => trans('api.data_has_been_retrieved_successfully'), 'data' => RepresentativeReservationResource::collection($reservations)], 200);
    }


    /**
     * Update Reservation Status Notification
     * 
     * @param mixed $reservation
     * @return bool
     */
    private function updateReservationStatusNotification($reservation)
    {
        if ($reservation->status == 0) {
            $message = array(
                "title" => trans('notifications.reject_reservation'),
                "body" => trans('notifications.reject_reservation_body'),
            );
        } elseif ($reservation->status == 1) {
            $message = array(
                "title" => trans('notifications.pending_reservation'),
                "body" => trans('notifications.pending_reservation_body'),
            );
        } elseif ($reservation->status == 2) {
            $message = array(
                "title" => trans('notifications.in_receive_reservation'),
                "body" => trans('notifications.in_receive_reservation_body'),
            );
        } elseif ($reservation->status == 3) {
            $message = array(
                "title" => trans('notifications.received_reservation'),
                "body" => trans('notifications.received_reservation_body'),
            );
        } elseif ($reservation->status == 4) {
            $message = array(
                "title" => trans('notifications.washing_reservation'),
                "body" => trans('notifications.washing_reservation_body'),
            );
        } elseif ($reservation->status == 5) {
            $message = array(
                "title" => trans('notifications.in_delivery_reservation'),
                "body" => trans('notifications.in_delivery_reservation_body'),
            );
        } elseif ($reservation->status == 6) {
            $message = array(
                "title" => trans('notifications.delivered_reservation'),
                "body" => trans('notifications.delivered_reservation_body'),
            );
        }

        $this->saveNotification($reservation->client->id, $message);
        send_notification($reservation->client->device_token, $message);

        return true;
    }

    /**
     * Save Notification
     *
     * @param mixed $client_id
     * @param mixed $message
     * @return bool
     */
    private function saveNotification($client_id, $message)
    {
        $notification = new Notification();
        $notification->client_id = $client_id;
        $notification->title = $message['title'];
        $notification->body = $message['body'];
        $notification->save();

        return true;
    }
}
