@extends('layouts.default')
@section('content')
@push('styles')
<link rel="stylesheet" href="{{asset('frontend/assets/plugins/dropify/css/dropify.min.css')}}">
<link rel="stylesheet" href="{{asset('frontend/assets/plugins/summernote/dist/summernote.css')}}" />
<link href="{{asset('frontend/assets/plugins/bootstrap-select/css/bootstrap-select.css')}}" rel="stylesheet" />
<link rel="stylesheet" href="{{asset('frontend/assets/plugins/select2/select2.css')}}" />
@endpush
<section class="content">
    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>Banner</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="zmdi zmdi-home"></i> Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('banners.index')}}">Banners</a></li>
                        <li class="breadcrumb-item active">View Banner</li>
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
                            <h2><strong>View</strong>Blog</h2>
                            <div style='text-align: end' ;><a href="{{route('banners.index')}}" class="btn btn-primary"><i class="zmdi zmdi-arrow-left" style="padding-right: 6px;"></i><span>Back</span></a></div>
                        </div>
                        <div class="body">
                            <form method="post" enctype="multipart/form-data" action="{{route('banners.changestatus',encrypt($banner->id))}}">
                                @csrf
                                @method('put')
                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">
                                        <label for="title">Banner Title</label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8">
                                        {{$banner->title}}
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">
                                        <label for="description">Banner Description</label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8">
                                        <div class="form-group">
                                            <textarea id="description" name="description" class="form-control" readonly>{{$banner->description}}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">
                                        <label for="label">Banner Label</label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8">
                                        {{$banner->label}}
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">
                                        <label for="slug">Banner Image</label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8">

                                        @if((file_exists('storage/' . $banner->image_url)) && $banner->image_url!="")
                                        <img src="{{ asset('storage/' . $banner->image_url) }}">
                                        @else
                                        <img src="{{asset('frontend/assets/images/no-image.png')}}">

                                        @endif
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">
                                        <label for="link_to">Banner Link to</label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8">
                                        {{$banner->link_to}}
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="body">
                                        <!-- <div class="row clearfix">
                                            <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">
                                                <label for="start_date">Start Date</label>
                                            </div>
                                            <div class="col-lg-10 col-md-10 col-sm-8">
                                                <div class="form-group">
                                                    <input type="date" name="start_date" class="form-control">
                                                </div>
                                            </div>
                                        </div> -->
                                        <div class="row clearfix">
                                            <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">
                                                <label for="approve">Status</label>
                                            </div>
                                            <div class="col-lg-10 col-md-10 col-sm-8">
                                                <div class="form-group">
                                                    <select class="form-control" name="status">
                                                        <option selected disabled>--Please Select--</option>
                                                        <option value='1' {{($banner->boostad->status=='1')?'selected':''}}>Active</option>
                                                        <option value='0' {{($banner->boostad->status=='0')?'selected':''}}>Inactive</option>
                                                        <option value='2' {{($banner->boostad->status=='2')?'selected':''}}>On Review</option>

                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">


                                        <div class="col-sm-8 offset-sm-2">
                                            <button type="submit" class="btn btn-primary">Save</button>
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
<script src="{{asset('frontend/assets/plugins/select2/select2.min.js')}}"></script>

@endpush
@endsection