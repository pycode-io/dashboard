<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Talent;
use App\Models\Comments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class TalentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $query = Talent::query();
        $query->join('users', 'talents.user_id', '=', 'users.id')
            ->select('talents.*', 'users.name', 'users.phone');

        if ($request->has('search') && !empty($request->search)) {
            $query->orWhere('name', 'LIKE', '%' . $request->search . '%')
                ->orWhere('phone', 'LIKE', '%' . $request->search . '%')
                ->orWhere('title', 'LIKE', '%' . $request->search . '%');
        }

        if (($request->has('start_date') && !empty($request->start_date)) && ($request->has('end_date') && !empty($request->start_date))) {
            $query->whereBetween('talents.created_at', [$request->start_date, $request->end_date]);
        }

        $talent_data = $query->paginate(10);
        $talents = Talent::get();

        return view('admin.talent-hunt.index', ['talent_data' => $talent_data, 'talents' => $talents]);
    }

    public function show_talents($id)
    {

        $talents_view = Talent::find($id);
        $user_details = User::get();

        return view('admin.talent-hunt.show', ['talents_view' => $talents_view, 'user_details' => $user_details]);
    }

    public function show_comments($id)
    {

        $users = User::get();
        $Talent_comments = Talent::find($id);
        $comments = $Talent_comments->user_comments;

        return view('admin.talent-hunt.viewcomments', ['Talent_comments' => $Talent_comments, 'comments' => $comments, 'users' => $users]);
    }


    public function deleted_records(Request $request)
    {

        $deleted_talent = Talent::onlyTrashed()->where([
            ['title', '!=', Null],
            [function ($query) use ($request) {
                if (($search = $request->search)) {
                    $query->orWhere('title', 'LIKE', '%' . $search . '%')
                        ->orWhere('description', 'LIKE', '%' . $search . '%')
                        ->get();
                }
            }]
        ])->paginate(10);
        $total_videos = Talent::onlyTrashed()->get();

        return view('admin.talent-hunt.restore_videos', ['deleted_talent' => $deleted_talent, 'total_videos' => $total_videos]);
    }

    public function restore(Request $request, $id)
    {
        Talent::withTrashed()->find($id)->restore();

        $request->session()->flash('success', 'Talent Restored Successfully.');
        return redirect()->back();
    }

    public function delete_permanent(Request $request, $id)
    {
        // Permanently delete a soft deleted 
        $delete_permanent =  Talent::withTrashed()->find($id);
        $delete_permanent->forceDelete();

        $request->session()->flash('success', 'Talent Deleted permanently.');
        return redirect()->back();
    }

    public function updateStatus(Request $request)
    {
        $talent_status = Talent::findOrFail($request->id);

        if (isset($request->status) && ($request->status == '1')) {
            $current_status = 'active';
        } else {
            $current_status = 'inactive';
        }
        $talent_status->status = $current_status;
        $talent_status->save();

        return response()->json(['message' => 'Talent status updated successfully.']);
    }
}
