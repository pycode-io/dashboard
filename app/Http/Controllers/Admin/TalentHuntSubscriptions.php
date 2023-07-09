<?php

namespace App\Http\Controllers\Admin;

use App\Models\TalentHuntSubscription;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\MoviePlans;

class TalentHuntSubscriptions extends Controller
{
    public function index(Request $request)
    {

        $query = TalentHuntSubscription::query();
        $query->join('users', 'talent_hunt_subscriptions.user_id', '=', 'users.id')
            ->select('talent_hunt_subscriptions.*', 'users.name', 'users.phone');

        if ($request->has('search') && !empty($request->search)) {
            $query->orWhere('name', 'LIKE', '%' . $request->search . '%')
                ->orWhere('phone', 'LIKE', '%' . $request->search . '%')
                ->orWhere('transaction_id', 'LIKE', '%' . $request->search . '%');
        }

        if (($request->has('start_date') && !empty($request->start_date)) && ($request->has('end_date') && !empty($request->start_date))) {
            $query->whereBetween('talents.created_at', [$request->start_date, $request->end_date]);
        }

        $subscription_data = $query->paginate(10);
        $TalentHuntSubscription = TalentHuntSubscription::get();

        return view('admin.talent-hunt.subscription', [
            'TalentHuntSubscription' => $TalentHuntSubscription, 'subscription_data' => $subscription_data,]);
    }

    public function invoice($id)
    {

        $show_subscriptions = TalentHuntSubscription::join('users', 'talent_hunt_subscriptions.user_id', '=', 'users.id')->where('th_subscription_id', '=',$id)->first();

        return view('admin.talent-hunt.subscriptionshow', ['show_subscriptions' => $show_subscriptions]);
    }

    public function showTalentSubscription($id)
    {
        
        $show_subscriptions = TalentHuntSubscription::join('users','talent_hunt_subscriptions.user_id', '=', 'users.id')
        ->join('movie_plans', 'talent_hunt_subscriptions.pack_id', '=', 'movie_plans.id')
        ->where('th_subscription_id', '=',$id)->first();

        return view('admin.talent-hunt.viewsubscription', ['show_subscriptions' => $show_subscriptions]);
    }
}
