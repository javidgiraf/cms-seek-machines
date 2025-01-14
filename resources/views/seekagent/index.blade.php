@extends('layouts.default')

@section('content')
<section class="content">
    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>Seek Agent</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="zmdi zmdi-home"></i> Home</a></li>
                        <li class="breadcrumb-item active">Seek Agent</li>
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
                            <h2><strong>List </strong> Seek Agents </h2>
                            <div style='text-align: end' ;><a href="{{route('seekagent.create')}}" class="btn btn-primary"><i class="zmdi zmdi-plus" style="padding-right: 6px;"></i><span>Add Seek Agent</span></a></div>
                        </div>

                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>User</th>
                                            <th>Designation</th>
                                            <th>Phone</th>
                                            <th>Status</th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                          <th>Image</th>
                                          <th>User</th>
                                          <th>Designation</th>
                                          <th>Phone</th>
                                          <th>Status</th>
                                          <th>Action</th>

                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @forelse($agents as $agent)

                                        <tr>
                                            <td>{{$agent->image_url}}</td>
                                            <td>{{$agent->user->name}}</td>
                                            <td>{{$agent->designation}}</td>
                                            <td>{{$agent->phone}}</td>
                                            <td>{{ $agent->status == 1 ? 'Active' : 'Inactive' }}</td>

                                            <td>
                                                <a href="{{route('seekagent.edit',$agent->id)}}" class="mr-2"><i class="zmdi zmdi-edit"></i></a>

                                                <a href="javascript:void(0)" data-id="{{$agent->id}}" data-url="{{ route('seekagent.destroy', $agent->id) }}" class="delete-user"><i class="zmdi zmdi-delete"></i></a>

                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="7">There are no data.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                {!! $agents->withQueryString()->links('pagination::bootstrap-5') !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>
@push('scripts')
<script>
    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        /*------------------------------------------
        --------------------------------------------
        When click customer on Delete Button
        --------------------------------------------
        --------------------------------------------*/

        $(document).on('click', '.delete-user', function() {

            var customerURL = $(this).data('url');
            var customerId = $(this).data('id');
            var trObj = $(this);

            if (confirm("Are you sure you want to delete this customer?") == true) {

                $.ajax({
                    url: customerURL,
                    type: 'DELETE',
                    dataType: 'json',
                    success: function(data) {
                        //alert(data.success);
                        trObj.parents("tr").remove();

                        Swal.fire({
                            title: "Deleted!",
                            text: data.message,
                            icon: "success",
                        });

                        // setTimeout(function() {
                        //     window.location.reload();
                        // }, 3000);

                    }
                });
            }

        });

        function deleteExistingImage(customerId) {
            let existingImage = $("#image_url_" + customerId).val();
            if (!existingImage) {
                return false;
            }

            let formData = new FormData();
            formData.append("imageurl", existingImage);
            formData.append("_token", "{{ csrf_token() }}");

            let api_root = "{{ env('API_URL') }}";
            let apiurl = api_root + "/deleteImage";

            $.ajax({
                type: 'POST',
                url: apiurl,
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    // setting a timeout
                },
                success: (response) => {
                    if (response.success) {
                        $("#image_url_" + customerId).val('');
                    }
                },
                error: function(response) {
                    // console.log(response.responseJSON.message);
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: response.responseJSON.message
                    });

                }
            });
        }

        /*------------------------------------------
        --------------------------------------------
        STATUS CHANGE
        --------------------------------------------
        --------------------------------------------*/
        $('input[name="verify_status"]').on('change', function(e) {

            let obj = $(this);
            if (!obj.val()) {
                return false;
            }
            //  console.log($(this).prop('checked'));

            let checked = $(this).prop('checked') ? 1 : 0;

            $.ajax({
                url: "{{ route('customer.updatestatus') }}",
                method: "POST",
                data: {
                    itemid: obj.val(),
                    status: checked
                },
                success: function(data) {

                    Swal.fire({
                        title: (checked) ? "Enabled" : "Disabled",
                        text: data.message,
                        icon: "success",
                    });
                },
                error: function(data) {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Something went wrong!"
                    });
                }
            });
        });
    });
</script>
@endpush
@endsection
