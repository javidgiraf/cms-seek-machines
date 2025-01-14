@extends('layouts.default')
@section('content')
@push('styles')
<link rel="stylesheet" href="{{asset('frontend/assets/plugins/dropify/css/dropify.min.css')}}">
@endpush
<section class="content">
    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>Brand</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="zmdi zmdi-home"></i> Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('brands.index')}}">Brands</a></li>
                        <li class="breadcrumb-item active">Create Brands</li>
                    </ul>
                    <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
                </div>
                {{-- <div class="col-lg-5 col-md-6 col-sm-12">
                    <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>
                </div> --}}
            </div>
        </div>

        <div class="container-fluid">
            <!-- Vertical Layout -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif


                </div>
            </div>

            <!-- Horizontal Layout -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="header">
                            <h2><strong>Create</strong> New Brands</h2>
                        </div>
                        <div class="body">
                            <form method="post" id="frmbrand" enctype="multipart/form-data" action="{{route('brands.store')}}">
                                @csrf
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 form-control-label">
                                        <label for="title">Manufacturer</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8">
                                        <div class="form-group">
                                            <input type="text" id="title" name="manufacturer" class="form-control" placeholder="Enter your Brand Title">
                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 form-control-label">
                                        <label for="slug">Short Code</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8">
                                        <div class="form-group">
                                            <input type="text" id="short_code" name="short_code" class="form-control" placeholder="Enter your Short Code (eg: ergopack) ">
                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 form-control-label">
                                        <label for="slug">Popular brand</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8">
                                        <div class="checkbox">
                                            <input type="checkbox" id="ispopular" name="ispopular" class="form-control" value="1">
                                            <label for="ispopular">
                                                Do you want to list out as Popular/featured brand?
                                            </label>
                                        </div>

                                    </div>
                                </div>

                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 form-control-label">
                                        <label for="slug">Upload Logo</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8">
                                        <input type="file" class="dropify" name="single_image_url" id="single_image_url" accept=".png,.jpeg,.jpg,.svg,.webp">
                                        <input type="hidden" id="image_folder" name="image_folder" value="brands">

                                        <div id="image-input-error" class="alert"></div>
                                        <input type="hidden" id="image_url" name="image_url">
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-lg-4 col-md-4 col-sm-4 form-control-label">&nbsp;</div>
                                    <div class="col-lg-8 col-md-8 col-sm-8">
                                        <button type="submit" class="btn btn-raised btn-primary btn-round waves-effect" id="save-btn">Save</button>
                                        <a href="{{route('brands.index')}}" class=" btn btn-raised  btn-round waves-effect btn-secondary">Back</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</section>

@push('scripts')
<script src="{{asset('frontend/assets/plugins/dropify/js/dropify.min.js')}}"></script>
<script src="{{asset('frontend/assets/js/pages/forms/dropify.js')}}"></script>
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#single_image_url').change(function(e) {
            e.preventDefault();

            const oFile = document.getElementById("single_image_url");
            const sFile = oFile.files[0];
            const maxSize = 1024 * 1024 * 2;
            // Check if any file is selected.
            if (sFile.size > maxSize) // 20 MiB for bytes.
            {
                alert("File size must under 2MB!");
                oFile.value = "";
                return;
            }
            let allowedExtension = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/bmp', 'image/svg', 'image/webp'];
            let type = sFile.type;
            if (allowedExtension.indexOf(type) > -1) {

            } else {
                alert("File format must be supported one");
                oFile.value = "";
                return;
            }

            if ($("#image_url").val() != '') {
                deleteExistingImage(false);
            }

            let formData = new FormData();
            formData.append("single_image_url", sFile);
            formData.append("image_folder", document.getElementById('image_folder').value);
            formData.append("_token", "{{ csrf_token() }}");

            $('#image-input-error').text('');
            $("#image_url").val('');

            let api_root = "{{ env('API_URL') }}";
            let apiurl = api_root + "/singleimage";

            $.ajax({
                type: 'POST',
                url: apiurl,
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    // setting a timeout
                    $("#save-btn").attr('disabled', true);
                },
                success: (response) => {
                    if (response) {
                        $("#image_url").val(response.data.single_image_url);
                        $("#save-btn").removeAttr('disabled');
                        Swal.fire({
                            title: "Uploaded!",
                            text: response.message,
                            icon: "success",
                        });
                    }
                },
                error: function(response) {
                    $('#image-input-error').text(response.responseJSON.message);
                    $("#image_url").val('');
                    $("#save-btn").attr('disabled', true);
                }
            });
        });

        $('.dropify-clear').click(function(e) {
            e.preventDefault();

            deleteExistingImage(true);
        });

        function deleteExistingImage(ispopup = false) {
            let existingImage = $("#image_url").val();
            if (!existingImage) {
                return false;
            }

            let formData = new FormData();
            formData.append("imageurl", existingImage);
            formData.append("_token", "{{ csrf_token() }}");

            $('#image-input-error').text('');

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
                    $("#save-btn").attr('disabled', true);
                },
                success: (response) => {
                    if (response.success) {
                        $("#image_url").val('');
                        $("#save-btn").removeAttr('disabled');
                        if (ispopup) {
                            Swal.fire({
                                title: "Deleted!",
                                text: response.message,
                                icon: "success",
                            });
                        }
                    }
                },
                error: function(response) {
                    $('#image-input-error').text(response.responseJSON.message);
                    $("#save-btn").attr('disabled', true);
                }
            });
        }

    });
</script>
@endpush
@endsection