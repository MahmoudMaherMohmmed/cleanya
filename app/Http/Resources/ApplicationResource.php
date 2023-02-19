<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationResource extends JsonResource
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
            'title' => $this->getTranslation('title', app()->getLocale()),
            'description' => $this->getTranslation('description', app()->getLocale()),
            'email_1' => $this->email_1,
            'email_2' => $this->email_2,
            "phone_1" => $this->phone_1,
            "phone_2" => $this->phone_2,
            "facebook_link" => $this->facebook_link,
            "whatsapp_link" => $this->whatsapp_link,
            "twitter_link" => $this->twitter_link,
            "instagram_link" => $this->instagram_link,
            "snapchat_link" => $this->snapchat_link,
            "youtube_link" => $this->youtube_link,
            "linkedin_link" => $this->linkedin_link,
            "tiktok_link" => $this->tiktok_link,
            "lat" => $this->lat,
            "lng" => $this->lng,
            "logo" => $this->logo != null ? url($this->logo) : '',
        ];
    }
}