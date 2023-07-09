@extends('admin.layouts.admin_main')
@push('title')
    <title>Movies Details</title>
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
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Movies Details</a></li>
                            </ol>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="float-right d-none d-md-block">
                            <div class="dropdown">
                                <a href="{{ route('admin.dashboard') }}">
                                    <button class="btn btn-primary" type="button" aria-expanded="false">Dashboard
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12">
                        <form action="{{ route('admin.movies.archive') }}" method="GET">
                            <div class="col-md-3 mt-1 float-left ">
                                <input type="text" class="form-control" name="search" placeholder="Search..." />
                            </div>
                            <div class="float-left m-1">
                                <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">Submit</button>
                                <a class="m-1" href="{{ route('admin.movies.archive') }}"><button type="button"
                                        class="btn btn-primary waves-effect waves-light mr-1" >
                                        <i class="mdi mdi-refresh"></i>Reset
                                    </button></a>
                            </div>
                        </form>

                        {{-- <form action="{{ route('admin.movies.between-dates') }}" method="GET">
                            <div class="col-md-3 mt-1 float-left ">
                                <input type="date" name="start_date" class="form-control">
                            </div>
                            <div class="col-md-3 mt-1 float-left ">
                                <input type="date" name="end_date" class="form-control">
                            </div>
                            <div class="float-left m-1">
                                <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">Submit</button>
                            </div>
                        </form> --}}
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
                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Sr.No</th>
                                            <th>Title</th>
                                            <th>Description</th>
                                            <th>Banner Image</th>
                                            <th>Url</th>
                                            <th>IMDB Rating</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @if (count($restor_movies) > 0)
                                            <?php $i = 1; foreach($restor_movies as $item){?>
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td>{{ $item->title }}</td>
                                                <td>{{ $item->description }}</td>
                                                <td><img src="{{ asset('storage/movies/' . $item->banner_image) }}"
                                                        class="img-circle person" alt="San Francisco" width="150"
                                                        height="150"></td>
                                                <td>{{ $item->url }}</td>
                                                <td>{{ $item->imdb_rating }}</td>
                                                <td>{{ $item->status }}</td>
                                                <td>
                                                    <a href="{{route('admin.movies.permanents_delete',$item->id)}}" class="btn btn-danger del"><i class="fa fa-eye"></i>delete</a>

                                                    <a href="{{ route('admin.movies.restore', $item->id) }}"
                                                        class="btn btn-warning restore"><i class="fa fa-edit"></i>Restore</a>

                                                </td>
                                                <?php $i++; ?>
                                            </tr>
                                            <?php }?>
                                        @else
                                            <tr>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th class="d-flex justify-content-center">No data found</th>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                                <div class="row align-items-center">
                                    <div class="col-sm-6">
                                        <div class="page-title-box">
                                            {{ $restor_movies->firstItem() }} - {{ $restor_movies->lastItem() }} of
                                            {{ count($restor_count) }} results
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="float-right d-none d-md-block">
                                            <div class="d-flex justify-content-center">
                                                {!! $restor_movies->links() !!}
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
    
    <script src="{{asset('assets/libs/jquery/jquery.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            $(".del").click(function() {
                if (!confirm("Do you want to delete permanently !!")) {
                    return false;
                }
            });
            $(".restore").click(function() {
                if (!confirm("Are You sure !!")) {
                    return false;
                }
            });
        });
    </script>
@endsection
