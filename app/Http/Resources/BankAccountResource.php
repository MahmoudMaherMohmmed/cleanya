<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BankAccountResource extends JsonResource
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
            'name' => $this->getTranslation('bank_name', app()->getLocale()),
            'account_name' => $this->account_name,
            'account_number' => $this->account_number,
            'IBAN' => $this->IBAN,
            "image" => isset($this->image) && $this->image != null ? url($this->image) : null,
            'created_at' => $this->created_at ? $this->created_at->toDateTimeString() : null,
            'created_at_formatted' => $this->created_at ? $this->created_at->diffForHumans() : null,
        ];
    }
}