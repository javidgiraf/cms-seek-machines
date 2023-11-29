@extends('layouts.default')

@section('content')
<section class="content">
    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>Membership Plans</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="zmdi zmdi-home"></i> Home</a></li>
                        <li class="breadcrumb-item active">Membership Plans</li>
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
                            <h2><strong>List </strong> Membership Plans </h2>
                            <div style='text-align: end' ;><a href="{{route('memberships.create')}}" class="btn btn-primary"><i class="zmdi zmdi-plus" style="padding-right: 6px;"></i><span>Add plans</span></a></div>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>Plans</th>
                                            <th>Price</th>
                                            <th>Period</th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Plans</th>
                                            <th>Price</th>
                                            <th>Period</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach($memberships as $plans)


                                        <tr>
                                            <td>{{$plans->title}}</td>
                                            <td>{{$plans->pricing}} AED</td>
                                            <td>{{$plans->no_of_month}} Months</td>
                                            <td><a href="{{route('memberships.edit',$plans->id)}}" style="margin-right: 10px;"><i class="zmdi zmdi-edit"></i></a>
                                                <a href="javascript:void(0);" onclick="event.preventDefault();
                                                document.getElementById('delete-form-{{ $plans->id }}').submit();"><i class="zmdi zmdi-delete"></i></a>
                                            </td>
                                            {!! Form::open(['method' => 'DELETE','route' => ['memberships.destroy', $plans->id],'style'=>'display:none',
                                            'id' => 'delete-form-'.$plans->id]) !!}
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