@extends('admin.layouts.admin_main')
@push('title')
    <title>Subscriptions</title>
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
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Subscriptions</a></li>
                            </ol>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-12">
                        <form action="{{ route('admin.subscription.archive') }}" method="GET">
                            <div class="col-md-3 mt-1 float-left ">
                                <label for="">Search</label>
                                <input type="text" class="form-control" name="search"
                                    placeholder="Search...Transaction ID" />
                            </div>

                            <div class="col-md-3 float-left" style="margin-top: 32px">
                                <button type="submit" class="btn btn-primary waves-effect waves-light ">Submit</button>
                                <a href="{{ route('admin.subscription.archive') }}">
                                    <button type="button" class="btn btn-primary waves-effect waves-light mr-1"><i class="mdi mdi-refresh"></i>Reset
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
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>transaction</th>
                                            <th>Amount</th>
                                            <th>status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @if (count($deleted_subscription) > 0)
                                            <?php $i = 1; foreach($deleted_subscription as $item){?>
                                            <tr>
                                                <td>{{ $i }}</td>
                                                @foreach ($user_details as $user)
                                                    @if ($user->id == $item->user_id)
                                                        <td> {{ $user->name }}</td>
                                                    @endif
                                                @endforeach
                                                <td>{{ $item->start_date }}</td>
                                                <td>{{ $item->end_date }}</td>
                                                <td>{{ $item->transaction_id }}</td>
                                                <td>{{ $item->amount }}</td>
                                                <td>{{ $item->status }}</td>
                                                <td>

                                                    <a href="{{ route('admin.subscription.permanents_delete', $item->id) }}"
                                                        class="btn btn-danger del"><i class="fa fa-eye"></i>delete</a>

                                                    <a href="{{ route('admin.subscription.restore', $item->id) }}" class="btn btn-warning restore"><i
                                                            class="fa fa-edit"></i>Restore</a>
                                                </td>
                                                <?php $i++; ?>
                                            </tr>
                                            <?php }?>
                                        @else
                                            <tr>
                                                <td></td><td></td><td></td>
                                                <td class="text-center">No data found</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                                <div class="row align-items-center">
                                    <div class="col-sm-6">
                                        <div class="page-title-box">
                                            {{ $deleted_subscription->firstItem() }} -
                                            {{ $deleted_subscription->lastItem() }} of {{ count($total_subscription) }} results
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="float-right d-none d-md-block">
                                            <div class="d-flex justify-content-center">
                                                {!! $deleted_subscription->links() !!}
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
