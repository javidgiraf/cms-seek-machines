@extends('layouts.default')

@section('content')
<section class="content">
  <div class="body_scroll">
    <div class="block-header">
      <div class="row">
        <div class="col-lg-7 col-md-6 col-sm-12">
          <h2>Boost Ad Details</h2>
          <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="zmdi zmdi-home"></i> Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('boost-ad-list') }}">Boost Ad</a></li>
            <li class="breadcrumb-item active">Boost Ad Details</li>
          </ul>
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <!-- Boost Ad Details -->
      <div class="row clearfix">
        <div class="col-lg-12">
          <div class="card">
            <div class="header">
              <h2><strong>Boost Ad</strong> Details </h2>
            </div>
            <div class="body">
              <div class="row mb-3">
                <div class="col-md-6">
                  <strong>Machine:</strong>
                  <p>{{ $boostAd->sellmachine->title }}</p>
                </div>
                <div class="col-md-6">
                  <strong>Item Code:</strong>
                  <p>{{ $boostAd->sellmachine->item_code  }}</p>
                </div>
              </div>
              <!-- Row-Wise Layout with Two Pairs in One Row -->
              <div class="row mb-3">
                <div class="col-md-6">
                  <strong>Package Title:</strong>
                  <p>{{ $boostAd->package->title }}</p>
                </div>
                <div class="col-md-6">
                  <strong>Start Date:</strong>
                  <p>{{ $boostAd->start_date }}</p>
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-md-6">
                  <strong>End Date:</strong>
                  <p>{{ $boostAd->end_date }}</p>
                </div>
                <div class="col-md-6">
                  <strong>Amount:</strong>
                  <p>{{ $boostAd->total_amount }}</p>
                </div>
              </div>
              <div class="row mb-3">
                <div class="col-md-6">
                  <strong>No Of Days:</strong>
                  <p>{{ $boostAd->days }}</p>
                </div>

              </div>


            </div>
          </div>

          <!-- Boosted Dates Table -->
          <div class="card">
            <div class="header">
              <h2><strong>Reserved Dates</strong> List</h2>
            </div>
            <div class="body">
              <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                  <thead>
                    <tr>
                      <th>Reserved Date</th>

                    </tr>
                  </thead>
                  <tbody>
                    @foreach($boostAd->boostedDate as $boostedDate)
                    <tr>
                      <td>{{ \Carbon\Carbon::parse($boostedDate->reserved_date)->format('M d, Y') }}</td>
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
