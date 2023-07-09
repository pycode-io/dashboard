<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Talent;
class TalentHuntController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getTalentByUser($id)
    {
        $movies =Talent::where('user_id','=', $id)->join('users', 'talents.user_id', '=', 'users.id')
        ->select('talents.title','talents.description','talents.video','talents.video_url','talents.share','talents.likes','talents.view','talents.comments', 'users.name', 'users.phone','users.email')->get();
            

        if ($movies->count() > 0) {
            return response()->json([
                'status' => 'success',
                'data' => $movies
            ]);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'No Record Found'
            ], 404);
        }
    }

}
