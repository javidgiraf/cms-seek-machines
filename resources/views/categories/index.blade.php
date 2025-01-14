@extends('layouts.default')

@section('content')
<section class="content">
    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>Categories</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="zmdi zmdi-home"></i> Home</a></li>
                        <li class="breadcrumb-item active">Categories</li>
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
                            <h2><strong>List </strong> Category </h2>
                            <div style='text-align: end' ;><a href="{{route('categories.create')}}" class="btn btn-primary"><i class="zmdi zmdi-plus" style="padding-right: 6px;"></i><span>Add Category</span></a></div>

                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>Icons</th>
                                            <th>Category</th>
                                            <th>Parent</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Icons</th>
                                            <th>Category</th>
                                            <th>Parent</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @forelse($categories as $category)
                                        <tr>
                                            @if($category->icon_url != "")
                                            <td width="15%"><img src="{{ asset(config('app.image_root_url'). $category->icon_url) }}"></td>
                                            @else
                                            <td width="15%"><img src="{{asset('frontend/assets/images/no-image.png')}}" width="20%"></td>
                                            @endif
                                            <td>{{$category->name}}</td>
                                            <td>{{$category->parent? $category->parent->name: '--'}}</td>
                                            <td>@if($category->status)<span class="badge badge-success">Active</span>
                                                @else
                                                <span class="badge badge-danger">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{route('categories.edit',$category->id )}}" class="mr-2"><i class="zmdi zmdi-edit"></i></a>

                                                <a href="javascript:void(0)" data-id="{{$category->id}}" data-url="{{ route('categories.destroy', $category->id) }}" class="delete-category"><i class="zmdi zmdi-delete"></i></a>
                                                <input type="hidden" id="image_url_{{$category->id}}" name="image_url" value="{{$category->icon_url}}">
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="3">There are no data.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                {!! $categories->withQueryString()->links('pagination::bootstrap-5') !!}
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
        When click category on Delete Button
        --------------------------------------------
        --------------------------------------------*/

        $(document).on('click', '.delete-category', function() {

            var categoryURL = $(this).data('url');
            var categoryId = $(this).data('id');
            var trObj = $(this);

            if (confirm("Are you sure you want to delete this category?") == true) {
                deleteExistingImage(categoryId);

                $.ajax({
                    url: categoryURL,
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

        function deleteExistingImage(categoryId) {
            let existingImage = $("#image_url_" + categoryId).val();
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
                        $("#image_url_" + categoryId).val('');
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

    });
</script>
@endpush
@endsection