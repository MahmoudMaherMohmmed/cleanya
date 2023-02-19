<?php

namespace App\Http\Resources;

use App\Models\Cloth;
use App\Models\Service;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservationItemResource extends JsonResource
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
            'service' => $this->getServiceName($this->service_id),
            'cloth' => $this->getClothName($this->cloth_id),
            'piece_cost' => sprintf("%1.2f", $this->piece_cost),
            'pieces_number' => $this->pieces_number,
            'cost' => sprintf("%1.2f", $this->cost),
        ];
    }

    /**
     * getServiceName
     *
     * @param mixed $service_id
     * @return mixed
     */
    private function getServiceName($service_id)
    {
        $service = Service::where('id', $service_id)->first();

        return $service->getTranslation('title', app()->getLocale());
    }

    /**
     * getClothName
     *
     * @param mixed $cloth_id
     * @return mixed
     */
    private function getClothName($cloth_id)
    {
        $cloth = Cloth::where('id', $cloth_id)->first();

        return $cloth->getTranslation('title', app()->getLocale());
    }
}
