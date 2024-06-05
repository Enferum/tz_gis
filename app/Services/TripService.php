<?php

namespace App\Services;

use App\Http\Repository\TripRepository;
use App\Http\Requests\CalculationRequest;
use App\Http\Requests\DriverRequest;
use App\Http\Requests\TripsRequest;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;

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

    public function getAllTripTimeByDriver(DriverRequest $request): array
    {
        $res = $this->tripRepository->getDriverTipsArray($request);

        $mergedIntervals = $this->mergeIntervals($res);
        $totalMinutes = 0;

        foreach ($mergedIntervals as $interval) {
            $pickup = Carbon::parse($interval['pickup']);
            $dropoff = Carbon::parse($interval['dropoff']);

            $totalMinutes += abs($dropoff->diffInSeconds($pickup));
        }

        $second = $totalMinutes % 60;
        $minutes = floor($totalMinutes / 60);
        $time = $minutes + $second / 100;

        return [
            'driver_id' => $request->driver_id,
            'total_minutes_with_passenger' => $time
        ];
    }

    protected function mergeIntervals($intervals)
    {
        $merged = [];
        $current = null;

        foreach ($intervals as $interval) {
            if ($current === null) {
                $current = $interval;
                continue;
            }

            if (Carbon::parse($current['dropoff'])->greaterThanOrEqualTo(Carbon::parse($interval['pickup']))) {
                $current['dropoff'] = max($current['dropoff'], $interval['dropoff']);
            } else {
                $merged[] = $current;
                $current = $interval;
            }

        }

        if ($current !== null) {
            $merged[] = $current;
        }

        return $merged;
    }
}
