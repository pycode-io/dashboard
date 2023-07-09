<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Genre;
use App\Models\Movies;
use Illuminate\Support\Facades\DB;
class MoviesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function similarMovies(Request $request)
    {
        $genreTitle = $request->search;

        $movies = DB::table('movies')
            ->whereRaw("CONCAT(',', movies.genre_id, ',') LIKE '%," . Genre::where('genre_title', $genreTitle)
            ->value('id') . ",%'")
            ->select('title', 'description', 'banner_image', 'movie_path','url','imdb_rating')
            ->get();

        if ($movies->count() > 0) {
            return response()->json([
                'status' => 'success',
                'data' => $movies
            ]);
        } else {
            return response()->json([
                'status' => 'not found',
                'message' => 'No Record Found'
            ], 404);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPopularMovies()
    {
        
        $latestMovies = Movies::where('imdb_rating','>=',4.0)
        ->select('title', 'description', 'banner_image', 'movie_path','url','imdb_rating')
        ->get();
        $response = [
            'success' => true,
            'data' => $latestMovies,
        ];
        return response()->json($response, 200);
    }


    public function searchMovies(Request $request){
        $genreTitle = $request->search;

        $movies = DB::table('movies')
            ->whereRaw("CONCAT(',', movies.genre_id, ',') LIKE '%," . Genre::where('genre_title', $genreTitle)
            ->value('id') . ",%'")
            ->orWhere('title', 'LIKE', '%' . $genreTitle . '%')
            ->select('title', 'description', 'banner_image', 'movie_path','url','imdb_rating')
            ->get();

        if ($movies->count() > 0) {
            return response()->json([
                'status' => 'success',
                'data' => $movies
            ]);
        } else {
            return response()->json([
                'status' => 'not found',
                'message' => 'No Record Found'
            ], 404);
        }
    }


}
