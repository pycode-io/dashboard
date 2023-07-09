<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use GuzzleHttp\Client;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{

    protected $SMS_SENDERID = 'HOTOTT';
    protected $SMS_API_KEY = 'aG90b3R0OlptdjJJT3R5';

    public function index(Request $request)
    {
        $query = User::query();

        if ($request->has('search') && !empty($request->search)) {
            $query->orWhere('name', 'LIKE', '%' . $request->search . '%')
                ->orWhere('email', 'LIKE', '%' . $request->search . '%')
                ->orWhere('phone', 'LIKE', '%' . $request->search . '%');
        }

        if (($request->has('start_date') && !empty($request->start_date)) && ($request->has('end_date') && !empty($request->start_date))) {
            $query->whereBetween('users.created_at', [$request->start_date, $request->end_date]);
        }

        $user_data = $query->paginate(10);
        $record = User::get();

        return view('admin.users.index', ['user_data' => $user_data, 'record' => $record]);
    }

    public function create()
    {
        $language = Language::get();
        return view('admin.users.create', ['language' => $language]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'phone' => ['required', 'digits:10'],
            'language_1' => 'required',
            'language_2' => 'nullable|different:language_1',
            'language_3' => 'nullable|different:language_1|different:language_2',
            'name' => 'required',
            'email' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'pincode' => 'required',
            'status' => 'required',
            'password' => 'required',
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

                $request->session()->flash('success', 'Please select Language 2 and Language 3 different from the previous.');
                return redirect()->route('admin.users.index');
            }
        } else {
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

        $request->session()->flash('success', 'User Created successfully.');
        return redirect()->route('admin.users.index');
    }


    public function update(Request $request)
{
    $validatedData = $request->validate([
        'phone' => ['required', 'digits:10'],
        'language_1' => 'required',
        'language_2' => 'nullable|different:language_1',
        'language_3' => 'nullable|different:language_1|different:language_2',
        'name' => 'required',
        'email' => 'required',
        'address' => 'required',
        'city' => 'required',
        'state' => 'required',
        'pincode' => 'required',
        'status' => 'required',
        'password' => 'required',
        'profile_image' => 'nullable',
        'latitude' => 'nullable',
        'lognitute' => 'nullable',
        'device_name' => 'nullable',
        'device_imei' => 'nullable',
        'installed_date' => 'nullable',
    ]);
    if (isset($request->user_id) && $request->user_id != null) {

        $user = User::findOrFail($request->user_id);

    // Check if the language options are different from the previous selection
    if (($request->language_2 == $user->language_1 ||
            $request->language_3 == $user->language_1 ||
            $request->language_2 == $user->language_2 ||
            $request->language_3 == $user->language_2 ||
            $request->language_2 == $user->language_3 ||
            $request->language_3 == $user->language_3 ) && $request->phone != $user->phone) {

        $request->session()->flash('success', 'Please select Language 2 and Language 3 different from the previous.');
        return redirect()->route('admin.users.index');
    }

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

    $request->session()->flash('success', 'User Updated successfully.');
    return redirect()->route('admin.users.index');
    }else{

        $request->session()->flash('success', 'User Not Found.');
        return redirect()->route('admin.users.index');
    }
}

    public function edit($id)
    {
        $edit_users = User::find($id);
        $language = Language::get();
        return view('admin.users.edit', ['edit_users' => $edit_users, 'language' => $language]);
    }



    public function deleteUser(Request $request, $id)
    {
        $SMS_BASE_URL = "https://webpostservice.com/sendsms_v2.0/sendsms.php?apikey=" . $this->SMS_API_KEY . "&type=TEXT&sender=" . $this->SMS_SENDERID;
        // $mobileNumber = $request->input('mobile_number');
        $mobileNumber = "9044438303";
        $otp = rand(1000, 9999); // Generate a random 4-digit OTP

        // Store OTP code in the session
        $request->session()->put('delete_user_otp', $otp);

        $name =  Auth::guard('admin')->user()->name;

        $message = "Dear " . $name . " Your OTP Code is: " . $otp . ". please do not share with anyone.
        Thank You HOTOTT ENTERTAINMENT PRIVATE LIMITED";

        $client = new Client();

        $response = $client->get($SMS_BASE_URL . "&mobile=" . $mobileNumber . "&message=" . urlencode($message) . "&peId=1301162488706014164&tempId=1307162521569403987");

        if ($response->getStatusCode() == 200) {
            // OTP sent successfully, store the OTP in the database or session
            // and return a success response to the user
            return response()->json([
                'status' => 'success',
                'message' => 'OTP sent successfully.'
            ]);
        } else {
            // Error sending OTP, return an error response to the user
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to send OTP. Please try again later.'
            ]);
        }
    }

    public function destroy(Request $request, $id)
    {
        // Check if the entered OTP code matches the stored OTP
        $otp = $request->session()->get('delete_user_otp');
        if ($request->otp_code != $otp) {
            // Return an error response if OTP is incorrect
            return response()->json(['error' => 'Invalid OTP code'], 400);
        }

        // Delete user
        $user = User::findOrFail($id);
        $user->delete();

        // Return a success response
        return response()->json(['success' => true]);
    }

    public function show($id)
    {

        $show_user = User::find($id);
        $pradeep =  explode(',', $show_user->language);
        $language = Language::get();

        return view('admin.users.show', ['show_user' => $show_user, 'language' => $language, 'pradeep' => $pradeep]);
    }



    public function deleted_users(Request $request)
    {

        $deleted_users = User::onlyTrashed()->where([
            ['name', '!=', Null],
            [function ($query) use ($request) {
                if (($search = $request->search)) {
                    $query->orWhere('name', 'LIKE', '%' . $search . '%')
                        ->orWhere('email', 'LIKE', '%' . $search . '%')
                        ->orWhere('phone', 'LIKE', '%' . $search . '%')
                        ->orWhere('address', 'LIKE', '%' . $search . '%')
                        ->get();
                }
            }]
        ])->paginate(10);

        $total_users = User::onlyTrashed()->get();

        return view('admin.users.restore_index', ['deleted_users' => $deleted_users, 'total_users' => $total_users]);
    }

    public function restore(Request $request, $id)
    {
        User::withTrashed()->find($id)->restore();

        $request->session()->flash('success', 'User Restored Successfully.');
        return redirect()->back();
    }

    public function delete_permanent(Request $request, $id)
    {
        // Permanently delete a soft deleted Movies
        $delete_permanent =  User::withTrashed()->find($id);
        $delete_permanent->forceDelete();

        $request->session()->flash('success', 'User Deleted permanently.');
        return redirect()->back();
    }

    public function updateStatus(Request $request)
    {

        $update_status = User::findOrFail($request->id);

        if (isset($request->status) && ($request->status == '1')) {
            $current_status = 'Active';
        } else {
            $current_status = 'InActive';
        }
        $update_status->status = $current_status;
        $update_status->save();

        return response()->json(['message' => 'User status updated successfully.']);
    }
}
