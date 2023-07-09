<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $show_users = Admin::where([
            ['name', '!=', Null],
            [function ($query) use ($request) {
                if (($search = $request->search)) {
                    $query->orWhere('name', 'LIKE', '%' . $search . '%')
                        ->orWhere('email', 'LIKE', '%' . $search . '%')
                        ->orWhere('phone', 'LIKE', '%' . $search . '%')
                        ->get();
                }
            }]
        ])->paginate(10);

        $users = Admin::get();
        return view('admin.employee.index', ['users' => $users, 'show_users' => $show_users]);
    }

    public function create()
    {
        return view('admin.employee.create');
    }

    public function store(Request $request)
    {

        if (isset($request->user_id) && $request->user_id != null) {

            $user = Admin::find($request->user_id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->password = Hash::make($request->password);
            $user->address = $request->address;

            if (isset($request->status) && ($request->status == 'active')) {
                $current_status = 'active';
            } else {
                $current_status = 'inactive';
            }
            $user->status = $current_status;
            $user->save();
            $request->session()->flash('success', 'Data Updated successfully.');
            return redirect()->route('admin.employee.index');
        } else {


            $add_user = new Admin();
            $add_user->name = $request->name;
            $add_user->email = $request->email;
            $add_user->phone = $request->phone;
            $add_user->user_role = 'employee';
            $add_user->password = Hash::make($request->password);
            $add_user->address = $request->address;

            if (isset($request->status) && ($request->status == 'active')) {
                $current_status = 'active';
            } else {
                $current_status = 'inactive';
            }
            $add_user->status = $current_status;
            $add_user->save();
            
        }

        $request->session()->flash('success', 'Employee Added successfully.');
        return redirect()->route('admin.employee.index');
    }

    public function edit(Request $request, $id)
    {
        $edit_employee = Admin::find($id);
        if($edit_employee->user_role =='admin'){

            $request->session()->flash('success', "you don't have permission to change the admin details.");
            return redirect()->back();
        }
        return view('admin.employee.create', ['edit_employee' => $edit_employee]);
        
    }

    public function delete(Request $request, $id)
    {
        $delete_employee = Admin::find($id);
        if($delete_employee->user_role =='admin'){

            $request->session()->flash('success', "You don't have permission to delete the Admin.");
            return redirect()->back();
        }
        $delete_employee->delete();
        return redirect()->route('admin.employee.index');
    }

    public function updateStatus(Request $request)
    {
        
        $update_status = Admin::findOrFail($request->id);
        
        if($update_status->user_role =='admin'){

            return response()->json(['message' => "You don't have permission."]);
        }

        if (isset($request->status) && ($request->status == '1')) {
            $current_status = 'active';
        } else {
            $current_status = 'inactive';
        }
        $update_status->status = $current_status;
        $update_status->save();

        return response()->json(['message' => 'User status updated successfully.']);
    }
}
