<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use GuzzleHttp\Client;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        // Validate request data
        $validatedData = $request->validate([
            'phone' => ['required', 'digits:10'],
            'language_1' => 'required',
            'language_2' => 'nullable|different:language_1',
            'language_3' => 'nullable|different:language_1|different:language_2',
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'pincode' => 'required',
            'status' => 'required',
            'password' => 'required|min:8',
            'profile_image' => 'nullable',
            'latitude' => 'nullable',
            'lognitute' => 'nullable',
            'device_name' => 'nullable',
            'device_imei' => 'nullable',
            'installed_date' => 'nullable',
        ]);
    
        // Check if the user already exists with the given phone number
        $user = User::where('phone', '=', $request->phone)->first();
    
        if ($user) {
            // Check if the language options are different from the previous selection
            if ($request->language_2 == $user->language_1 ||
                $request->language_3 == $user->language_1 ||
                $request->language_2 == $user->language_2 ||
                $request->language_3 == $user->language_2 ||
                $request->language_2 == $user->language_3 ||
                $request->language_3 == $user->language_3 ) {
    
                return response()->json([
                    'success' => false,
                    'message' => 'Please select Language 2 and Language 3 different from the previous.'
                ], 400);
            }
        } else {
            // Create a new user
            $user = new User;
            $user->phone = $validatedData['phone'];
            $user->language_1 = $validatedData['language_1'];
            $user->language_2 = $validatedData['language_2'];
            $user->language_3 = $validatedData['language_3'];
            $user->name = $validatedData['name'];
            $user->email = $validatedData['email'];
            $user->address = $validatedData['address'];
            $user->city = $validatedData['city'];
            $user->state = $validatedData['state'];
            $user->pincode = $validatedData['pincode'];
            $user->status = $validatedData['status'];
            $user->password = Hash::make($validatedData['password']);
            $user->save();
        }
    
        return response()->json([
            'success' => true,
            'message' => 'User Created successfully.'
        ], 200);
    }
}
