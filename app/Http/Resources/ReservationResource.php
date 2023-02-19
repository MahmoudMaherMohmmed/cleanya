<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReservationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'representative' => new ReservationClientResource($this->representative),
            'reception_address' => new AddressResource($this->reception_address),
            'reception_date' => $this->reception_date,
            'reception_time' => $this->reception_time,
            'sending_address' => new AddressResource($this->sending_address),
            'sending_date' => $this->sending_date,
            'sending_time' => $this->sending_time,
            'delivery_cost' => $this->delivery_cost,
            'items' => ReservationItemResource::collection($this->items),
            'total_pieces_number' => $this->items->sum('pieces_number'),
            'pieces_price' => sprintf("%1.2f", $this->pieces_price),
            'coupoon' => $this->coupon,
            'discount' => $this->discount,
            'price_after_discount' => sprintf("%1.2f", $this->price_after_discount),
            'tax' => sprintf("%1.2f", $this->tax),
            'tax_amount' => sprintf("%1.2f", $this->tax_amount),
            'total_price' => sprintf("%1.2f", $this->total_price),
            'payment_type' => $this->payment_type,
            'transaction_id' => $this->transaction_id,
            'client_approve' => $this->client_approve,
            'status' => $this->status,
            'is_review' => $this->review!=null ? true : false,
            'created_at' => $this->created_at ? $this->created_at->toDateTimeString() : null,
            'created_at_formatted' => $this->created_at ? $this->created_at->diffForHumans() : null,
        ];
    }
}
