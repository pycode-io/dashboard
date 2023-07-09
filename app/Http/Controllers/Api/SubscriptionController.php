<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Models\User;

class SubscriptionController extends Controller
{
    public function subscriptionHistories(Request $request, $userId)
    {
        $user = User::find($userId);

        if (!$user) {
            return response()->json([
                'message' => 'User not found.',
            ], 404);
        }

        $subscriptionHistories = Subscription::join('users', 'users.id', '=', 'subscriptions.user_id')
            ->select(
                'subscriptions.id',
                'subscriptions.user_id',
                'subscriptions.pack_id',
                'subscriptions.start_date',
                'subscriptions.end_date',
                'subscriptions.payment_mode',
                'subscriptions.payment_date',
                'subscriptions.reference_id',
                'subscriptions.transaction_id',
                'subscriptions.amount',
                'subscriptions.status',
                'users.name',
                'users.email'
            )
            ->where('subscriptions.user_id', $userId)
            ->get();

        if ($subscriptionHistories->isEmpty()) {
            return response()->json([
                'message' => 'No subscription history found for this user.',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'subscriptions' => $subscriptionHistories,
        ]);
    }

    public function subscribe(Request $request)
    {
        
        $subscription = new Subscription;
        $subscription->user_id = $request->input('user_id');
        $subscription->pack_id = $request->input('pack_id');
        $subscription->start_date = now(); // or use the date provided in the request
        $subscription->end_date = now()->addMonth(); // or use the subscription duration provided in the request
        $subscription->payment_mode = $request->input('payment_mode');
        $subscription->payment_date = $request->input('payment_date');
        $subscription->reference_id = $request->input('reference_id');
        $subscription->transaction_id = $request->input('transaction_id');
        $subscription->status = $request->input('status');
        $subscription->amount = $request->input('amount');
        $subscription->save();


        if ($subscription->count() > 0) {
            return response()->json([
                'success' => true,
                'status' => 'success',
                'data' => $subscription
            ]);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Internal server error'
            ], 500);
        }

    }
}
