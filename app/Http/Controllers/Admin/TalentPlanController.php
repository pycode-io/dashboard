<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TalentHuntPlan;

class TalentPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $talent_plan = TalentHuntPlan::where([
            ['thp_plan', '!=', Null],
            [function ($query) use ($request) {
                if (($search = $request->search)) {
                    $query->orWhere('thp_plan', 'LIKE', '%' . $search . '%')
                        ->orWhere('thp_description', 'LIKE', '%' . $search . '%')
                        ->get();
                }
            }]
        ])->paginate(10);

        $talent_plan_data = TalentHuntPlan::get();
        return view('admin.talent-plan.index',['talent_plan'=>$talent_plan,'talent_plan_data'=>$talent_plan_data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.talent-plan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){

        if (isset($request->plan_id) && $request->plan_id != null) {
        
            $plans = TalentHuntPlan::find($request->plan_id);
            $plans->thp_plan  = $request->thp_plan;   
            $plans->thp_description  = $request->thp_description;
            $plans->thp_price  = $request->thp_price;
            $plans->thp_validity  = $request->thp_validity;
            $plans->thp_movies_qty  = $request->thp_movies_qty;
            $plans->save();
            $request->session()->flash('success', 'Data Updated successfully.');
            return redirect()->route('admin.talents.plan.index');

        } else {
            $this->validate($request, [
                'thp_plan' => ['required', 'unique:talent_hunt_plans'],
            ]);

            $add_plans = new TalentHuntPlan();
            $add_plans->thp_plan  = $request->thp_plan;   
            $add_plans->thp_description  = $request->thp_description;
            $add_plans->thp_price  = $request->thp_price;
            $add_plans->thp_validity  = $request->thp_validity;
            $add_plans->thp_movies_qty  = $request->thp_movies_qty;
            $add_plans->save();

            $request->session()->flash('success', 'Data Inserted successfully.');
            return redirect()->route('admin.talents.plan.index');    
        }
        
    }

    public function edit($id)
    {
        $edit_plan = TalentHuntPlan::find($id);
        return view('admin.talent-plan.create', ['edit_plan' => $edit_plan]);
    }

    public function destroy(Request $request, $id){

        $delete_plan = TalentHuntPlan::find($id);
        $delete_plan->delete();
        $request->session()->flash('success', 'Data Deleted successfully.');
        return redirect()->route('admin.talents.plan.index');
    }
}
