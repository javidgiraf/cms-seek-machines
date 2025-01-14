<div class="container-fluid">
  <!-- Basic Examples -->
  <div class="row clearfix">
    <div class="col-lg-12">
      <div class="card">
        <div class="header">
          @if (session()->has('message'))
          <div class="alert alert-success">
            {{ session('message') }}
          </div>
          <script>
          setTimeout(function() {
            location.reload();
          }, 1000); // 1000 milliseconds = 1 second
          </script>
          @endif

          @if (session()->has('error'))
          <div class="alert alert-danger">
            {{ session('error') }}
          </div>
          <script>
          setTimeout(function() {
            location.reload();
          }, 1000);
          </script>
          @endif

          @include('layouts.partials.messages')
          <h2><strong>List </strong> Hot deals</h2>
          <!-- <div style='text-align: end' ;><a href="{{route('sellmachines.create')}}" class="btn btn-primary"><i class="zmdi zmdi-plus" style="padding-right: 6px;"></i><span>Add Selling Machines Ads</span></a></div> -->
        </div>
        <div class="body">

          <div class="table-responsive mt-4">
            <table class="table table-bordered table-striped table-hover js-basic-example dataTable">

              <thead>
                <tr>
                  <th>No.</th>
                  <th>Name</th>
                  <th>Start Date</th>
                  <th>End Date</th>
                  <th>Amount(USD)</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($packages as $key=> $ad)

                <tr>
                  <td>{{ $key+1 }}</td>
                  <td>{{ $ad->sellmachine->title  }}</td>
                  <td>{{ $ad->start_date }}</td>
                  <td>{{ $ad->end_date }}</td>
                  <td>{{ number_format($ad->total_amount, 2) }}</td>

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

@push('scripts')

@endpush
