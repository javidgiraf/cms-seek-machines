@extends('layouts.default')

@section('content')
<section class="content">
    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>Admins</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="zmdi zmdi-home"></i> Home</a></li>
                        <li class="breadcrumb-item active">Admins</li>
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
                            <h2><strong>List </strong> Admins </h2>
                            <div style='text-align: end' ;><a href="{{route('admins.create')}}" class="btn btn-primary"><i class="zmdi zmdi-plus" style="padding-right: 6px;"></i><span>Add Admin</span></a></div>
                        </div>

                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>

                                            <th>Action</th>

                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>

                                            <th>Action</th>


                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach($users as $user)


                                        <tr>
                                            <td>{{$user->name}}</td>
                                            <td>{{$user->email}}</td>

                                            {{-- @if((file_exists('storage/' . $brand->logo_url)) && $brand->logo_url!="")

                                            <td><img src="{{ asset('storage/' . $brand->logo_url) }}"></td>
                                            @else
                                            <td><img src="{{asset('frontend/assets/images/no-image.png')}}" style="width:100px"></td>
                                            @endif --}}
                                            <td><a href="{{route('admins.edit',encrypt($user->id))}}" style="margin-right: 10px;"><i class="zmdi zmdi-edit"></i></a><a href="javascript:void(0);" onclick="event.preventDefault();
                                                document.getElementById('delete-form-{{ $user->id }}').submit();"><i class="zmdi zmdi-delete"></i></a></td>
                                            {!! Form::open(['method' => 'DELETE','route' => ['admins.destroy', $user->id],'style'=>'display:none',
                                            'id' => 'delete-form-'.$user->id]) !!}
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