<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SliderResource extends JsonResource
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
            'title' => $this->getTranslation('title', app()->getLocale()),
            'description' => $this->getTranslation('description', app()->getLocale()),
            "image" => $this->image != null ? url($this->image) : '',
            'created_at' => $this->created_at ? $this->created_at->toDateTimeString() : null,
            'created_at_formatted' => $this->created_at ? $this->created_at->diffForHumans() : null,
        ];
    }
}