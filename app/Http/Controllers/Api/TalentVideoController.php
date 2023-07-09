<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Talent;
use Illuminate\Support\Facades\File;
class TalentVideoController extends Controller
{
    public function storeVideo(Request $request)
    {

        $talent_video = new Talent();
        $talent_video->user_id = $request->user_id;
        $talent_video->title = $request->title;
        $talent_video->description = $request->description;

        if (isset($request->video)) {
            $video_file = $request->file('video');
            $extension = $video_file->getClientOriginalExtension();
            $media_file = preg_replace('/\s+/', '', $talent_video->title) . time() . '.' . $extension;
            $video_file->move('storage/talenthunt/', $media_file);
            $talent_video->video = $media_file;
        } else {
            
            $talent_video->video_url = $request->video_url;
        }

        $talent_video->save();

        return response()->json([
            'success' => true,
            'message' => 'Video uploaded successfully',
            'data' => $talent_video,
        ], 200);
    }
}
