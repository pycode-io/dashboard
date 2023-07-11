<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;
class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'phone' => ['required', 'digits:10'],
            'name' => 'required',
            'email' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'pincode' => 'required',
            'status' => 'required',
            'password' => 'required',
            'profile_image' => 'nullable',
        ]);


        $user = new User();
        $user->phone = $validatedData['phone'];
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
        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user_edit = User::findOrFail($id);

        return view('admin.users.edit',['user_edit' => $user_edit]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'phone' => ['required', 'digits:10'],
            'name' => 'required',
            'email' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'pincode' => 'required',
            'status' => 'required',
            'password' => 'required',
            'profile_image' => 'nullable',
        ]);
        $user  = User::findOrFail($id);
        $user->phone = $validatedData['phone'];
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
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $delete_user  = User::findOrFail($id);
        $delete_user->delete();
        $request->session()->flash('success', 'User Deleted successfully.');
        return redirect()->back();

    }
}
