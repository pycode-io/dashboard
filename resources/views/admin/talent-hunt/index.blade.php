@extends('admin.layouts.admin_main')
@push('title')
    <title>Talent Hunt</title>
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
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Talent Hunt</a></li>
                            </ol>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="float-right d-none d-md-block">
                            <div class="dropdown">
                                <a href="{{ route('admin.dashboard') }}">
                                    <button class="btn btn-primary" type="button" aria-expanded="false">
                                        Back
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12">
                        <form action="{{ route('admin.talents.index') }}" method="GET">
                            <div class="col-md-3 mt-1 float-left ">
                                <label for="">Search</label>
                                <input type="text" class="form-control" name="search" placeholder="Search..." />
                            </div>

                            <div class="col-md-3 mt-1 float-left ">
                                <label for="">Start Date</label>
                                <input type="date" name="start_date" class="form-control">
                            </div>

                            <div class="col-md-3 mt-1 float-left">
                                <label for="">End Date</label>
                                <input type="date" name="end_date" class="form-control">
                            </div>

                            <div class="col-md-3 float-left" style="margin-top: 32px">
                                <button type="submit" class="btn btn-primary waves-effect waves-light ">Submit</button>

                                <a href="{{ route('admin.talents.index') }}">
                                    <button type="button" class="btn btn-primary waves-effect waves-light mr-1"><i
                                            class="mdi mdi-refresh"></i>Reset
                                    </button>
                                </a>
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
                                            <th>Phone</th>
                                            <th>Title</th>
                                            <th>Description</th>
                                            <th>Url</th>
                                            <th>Like</th>
                                            <th>View</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @if (count($talent_data) > 0)
                                            <?php $i = 1; foreach($talent_data as $item){?>
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->phone }}</td>
                                                <td>{{ $item->title }}</td>
                                                <td>{{ $item->description }}</td>
                                                <td>
                                                    <a href="{{$item->video_url}}" target="_blank">{{$item->video_url}}</a>
                                                    
                                                </td>
                                                <td>{{ $item->likes }}</td>
                                                <td>{{ $item->view }}</td>
                                                <td>
                                                    <input type="checkbox" data-id="{{ $item->id }}" name="status" class="js-switch" {{ $item->status == 'active' ? 'checked' : '' }}>

                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.talents.view', $item->id) }}"
                                                        class="btn btn-primary"><i class="fa fa-eye"></i> </a>
                                                    <a href="{{ route('admin.talents.comments', $item->id) }}"
                                                        class="btn btn-warning"><i class="fa fa-eye"></i> Comments</a>
                                                </td>

                                                <?php $i++; ?>
                                            </tr>
                                            <?php }?>
                                        @else
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td class="text-center">No data found</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                                <div class="row align-items-center">
                                    <div class="col-sm-6">
                                        <div class="page-title-box">
                                            {{ $talent_data->firstItem() }} - {{ $talent_data->lastItem() }} of
                                            {{ count($talents) }} results
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="float-right d-none d-md-block">
                                            <div class="d-flex justify-content-center">
                                                {!! $talent_data->links() !!}
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
                let talent_id = $(this).data('id');
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '{{ route('admin.talents.change.status') }}',
                    data: {'status': status, 'id': talent_id },
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
