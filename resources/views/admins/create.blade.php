@extends('layouts.default')
@section('content')
@push('styles')
<link rel="stylesheet" href="{{asset('frontend/assets/plugins/dropify/css/dropify.min.css')}}">
<link rel="stylesheet" href="{{asset('frontend/assets/plugins/summernote/dist/summernote.css')}}" />
<link href="{{asset('frontend/assets/plugins/bootstrap-select/css/bootstrap-select.css')}}" rel="stylesheet" />
@endpush
<section class="content">
    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>Admin</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="zmdi zmdi-home"></i> Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('admins.index')}}">Admin User</a></li>
                        <li class="breadcrumb-item active">Add Admin User</li>
                    </ul>
                    <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
                </div>
                {{-- <div class="col-lg-5 col-md-6 col-sm-12">
                    <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>
                </div> --}}
            </div>
        </div>

        <div class="container-fluid">
            <!-- Vertical Layout -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif


                </div>
            </div>

            <!-- Horizontal Layout -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="header">
                            <h2><strong>Add</strong>Admin</h2>

                        </div>
                        <div class="body">
                            <form method="post" enctype="multipart/form-data" action="{{route('admins.store')}}">
                                @csrf

                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 form-control-label">
                                        <label for="name">Name</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8">
                                        <div class="form-group">
                                            <input type="hidden" id="is_admin" name="is_admin" class="form-control" value="1">
                                            <input type="text" id="title" name="name" class="form-control" value="{{old('name')}}" placeholder="Enter admin Name">
                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 form-control-label">
                                        <label for="email">Email</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8">
                                        <div class="form-group">
                                            <input type="email" id="email" name="email" class="form-control" value="{{old('email')}}" placeholder="Enter admin Email ">
                                        </div>
                                    </div>
                                </div>

                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 form-control-label">
                                        <label for="category">Roles</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8">
                                        <div class="form-group">
                                            <select class="form-control show-tick ms select2" name="roles">
                                                <option selected disabled>--Please Select--</option>
                                                @foreach ($roles as $key => $value)
                                                <option value=" {{ $key }}">
                                                    {{ $value }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 form-control-label">
                                        <label for="password">Password</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8">
                                        <div class="form-group">
                                            <input type="password" id="password" name="password" class="form-control" value="" placeholder="***********">
                                        </div>
                                    </div>
                                </div>



                                <div class="row mt-2">
                                    <div class="col-lg-4 col-md-4 col-sm-4 form-control-label">&nbsp;</div>
                                    <div class="col-lg-8 col-md-8 col-sm-8">
                                        <button type="submit" class="btn btn-raised btn-primary btn-round waves-effect" id="save-btn">Save</button>
                                        <a href="{{route('admins.index')}}" class=" btn btn-raised  btn-round waves-effect btn-secondary">Back</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</section>

@push('scripts')
<script src="{{asset('frontend/assets/plugins/dropify/js/dropify.min.js')}}"></script>
<script src="{{asset('frontend/assets/js/pages/forms/dropify.js')}}"></script>
<script src="{{asset('frontend/assets/plugins/summernote/dist/summernote.js')}}"></script>

@endpush
@endsection
