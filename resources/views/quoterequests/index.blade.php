@extends('layouts.default')

@section('content')
<section class="content">
    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>Quote Requests</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="zmdi zmdi-home"></i> Home</a></li>
                        <li class="breadcrumb-item active">Quote Requests</li>
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
                            <h2><strong>List </strong> Quote Requests</h2>
                            <div  style='text-align: end';><a href="{{route('quoterequests.create')}}" class="btn btn-primary"><i class="zmdi zmdi-plus" style="padding-right: 6px;"></i><span>Add Quote Request</span></a></div>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>Quote</th>
                                            <th>Seller Machine Ad</th>
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
                                            <th>Quote</th>
                                            <th>Seller Machine Ad</th>
                                            <th>Company</th>
                                            <th>Contact Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Approval Status</th>
                                            <th>Action</th>

                                        </tr>
                                    </tfoot>
                                    <tbody>
                                      @foreach($quoteRequests as $quoteRequest)

                                        <tr>


                                            <td>{{$quoteRequest->user->name}}</td>
                                            <td>{{$quoteRequest->sell_machines->title}}</td>
                                            <td>{{$quoteRequest->company}}</td>
                                            <td>{{$quoteRequest->contact_name}}</td>
                                            <td>{{$quoteRequest->email}}</td>
                                            <td>{{$quoteRequest->phone}}</td>
                                            @if($quoteRequest->status=='0')
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

                                            <td><a  href="{{route('quoterequests.edit',encrypt($quoteRequest->id))}}" style="margin-right: 10px;"><i class="zmdi zmdi-edit"></i></a><a  href="javascript:void(0);" onclick="event.preventDefault();
                                                document.getElementById('delete-form-{{ $quoteRequest->id }}').submit();"><i class="zmdi zmdi-delete"></i></a></td>
                                                {!! Form::open(['method' => 'DELETE','route' => ['quoterequests.destroy', $quoteRequest->id],'style'=>'display:none',
                                                'id' => 'delete-form-'.$quoteRequest->id]) !!}
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
