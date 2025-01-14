@extends('layouts.default')
@section('content')

<section class="content">
    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>Membership</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="zmdi zmdi-home"></i> Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('memberships.index')}}">Membership Plans</a></li>
                        <li class="breadcrumb-item active">Create Membership</li>
                    </ul>
                    <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12">
                    <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <!-- Vertical Layout -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif


                </div>
            </div>

            <!-- Horizontal Layout -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="header">
                            <h2><strong>Create</strong> New Membership Plans</h2>

                        </div>
                        <div class="body">
                            <form method="post" enctype="multipart/form-data" action="{{route('memberships.store')}}">
                                @csrf
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 form-control-label">
                                        <label for="title">Title</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8">
                                        <div class="form-group">
                                            <input type="text" id="title" name="title" class="form-control" placeholder="Enter your plan">
                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 form-control-label">
                                        <label for="title">Descriptions</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8">
                                        <div class="form-group">
                                            <textarea class="form-control" row="10" name="description"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 form-control-label">
                                        <label for="title">Price (AED)</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8">
                                        <div class="form-group">
                                            <input type="number" id="pricing" name="pricing" class="form-control" placeholder="Enter your pricing">
                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 form-control-label">
                                        <label for="title">Duration of Plan (Months)</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8">
                                        <div class="form-group">
                                            <input type="number" id="no_of_month" name="no_of_month" class="form-control" placeholder="Enter your period (months)">
                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 form-control-label">
                                        <label for="title">Discount (AED)</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8">
                                        <div class="form-group">
                                            <input type="number" id="discount" name="discount" class="form-control" placeholder="Enter discount if any">
                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 form-control-label">
                                        <label for="title">Allowed Number of Views</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8">
                                        <div class="form-group">
                                            <input type="number" id="view_limit" name="view_limit" class="form-control" placeholder="Enter number of views allowed for a customer">
                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 form-control-label">
                                        <label for="slug">Is Premium ?</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8">
                                        <div class="checkbox">
                                            <input type="checkbox" id="is_premium" name="is_premium" class="form-control" value="1">
                                            <label for="is_premium">
                                                Is this a premium plan for capital equipments ?
                                            </label>
                                        </div>

                                    </div>
                                </div>
                                <div id="ispremium" class="d-none">
                                    <div class="row clearfix">
                                        <div class="col-lg-4 col-md-4 col-sm-4 form-control-label">
                                            <label for="title">Capital equipment's Minimum Range (AED)</label>
                                        </div>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <div class="form-group">
                                                <input type="number" id="min_premium_amount" name="min_premium_amount" class="form-control" placeholder="Enter minimum amount of capital equipment">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-lg-4 col-md-4 col-sm-4 form-control-label">
                                            <label for="title">Capital equipment's Maximum Range (AED)</label>
                                        </div>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <div class="form-group">
                                                <input type="number" id="max_premium_amount" name="max_premium_amount" class="form-control" placeholder="Enter maximum amount of capital equipment">
                                                <p class="small text-warning">If there is no upper limit, please leave the text box empty</p>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 form-control-label">&nbsp;</div>
                                    <div class="col-lg-8 col-md-8 col-sm-8">
                                        <button type="submit" class="btn btn-raised btn-primary btn-round waves-effect" id="save-btn">Save</button>
                                        <a href="{{route('memberships.index')}}" class=" btn btn-raised  btn-round waves-effect btn-secondary">Back</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</section>
@push('scripts')

<script>
    $(document).ready(function() {
        $("#is_premium").on("click", function(e) {
            if ($(this).is(':checked')) {

                $("#ispremium").removeClass().addClass('d-block');
            } else {

                $("#ispremium").removeClass().addClass('d-none');

                $("#min_premium_amount").val(0);
                $("#max_premium_amount").val(0);

            }


        });

    });
</script>

@endpush
@endsection