@extends('layouts.default')

@section('content')
<section class="content">
  <div class="body_scroll">
    <div class="block-header">
      <div class="row">
        <div class="col-lg-7 col-md-6 col-sm-12">
          <h2>Packages</h2>
          <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="zmdi zmdi-home"></i> Home</a></li>
            <li class="breadcrumb-item active">Packages</li>
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
              <h2><strong>List </strong> Packages </h2>
              <div style='text-align: end' ;><a href="{{route('boost-ad-packages.create')}}" class="btn btn-primary"><i class="zmdi zmdi-plus" style="padding-right: 6px;"></i><span>Add Package</span></a></div>
            </div>
            <div class="body">
              <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                  <thead>
                    <tr>
                      <th>Title</th>
                      <th>Pricing</th>
                      <th>No. of Days</th>
                      <th>Discount</th>
                      <th>Status</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($packages as $package)
                    <tr>
                      <td>{{ $package->title }}</td>
                      <td>{{ $package->pricing }}</td>
                      <td>{{ $package->no_of_days }}</td>
                      <td>{{ $package->discount }}</td>
                      <td>{{ $package->status ? 'Active' : 'Inactive' }}</td>
                      <td>
                        <a href="{{ route('boost-ad-packages.edit', $package) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('boost-ad-packages.destroy', $package) }}" method="POST" style="display:inline;">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
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
