@extends('admin.layouts.admin_main')
@push('title')
    <title>Users Details</title>
    <link href="{{ asset('assets/css/comments.css') }}" rel="stylesheet"/>
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
                                <li class="breadcrumb-item">Users Details</li>
                            </ol>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="float-right d-none d-md-block">
                            <div class="dropdown">
                                <a href="{{ route('admin.talents.index') }}">
                                    <button class="btn btn-primary" type="button" aria-expanded="false">
                                        Back
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
                <h3>Comments On "{{ $Talent_comments->title }}"</h3>

                <div class="ps-container ps-theme-default ps-active-y" id="chat-content"
                    style="overflow-y: scroll !important; height:400px !important;">
                    @foreach ($comments as $items)
                        @if ($Talent_comments->user_id == $items->com_user_id)
                            <div class="media media-chat">
                                <img class="avatar" src="https://img.icons8.com/color/36/000000/administrator-male.png"
                                    alt="...">
                                <div class="media-body">
                                    @foreach ($users as $user)
                                        @if ($user->id == $items->com_user_id)
                                            <p>{{ $items->comment }}
                                                <br>...<i>{{ $user->name }}</i>
                                            </p><br>
                                        @endif
                                    @endforeach

                                </div>
                            </div>
                        @else
                            <div class="media media-chat media-chat-reverse">
                                <div class="media-body">
                                    {{-- @foreach ($comments as $items) --}}

                                    @foreach ($users as $user)
                                        @if ($user->id == $items->com_user_id)
                                            <p>{{ $items->comment }}
                                                <br>...<i style="font-size:12px;">{{ $user->name }}</i>
                                            </p><br>
                                        @endif
                                    @endforeach
                                    {{-- @endforeach --}}
                                </div>
                            </div>
                        @endif
                    @endforeach
                    <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 0px;">
                        <div class="ps-scrollbar-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                    </div>
                    <div class="ps-scrollbar-y-rail" style="top: 0px; height: 0px; right: 2px;">
                        <div class="ps-scrollbar-y" tabindex="0" style="top: 0px; height: 2px;"></div>
                    </div>
                </div>
            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
    </div>
    <!-- end main content-->
@endsection
