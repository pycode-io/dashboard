<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PrivacyPolicy;
class PrivacyPolicyController extends Controller
{ 
    public function index(Request $request)
    {
        $policy = PrivacyPolicy::latest()->first();

        return response()->json([
            'status' => 'success',
            'text' => $policy->text,
            
        ], 200);
    }
}
