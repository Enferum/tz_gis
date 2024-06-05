<?php

namespace App\Http\Controllers;

use App\Http\Requests\CalculationRequest;
use App\Http\Requests\DriverRequest;
use App\Http\Requests\TripsRequest;
use App\Http\Resources\CalculationResource;
use App\Http\Resources\TripResource;
use App\Services\TripService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TripController extends Controller
{
    public function __construct(private TripService $tripService)
    {
    }

    public function getDashboard(): View
    {
        return view('dashboard');
    }

    public function getCalculation(): View
    {
        return view('calculation');
    }

    public function searchTrips(TripsRequest $request): AnonymousResourceCollection
    {
        return TripResource::collection($this->tripService->search($request));
    }

    public function getDrivers(CalculationRequest $request): AnonymousResourceCollection
    {
        return CalculationResource::collection($this->tripService->getAllDrivers($request));
    }

    public function getCalculationTips(DriverRequest $request): JsonResponse
    {
        return response()->json($this->tripService->getAllTripTimeByDriver($request));
    }
}