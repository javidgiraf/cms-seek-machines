@extends('layouts.default')

@section('content')
<section class="content">
    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>Customers</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="zmdi zmdi-home"></i> Home</a></li>
                        <li class="breadcrumb-item active">Customers</li>
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
                            <h2><strong>List </strong> Customers </h2>
                            <div style='text-align: end' ;><a href="{{route('customers.create')}}" class="btn btn-primary"><i class="zmdi zmdi-plus" style="padding-right: 6px;"></i><span>Add Customer</span></a></div>
                        </div>

                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Company</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Country</th>
                                            <th>Status</th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Name</th>
                                            <th>Company</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Country</th>
                                            <th>Status</th>
                                            <th>Action</th>


                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @forelse($users as $user)

                                        <tr>
                                            <td>{{$user->name}}</td>
                                            <td>{{($user->customer)? $user->customer->company: '--'}}</td>
                                            <td>{{$user->email}}</td>
                                            <td>{{($user->customer)? $user->customer->phone: '--'}}</td>
                                            <td>{{($user->customer)? $user->customer->country->name: '--'}}</td>

                                            <td width="20%">
                                                @if($user->customer)
                                                <input type="checkbox" name="verify_status" id="verify_status_{{$user->customer->id}}" {{ ($user->customer->status)? 'checked' : ''}} data-toggle="toggle" data-on="Verify" data-off="Notverify" data-onstyle="success" data-offstyle="danger" value={{ $user->customer->id }}>
                                                @endif
                                            </td>

                                            <td>
                                                <a href="{{route('customers.edit',$user->id)}}" class="mr-2"><i class="zmdi zmdi-edit"></i></a>

                                                <a href="javascript:void(0)" data-id="{{$user->id}}" data-url="{{ route('customers.destroy', $user->id) }}" class="delete-user"><i class="zmdi zmdi-delete"></i></a>
                                                @if($user->customer)
                                                <input type="hidden" id="image_url_{{$user->id}}" name="image_url" value="{{$user->customer->image_url}}">
                                                @endif

                                                <!-- <a href="javascript:void(0);" onclick="event.preventDefault();
                                                document.getElementById('delete-form-{{ $user->id }}').submit();"><i class="zmdi zmdi-delete"></i></a> -->
                                            </td>
                                            <!-- {!! Form::open(['method' => 'DELETE','route' => ['customers.destroy', $user->id],'style'=>'display:none',
                                            'id' => 'delete-form-'.$user->id]) !!}
                                            {!! Form::close() !!} -->

                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="7">There are no data.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                {!! $users->withQueryString()->links('pagination::bootstrap-5') !!}
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
                deleteExistingImage(customerId);

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