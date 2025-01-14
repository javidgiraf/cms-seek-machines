@extends('layouts.default')
@section('content')
@push('styles')
<link rel="stylesheet" href="{{asset('frontend/assets/plugins/dropify/css/dropify.min.css')}}">
<link href="{{asset('frontend/assets/plugins/bootstrap-select/css/bootstrap-select.css')}}" rel="stylesheet" />
@endpush
<section class="content">
    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>Category</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="zmdi zmdi-home"></i> Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('categories.index')}}">Categories</a></li>
                        <li class="breadcrumb-item active">Edit Category</li>
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
                            <h2><strong>Edit</strong> Category</h2>

                        </div>
                        <div class="body">
                            <form method="post" enctype="multipart/form-data" action="{{route('categories.update',$category->id)}}">
                                @csrf
                                @method('put')
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 form-control-label">
                                        <label for="title">Category Name</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8">
                                        <div class="form-group">
                                            <input type="text" id="title" name="name" class="form-control" value="{{$category->name}}" placeholder="Enter your Blog Title">
                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 form-control-label">
                                        <label for="slug">Short Code</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8">
                                        <div class="form-group">
                                            <input type="text" id="slug" name="short_code" class="form-control" value="{{$category->short_code }}" placeholder="Enter your blog slug ">
                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 form-control-label">
                                        <label for="slug">Category Icon</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8">

                                        @if($category->icon_url!="")
                                        <input type="file" class="dropify" name="single_image_url" id="single_image_url" accept=".png,.jpeg,.jpg,.svg,.webp" data-default-file="{{ asset(config('app.image_root_url'). $category->icon_url) }}">
                                        @else
                                        <input type="file" class="dropify" name="single_image_url" id="single_image_url" accept=".png,.jpeg,.jpg,.svg,.webp" data-default-file="{{asset('frontend/assets/images/no-image.png')}}">
                                        @endif
                                        <input type="hidden" id="image_folder" name="image_folder" value="categories">

                                        <div id="image-input-error" class="alert"></div>
                                        <input type="hidden" id="image_url" name="image_url" value="{{$category->icon_url}}">
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 form-control-label">
                                        <label for="slug">Parent Category</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8">
                                        <div class="form-group">
                                            <select class="form-control" name="parent_id">
                                                <option selected disabled>--Please Select--</option>
                                                @foreach ($parents as $id => $value)
                                                <option value=" {{ $id }}" {{($category->parent_id == $id)? "selected": ""}}>
                                                    {{ $value }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 form-control-label">
                                        <label for="slug">Meta Title</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8">
                                        <div class="form-group">
                                            <input type="text" id="title" name="meta_title" class="form-control" value="{{$category->meta_title}}" placeholder="Enter your Meta Title">
                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 form-control-label">
                                        <label for="slug">Keywords</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8">
                                        <div class="form-group">
                                            <textarea name="keywords" class="form-control">{{$category->keywords}}</textarea>

                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 form-control-label">
                                        <label for="slug">Meta Description</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8">
                                        <div class="form-group">
                                            <textarea name="meta_descriptions" class="form-control">{{$category->meta_descriptions}}</textarea>

                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix mt-2">
                                    <div class="col-lg-4 col-md-4 col-sm-4  form-control-label">
                                        <label for="approve">Status</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8">
                                        <div class="form-group">
                                            <select class="form-control show-tick ms select2" name="status">
                                                <option selected disabled>--Please Select--</option>
                                                <option value='1' {{($category->status=='1')?'selected':''}}>Active</option>
                                                <option value='0' {{($category->status=='0')?'selected':''}}>Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-lg-4 col-md-4 col-sm-4 form-control-label">&nbsp;</div>
                                    <div class="col-lg-8 col-md-8 col-sm-8">
                                        <button type="submit" class="btn btn-raised btn-primary btn-round waves-effect" id="save-btn">Save</button>
                                        <a href="{{route('categories.index')}}" class=" btn btn-raised  btn-round waves-effect btn-secondary">Back</a>
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
<script src="{{asset('frontend/assets/plugins/summernote/dist/summernote.js')}}"></script>

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

            // delete existing image from the folder
            let existingFile = $("#image_url").val();

            if (existingFile) {

                // if a file already exists, delete existing file
                deleteExistingImage(false);
            }

            let formData = new FormData();
            formData.append("single_image_url", sFile);
            formData.append("image_folder", document.getElementById('image_folder').value);
            formData.append("_token", "{{ csrf_token() }}");
            console.log(formData)
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