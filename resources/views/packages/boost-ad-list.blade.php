@extends('layouts.default')

@section('content')
<section class="content">
  <div class="body_scroll">
    <div class="block-header">
      <div class="row">
        <div class="col-lg-7 col-md-6 col-sm-12">
          <h2>Boost Ads</h2>
          <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="zmdi zmdi-home"></i> Home</a></li>
            <li class="breadcrumb-item active">Boost Ads</li>
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
              <h2><strong>List </strong> Boost Ads </h2>

            </div>
            <div class="body">
              <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                  <thead>
                    <tr>
                      <th>Package Title</th>
                      <th>Start Date</th>
                      <th>End Date</th>
                      <th>Amount</th>
                      <th>View</th> <!-- New column for View -->
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($boostAds as $boostAd)
                    <tr>
                        <td>{{ $boostAd->package->title }}</td> <!-- Accessing the related BoostAdPackage title -->
                        <td>{{ $boostAd->start_date }}</td>
                        <td>{{ $boostAd->end_date }}</td>
                        <td>{{ $boostAd->total_amount }}</td>
                        <td>
                          <!-- View button that links to the show page -->
                          <a href="{{ route('boost-ad-view', $boostAd->id) }}" class="btn btn-info">View</a>
                        </td>
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
