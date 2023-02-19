<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CouponApplyRequest;
use App\Http\Resources\ReservationResource;
use App\Models\Coupon;
use App\Models\Reservation;
use Carbon\Carbon;

class CouponController extends Controller
{
    /**
     * Apply Coupon
     *
     * @param \App\Http\Requests\Api\CouponApplyRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function apply(CouponApplyRequest $request)
    {
        $coupon = Coupon::where('code', $request->code)->where('status', 1)->first();
        if (!$coupon || $coupon==null) {
            return response()->json(['status' => false, 'message' => trans('api.coupon_not_exist')], 403);
        }

        if (Reservation::where('coupon', $coupon->code)->count() >= $coupon->available_use_count) {
            return response()->json(['status' => false, 'message' => trans('api.coupon_exceeded_max_number_available_use')], 403);
        }

        if ($coupon->active_from == null && $coupon->active_to == null) {
            $reservation= $this->updateReservation($request->reservation_id, $coupon);
            return response()->json(['status' => true, 'message' => trans('api.data_has_been_retrieved_successfully'), 'data' => new ReservationResource($reservation)], 200);
        } elseif (($coupon->active_from != null && $coupon->active_from <= Carbon::now()) && ($coupon->active_to != null && $coupon->active_to >= Carbon::now())) {
            $reservation= $this->updateReservation($request->reservation_id, $coupon);
            return response()->json(['status' => true, 'message' => trans('api.data_has_been_retrieved_successfully'), 'data' => new ReservationResource($reservation)], 200);
        } elseif (($coupon->active_from == null) && ($coupon->active_to != null && $coupon->active_to >= Carbon::now())) {
            $reservation= $this->updateReservation($request->reservation_id, $coupon);
            return response()->json(['status' => true, 'message' => trans('api.data_has_been_retrieved_successfully'), 'data' => new ReservationResource($reservation)], 200);
        } elseif (($coupon->active_from != null && $coupon->active_from <= Carbon::now()) && ($coupon->active_to == null)) {
            $reservation= $this->updateReservation($request->reservation_id, $coupon);
            return response()->json(['status' => true, 'message' => trans('api.data_has_been_retrieved_successfully'), 'data' => new ReservationResource($reservation)], 200);
        } else {
            return response()->json(['status' => false, 'message' => trans('api.coupon_not_active')], 403);
        }
    }

    /**
     * UpdateReservation
     *
     * @param mixed $reservation_id
     * @param mixed $coupon
     * @return mixed
     */
    public function updateReservation($reservation_id, $coupon)
    {
        $reservation = Reservation::where('id', $reservation_id)->first();
        $reservation->coupon = $coupon->code;
        $reservation->discount = $coupon->discount;
        $reservation->price_after_discount = $reservation->pieces_price - ($reservation->pieces_price * ($coupon->discount / 100));
        $reservation->tax_amount = $this->calTaxAmount($reservation->delivery_cost, $reservation->price_after_discount, $reservation->tax);
        $reservation->total_price = $this->calTotalPrice($reservation->delivery_cost, $reservation->price_after_discount, $reservation->tax);
        $reservation->save();

        return $reservation;
    }

    /**
     * CalTaxAmount
     *
     * @param mixed $delivery_cost
     * @param mixed $price_after_discount
     * @param mixed $tax
     * @return float
     */
    private function calTaxAmount($delivery_cost, $price_after_discount, $tax)
    {
        return ($delivery_cost + $price_after_discount) * ($tax / 100);
    }

    /**
     * CalTotalPrice
     *
     * @param mixed $delivery_cost
     * @param mixed $price_after_discount
     * @param mixed $tax
     * @return float
     */
    private function calTotalPrice($delivery_cost, $price_after_discount, $tax)
    {
        return ($delivery_cost + $price_after_discount) + (($delivery_cost + $price_after_discount) * ($tax / 100));
    }
}
