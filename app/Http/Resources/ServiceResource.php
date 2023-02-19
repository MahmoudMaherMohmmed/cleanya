<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ClothResource;

class ServiceResource extends JsonResource
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
            'image' => $this->image != null ? url($this->image) : create_avater($this->getTranslation('title', app()->getLocale())),
            'clothes' => ClothResource::collection($this->clothes),
            'created_at' => $this->created_at ? $this->created_at->toDateTimeString() : null,
            'created_at_formatted' => $this->created_at ? $this->created_at->diffForHumans() : null,
        ];
    }
}
