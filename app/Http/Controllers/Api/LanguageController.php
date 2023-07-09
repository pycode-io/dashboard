<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Language;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function languages()
    {
        $all_language = Language::select('language', 'language_image')->get();
        $response = [
            'success' => true,
            'data' => $all_language,
        ];
        return response()->json($response, 200);
    }

    
}
