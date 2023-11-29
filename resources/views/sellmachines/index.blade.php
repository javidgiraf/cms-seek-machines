@extends('layouts.default')

@section('content')
<section class="content">
    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>Selling Machines Ads</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="zmdi zmdi-home"></i> Home</a></li>
                        <li class="breadcrumb-item active">Selling Machines Ads</li>
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
                            <h2><strong>List </strong> Selling Machines Ads</h2>
                            <div style='text-align: end' ;><a href="{{route('sellmachines.create')}}" class="btn btn-primary"><i class="zmdi zmdi-plus" style="padding-right: 6px;"></i><span>Add Selling Machines Ads</span></a></div>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>Title</th>
                                            <th>Item Code</th>
                                            <th>User</th>
                                            <th>Model No</th>
                                            <th>Approval Status</th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Image</th>
                                            <th>Title</th>
                                            <th>Item Code</th>
                                            <th>User</th>
                                            <th>Model No</th>

                                            <th>Approval Status</th>
                                            <th>Action</th>

                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach($sellMachines as $sellMachine)

                                        <tr>

                                            @if((file_exists('storage/' . $sellMachine->default_image)) && $sellMachine->default_image!="")

                                            <td><img src="{{ asset('storage/' . $sellMachine->default_image) }}"></td>
                                            @else
                                            <td><img src="{{asset('frontend/assets/images/no-image.png')}}" style="width:100px"></td>
                                            @endif
                                            <td>{{$sellMachine->title}}</td>
                                            <td>{{$sellMachine->item_code}}</td>
                                            <td>{{$sellMachine->user->name}}</td>
                                            <td>{{$sellMachine->modelno}}</td>
                                            @if($sellMachine->status=='0')
                                            <td><span class="badge badge-danger">Not Verified</span></td>
                                            @elseif($sellMachine->status=='2')
                                            <td><span class="badge badge-warning">Pending</span></td>
                                            @else
                                            <td><span class="badge badge-success">Verified</span></td>
                                            @endif
                                            <td><a href="{{route('sellmachines.edit',$sellMachine->id)}}" style="margin-right: 10px;"><i class="zmdi zmdi-edit"></i></a><a href="javascript:void(0);" onclick="event.preventDefault();
                                                document.getElementById('delete-form-{{ $sellMachine->id }}').submit();"><i class="zmdi zmdi-delete"></i></a></td>
                                            {!! Form::open(['method' => 'DELETE','route' => ['sellmachines.destroy', $sellMachine->id],'style'=>'display:none',
                                            'id' => 'delete-form-'.$sellMachine->id]) !!}
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