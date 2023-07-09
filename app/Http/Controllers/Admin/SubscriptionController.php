<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        // $subscription_data = Subscription::where([
        //     ['start_date', '!=', Null],
        //     [function ($query) use ($request) {
        //         if (($search = $request->search)) {
        //             $query->orWhere('start_date', 'LIKE', '%' . $search . '%')
        //                 ->orWhere('transaction_id', 'LIKE', '%' . $search . '%')
        //                 ->get();
        //         }
        //     }]
        // ])->paginate(10);

        $query = Subscription::query();

        if ($request->has('search') && !empty($request->search)) {
            $query->orWhere('transaction_id', 'LIKE', '%' . $request->search . '%');
        }

        if (($request->has('start_date') && !empty($request->start_date)) && ($request->has('end_date') && !empty($request->start_date))) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        $subscription_data = $query->paginate(10);
        $subscriptions = Subscription::get();
        $user_details = User::get();

        return view('admin.subscription.index', ['subscription_data' => $subscription_data, 'subscriptions' => $subscriptions, 'user_details' => $user_details]);
    }

    public function showOrderDetails($id)
    {

        $view_subscriptions = Subscription::find($id);
        $view_user = User::get();

        return view('admin.subscription.show', ['view_subscriptions' => $view_subscriptions, 'view_user' => $view_user]);
    }


    public function deleted_users(Request $request)
    {

        $deleted_subscription = Subscription::onlyTrashed()->where([
            ['transaction_id', '!=', Null],
            [function ($query) use ($request) {
                if (($search = $request->search)) {
                    $query->orWhere('transaction_id', 'LIKE', '%' . $search . '%')
                        ->get();
                }
            }]
        ])->paginate(10);
        $user_details = User::get();
        $total_subscription = Subscription::onlyTrashed()->get();
        
        return view('admin.subscription.restore_index',['deleted_subscription' => $deleted_subscription,'total_subscription'=>$total_subscription, 'user_details' => $user_details]);
    }

    public function restore(Request $request, $id)
    {
        Subscription::withTrashed()->find($id)->restore();
  
        $request->session()->flash('success', 'Subscription Restored Successfully.');
        return redirect()->back();
    }  

    public function delete_permanent(Request $request, $id){
        // Permanently delete a soft deleted 
        $delete_permanent =  Subscription::withTrashed()->find($id);
        $delete_permanent->forceDelete();

        $request->session()->flash('success', 'Subscription Deleted permanently.');
        return redirect()->back();
    }

}
