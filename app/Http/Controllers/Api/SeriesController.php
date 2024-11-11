<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Series;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\SeriesResource;

class SeriesController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(SeriesResource::collection(Series::all()));
    }
}
