<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CalculationResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'driver_id' => $this->driver_id,
            'total_minutes_with_passenger' => round($this->total_minutes_with_passenger) ?? null,
        ];
    }
}
