@extends('layouts.default')

@section('content')
<section class="content">
    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>Blogs</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="zmdi zmdi-home"></i> Home</a></li>
                        <li class="breadcrumb-item active">Blogs</li>
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
                            <h2><strong>List </strong> Blogs </h2>
                            <div style='text-align: end' ;><a href="{{route('blogs.create')}}" class="btn btn-primary"><i class="zmdi zmdi-plus" style="padding-right: 6px;"></i><span>Add Blogs</span></a></div>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>Blog Title</th>
                                            <th>Blog Slug</th>
                                            <th>Blog Image</th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Blog Title</th>
                                            <th>Blog Slug</th>
                                            <th>Blog Image</th>
                                            <th>Action</th>

                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach($blogs as $blog)


                                        <tr>
                                            <td>{{$blog->title}}</td>
                                            <td>{{$blog->slug}}</td>
                                            @if((file_exists('storage/' . $blog->default_image)) && $blog->default_image!="")

                                            <td><img src="{{ asset('storage/' . $blog->default_image) }}"></td>
                                            @else
                                            <td><img src="{{asset('frontend/assets/images/no-image.png')}}" style="width:100px"></td>
                                            @endif
                                            <td><a href="{{route('blogs.edit',encrypt($blog->id))}}" style="margin-right: 10px;"><i class="zmdi zmdi-edit"></i></a><a href="javascript:void(0);" onclick="event.preventDefault();
                                                document.getElementById('delete-form-{{ $blog->id }}').submit();"><i class="zmdi zmdi-delete"></i></a></td>
                                            {!! Form::open(['method' => 'DELETE','route' => ['blogs.destroy', $blog->id],'style'=>'display:none',
                                            'id' => 'delete-form-'.$blog->id]) !!}
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