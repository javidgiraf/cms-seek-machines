<div class="container-fluid">
  <!-- Basic Examples -->
  <div class="row clearfix">
    <div class="col-lg-12">
      <div class="card">
        <div class="header">
          @include('layouts.partials.messages')
          <h2><strong>Package Subscription Report</strong></h2>

        </div>
        <div class="body">
          <div class="row clearfix">
            <div class="col-3">
              <input class="form-control" type="search" placeholder="Search By Keywords" aria-label="Search" wire:model="keyword">
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

                  <th>Plan</th>
                  <th>Count</th>
                  <th>Amount(USD)</th>
                  <th>View Count</th>

                </tr>
              </thead>

              <tbody>
                @foreach($packages  as $subs)

                <tr>
                  <td>{{ $subs->membership->title }}</td>
                  <td>{{ $subs->plan_count }}</td>
                  <td>{{ $subs->total_amount }}</td>

                    <td>
                      <a href="{{ route('package-view', ['plan_id' => $subs->plan_id, 'start_date' => $startDate, 'end_date' => $endDate]) }}">
                        View Details for {{ $subs->membership->title }}
                      </a>
                  </td>

                </tr>
                @endforeach
              </tbody>
            </table>
            {!! $packages->withQueryString()->links('pagination::bootstrap-5') !!}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@push('scripts')


@endpush
