@extends('layouts.default')

@section('content')
<section class="content">
    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>Countries</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="zmdi zmdi-home"></i> Home</a></li>
                        <li class="breadcrumb-item active">Countries</li>
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
                            <h2><strong>List </strong> Countries </h2>
                            <div style='text-align: end' ;><a href="{{route('countries.create')}}" class="btn btn-primary"><i class="zmdi zmdi-plus" style="padding-right: 6px;"></i><span>Add Country</span></a></div>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>Country</th>
                                            <th>Allow Signup</th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Country</th>
                                            <th>Allow Signup</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @forelse($countries as $country)
                                        <tr>
                                            <td>{{$country->name}}</td>
                                            <td>{{$country->allow_signup? "Yes": '--'}}</td>
                                            <td><a href="{{route('countries.edit',$country->id)}}" class="mr-2"><i class="zmdi zmdi-edit"></i></a><a href="javascript:void(0);" onclick="event.preventDefault();
                                                document.getElementById('delete-form-{{ $country->id }}').submit();"><i class="zmdi zmdi-delete"></i></a></td>
                                            {!! Form::open(['method' => 'DELETE','route' => ['countries.destroy', $country->id],'style'=>'display:none',
                                            'id' => 'delete-form-'.$country->id]) !!}
                                            {!! Form::close() !!}

                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="3">There are no data.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                {!! $countries->withQueryString()->links('pagination::bootstrap-5') !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>



        </div>

    </div>
</section>
@endsection
