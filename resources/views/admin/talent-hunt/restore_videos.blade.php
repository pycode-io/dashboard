@extends('admin.layouts.admin_main')
@push('title')
<title>Talent Hunt</title>  
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
                                        <a href="{{route('admin.dashboard')}}">
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
                                <form action="{{ route('admin.talents.archive') }}" method="GET">
                                    <div class="col-md-3 mt-1 float-left ">
                                        <input type="text" class="form-control" name="search" placeholder="Search..." />
                                    </div>
                                    <div class="float-left m-1">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">Submit</button>
                                        <a class="m-1" href="{{route('admin.talents.index')}}"><button type="button" class="btn btn-primary waves-effect waves-light mr-1"></i>Reset
                                       </button></a>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @if(session()->has('success'))
                            <div class="alert alert-success">
                                {{ session()->get('success') }}
                            </div>
                        @endif      
                        <!-- end page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Sr.No</th>
                                                    <th>Title</th>
                                                    <th>Description</th>
                                                    <th>Url</th>
                                                    <th>Video</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @if (count($deleted_talent) > 0)
                                                <?php $i = 1; foreach($deleted_talent as $item){?>
                                                <tr>
                                                    <td>{{$i}}</td>
                                                    <td>{{$item->title}}</td>
                                                    <td>{{$item->description}}</td>
                                                    <td>{{$item->video_url}}</td>
                                                    <td>
                                                        <img src="{{asset('storage/talenthunt/'.$item->video)}}" alt="video" width="150" height="150">
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('admin.talents.restore', $item->id) }}" class="btn btn-success restore">Restore</a>
                    
                                                        <a href="{{route('admin.talents.permanents_delete', $item->id) }}" 
                                                            class="btn btn-danger del">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    </td>

                                                    <?php $i++; ?>
                                                </tr>
                                                <?php }?>
                                                @else
                                                    <tr>
                                                        <td></td><td></td>
                                                        <td class="text-center">No data found</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                        <div class="row align-items-center">
                                            <div class="col-sm-6">
                                                <div class="page-title-box">
                                                    {{ $deleted_talent->firstItem() }} - {{ $deleted_talent->lastItem() }} of {{ count($total_videos) }} results
                                                </div>
                                            </div>
                        
                                            <div class="col-sm-6">
                                                <div class="float-right d-none d-md-block">
                                                    <div class="d-flex justify-content-center">
                                                        {!! $deleted_talent->links() !!}
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