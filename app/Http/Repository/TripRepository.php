<?php

namespace App\Http\Repository;

use App\Http\Requests\CalculationRequest;
use App\Http\Requests\DriverRequest;
use App\Http\Requests\TripsRequest;
use App\Models\Trip;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class TripRepository
{
    public function search(TripsRequest $request): LengthAwarePaginator
    {
        return Trip::query()
            ->when(!is_null($request['search']), function ($query) use ($request) {
                $query->where('id', 'like', '%' . $request['search'] . '%')
                    ->orWhere('driver_id', 'like', '%' . $request['search'] . '%');
            })
            ->orderBy($request['sort'], $request['delimiter'])
            ->paginate(Trip::LIMIT, page: $request['currentPage']);
    }

    public function getAllDrivers(CalculationRequest $request): LengthAwarePaginator
    {
        return Trip::query()
            ->select('driver_id')
            ->when(!is_null($request['search']), function ($query) use ($request) {
                $query->orWhere('driver_id', 'like', '%' . $request['search'] . '%');
            })
            ->groupBy('driver_id')
            ->orderBy($request['sort'], $request['delimiter'])
            ->paginate(Trip::LIMIT, page: $request['currentPage']);
    }

    public function getTripTime(DriverRequest $request): Collection|array
    {
        return Trip::query()
            ->select(
                'driver_id',
                DB::raw('SUM(UNIX_TIMESTAMP(dropoff) - UNIX_TIMESTAMP(pickup)) / 60 AS total_minutes_with_passenger')
            )
            ->where('driver_id', $request['driver_id'])
            ->groupBy('driver_id')
            ->get();
    }
}
