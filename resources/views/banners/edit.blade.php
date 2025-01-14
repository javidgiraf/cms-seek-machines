@extends('layouts.default')
@section('content')
@push('styles')
<link rel="stylesheet" href="{{asset('frontend/assets/plugins/dropify/css/dropify.min.css')}}">
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
@endpush
<section class="content">
    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>Boosted Ad Banner</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="zmdi zmdi-home"></i> Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('banners.index')}}">Banners</a></li>
                        <li class="breadcrumb-item active">Edit Ad Banner</li>
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
                    @if(session()->has('success'))
                    <div class="alert alert-success">
                        {{ session()->get('success') }}
                    </div>
                    @endif


                </div>
            </div>

            <!-- Horizontal Layout -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="header">
                            <h2><strong>Edit</strong> Ad Banner</h2>

                        </div>
                        <div class="body">
                            <form method="post" enctype="multipart/form-data" action="{{route('banners.update',$banner->id)}}">
                                @csrf
                                @method('put')

                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 form-control-label">
                                        <label for="title">Banner Ad Title</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8">
                                        <div class="form-group">
                                            <input type="text" id="title" name="title" class="form-control" value="{{$banner->title}}" placeholder="Enter your Banner Title">
                                        </div>
                                    </div>
                                </div>

                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 form-control-label">
                                        <label for="description">Ad Short Description</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8">
                                        <div class="form-group">
                                            <textarea id="description" name="description" class="form-control">{{$banner->description}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 form-control-label">
                                        <label for="label">Display Label</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8">
                                        <div class="form-group">
                                            <input type="text" id="label" name="label" class="form-control" value="{{$banner->label}}" placeholder="Enter your Blog Label">
                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 form-control-label">
                                        <label for="link_to">Banner Linked to</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8">
                                        <div class="form-group">
                                            <input type="text" id="link_to" name="link_to" class="form-control" value="{{$banner->link_to}}" placeholder="Enter Banner Link">
                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix mt-2">
                                    <div class="col-lg-4 col-md-4 col-sm-4 form-control-label">
                                        <label for="slug">Banner Image</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8">

                                        @if($banner->image_url !="")
                                        <input type="file" class="dropify" name="single_image_url" id="single_image_url" data-default-file="{{ asset(config('app.image_root_url'). $banner->image_url) }}" accept=".png,.jpeg,.jpg,.svg,.webp">
                                        @else
                                        <input type="file" class="dropify" name="single_image_url" id="single_image_url" data-default-file="{{asset('frontend/assets/images/no-image.png')}}">
                                        @endif
                                        <input type="hidden" id="image_folder" name="image_folder" value="banners">
                                        <div id="image-input-error" class="alert"></div>
                                        <input type="hidden" id="image_url" name="image_url" value="{{$banner->image_url}}">
                                    </div>
                                </div>
                                <div class="row clearfix mt-2">
                                    <div class="col-12">
                                        <hr />
                                    </div>
                                </div>
                                <div class="row clearfix mt-2">
                                    <div class="col-lg-4 col-md-4 col-sm-4 form-control-label">
                                        <label for="link_to">No Of Days</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8">
                                        <input type="number" id="no_of_days" name="no_of_days" class="form-control" value="{{$banner->boostad->days}}" placeholder="Enter No of Days">
                                    </div>
                                </div>
                                <div class="row clearfix mt-2">
                                    <div class="col-lg-4 col-md-4 col-sm-4 form-control-label">
                                        <label for="link_to">Total Amount</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8">
                                        <input type="hidden" id="basic_amt" name="basic_amt" value="{{$adamount->def_value}}" />
                                        <input type="number" readonly id="total_amount" name="total_amount" class="form-control" value="{{$banner->boostad->total_amount}}" placeholder="Enter Amount (AED)">
                                        <span class="text-info small">Basic Amount : {{$adamount->def_value}} AED</span>
                                    </div>
                                </div>
                                <div class="row clearfix mt-2">
                                    <div class="col-lg-4 col-md-4 col-sm-4 form-control-label">
                                        <label for="link_to">Start Date</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8">
                                        <input type="text" name="start_date" id="start_date" class="form-control" value="{{ date('d-m-Y', strtotime($banner->boostad->start_date)) }}">
                                    </div>
                                </div>
                                <div class="row clearfix mt-2">
                                    <div class="col-lg-4 col-md-4 col-sm-4 form-control-label">
                                        <label for="link_to">End Date</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8">
                                        <input type="text" readonly name="end_date" id="end_date" class="form-control" value="{{ date('d-m-Y', strtotime($banner->boostad->end_date)) }}">
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-lg-4 col-md-4 col-sm-4 form-control-label">&nbsp;</div>
                                    <div class="col-lg-8 col-md-8 col-sm-8">
                                        <button type="submit" class="btn btn-raised btn-primary btn-round waves-effect" id="save-btn">Save</button>
                                        <a href="{{route('banners.index')}}" class=" btn btn-raised  btn-round waves-effect btn-secondary">Back</a>
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
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

<script>
    $(function() {

        $("#start_date").datepicker({
            dateFormat: 'dd-mm-yy',
            minDate: new Date(),
            onSelect: function(date) {
                findEndDate(date);
            },
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // single image upload
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
                // already have an uploaded file, please remove it 
                deleteExistingImage();
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
                        $("#single_image_url").attr("data-default-file", response.data.single_image_url);

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

            deleteExistingImage();
        });

        function deleteExistingImage() {
            let existingImage = $("#image_url").val();
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
                        $("#image_url").val('');
                    }
                },
                error: function(response) {
                    console.log(response.responseJSON.message);
                    // Swal.fire({
                    //     icon: "error",
                    //     title: "Oops...",
                    //     text: response.responseJSON.message
                    // });

                }
            });
        }
    });

    function findEndDate(start) {
        let days = $("#no_of_days").val() ? $("#no_of_days").val() : 0;


        let end_date = moment(start, "DD-MM-YYYY").add(days, 'days');
        const formatedDate = end_date.format("DD-MM-YYYY");
        $("#end_date").val(formatedDate);
    }
    /**********************
     * Number Of Days
     * ******************************/
    $("#no_of_days").keyup(function(e) {
        //e.preventDefault();
        let amt = $('#basic_amt').val(),
            days = $(this).val(),
            total = 0;

        if (amt && days) {
            total = (parseInt(amt) * parseInt(days));
        }
        $("#total_amount").val(total);

        let start = $("#start_date").val();
        if (start) {
            findEndDate(start);
        }

    });
</script>
@endpush
@endsection