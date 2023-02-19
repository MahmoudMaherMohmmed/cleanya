<?php

namespace App\Http\Controllers\Api;

use App\Models\Reservation;
use App\Models\Review;
use App\Models\Application;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\StoreReservationRequest;
use App\Http\Requests\Api\ReviewReservationRequest;
use App\Http\Resources\ReservationResource;
use App\Http\Resources\RepresentativeReservationResource;

class ReservationController extends Controller
{
    /**
     * Store reservation
     *
     * @param \App\Http\Requests\Api\StoreReservationRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreReservationRequest $request)
    {
        $reservation = Reservation::create(array_merge($request->all(), ['client_id'=>$request->user()->id]));

        //notify client about reservation by push notification and email
        $this->newReservationNotification($reservation);
        // $this->newReservationMail($reservation);

        return response()->json(['status' => true, 'message' => trans('api.appointment_reserved')], 200);
    }

    /**
     * Send newReservationMail
     *
     * @param mixed $reservation
     * @return bool
     */
    private function newReservationMail($reservation)
    {
        $application = Application::first();

        if ($application != null) {
            \Mail::to($application->email_1)->send(new \App\Mail\NewReservationMail($reservation));
        }

        return true;
    }

    /**
     * Send newReservationNotification
     *
     * @param mixed $reservation
     * @return bool
     */
    private function newReservationNotification($reservation)
    {
        send_notification($reservation->client->device_token, array(
            "title" => trans('notifications.new_reservation'),
            "body" => trans('notifications.new_reservation_body'),
        ));

        return true;
    }

    /**
     * Show Reservation
     *
     * @param \App\Models\Reservation $reservation
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Reservation $reservation, Request $request)
    {
        if ($request->user()->type == 0) {
            return response()->json(['status' => true, 'message' => trans('api.data_has_been_retrieved_successfully'), 'data' => new ReservationResource($reservation)], 200);
        } else {
            return response()->json(['status' => true, 'message' => trans('api.data_has_been_retrieved_successfully'), 'data' => new RepresentativeReservationResource($reservation)], 200);
        }
    }

    /**
     * Current Reservation
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function current(Request $request)
    {
        $reservations = Reservation::where('client_id', $request->user()->id)->whereIn('status', [1, 2,3,4,5])->latest()->get();

        return response()->json(['status' => true, 'message' => trans('api.data_has_been_retrieved_successfully'), 'data' => ReservationResource::collection($reservations)], 200);
    }

    /**
     * Finished Reservation
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function finished(Request $request)
    {
        $reservations = Reservation::where('client_id', $request->user()->id)->where('status', 6)->latest()->get();

        return response()->json(['status' => true, 'message' => trans('api.data_has_been_retrieved_successfully'), 'data' => ReservationResource::collection($reservations)], 200);
    }

    /**
     * Cancelled Reservation
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancelled(Request $request)
    {
        $reservations = Reservation::where('client_id', $request->user()->id)->where('status', 0)->latest()->get();

        return response()->json(['status' => true, 'message' => trans('api.data_has_been_retrieved_successfully'), 'data' => ReservationResource::collection($reservations)], 200);
    }

    /**
     * Cancel Reservation
     *
     * @param \App\Models\Reservation $reservation
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancel(Reservation $reservation)
    {
        $reservation->status = 0;
        $reservation->save();

        return response()->json(['status' => true, 'message' => trans('api.reservation_cancelled_successfully')], 200);
    }

    /**
     * Complete Reservation
     *
     * @param \App\Models\Reservation $reservation
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function complete(Reservation $reservation, Request $request)
    {
        if ($reservation->status>3) {
            if ($reservation->payment_type==0) {
                $reservation->client_approve = 1;
                $reservation->save();

                $this->completeReservationNotification($reservation);

                return response()->json(['status' => true, 'message' => trans('api.completed_order'), 'data' => new ReservationResource($reservation)], 200);
            } elseif ($reservation->payment_type==1) {
                if ($request->user()->balance >= $reservation->total_price) {
                    $request->user()->balance = $request->user()->balance - $reservation->total_price;
                    if ($request->user()->save()) {
                        $reservation->client_approve = 1;
                        $reservation->save();
                    }

                    $this->completeReservationNotification($reservation);

                    return response()->json(['status' => true, 'message' => trans('api.completed_order'), 'data' => new ReservationResource($reservation)], 200);
                } else {
                    return response()->json(['status' => false,'message' => trans('api.user_balance_is_not_enough')], 403);
                }
            } elseif ($reservation->payment_type==2) {
                if (isset($request->transaction_id) && $request->transaction_id!=null) {
                    $reservation->transaction_id = $request->transaction_id;
                    $reservation->client_approve = 1;
                    $reservation->save();

                    $this->completeReservationNotification($reservation);

                    return response()->json(['status' => true, 'message' => trans('api.completed_order'), 'data' => new ReservationResource($reservation)], 200);
                } else {
                    return response()->json(['status' => false,'message' => trans('api.transaction_id_required')], 403);
                }
            }
        } else {
            return response()->json(['status' => false,'message' => trans('api.can_not_complete_reservation')], 403);
        }
    }

    private function completeReservationNotification($reservation)
    {
        send_notification($reservation->client->device_token, array(
            "title" => trans('notifications.complete_reservation'),
            "body" => trans('notifications.complete_reservation_body'),
        ));
    }


    /**
     * Review Reservation
     *
     * @param \App\Http\Requests\Api\ReviewReservationRequest $request
     * @param mixed $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function review(ReviewReservationRequest $request, $id)
    {
        if ($this->checkReview($id)) {
            return response()->json(['status' => false,'message' => trans('api.review_already_exist')], 403);
        }

        $review = new Review();
        $review->reservation_id = $id;
        $review->review_text = $request->review_text;
        $review->score = $request->score;
        $review->save();

        return response()->json(['status' => true,'message' => trans('api.review_added_successfully')], 200);
    }

    private function checkReview($reservation_id)
    {
        $review = Review::where('reservation_id', $reservation_id)->first();
        if (isset($review) && $review != null) {
            return true;
        } else {
            return false;
        }
    }
}
