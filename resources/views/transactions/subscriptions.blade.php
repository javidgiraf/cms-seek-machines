@extends('layouts.default')

@section('content')
<section class="content">
    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>Transactions</h2>
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
                            <h2><strong>List </strong>Subscriptions</h2>
                            <!-- <div style='text-align: end' ;><a href="{{route('sellmachines.create')}}" class="btn btn-primary"><i class="zmdi zmdi-plus" style="padding-right: 6px;"></i><span>Add Selling Machines Ads</span></a></div> -->
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <td colspan="4"></td>
                                            <td><strong>Total Amount</strong></td>
                                            <td><strong>AED: {{$total}}</strong></td>
                                        </tr>
                                        <tr>
                                            <th>User</th>
                                            <th>Payment Method</th>
                                            <th>Amount</th>
                                            <th>Paid On</th>
                                            <th>Reference Id</th>
                                            <th>Status</th>


                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>User</th>

                                            <th>Payment Method</th>
                                            <th>Amount</th>
                                            <th>Paid On</th>
                                            <th>Reference Id</th>
                                            <th>Status</th>


                                        </tr>
                                        <tr>
                                            <td colspan="4"></td>
                                            <td><strong>Total Amount</strong></td>
                                            <td><strong>AED: {{$total}}</strong></td>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach($subscriptionTransactions as $transaction)

                                        <tr>
                                            <th>{{$transaction->subscription->user->name}}</th>

                                            <th>{{$transaction->transaction->payment_method}}</th>
                                            <th>{{$transaction->transaction->total_amount}}</th>
                                            <th>{{$transaction->transaction->paid_on}}</th>
                                            <th>{{$transaction->transaction->reference_id}}</th>
                                            <th>{{$transaction->transaction->payment_status}}</th>

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