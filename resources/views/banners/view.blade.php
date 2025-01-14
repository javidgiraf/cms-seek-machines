@extends('layouts.default')
@section('content')
@push('styles')
<link rel="stylesheet" href="{{asset('frontend/assets/plugins/dropify/css/dropify.min.css')}}">
<link href="{{asset('frontend/assets/plugins/bootstrap-select/css/bootstrap-select.css')}}" rel="stylesheet" />
@endpush
<section class="content">
    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>Ad Banner</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="zmdi zmdi-home"></i> Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('banners.index')}}">Banners</a></li>
                        <li class="breadcrumb-item active">View Boosted Banner</li>
                    </ul>
                    <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
                </div>
                {{-- <div class="col-lg-5 col-md-6 col-sm-12">
                    <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>
                </div> --}}
            </div>
        </div>

        <div class="container-fluid">

            <!-- Horizontal Layout -->
            <div class="row clearfix">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="card">
                        <div class="header">
                            <h2>View <strong> Ad Banner</strong></h2>
                        </div>
                        <div class="body">
                            @if($banner->image_url !="")
                            <img src="{{ asset(config('app.image_root_url').$banner->image_url) }}" width="70%">
                            @else
                            <img src="{{asset('frontend/assets/images/no-image.png')}}">
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="card">
                        <div class="header">
                            <h2>Banner <strong>Details</strong></h2>
                        </div>
                        <div class="body">

                            <div class="row clearfix">
                                <div class="col-lg-4 col-md-4 col-sm-4 form-control-label">
                                    <label for="title">Banner Title</label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8">
                                    {{$banner->title}}
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 form-control-label">
                                    <label for="description">Short Description</label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8">
                                    <div class="form-group">
                                        {{$banner->description}}
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 form-control-label">
                                    <label for="label">Display Label</label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8">
                                    <span class="badge badge-primary"> {{$banner->label}}</span>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 form-control-label">
                                    <label for="link_to">Banner Linked to</label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8">
                                    <a href="{{$banner->link_to}}">{{$banner->link_to}}</a>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 form-control-label">
                                    <label for="link_to">Total Amount</label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8">
                                    <span class="badge badge-default">{{$banner->boostad->total_amount}} AED</span>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 form-control-label">
                                    <label for="link_to">No Of Days</label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8">
                                    {{$banner->boostad->days}}
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 form-control-label">
                                    <label for="link_to">Start Date</label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8">
                                    {{$banner->boostad->start_date}}
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 form-control-label">
                                    <label for="link_to">End Date</label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8">
                                    {{$banner->boostad->end_date}}
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="card">
                        <div class="header">
                            <h2>Update Status of <strong> Boosted Banner</strong></h2>

                        </div>
                        <div class="body">
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
                                    @if(session()->has('success'))
                                    <div class="alert alert-success">
                                        {{ session()->get('success') }}
                                    </div>
                                    @endif


                                </div>
                            </div>
                            <form method="post" enctype="multipart/form-data" action="{{route('banners.changestatus',$banner->id) }}">
                                @csrf
                                @method('put')
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 form-control-label">
                                        <label for="approve">Banner Status</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8">
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
                                <div class="row mt-4">
                                    <div class="col-lg-4 col-md-4 col-sm-4 form-control-label">&nbsp;</div>
                                    <div class="col-lg-8 col-md-8 col-sm-8">
                                        <button type="submit" class="btn btn-raised btn-primary btn-round waves-effect" id="save-btn">Save</button>
                                        <a href="{{route('banners.index')}}" class=" btn btn-raised  btn-round waves-effect btn-secondary">Back</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card">
                        <div class="header">
                            <h2><strong>Machine Ads</strong> boosted as banner ad</h2>
                        </div>
                        <div class="body">
                            <ul class="list-unstyled mb-0 widget-recentpost">
                                <li>
                                    <a href="{{route('sellmachines.view',$machinead->id)}}">
                                        <img src="{{ asset(config('app.image_root_url'). $machinead->default_image) }}" width="100"><br />
                                        <span class="badge badge-info mt-2">{{$machinead->item_code}}</span>
                                    </a>
                                    <div class="recentpost-content">
                                        <a href="{{route('sellmachines.view',$machinead->id)}}"><b>{{$machinead->title}}</b></a>
                                        <ul class="list-unstyled mb-0 ">
                                            <li>{{$machinead->category->name}}</li>
                                            <li> {{$machinead->modelno}}, {{$machinead->brand->manufacturer}}</li>
                                            <li> {{$machinead->yearof}}, {{$machinead->country->name}}</li>
                                        </ul>
                                        <span>{{$machinead->created_at}}</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>

@push('scripts')
<script src="{{asset('frontend/assets/plugins/dropify/js/dropify.min.js')}}"></script>
<script src="{{asset('frontend/assets/js/pages/forms/dropify.js')}}"></script>


@endpush
@endsection