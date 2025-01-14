@extends('layouts.default')

@section('content')
<section class="content">
    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>Brands</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="zmdi zmdi-home"></i> Home</a></li>
                        <li class="breadcrumb-item active">Brands</li>
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
                            <h2><strong>List </strong> Brands </h2>
                            <div style='text-align: end' ;><a href="{{route('brands.create')}}" class="btn btn-primary"><i class="zmdi zmdi-plus" style="padding-right: 6px;"></i><span>Add Brands</span></a></div>
                        </div>

                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>Brands</th>
                                            <th>Is Popular?</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Image</th>
                                            <th>Brands</th>
                                            <th>Is Popular?</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @forelse($brands as $brand)
                                        <tr>
                                            @if($brand->logo_url!="")
                                            <td width="30%"><img src="{{ asset(config('app.image_root_url'). $brand->logo_url) }}" width="30%" />
                                            </td>
                                            @else
                                            <td width="30%"><img src="{{asset('frontend/assets/images/no-image.png')}}" width="30%"></td>
                                            @endif
                                            <td>{{$brand->manufacturer}}</td>
                                            <td>{{$brand->ispopular ? "Yes": '--'}}</td>
                                            <td width="20%">
                                                <input type="checkbox" name="verify_status" id="verify_status_{{$brand->id}}" {{ ($brand->status)? 'checked' : ''}} data-toggle="toggle" data-on="Verify" data-off="Notverify" data-onstyle="success" data-offstyle="danger" value={{ $brand->id }}>
                                            </td>
                                            <td width="20%">
                                                <a href="{{route('brands.edit',$brand->id)}}" class="mr-2"><i class="zmdi zmdi-edit"></i></a>

                                                <a href="javascript:void(0)" data-id="{{$brand->id}}" data-url="{{ route('brands.destroy', $brand->id) }}" class="delete-brand"><i class="zmdi zmdi-delete"></i></a>
                                                <input type="hidden" id="image_url_{{$brand->id}}" name="image_url" value="{{$brand->logo_url}}">

                                            </td>

                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5">There are no data.</td>
                                        </tr>
                                        @endforelse

                                    </tbody>
                                </table>
                                {!! $brands->withQueryString()->links('pagination::bootstrap-5') !!}
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
        When click brand on Delete Button
        --------------------------------------------
        --------------------------------------------*/

        $(document).on('click', '.delete-brand', function() {

            var brandURL = $(this).data('url');
            var brandId = $(this).data('id');
            var trObj = $(this);

            if (confirm("Are you sure you want to delete this brand?") == true) {
                deleteExistingImage(brandId);

                $.ajax({
                    url: brandURL,
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

        function deleteExistingImage(brandId) {
            let existingImage = $("#image_url_" + brandId).val();
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
                        $("#image_url_" + brandId).val('');
                    }
                },
                error: function(response) {
                    console.log(response.responseJSON.message);
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
                url: "{{ route('brand.updatestatus') }}",
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