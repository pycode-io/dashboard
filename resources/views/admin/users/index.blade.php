@extends('admin.layouts.admin_main')
@push('title')
    <title>Users Details</title>
    <link href="{{ asset('assets/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
@endpush
@section('admin_main-section')
    <!-- Start right Content here -->
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
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Users Details</a></li>
                            </ol>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="float-right d-none d-md-block">
                            <div class="dropdown">
                                <a class="btn btn-primary waves-effect waves-light" href="{{ route('admin.dashboard') }}">
                                    <i class="ion ion-md-add-arrow"></i> Back
                                </a>
                                <a class="btn btn-primary waves-effect waves-light" href="{{ route('users.create') }}">
                                    <i class="ion ion-md-add-circle-outline"></i> Add
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <form action="{{ route('users.index') }}" method="GET">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-12">
                
                                            <div class="col-md-2 mt-1 float-left">
                                                <input class="form-control" name="search" type="text"
                                                    placeholder="Search by number" data-toggle="tooltip" data-placement="top" data-original-title="Search Here..."/>
                                            </div>

                                            <div class="col-md-2 mt-1 float-left">
                                                <input class="form-control" name="start_date" type="date" data-toggle="tooltip" data-placement="top" data-original-title="Start Date"/>
                                            </div>

                                            <div class="col-md-2 mt-1 float-left">
                                                <input class="form-control" name="end_date" type="date" data-toggle="tooltip" data-placement="top" data-original-title="End Date"/>
                                            </div>
                
                                            <div class="col-lg-3 mt-6 float-left mt-1">
                                                <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">Submit
                                                </button>
                
                                                <a href="{{route('users.index')}}"><button type="button" class="btn btn-primary waves-effect waves-light mr-1" data-toggle="tooltip" data-placement="top" title="" data-original-title="Clear Search Filters"><i class="mdi mdi-refresh"></i>Clear</button>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- row end -->
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                @if (session()->has('success'))
                    <div class="alert alert-success">
                        {{ session()->get('success') }}
                    </div>
                @endif
                <!-- end page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <table id="example" class="table table-striped table-bordered" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>Sr.No.</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Address</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php $i = 1; foreach($user_data as $user){?>
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->phone }}</td>
                                                <td>{{ $user->address }}</td>
                                                <td>
                                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                
                                                    <a href="{{ route('users.delete', $user->id) }}" class="btn btn-danger"><i class="fa fa-trash"></i></a>

                                                    <a href="{{route('users.show', $user->id) }}" 
                                                     class="btn btn-primary"><i class="fa fa-eye"></i></a>
                                                </td>
                                                <?php $i++; ?>
                
                                            </tr>
                                            <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div> <!-- end col -->
                </div> <!-- end row -->
               
            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
    </div>
    <!-- end main content-->
   

    <script src="{{asset('assets/js/jquery-3.7.0.js')}}"></script>
    <script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/js/dataTables.bootstrap4.min.js')}}"></script>
    <script>
        $("#example").DataTable();
    </script>
    
@endsection
