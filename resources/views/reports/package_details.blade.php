@extends('layouts.default')

@section('content')
<section class="content">
  <div class="body_scroll">
    <div class="block-header">
      <div class="row">
        <div class="col-lg-7 col-md-6 col-sm-12">
          <h2>Subscriptions Details for Plan</h2>
          <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="zmdi zmdi-home"></i> Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('package-report')}}"> Subscriptions</a></li>
          </ul>
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <!-- Membership Plan and Total Amount -->



      <!-- Basic Examples -->
      <div class="row clearfix">
        <div class="col-lg-12">
          <div class="card">
            <div class="header">
              <h2><strong>Plan </strong> Details</h2>
            </div>
            <div class="body">
              <div class="table-responsive">

                @livewire('package-detail-report', ['plan_id' => $plan_id, 'startDate' => $start_date, 'endDate' => $end_date])


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
