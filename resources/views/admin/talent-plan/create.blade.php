@extends('admin.layouts.admin_main')
@push('title')
    <title>Add Plan</title>
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
                                <li class="breadcrumb-item">Talent Hunt</li>
                            </ol>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="float-right d-none d-md-block">
                            <a href="{{ route('admin.talents.plan.index') }}">
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

                                <form class="custom-validation" action="{{route('admin.talent.plan.store')}}" method="POST">
                                    @csrf
                                    @if (isset($edit_plan))
                                        <input hidden value="{{$edit_plan->thp_id}}" name="plan_id"/>
                                    @endif

                                    <div class="form-group row">
                                        <label for="thp_plan" class="col-sm-2 col-form-label">Title</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="thp_plan" name="thp_plan"
                                                required placeholder="Enter Plan"
                                                value="{{ isset($edit_plan) ? $edit_plan->thp_plan : '' }}" />
                                            @error('thp_plan')
                                                <div class="alert alert-danger text-center">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="thp_description" class="col-sm-2 col-form-label">Descriptions :</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="thp_description" name="thp_description"
                                                required placeholder="Enter description"
                                                value="{{ isset($edit_plan) ? $edit_plan->thp_description : '' }}" />
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label for="thp_price" class="col-sm-2 col-form-label">Price :</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="thp_price" name="thp_price" required placeholder="Enter Price"
                                                value="{{ isset($edit_plan) ? $edit_plan->thp_price : '' }}" />
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="thp_validity" class="col-sm-2 col-form-label">Validity :</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="thp_validity" name="thp_validity" required placeholder="Enter the validity"
                                                value="{{ isset($edit_plan) ? $edit_plan->thp_validity : '' }}" />
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="thp_movies_qty" class="col-sm-2 col-form-label">Number of Movies :</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="thp_movies_qty" name="thp_movies_qty" placeholder="Enter movies Quantity" required 
                                                value="{{ isset($edit_plan) ? $edit_plan->thp_movies_qty : '' }}" />
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
