@extends('layouts.default')

@section('content')
<section class="content">
    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>Settings</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="zmdi zmdi-home"></i> Home</a></li>
                        <li class="breadcrumb-item active">Settings</li>
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
                            <h2><strong>List </strong> Settings </h2>
                            <!-- <div style='text-align: end;'><a href="{{route('banners.create')}}" class="btn btn-primary"><i class="zmdi zmdi-plus" style="padding-right: 6px;"></i><span>Add Banner</span></a></div> -->
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Value</th>
                                            <th>Status</th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Title</th>
                                            <th>Value</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @forelse($settings as $setting)
                                        <tr>
                                            <td>{{$setting->title}}</td>
                                            <td>{{$setting->def_value }}</td>
                                            <td><span class="badge {{($setting->status == 1)? 'badge-success':'badge-danger'}}">{{($setting->status == 1)? "Active" : "Inactive"}}</span></td>
                                            <td><a href="{{route('settings.edit',$setting->id)}}" style="margin-right: 10px;"><i class="zmdi zmdi-edit"></i></a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4">There are no data.</td>
                                        </tr>
                                        @endforelse
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