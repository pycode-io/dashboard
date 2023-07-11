@extends('admin.layouts.admin_main')
@push('title')
    <title>Employee</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.css">
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
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Employee</a></li>
                            </ol>
                        </div>
                    </div>
                    @if (Auth::guard('admin')->user()->user_role == 'admin')
                        <div class="col-sm-6">
                            <div class="float-right d-none d-md-block">
                                <div class="dropdown">
                                    <a href="{{ route('employee.create') }}">
                                        <button class="btn btn-primary" type="button" aria-expanded="false">Add Employee
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="row">
                    <div class="col-xl-12">
                        <form action="{{ route('employee.search') }}" method="GET">
                            <div class="col-md-3 mt-1 float-left ">
                                <input type="text" class="form-control" name="search" placeholder="Search..." />
                            </div>
                            <div class="float-left m-1">
                                <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">Submit</button>
                                <a class="m-1" href="{{ route('employee.index') }}"><button type="button"
                                        class="btn btn-primary waves-effect waves-light mr-1"><i
                                            class="mdi mdi-refresh"></i>Reset
                                    </button></a>
                            </div>
                        </form>
                    </div>
                </div>
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
                                <table id="datatable-buttons"
                                    class="table table-striped table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Sr.No</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Address</th>
                                            @if (Auth::guard('admin')->user()->user_role == 'admin')
                                            <th>Status</th>
                                            <th>Action</th>
                                            @endif

                                        </tr>
                                    </thead>

                                    <tbody>
                                        @if (count($show_users) > 0)
                                            <?php $i = 1; foreach($show_users as $item){?>
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->email }}</td>
                                                <td>{{ $item->phone }}</td>
                                                <td>{{ $item->address }}</td>
                                                @if (Auth::guard('admin')->user()->user_role == 'admin')

                                                <td>
                                                    <input type="checkbox" data-id="{{ $item->id }}" name="status" class="js-switch" {{ $item->status == 'active' ? 'checked' : '' }}>
                                                </td>

                                                <td>
                                                    <a href="{{ route('employee.edit', $item->id) }}" class="btn btn-primary"><i class="fa fa-edit"></i></a>

                                                    <a href="{{ route('employee.delete', $item->id) }}" class="btn btn-danger">
                                                    <i class="fa fa-trash"></i></a>
                                                </td>
                                                @endif
                                                <?php $i++; ?>
                                            </tr>
                                            <?php }?>
                                        @else
                                            <tr>
                                                <th></th><th></th><th></th>
                                                <th class="d-flex justify-content-center">No data found</th>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                                <div class="row align-items-center">
                                    <div class="col-sm-6">
                                        <div class="page-title-box">
                                            {{ $show_users->firstItem() }} - {{ $show_users->lastItem() }} of
                                            {{ count($users) }} results
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="float-right d-none d-md-block">
                                            <div class="d-flex justify-content-center">
                                                {!! $show_users->links() !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end col -->
                </div> <!-- end row -->

            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
    </div>
    <!-- end main content-->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        let elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        elems.forEach(function(html) {
            let switchery = new Switchery(html, {
                size: 'small'
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.js-switch').change(function() {
                let status = $(this).prop('checked') === true ? 1 : 0;
                let Id = $(this).data('id');
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '{{ route('employee.change.status') }}',
                    data: {'status': status, 'id': Id },
                    success: function(data) {
                        toastr.options.closeButton = true;
                        toastr.options.closeMethod = 'fadeOut';
                        toastr.options.closeDuration = 100;
                        toastr.success(data.message);
                    }
                });
            });
        });
    </script>

@endsection