@extends('layouts.default')

@section('content')
<section class="content">
    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>Brands</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="zmdi zmdi-home"></i> Home</a></li>
                        <li class="breadcrumb-item active">Brands</li>
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
                            <h2><strong>List </strong> Brands </h2>
                            <div style='text-align: end' ;><a href="{{route('brands.create')}}" class="btn btn-primary"><i class="zmdi zmdi-plus" style="padding-right: 6px;"></i><span>Add Brands</span></a></div>
                        </div>

                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>Brands</th>
                                            <th>Image</th>
                                            <th>Approval Status</th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Brands</th>
                                            <th>Image</th>
                                            <th>Approval Status</th>
                                            <th>Action</th>

                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach($brands as $brand)


                                        <tr>
                                            <td>{{$brand->manufacturer}}</td>
                                            @if((file_exists('storage/' . $brand->logo_url)) && $brand->logo_url!="")
                                            <td width="30%"><img src="{{ asset('storage/' . $brand->logo_url) }}" width="50%" />
                                            </td>
                                            @else
                                            <td width="30%"><img src="{{asset('frontend/assets/images/no-image.png')}}"></td>
                                            @endif

                                            @if($brand->status=='0')
                                            <td width="20%"><span class="badge badge-danger">Not Verified</span></td>
                                            @else
                                            <td width="20%"><span class="badge badge-success">Verified</span></td>
                                            @endif
                                            <td width="20%"><a href="{{route('brands.edit',encrypt($brand->id))}}" style="margin-right: 10px;"><i class="zmdi zmdi-edit"></i></a><a href="javascript:void(0);" onclick="event.preventDefault();
                                                document.getElementById('delete-form-{{ $brand->id }}').submit();"><i class="zmdi zmdi-delete"></i></a></td>
                                            {!! Form::open(['method' => 'DELETE','route' => ['brands.destroy', $brand->id],'style'=>'display:none',
                                            'id' => 'delete-form-'.$brand->id]) !!}
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