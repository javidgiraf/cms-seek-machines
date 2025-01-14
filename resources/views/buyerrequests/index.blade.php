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
                                            <th>Company</th>
                                            <th>Product</th>
                                            <th>Industry</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Approval Status</th>
                                            <th>Submitted On</th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Company</th>
                                            <th>Product</th>
                                            <th>Industry</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Approval Status</th>
                                            <th>Submitted On</th>
                                            <th>Action</th>

                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @forelse($buyerRequests as $buyerRequest)
                                        <tr>

                                            <td>{{$buyerRequest->company}} / {{$buyerRequest->contact_name}}</td>
                                            <td>{{$buyerRequest->product}} </td>
                                            <td>{{(isset($buyerRequest->category))?$buyerRequest->category->name:''}}</td>

                                            <td>{{$buyerRequest->email}}</td>
                                            <td>{{$buyerRequest->phone}}</td>
                                            @if($buyerRequest->status=='0')
                                            <td><span class="badge badge-danger">Not Verified</span></td>
                                            @else
                                            <td><span class="badge badge-success">Verified</span></td>
                                            @endif
                                            <th>{{date("Y-m-d", strtotime($buyerRequest->created_at))}}</th>
                                            <td>
                                                <a href="{{route('buyerrequests.edit',$buyerRequest->id)}}" class="mr-2"><i class="zmdi zmdi-edit"></i></a>
                                                <a href="javascript:void(0);" onclick="event.preventDefault();
                                                document.getElementById('delete-form-{{ $buyerRequest->id }}').submit();"><i class="zmdi zmdi-delete"></i></a>
                                            </td>
                                            {!! Form::open(['method' => 'DELETE','route' => ['buyerrequests.destroy', $buyerRequest->id],'style'=>'display:none',
                                            'id' => 'delete-form-'.$buyerRequest->id]) !!}
                                            {!! Form::close() !!}

                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="8">There are no data.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                {!! $buyerRequests->withQueryString()->links('pagination::bootstrap-5') !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>



        </div>

    </div>
</section>
@endsection