<?php

namespace App\Services;

use App\Http\Repository\TripRepository;
use App\Http\Requests\CalculationRequest;
use App\Http\Requests\DriverRequest;
use App\Http\Requests\TripsRequest;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

readonly class TripService
{
    public function __construct(private TripRepository $tripRepository)
    {
    }

    public function search(TripsRequest $request): LengthAwarePaginator
    {
        return $this->tripRepository->search($request);
    }

    public function getAllDrivers(CalculationRequest $request): LengthAwarePaginator
    {
        return $this->tripRepository->getAllDrivers($request);
    }

    public function getAllTripTime(DriverRequest $request): Collection
    {
        return $this->tripRepository->getTripTime($request);
    }
}
