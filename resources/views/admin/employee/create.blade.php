@extends('admin.layouts.admin_main')
@push('title')
    <title>Add Employee</title>
@endpush
@section('admin_main-section')
    <!-- Start right Content here -->
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <!-- start page title -->
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <div class="page-title-box">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                <li class="breadcrumb-item">Employee</li>
                                <li class="breadcrumb-item active">Add Employee</li>
                            </ol>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="float-right d-none d-md-block">
                            <a href="{{ route('admin.employee.index') }}">
                                <button class="btn btn-primary" type="button" aria-expanded="false">
                                    Back
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">

                                <form class="custom-validation" action="{{ route('admin.employee.store') }}" method="post">
                                    @csrf
                                    @if (isset($edit_employee))
                                        <input hidden value="{{ $edit_employee->id }}" name="user_id" />
                                    @endif

                                    <div class="form-group row">
                                        <label for="name" class="col-sm-2 col-form-label">Name :</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="name" name="name"
                                                required placeholder="Enter Name"
                                                value="{{ isset($edit_employee) ? $edit_employee->name : '' }}" />
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="email" class="col-sm-2 col-form-label">Email :</label>
                                        <div class="col-sm-10">
                                            <input type="email" class="form-control" id="email" name="email"
                                                required placeholder="Enter Email"
                                                value="{{ isset($edit_employee) ? $edit_employee->email : '' }}" />
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="phone" class="col-sm-2 col-form-label">Phone
                                            :</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="phone" name="phone"
                                                required placeholder="Enter Number"
                                                value="{{ isset($edit_employee) ? $edit_employee->phone : '' }}" />
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="address" class="col-sm-2 col-form-label">Address
                                            :</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="address" name="address"
                                                required placeholder="Enter Address"
                                                value="{{ isset($edit_employee) ? $edit_employee->address : '' }}" />
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="password" class="col-sm-2 col-form-label">Password :</label>
                                        <div class="col-sm-10">
                                            <input type="password" class="form-control" id="password" name="password"
                                                required placeholder="Enter Password"
                                                value="{{ isset($edit_employee) ? $edit_employee->password : '' }}" />
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="user_status" class="col-sm-2 col-form-label">Status :</label>
                                        <div class="col-sm-10">
                                            <select name="status" id="user_status" class="form-control" required>
                                                <option value="">Select</option>
                                                {{-- <option value="active">Active</option>
                                                <option value="inactive">InActive</option> --}}
                                                
                                                <option value="active" {{ isset($edit_employee)?$edit_employee->status == 'active' ? 'selected':'':'' }}>Active</option>
                                                <option value="inactive" {{ isset($edit_employee)?$edit_employee->status == 'inactive' ? 'selected':'':'' }}>InActive</option>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label for="genre_description" class="col-sm-2 col-form-label"></label>
                                        <div class="col-sm-10">
                                            <button type="submit"
                                                class="btn btn-primary waves-effect waves-light mr-1">Submit</button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div> <!-- end col -->
                </div> <!-- end row -->
            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
    </div>
    <!-- end main content-->
@endsection
