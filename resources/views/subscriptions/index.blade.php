@extends('layouts.default')

@section('content')
<section class="content">
    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>Subscriptions</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="zmdi zmdi-home"></i> Home</a></li>
                        <li class="breadcrumb-item active">Subscriptions</li>
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
                            <h2><strong>List </strong> Subscriptions </h2>

                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>Customer</th>
                                            <th>Plan</th>
                                            <th>Period</th>
                                            <th>View Count</th>
                                            <th>Subscribed On</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Customer</th>
                                            <th>Plan</th>
                                            <th>Period</th>
                                            <th>View Count</th>
                                            <th>Subscribed On</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @forelse($subscriptions as $subs)

                                        <tr>
                                            <td>{{$subs->user->name}} / {{$subs->user->customer->company}}</td>
                                            <td>{{$subs->membership->title}}</td>
                                            <td>{{$subs->start_at}} to {{$subs->expires_at}} </td>
                                            <td>{{$subs->view_count}}</td>
                                            <td>{{date("d-m-Y", strtotime($subs->created_at))}}</td>
                                            <td>
                                                @if($subs->status == 1)
                                                <span class="badge badge-success">Active</span>
                                                @else
                                                <span class="badge badge-danger">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($subs->status == 1)
                                                <button type="button" data-color="blue" class="btn bg-blue waves-effect" data-toggle="modal" data-target="#defaultModal{{$subs->id}}">
                                                    <i class="zmdi zmdi-plus-1"></i> <i class="zmdi zmdi-eye"></i>
                                                </button>

                                                <div class="modal fade" id="defaultModal{{$subs->id}}" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog" role="document">
                                                        <form method="post" action="{{route('subscriptions.count')}}">
                                                            @csrf
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="title" id="defaultModalLabel">Update Subscription Views</h4>
                                                                </div>
                                                                <div class="modal-body">

                                                                    <input type="hidden" name="subscriptionid" value="{{$subs->id}}" />
                                                                    <div class="row clearfix">
                                                                        <div class="col-lg-4 col-md-4 col-sm-4 form-control-label">
                                                                            <label for="company">View Count</label>
                                                                        </div>
                                                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                                                            <div class="form-group">
                                                                                <input type="number" id="view_count" name="view_count" class="form-control" required>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="submit" class="btn btn-default btn-round waves-effect">SAVE CHANGES</button>
                                                                    <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">CLOSE</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                @endif
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="7">There are no data.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                {!! $subscriptions->withQueryString()->links('pagination::bootstrap-5') !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>



        </div>

    </div>
</section>
@endsection