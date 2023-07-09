<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Feedback;
use Illuminate\Support\Facades\Validator;
class FeedbackController extends Controller
{
    public function addFeedback(Request $request)
    {
        
       
        $validator = Validator::make($request->all(), [
            'contact_number' => 'required|digits:10',
            'description' => 'required|string',
            'star_rating' => 'required|integer|between:1,5',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $feedback = new Feedback();
        $feedback->contact_number = $request->input('contact_number');
        $feedback->description = $request->input('description');
        $feedback->star_rating = $request->input('star_rating');
        $feedback->save();

        return response()->json([
            'success' => true,
            'message' => 'Feedback saved successfully',
            'feedback' => $feedback,
        ]);
    }
}
