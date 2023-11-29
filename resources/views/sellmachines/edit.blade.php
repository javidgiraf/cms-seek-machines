@extends('layouts.default')
@section('content')
@push('styles')
<link rel="stylesheet" href="{{asset('frontend/assets/plugins/dropify/css/dropify.min.css')}}">
<link rel="stylesheet" href="{{asset('frontend/assets/plugins/summernote/dist/summernote.css')}}" />
<link href="{{asset('frontend/assets/plugins/bootstrap-select/css/bootstrap-select.css')}}" rel="stylesheet" />
<link rel="stylesheet" href="{{asset('frontend/assets/plugins/select2/select2.css')}}" />
<style>
    .remove-btn {

        border: none;
        cursor: pointer;
        width: 41px;
        height: 40px;
        /* padding: 10px; */
        /* padding-bottom: 10px; */
        margin: 5px;
    }

    .attach-file.style--three {
        width: auto;
        height: auto;
        padding: 5px 15px;

        display: inline-flex;
        background-color: #CCF5F8;
        color: #09D1DE;
    }
</style>
@endpush
<section class="content">
    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>Selling Machines Ads</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="zmdi zmdi-home"></i> Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('sellmachines.index')}}">Selling Machines Ads</a></li>
                        <li class="breadcrumb-item active">Edit Selling Machines Ads</li>
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
                    <form method="post" enctype="multipart/form-data" action="{{route('sellmachines.update',$sellmachine->id) }}">
                        @csrf
                        @method('put')
                        <div class="card">
                            <div class="header">
                                <h2><strong>Edit</strong>Customer</h2>
                                <div style='text-align: end' ;><a href="{{route('sellmachines.index')}}" class="btn btn-primary"><i class="zmdi zmdi-arrow-left" style="padding-right: 6px;"></i><span>Back</span></a></div>
                            </div>
                            <div class="body">

                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">
                                        <label for="name">Name</label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8">
                                        <div class="form-group">
                                            <input type="text" id="title" name="name" class="form-control" value="{{$sellmachine->title}}" placeholder="Enter Sell Machine Title">
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">
                                        <label for="slug">Slug</label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8">
                                        <div class="form-group">
                                            <input type="text" id="slug" name="slug" class="form-control" value="{{$sellmachine->slug}}" placeholder="Enter Sell Machine slug ">
                                        </div>
                                    </div>
                                </div> -->

                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">
                                        <label for="slug">Description</label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8">
                                        <div class="form-group">
                                            <textarea class="form-control" rows="10" id="description" name="description">{{$sellmachine->description}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">
                                        <label for="item_code">Item Code</label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8">
                                        <div class="form-group">
                                            <input type="text" id="item_code" name="item_code" class="form-control" value="{{$sellmachine->item_code }}" placeholder="Enter Sell Machine Item Code">
                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">
                                        <label for="category">Category</label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8">
                                        <div class="form-group">
                                            <select class="form-control show-tick ms select2" name="category_id">
                                                <option selected disabled>--Please Select--</option>
                                                @foreach ($categories as $category)
                                                <option value=" {{ $category->id }}" {{($sellmachine->category_id== $category->id)? "selected": ""}}>
                                                    {{ $category->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>




                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">
                                        <label for="slug">Image</label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8">
                                        @if((file_exists('storage/' . $sellmachine->default_image)) && $sellmachine->default_image!="")
                                        <input type="file" class="dropify" name="default_image" data-default-file="{{ asset('storage/' . $sellmachine->default_image) }}">
                                        @else
                                        <input type="file" class="dropify" name="default_image" data-default-file="{{asset('frontend/assets/images/no-image.png')}}">
                                        @endif
                                    </div>
                                </div>

                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">
                                        <label for="country">Country</label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8">
                                        <div class="form-group">
                                            <select class="form-control show-tick ms select2" name="country_id">
                                                <option selected disabled>--Please Select--</option>
                                                @foreach ($countries as $country)
                                                <option value=" {{ $country->id }}" {{($sellmachine->country_id == $country->id)? "selected": ""}}>
                                                    {{ $country->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">
                                        <label for="brands">Brands</label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8">
                                        <div class="form-group">
                                            <select class="form-control show-tick ms select2" name="brand_id">
                                                <option selected disabled>--Please Select--</option>
                                                @foreach ($brands as $brand)
                                                <option value=" {{ $brand->id }}" {{($sellmachine->brand_id == $brand->id)? "selected": ""}}>
                                                    {{ $brand->manufacturer }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">
                                        <label for="yearof">Year Of Manufacturing</label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8">
                                        <div class="form-group">
                                            <input type="text" id="yearof" name="yearof" class="form-control" value="{{$sellmachine->yearof }}" placeholder="Year of Manufacturing">
                                        </div>
                                    </div>
                                </div>

                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">
                                        <label for="modelno">Model No</label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8">
                                        <div class="form-group">
                                            <input type="text" id="modelno" name="modelno" class="form-control" value="{{$sellmachine->modelno }}" placeholder="Model No">
                                        </div>
                                    </div>
                                </div>


                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">
                                        <label for="approve">Usage</label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8">
                                        <div class="form-group">
                                            <select class="form-control show-tick ms select2" name="usage">
                                                <option selected disabled>--Please Select--</option>
                                                <option value='used' {{($sellmachine->usage=='used')?'selected':''}}>Used</option>
                                                <option value='new' {{($sellmachine->usage=='new')?'selected':''}}>New</option>

                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">
                                        <label for="location">Location</label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8">
                                        <div class="form-group">
                                            <input type="text" id="location" name="location" class="form-control" value="{{$sellmachine->location }}" placeholder="Location">
                                        </div>
                                    </div>
                                </div>

                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">
                                        <label for="approve">Status Approve</label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8">
                                        <div class="form-group">
                                            <select class="form-control" name="status">
                                                <option selected disabled>--Please Select--</option>
                                                <option value='1' {{($sellmachine->status=='1')?'selected':''}}>Yes</option>
                                                <option value='0' {{($sellmachine->status=='0')?'selected':''}}>No</option>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="header">
                                <h2><strong>Gallery</strong> (Upload Mutliple Images)</h2>

                            </div>
                            <div class="body">
                                @foreach($sellmachineimages as $model)
                                <div class="row mb-4 " id="mrw-{{$model->id}}">

                                    <div class="col-5 col-lg-5">

                                        @if((file_exists('storage/' . $model->image_url)) && $model->image_url!="")
                                        <img src="{{ asset('storage/'. $model->image_url) }}" style="width: 25%;" alt="">
                                        @else
                                        <img src="{{asset('frontend/assets/images/no-image.png')}}" style="width: 25%;" alt="">
                                        @endif
                                    </div>
                                    <div class="col-2 col-lg-2 text-lg-right">
                                        <!-- Repeater Remove Btn -->
                                        <button class="remove-btn style--two" type="button" data-id="{{$model->id}}">
                                            <img src="{{asset('frontend/assets/images/remove.svg')}}" alt="" class="svg">
                                        </button>
                                    </div>
                                </div>
                                @endforeach
                                <div class="file-repeater">
                                    <div data-repeater-list="repeater-list">
                                        <div data-repeater-item>
                                            <div class="row mb-20">

                                                <div class="col-5 col-lg-5">
                                                    <!-- <input type="file"> -->
                                                    <div class="attach-file style--three">
                                                        <div class="upload-button">
                                                            Choose an image
                                                            <input class="file-input" type="file" id="image_url" name="image_url" accept=".png,.jpeg,.jpg,.webp">
                                                        </div>
                                                    </div>
                                                    <label class="file_upload ml-2">No file added</label>
                                                    <p class="small text-muted mt-1">Size <span class="text-danger">
                                                            <= 2MB</span>. Image formats are <span class="text-danger">.png,.jpeg,.jpg,.webp</span>.
                                                    </p>
                                                    <div id="file-error" class="text-danger mt-1"></div>
                                                </div>
                                                <div class="col-2 col-lg-2 text-lg-right">
                                                    <!-- Repeater Remove Btn -->
                                                    <button data-repeater-delete class="remove-btn style--two" type="button">
                                                        <img src="{{asset('frontend/assets/images/remove.svg')}}" alt="" class="svg">
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="pt-2">
                                        <!-- Repeater Add Btn -->
                                        <button data-repeater-create type="button" class="repeater-add-btn btn btn-circle position-relative">
                                            <img src="{{asset('frontend/assets/images/plus_white.svg')}}" alt="" class="svg">
                                        </button>
                                        <span class="bold c2 ml-1">Add New</span>
                                    </div>
                                </div>
                                <hr class="mt-4" />
                                <h5 class="mb-3 mt-4"> Upload Technical Catalog </h5>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="file_path"> {{ 'Default Catalog'}}</label>
                                            <input id="tech_file_path" class="form-control" accept="application/pdf" type="file" placeholder="Upload Default Catalog" name="file_path" :value="old('file_path')" autofocus autocomplete="file_path" />

                                            <p class="small text-muted m-1">
                                                File upload size should be less than 3MB. Format should be pdf </p>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        @if(!empty($technicalpdf->file_path))
                                        @if(isset($technicalpdf->file_path))
                                        <iframe class="up-tech-catalog" src="{{asset('storage/'.$technicalpdf->file_path)}}" width="30%"></iframe>
                                        @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="header">
                                <h2 class="mb-4">Add Machine <strong>Specifications</strong>
                                    <a href="javascript:void(0);" class="addCF btn btn-secondary btn-sm mb-4" style="float: right;">
                                        <i data-feather="plus"></i> Add Row</a>
                                </h2>
                            </div>
                            <div class="body">
                                <table class="table form-table" id="customFields">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Value</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($specifications as $item)
                                        <tr id="srow-{{$item->id}}">
                                            <th>{{$item->spec_title}}</th>
                                            <td>{{$item->spec_value}}</td>
                                            <td>
                                                <a href="javascript:void(0);" onclick="deleteSpec({{$item->id}})" class="text-danger" title="Delete Specification">Delete</a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="2">No data found</td>
                                        </tr>
                                        @endforelse
                                        <tr valign="top">
                                            <td>
                                                <input type="text" class="form-control" id="specTitle" name="spec_title[]" value="" placeholder="Title" />
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="specValue" name="spec_value[]" value="" placeholder="Value" />
                                            </td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-sm-8 offset-sm-2">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script src="{{asset('frontend/assets/plugins/dropify/js/dropify.min.js')}}"></script>
<script src="{{asset('frontend/assets/js/pages/forms/dropify.js')}}"></script>
<script src="{{asset('frontend/assets/plugins/summernote/dist/summernote.js')}}"></script>
<script src="{{asset('frontend/assets/plugins/jquery-repeater/repeater.min.js')}}"></script>
<script src="{{asset('frontend/assets/plugins/jquery-repeater/custom-repeater.js')}}"></script>
<script src="{{asset('frontend/assets/plugins/select2/select2.min.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        // delete row image
        jQuery(document).delegate('.remove-btn', 'click', function(e) {

            e.preventDefault();

            let mid = jQuery(this).attr('data-id');
            mid = parseInt(mid);
            var token = $("meta[name='csrf-token']").attr("content");

            $.ajax({
                url: "{{ route('sellmachine.imagedelete', '')}}" + "/" + mid,
                type: 'DELETE',
                data: {
                    "id": mid,
                    "_token": token,
                },
                success: function() {
                    jQuery('#mrw-' + mid).remove();
                }
            });
        });

    });
    /*************** ADD NEW ROW *******************/
    $(document).ready(function() {
        $(".addCF").click(function() {
            $("#customFields").append(`<tr valign="top">
                <td><input type="text" class="form-control" id="specTitle" name="spec_title[]" value="" placeholder="Title" /></td>
                <td> <input type="text" class="form-control" id="specValue" name="spec_value[]" value="" placeholder="Value" /></td>
                <td><a href="javascript:void(0);" class="remCF" title="DELETE ROW">Delete</a></td></tr>`);
        });

        $("#customFields").on('click', '.remCF', function() {
            $(this).parent().parent().remove();
        });
    });
    /***************
     * Delete Specifications
     * ***********************/

    function deleteSpec(itemid) {
        itemid = parseInt(itemid);

        if (itemid) {
            if (!confirm("Do you really want to delete?")) {
                return false;
            }

            $.ajax({
                url: "{{route('sellmachine.specdelete', '')}}" + "/" + itemid,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    if (data.success) {

                        jQuery("#srow-" + itemid).remove();
                        toastr.success('Success').css("width", "500px");
                    }
                },
                error: function(data) {
                    if (data.responseJSON.errors) {
                        // loading = false;
                        // $('#loader').html('');
                        err_str = '<dl class="row"><dt class="col-sm-12"><p><b>Whoops!</b> There were some problems with your input.</p></dt>';
                        $.each(data.responseJSON.errors, function(key, val) {
                            err_str += '<dt class="col-sm-4">' + key.replace("_", " ") + ' </dt><dd class="col-sm-8">' + val + '</dd>';
                        });
                        err_str += '</dl>';
                        toastr.error(err_str).css("width", "500px");
                        return;
                    }
                }

            });

        } else {
            jQuery("#srow-" + itemid).remove();
        }

    }
</script>
@endpush
@endsection