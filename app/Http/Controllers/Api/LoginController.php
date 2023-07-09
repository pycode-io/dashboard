<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    protected $smsSenderId = 'HOTOTT';
    protected $smsApiKey = 'aG90b3R0OlptdjJJT3R5';

    /**
     * Send OTP to the user's phone number and update the user's record with the new OTP.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $smsBaseUrl = "https://webpostservice.com/sendsms_v2.0/sendsms.php?apikey=" . $this->smsApiKey . "&type=TEXT&sender=" . $this->smsSenderId;

        $request->validate([
            'phone' => 'required',
        ]);

        $user = DB::table('users')->where('phone', $request->input('phone'))
        ->select('id','name','phone','email')->first();

        if ($user) {
            $otp = rand(100000, 999999);

            DB::table('users')->where('id', $user->id)->update(['otp' => $otp]);
            
            $message = "Dear " . $user->name . " Your OTP Code is: " . $otp . ". please do not share with anyone.Thank You HOTOTT ENTERTAINMENT PRIVATE LIMITED";

            $client = new Client();
            $client->get($smsBaseUrl . "&mobile=" . $user->phone . "&message=" . urlencode($message) . "&peId=1301162488706014164&tempId=1307162521569403987");

            return response()->json([
                'success' => true,
                'message' => 'OTP has been sent to your phone number',
                'data' =>  $user,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'We could not find a user with that phone number.',
            ], 404);
        }
    }

    /**
     * Verify the OTP entered by the user and login the user if OTP is correct.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'otp' => 'required|numeric',
        ]);

        $user = DB::table('users')->where('phone', $request->input('phone'))->first();

        if ($user && $user->otp == $request->input('otp')) {
            Auth::loginUsingId($user->id);

            DB::table('users')->where('id', $user->id)->update(['otp' => null]);

            return response()->json([
                'success' => true,
                'message' => 'OTP verified successfully',
            ], 200);
            
        } else {
            return response()->json([
                'success' => false,
                'message' => 'The OTP is invalid.',
            ], 401);
        }
    }
}
