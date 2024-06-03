<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TripResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'driver_id' => $this->driver_id,
            'pickup' => $this->pickup,
            'dropoff' => $this->dropoff,
        ];
    }
}
