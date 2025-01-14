<div class="container-fluid">
  <!-- Basic Examples -->
  <div class="row clearfix">
    <div class="col-lg-12">
      <div class="card">
       
        <div class="body">

<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card shadow-sm">
            <div class="body p-4">
                <h4 class="text-center mb-4">Membership Details</h4>
                <div class="row align-items-center text-center">
                    <div class="col-md-4">
                        <h5 class="mb-1"><strong>Membership Plan:</strong></h5>
                        <p class="lead">{{ $subscriptions->first()->membership->title ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-4">
                        <h5 class="mb-1"><strong>Plan Amount:</strong></h5>
                        <p class="lead">${{ number_format($subscriptions->first()->membership->pricing ?? 0, 2) }}</p>
                    </div>
                    <div class="col-md-4">
                        <h5 class="mb-1"><strong>Total Amount:</strong></h5>
                        <p class="lead">${{ number_format($subscriptions->sum('total_amount') ?? 0, 2) }} (USD)</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





          <table class="table table-bordered table-striped table-hover">
            <thead>
              <tr>
                <th>No.</th>
                <th>User</th>
                 <th>Status</th>
                <th>Start Date</th>
                <th>End Date</th>
              </tr>
            </thead>
            <tbody>
              @foreach($subscriptions as $key => $subscription)
              <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ $subscription->user->name ?? 'N/A' }}</td>
              
                <td>
                  @if($subscription->status == 1)
                  <span class="badge badge-success">Active</span>
                  @else
                  <span class="badge badge-danger">Inactive</span>
                  @endif
                </td>
                <td>{{ $subscription->start_at }}</td>
                <td>{{ $subscription->expires_at }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
