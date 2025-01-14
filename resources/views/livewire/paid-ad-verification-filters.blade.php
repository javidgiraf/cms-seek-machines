<div class="body">
    <div class="row clearfix">
        <div class="col-3">
            <input class="form-control mr-sm-12" type="search" placeholder="Search By title" aria-label="Search" wire:model="keyword">
        </div>
        <div class="col-3"></div>
        <div class="col-3"></div>
        <div class="col-3"></div>
    </div>
    <div class="table-responsive mt-4">
        <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Industry</th>
                    <th>Customer</th>
                    <th>Verify Requested On</th>
                    <th>Verify Status</th>
                    <th>Action</th>

                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Industry</th>
                    <th>Customer</th>
                    <th>Verify Requested On</th>
                    <th>Verify Status</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
             
             
                @forelse($sellMachines as $sellMachine)
                <tr>
                    @if($sellMachine->default_image!="")
                    <td><img src="{{ asset(config('app.image_root_url'). $sellMachine->default_image) }}" width="100"><br />
                        <span class="badge badge-info">{{$sellMachine->item_code}}</span>
                    </td>
                    @else
                    <td><img src="{{asset('frontend/assets/images/no-image.png')}}" style="width:100px"><br />
                        <span class="badge badge-info">{{$sellMachine->item_code}}</span>
                    </td>
                    @endif
                    <td>{{$sellMachine->title}}
                        <span class="badge badge-danger">{{$sellMachine->usage}}</span>
                    </td>
                    <td>{{$sellMachine->category->name}}</td>
                    <td width="15%">{{$sellMachine->user->customer->company}} / {{$sellMachine->user->name}}</td>
                    <td>{{ $sellMachine->verify_submitted_on }}</td>
                    @if($sellMachine->isverified=='0')
                    <td><span class="badge badge-danger">Failed</span></td>
                    @elseif($sellMachine->isverified=='2')
                    <td><span class="badge badge-warning">On Pending</span></td>
                    @else
                    <td><span class="badge badge-success">Verified</span></td>
                    @endif
                    <td><a href="{{route('adverifications.verfication-view',$sellMachine->id)}}" class="mr-2"><i class="zmdi zmdi-eye"></i></a></td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">There are no data.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        {!! $sellMachines->withQueryString()->links('pagination::bootstrap-5') !!}
    </div>
</div>