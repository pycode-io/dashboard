<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LatestMovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLatestMovies()
    {
        $today = date('Y-m-d');
        $oneMonthAgo = date('Y-m-d', strtotime('-1 month'));
        // dd($oneMonthAgo);

        $latestMovies = DB::table('movies')
            ->whereBetween('release_date', [$oneMonthAgo, $today])
            ->orderByDesc('release_date')
            ->select('title', 'description', 'banner_image', 'movie_path','url','imdb_rating')
            ->get();

        $response = [
            'success' => true,
            'data' => $latestMovies,
        ];
        return response()->json($response, 200);
    }
}
