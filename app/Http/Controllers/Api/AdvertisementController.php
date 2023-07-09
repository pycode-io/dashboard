<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Advertisement;
use App\Http\Controllers\Controller;
class AdvertisementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $advertisements = Advertisement::select('title', 'description', 'advertised_video', 'duration')->get();
        $response = [
            'success' => true,
            'data' => $advertisements,
        ];
        return response()->json($response, 200);
    }

}
