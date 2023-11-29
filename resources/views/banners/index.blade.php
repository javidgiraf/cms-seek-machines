@extends('layouts.default')

@section('content')
<section class="content">
    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>Boosted Banners</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="zmdi zmdi-home"></i> Home</a></li>
                        <li class="breadcrumb-item active">Boosted Banners</li>
                    </ul>

                </div>

            </div>
        </div>

        <div class="container-fluid">
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header">
                            @include('layouts.partials.messages')
                            <h2><strong>Boosted </strong> Banners </h2>
                            <!-- <div style='text-align: end;'><a href="{{route('banners.create')}}" class="btn btn-primary"><i class="zmdi zmdi-plus" style="padding-right: 6px;"></i><span>Add Banner</span></a></div> -->
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Image</th>
                                            <th>Period</th>
                                            <th>Amount (AED)</th>
                                            <th>Status</th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Title</th>
                                            <th>Image</th>
                                            <th>Period</th>
                                            <th>Amount (AED)</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach($banners as $banner)


                                        <tr>
                                            <td width="35%">{{$banner->title}}

                                                <a href="{{route('sellmachines.edit',$banner->boostad->sell_machine_id)}}" class="ml-2"><i class="zmdi zmdi-arrow-right-top"></i> See Ads</a>
                                            </td>
                                            @if((file_exists('storage/' . $banner->image_url)) && $banner->image_url!="")

                                            <td><img src="{{ asset('storage/' . $banner->image_url) }}"></td>
                                            @else
                                            <td><img src="{{asset('frontend/assets/images/no-image.png')}}" style="width:100px"></td>
                                            @endif
                                            <td>{{$banner->boostad->start_date}} to {{$banner->boostad->end_date}}
                                                <br /><span class="badge badge-info">{{$banner->boostad->days}} Days</span>
                                            </td>
                                            <td>{{$banner->boostad->total_amount}} AED</td>
                                            <td><span class="badge {{($banner->status == 1)? 'badge-success':'badge-danger'}}">{{($banner->status == 1)? "Active" : "Inactive"}}</span></td>
                                            <td><a href="{{route('banners.edit',encrypt($banner->id))}}" style="margin-right: 10px;"><i class="zmdi zmdi-edit"></i></a><a href="javascript:void(0);" onclick="event.preventDefault();
                                                document.getElementById('delete-form-{{ $banner->id }}').submit();"><i class="zmdi zmdi-delete"></i></a></td>
                                            {!! Form::open(['method' => 'DELETE','route' => ['banners.destroy', $banner->id],'style'=>'display:none',
                                            'id' => 'delete-form-'.$banner->id]) !!}
                                            {!! Form::close() !!}

                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



        </div>

    </div>
</section>
@endsection