@extends('layouts.default')

@section('content')
<section class="content">
    <div class="">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>Dashboard</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="zmdi zmdi-home"></i> Seek Machines</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ul>
                    <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
                </div>
                <!-- <div class="col-lg-5 col-md-6 col-sm-12">
                    <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>
                </div> -->
            </div>
        </div>
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="card widget_2">
                        <div class="body">
                            <a href="{{route('sellmachines.pending')}}">
                                <h6>Pending Sell Machine Ads</h6>
                                <h2 style="color: #ec2525;">{{count($sellMachines)}} <small class="info"></small></h2>
                            </a>

                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="card widget_2">
                        <div class="body">
                            <a href="{{route('banners.onreview')}}">
                                <h6>On Review Booster Ads</h6>
                                <h2 style="color: #ec2525;">{{count($banners)}} <small class="info"></small></h2>
                            </a>

                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="card widget_2">
                        <div class="body">
                            <a href="{{route('adverifications.verification-pending')}}">
                                <h6>Paid Ads With Pending Reviews</h6>
                                <h2 style="color: #ec2525;">{{count($sellMachinesPendingads)}} <small class="info"></small></h2>
                            </a>

                        </div>
                    </div>
                </div>

            </div>
            <div class="row clearfix">
                <div class="col-sm-6 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="header">
                            <h2><strong>Pending</strong> Selling Machines Ad</h2>

                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover c_table">
                                <thead>
                                    <tr>
                                        <!-- <th>Image</th> -->
                                        <th>Title</th>
                                        <!-- <th>Item Code</th>
                                        <th>User</th>
                                        <th>Model No</th> -->
                                        <th>Approval Status</th>
                                        {{-- <th>Action</th> --}}

                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($sellMachines->reverse()->take(5) as $sellMachine)

                                    <tr>

                                        <!-- @if((file_exists('storage/' . $sellMachine->default_image)) && $sellMachine->default_image!="")

                                        <td><img src="{{ asset('storage/' . $sellMachine->default_image) }}"></td>
                                        @else
                                        <td><img src="{{asset('frontend/assets/images/no-image.png')}}" style="width:100px"></td>
                                        @endif -->
                                        <td>{{substr($sellMachine->title,0,20)}}</td>
                                        <!-- <td>{{$sellMachine->item_code}}</td>
                                        <td>{{$sellMachine->user->name}}</td>
                                        <td>{{$sellMachine->modelno}}</td> -->
                                        @if($sellMachine->status=='0')
                                        <td><span class="badge badge-danger">Inactive</span></td>
                                        @elseif($sellMachine->status=='2')
                                        <td><span class="badge badge-warning">Pending</span></td>
                                        @else
                                        <td><span class="badge badge-success">Active</span></td>
                                        @endif
                                        {{-- <td><a href="{{route('sellmachines.view',$sellMachine->id)}}" style="margin-right: 10px;"><i class="zmdi zmdi-eye"></i></a><a href="{{route('sellmachines.edit',$sellMachine->id)}}" style="margin-right: 10px;"><i class="zmdi zmdi-edit"></i></a><a href="javascript:void(0);" onclick="event.preventDefault();
                                            document.getElementById('delete-form-{{ $sellMachine->id }}').submit();"><i class="zmdi zmdi-delete"></i></a></td> --}}
                                        {!! Form::open(['method' => 'DELETE','route' => ['sellmachines.destroy', $sellMachine->id],'style'=>'display:none',
                                        'id' => 'delete-form-'.$sellMachine->id]) !!}
                                        {!! Form::close() !!}

                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="block-header">
                            <div class="row">
                                <div class="col-lg-7 col-md-6 col-sm-12">



                                </div>
                                <div class="col-lg-5 col-md-6 col-sm-12" style="display:block;">
                                    <a href="{{route('sellmachines.pending')}}" class="btn btn-primary float-right" style="color:white;padding: 10px;" type="button">View All</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-6">
                    <div class="card">
                        <div class="header">
                            <h2><strong>On Review</strong> Booster Ads</h2>

                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover c_table">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <!-- <th>Image</th> -->
                                        <th>Period</th>
                                        <th>Amount (USD)</th>
                                        <th>Status</th>


                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($banners->reverse()->take(5) as $banner)


                                    <tr>
                                        <td>{{substr($banner->title,0,20)}}

                                            <a href="{{route('sellmachines.edit',$banner->boostad->sell_machine_id)}}" class="ml-2"><i class="zmdi zmdi-arrow-right-top"></i> See Ads</a>
                                        </td>
                                        <!-- @if((file_exists('storage/' . $banner->image_url)) && $banner->image_url!="")

                                        <td><img src="{{ asset('storage/' . $banner->image_url) }}"></td>
                                        @else
                                        <td><img src="{{asset('frontend/assets/images/no-image.png')}}" style="width:100px"></td>
                                        @endif -->
                                        <td>{{$banner->boostad->start_date}} to {{$banner->boostad->end_date}}
                                            <br /><span class="badge badge-info">{{$banner->boostad->days}} Days</span>
                                        </td>
                                        <td>{{$banner->boostad->total_amount}} USD</td>
                                        <td><span class="badge badge-warning">{{($banner->boostad->status == 2)? "On Review" : ""}}</span></td>

                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="block-header">
                            <div class="row">
                                <div class="col-lg-7 col-md-6 col-sm-12">



                                </div>
                                <div class="col-lg-5 col-md-6 col-sm-12" style="display:block;">
                                    <a href="{{route('banners.onreview')}}" class="btn btn-primary float-right" style="color:white;padding: 10px;" type="button">View All</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-6">
                    <div class="card">
                        <div class="header">

                            <h2><strong> Paid</strong> Ads with Pending Reviews</h2>


                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover c_table">
                                <thead>
                                    <tr>

                                        <th>Title</th>
                                        <!-- <th>Item Code</th>
                                        <th>User</th>
                                        <th>Model No</th> -->
                                        <th>Approval Status</th>


                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($sellMachinesPendingads->reverse()->take(5) as $sellMachine)

                                    <tr>

                                        <!-- @if((file_exists('storage/' . $sellMachine->default_image)) && $sellMachine->default_image!="")

                                        <td><img src="{{ asset('storage/' . $sellMachine->default_image) }}"></td>
                                        @else
                                        <td><img src="{{asset('frontend/assets/images/no-image.png')}}" style="width:100px"></td>
                                        @endif -->
                                        <td>{{substr($sellMachine->title,0,20)}}</td>
                                        <!-- <td>{{$sellMachine->item_code}}</td>
                                        <td>{{$sellMachine->user->name}}</td>
                                        <td>{{$sellMachine->modelno}}</td> -->
                                        <td><span class="badge badge-warning">Verification Pending</td>

                                        <!-- @if($sellMachine->status=='0')
                                            <td><span class="badge badge-danger">Not Verified</span></td>
                                            @else
                                            <td><span class="badge badge-success">Verified</span></td>
                                            @endif -->



                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="block-header">
                            <div class="row">
                                <div class="col-lg-7 col-md-6 col-sm-12">



                                </div>
                                <div class="col-lg-5 col-md-6 col-sm-12" style="display:block;">
                                    <a href="{{route('adverifications.verification-pending')}}" class="btn btn-primary float-right" style="color:white;padding: 10px;" type="button">View All</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row clearfix">

            </div>


        </div>
    </div>
</section>
@endsection