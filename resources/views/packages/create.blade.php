@extends('layouts.default')
@section('content')
@push('styles')
<link rel="stylesheet" href="{{asset('frontend/assets/plugins/dropify/css/dropify.min.css')}}">
@endpush
<section class="content">
  <div class="body_scroll">
    <div class="block-header">
      <div class="row">
        <div class="col-lg-7 col-md-6 col-sm-12">
          <h2>Package</h2>
          <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="zmdi zmdi-home"></i> Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('boost-ad-packages.index')}}">Packages</a></li>
            <li class="breadcrumb-item active">Create Package</li>
          </ul>
          <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
        </div>
        {{-- <div class="col-lg-5 col-md-6 col-sm-12">
          <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>
        </div> --}}
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

      <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12">
          <div class="card">
            <div class="header">
              <h2><strong>Create</strong> New Boost Ad Package</h2>
            </div>
            <div class="body">
              <form method="post" action="{{ route('boost-ad-packages.store') }}">
                @csrf
                <div class="row clearfix">
                  <div class="col-lg-4 col-md-4 col-sm-4 form-control-label">
                    <label for="title">Package Title</label>
                  </div>
                  <div class="col-lg-8 col-md-8 col-sm-8">
                    <div class="form-group">
                      <input type="text" id="title" name="title" class="form-control" placeholder="Enter package title" required>
                    </div>
                  </div>
                </div>

                <div class="row clearfix">
                  <div class="col-lg-4 col-md-4 col-sm-4 form-control-label">
                    <label for="pricing">Pricing</label>
                  </div>
                  <div class="col-lg-8 col-md-8 col-sm-8">
                    <div class="form-group">
                      <input type="number" id="pricing" name="pricing" class="form-control" step="0.01" placeholder="Enter package pricing" required>
                    </div>
                  </div>
                </div>

                <div class="row clearfix">
                  <div class="col-lg-4 col-md-4 col-sm-4 form-control-label">
                    <label for="no_of_days">Number of Days</label>
                  </div>
                  <div class="col-lg-8 col-md-8 col-sm-8">
                    <div class="form-group">
                      <input type="number" id="no_of_days" name="no_of_days" class="form-control" placeholder="Enter number of days" required>
                    </div>
                  </div>
                </div>

                <div class="row clearfix">
                  <div class="col-lg-4 col-md-4 col-sm-4 form-control-label">
                    <label for="discount">Discount (%)</label>
                  </div>
                  <div class="col-lg-8 col-md-8 col-sm-8">
                    <div class="form-group">
                      <input type="number" id="discount" name="discount" class="form-control" value="0" placeholder="Enter discount percentage" min="0">
                    </div>
                  </div>
                </div>


                <div class="row clearfix">
                  <div class="col-lg-4 col-md-4 col-sm-4 form-control-label">
                    <label for="category">Industry of machine used</label>
                  </div>
                  <div class="col-lg-8 col-md-8 col-sm-8">
                    <div class="form-group">
                      <select class="form-control show-tick ms sel-category" name="category_id">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                      </select>
                    </div>
                  </div>
                </div>


                <div class="row mt-4">
                  <div class="col-lg-4 col-md-4 col-sm-4 form-control-label">&nbsp;</div>
                  <div class="col-lg-8 col-md-8 col-sm-8">
                    <button type="submit" class="btn btn-raised btn-primary btn-round waves-effect" id="save-btn">Save</button>
                    <a href="{{ route('boost-ad-packages.index') }}" class="btn btn-raised btn-round waves-effect btn-secondary">Back</a>
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
<script src="{{asset('frontend/assets/plugins/dropify/js/dropify.min.js')}}"></script>
<script src="{{asset('frontend/assets/js/pages/forms/dropify.js')}}"></script>

@endpush
@endsection
