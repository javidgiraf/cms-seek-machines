@extends('layouts.default')

@section('content')
<section class="content">
    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>Buyer Requests</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="zmdi zmdi-home"></i> Home</a></li>
                        <li class="breadcrumb-item active">Buyer Requests</li>
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
                            <h2><strong>List </strong> Buyer Requests</h2>
                            <div style='text-align: end' ;><a href="{{route('buyerrequests.create')}}" class="btn btn-primary"><i class="zmdi zmdi-plus" style="padding-right: 6px;"></i><span>Add Buyer Request</span></a></div>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>User</th>
                                            <th>Category</th>
                                            <th>Company</th>
                                            <th>Contact Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Approval Status</th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>User</th>
                                            <th>Category</th>
                                            <th>Company</th>
                                            <th>Contact Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Approval Status</th>
                                            <th>Action</th>

                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach($buyerRequests as $buyerRequest)
                                        <tr>
                                            <td>{{$buyerRequest->user->name}}</td>
                                            <td>{{$buyerRequest->category->name}}</td>
                                            <td>{{$buyerRequest->company}}</td>
                                            <td>{{$buyerRequest->contact_name}}</td>
                                            <td>{{$buyerRequest->email}}</td>
                                            <td>{{$buyerRequest->phone}}</td>
                                            @if($buyerRequest->status=='0')
                                            <td style="background: red;
                                            padding: 10px;
                                            color: white;
                                            font-weight: 700;"><span>Not Verified</span></td>
                                            @else
                                            <td style="background: #0e9f17;
                                            padding: 10px;
                                            color: white;
                                            font-weight: 700;
                                        "><span>Verified</span></td>
                                            @endif

                                            <td><a href="{{route('buyerrequests.edit',encrypt($buyerRequest->id))}}" style="margin-right: 10px;"><i class="zmdi zmdi-edit"></i></a><a href="javascript:void(0);" onclick="event.preventDefault();
                                                document.getElementById('delete-form-{{ $buyerRequest->id }}').submit();"><i class="zmdi zmdi-delete"></i></a></td>
                                            {!! Form::open(['method' => 'DELETE','route' => ['buyerrequests.destroy', $buyerRequest->id],'style'=>'display:none',
                                            'id' => 'delete-form-'.$buyerRequest->id]) !!}
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