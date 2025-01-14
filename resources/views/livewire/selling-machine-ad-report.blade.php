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
          <h2><strong>List </strong> Monthly Report</h2>
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
                  <th>Image</th>
                  <th>Title</th>
                  <th>Industry</th>
                  <th>Customer</th>
                  <th>Year</th>
                  <th>Origin</th>
                  <th>Ad Status</th>
                  <th>Verified Stataus</th>
                  <th>Posted On</th>
                </tr>
              </thead>

              <tbody>
                @forelse($sellMachines as $sellMachine)

                <tr>

                  @if( $sellMachine->default_image!="")

                  <td>
                    <img src="{{ asset(config('app.image_root_url'). $sellMachine->default_image) }}" width="100"><br />
                    <span class="badge badge-info mt-2">{{$sellMachine->item_code}}</span>
                  </td>
                  @else
                  <td>
                    <img src="{{asset('frontend/assets/images/no-image.png')}}" width="100"><br />
                    <span class="badge badge-info mt-2">{{$sellMachine->item_code}}</span>
                  </td>
                  @endif
                  <td>
                    {{ Str::limit($sellMachine->title, 40, $end='...') }}
                    <span class="badge badge-danger">{{$sellMachine->usage}}</span>
                  </td>
                  <td>{{$sellMachine->category->name}}</td>
                  <td width="15%">{{(isset($sellMachine->user->customer->company))? $sellMachine->user->customer->company : ''}} /

                    {{$sellMachine->user->name}}</td>
                    <td>{{$sellMachine->yearof}}</td>
                    <td>{{$sellMachine->country->name}}</td>
                    <th>
                      @switch($sellMachine->status)
                      @case(1)
                      <span class="badge badge-success">Active</span>
                      @break
                      @case(2)
                      <span class="badge badge-warning">Pending</span>
                      @break
                      @default
                      <span class="badge badge-danger">Inactive</span>
                      @break
                      @endswitch
                    </th>
                    <td>
                      @if($sellMachine->isverified)
                      Verified
                      @else
                      Unverified
                      @endif
                    </td>
                    <td>{{ date("d-m-Y", strtotime($sellMachine->created_at))}}</td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="9">There are no data.</td>
                  </tr>
                  @endforelse
                </tbody>
              </table>
              {{ $sellMachines->links() }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  @push('scripts')

  @endpush
