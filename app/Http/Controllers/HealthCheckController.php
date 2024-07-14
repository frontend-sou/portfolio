<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class HealthCheckController extends Controller
{
    public function check()
    {
        try {
            DB::connection()->getPdo();
            return response()->json(['status' => 'healthy'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['status' => 'unhealthy'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
