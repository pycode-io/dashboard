<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Term;
class TermController extends Controller
{
    public function index()
    {
        $terms = Term::latest()->select('terms.content')->first();

        return response()->json([
            'status'=>'success',
            'data' => $terms,
        ],200);
    }
}
