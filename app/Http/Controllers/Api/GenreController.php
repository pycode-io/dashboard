<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Genre;
class GenreController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $genre = Genre::select('genre_title', 'genre_description')->get();
        $response = [
            'success' => true,
            'data' => $genre,
        ];
        return response()->json($response, 200);
    }
}
