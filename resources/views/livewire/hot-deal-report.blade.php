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
          <h2><strong>List </strong>Hot Deal Report</h2>
          <!-- <div style='text-align: end' ;><a href="{{route('sellmachines.create')}}" class="btn btn-primary"><i class="zmdi zmdi-plus" style="padding-right: 6px;"></i><span>Add Selling Machines Ads</span></a></div> -->
        </div>
        <div class="body">
          <div class="row clearfix">
            <div class="col-3">
              <input class="form-control" type="search" placeholder="Search By Keywords" aria-label="Search" wire:model="keyword" wire:change="resetPage">
            </div>
            <div class="col-3">
              <input type="date" class="form-control" wire:model="startDate" wire:change="resetPage">
            </div>
            <div class="col-3">
              <input type="date" class="form-control" wire:model="endDate" wire:change="resetPage">
            </div>
            <div class="col-3">
              <button wire:click="downloadExcel" class="btn btn-success">Download</button>

            </div>
          </div>

          <div class="table-responsive mt-4">
            <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
              <thead>
                <tr>

                  <th>Title</th>
                  <th>Count</th>
                  <th>Amount(USD)</th>
                  <th>View</th>

                </tr>
              </thead>

              <tbody>
                @foreach($packages as $package)
          
                <tr>
                  <td>{{ $package->title }}</td>
                  <td>{{ $package->boost_ads_count }} </td>
                  <td>{{ $package->boost_ads_sum_total_amount }}</td>
                  <td>
                    <a href="{{ route('hot-deals-view', ['packageId' => $package->id, 'startDate' => $startDate, 'endDate' => $endDate]) }}">
                      View Details
                    </a>
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

@push('scripts')

@endpush
