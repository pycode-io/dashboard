@extends('admin.layouts.admin_main')
@push('title')
    <title>edit Users</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
@endpush
@section('admin_main-section')
    <!-- ============================================================== -->
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <!-- start page title -->
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <div class="page-title-box">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                <li class="breadcrumb-item">Users Details</li>
                                <li class="breadcrumb-item active">Edit User</li>
                            </ol>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="float-right d-none d-md-block">
                            <div class="dropdown">
                                <a href="{{ route('users.index') }}">
                                    <button class="btn btn-primary" type="button" aria-expanded="false">
                                        Back
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">

                                <form class="custom-validation" action="{{ route('users.update',$user_edit->id) }}" method="post" enctype="multipart/form-data">
                                    @csrf

                                    <div class="form-group row">
                                        <label for="name" class="col-sm-2 col-form-label">Name :</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="name" name="name"
                                                required placeholder="Enter Name"
                                                value="{{$user_edit->name}}" />
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="email" class="col-sm-2 col-form-label">Email :</label>
                                        <div class="col-sm-10">
                                            <input type="email" class="form-control" id="email" name="email"
                                                required placeholder="Enter Email"
                                                value="{{$user_edit->email}}" />
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="phone" class="col-sm-2 col-form-label">Phone
                                            :</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="phone" name="phone"
                                                required placeholder="Enter Phone Number"
                                                value="{{$user_edit->phone}}" />
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="password" class="col-sm-2 col-form-label">Password :</label>
                                        <div class="col-sm-10">
                                            <input type="password" class="form-control" id="password" name="password"
                                                required placeholder="Enter Password"
                                                value="{{ $user_edit->password }}" />
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label for="city" class="col-sm-2 col-form-label">City :</label>
                                        <div class="col-sm-10">
                                            <input type="text" id="city" class="form-control" name="city"
                                                value="{{$user_edit->city}}"
                                                placeholder="Enter City Name">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="state" class="col-sm-2 col-form-label">State :</label>
                                        <div class="col-sm-10">
                                            <input type="text" id="state" class="form-control" name="state"
                                                value="{{ $user_edit->state }}"
                                                placeholder="Enter State Name">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="address" class="col-sm-2 col-form-label">Address :</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="address" name="address"
                                                required placeholder="Enter Address"
                                                value="{{ $user_edit->address}}" />
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="pincode" class="col-sm-2 col-form-label">Pincode :</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="pincode" name="pincode"
                                                required placeholder="Enter Pincode"
                                                value="{{ $user_edit->pincode }}" />
                                        </div>
                                    </div>

                                    {{-- <div class="form-group row">
                                        <label for="profile_image" class="col-sm-2 col-form-label">Profile Image :</label>
                                        <div class="col-sm-10">
                                            <input type="file" class="form-control" id="profile_image"
                                                name="profile_image" value="{{ $user_edit->profile_image }}" />

                                                <!-- Show the image box -->
                                                <img src="{{asset('storage/users/'.$user_edit->profile_image)}}" alt="image" width="50" height="50">
                                                
                                        </div>
                                    </div> --}}



                                    <div class="form-group row">
                                        <label for="status" class="col-sm-2 col-form-label">Status :</label>
                                        <div class="col-sm-10">
                                            <select name="status" id="status" class="form-control" required>
                                                <option value="">Select</option>

                                                <option value="Active"{{ $user_edit->status == 'Active' ? 'selected' : ''}}> Active</option>

                                                <option value="InActive" {{ $user_edit->status == 'InActive' ? 'selected' : '' }}> InActive</option>

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
    <!-- Initialize the plugin: -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('select').selectpicker();
        });
    </script>
@endsection
