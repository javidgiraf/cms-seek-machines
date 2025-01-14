<div class="container-fluid">
  <!-- Basic Examples -->
  <div class="row clearfix">
    <div class="col-lg-12">
      <div class="card">
        <div class="header">
          @include('layouts.partials.messages')
         
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
                  <th>Item Code</th>
                  <th>Model No</th>
                  <th>Machine Title</th>
                  <th>Industry</th>
                  <th>Visitors Count</th>

                </tr>
              </thead>

              <tbody>
                @forelse($sellMachines as $sellMachine)

                <tr>
                  <td>
                   
                     <span class="badge badge-info mt-2">{{$sellMachine->item_code}}</span>
                   
                  </td>
                    <td>{{$sellMachine->modelno}}</td>
                  <td>
                    {{ Str::limit($sellMachine->title, 40, '...') }}
                    <span class="badge badge-danger">{{$sellMachine->usage}}</span>
                  </td>
                  <td>{{$sellMachine->category->name}}</td>
                  <td>
                    {{-- Display the count of visitors --}}
                    {{$sellMachine->subscribe_visits_count}}
                  </td>


                </tr>
                @empty
                <tr>
                  <td colspan="8">There are no data.</td>
                </tr>
                @endforelse
              </tbody>
            </table>
            {!! $sellMachines->withQueryString()->links('pagination::bootstrap-5') !!}
          </div>
        </div>
      </div>
    </div>
  </div>

  @push('scripts')
  @endpush
</div>
