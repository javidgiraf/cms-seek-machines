@extends('layouts.default')
@section('content')
@push('styles')
<link rel="stylesheet" href="{{asset('frontend/assets/plugins/dropify/css/dropify.min.css')}}">
<!-- <link rel="stylesheet" href="{{asset('frontend/assets/plugins/summernote/dist/summernote.css')}}" /> -->
<link href="{{asset('frontend/assets/plugins/bootstrap-select/css/bootstrap-select.css')}}" rel="stylesheet" />

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
.preview_image p {
  text-align: center;
}

#images {
  display: flex;
  gap: 15px;
  flex-wrap: wrap;
  justify-content: space-between;
}

/* .image_box {
width: 45%;
} */

img {
  width: 100%;
}

.image_name {
  display: block;
  font-size: 14px;
  text-align: center;
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
                <h2><strong>Edit</strong>Ad Details</h2>
                <!-- <div style='text-align: end' ;><a href="{{route('sellmachines.index')}}" class="btn btn-primary"><i class="zmdi zmdi-arrow-left" style="padding-right: 6px;"></i><span>Back</span></a></div> -->
              </div>
              <div class="body">

                <div class="row clearfix">
                  <div class="col-lg-3 col-md-3 col-sm-3 form-control-label">
                    <label for="name">Ad Title</label>
                  </div>
                  <div class="col-lg-9 col-md-9 col-sm-9">
                    <div class="form-group">
                      <input type="text" id="title" name="title" class="form-control" value="{{$sellmachine->title}}" placeholder="Enter Sell Machine Title">
                    </div>
                  </div>
                </div>

                <div class="row clearfix">
                  <div class="col-lg-3 col-md-3 col-sm-3 form-control-label">
                    <label for="slug">Ads Slug</label>
                  </div>
                  <div class="col-lg-9 col-md-9 col-sm-9">
                    <div class="form-group">
                      <input type="text" id="title" name="slug" class="form-control" value="{{$sellmachine->slug}}" placeholder="Enter Sell Machine Ad Slug">
                    </div>
                  </div>
                </div>

                <div class="row clearfix">
                  <div class="col-lg-3 col-md-3 col-sm-3 form-control-label">
                    <label for="slug">Ads Description</label>
                  </div>
                  <div class="col-lg-9 col-md-9 col-sm-9">
                    <div class="form-group">
                      <textarea class="form-control" rows="10" id="description" name="description">{{$sellmachine->description}}</textarea>
                    </div>
                  </div>
                </div>
                <div class="row clearfix">
                  <div class="col-lg-3 col-md-3 col-sm-3 form-control-label">
                    <label for="item_code">Item Code</label>
                  </div>
                  <div class="col-lg-9 col-md-9 col-sm-9">
                    <div class="form-group">
                      <input type="text" readonly id="item_code" name="item_code" class="form-control" value="{{$sellmachine->item_code }}" placeholder="Enter Sell Machine Item Code">
                    </div>
                  </div>
                </div>

                <div class="row clearfix">
                  <div class="col-lg-3 col-md-3 col-sm-3 form-control-label">
                    <label for="customers">Customer & Company</label>
                  </div>
                  <div class="col-lg-9 col-md-9 col-sm-9">
                    <div class="form-group">
                      <select class="form-control show-tick ms sel-customers" name="user_id">
                        <option value="">--Please Select--</option>
                        @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{$sellmachine->user_id == $user->id? "selected": ""}}>
                          {{ $user->name }} / {{ $user->customer ? $user->customer->company : 'N/A' }}
                        </option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row clearfix">
                  <div class="col-lg-3 col-md-3 col-sm-3 form-control-label">
                    <label for="category">Industry of machine used</label>
                  </div>
                  <div class="col-lg-9 col-md-9 col-sm-9">
                    <div class="form-group">
                      <select class="form-control show-tick ms sel-category" name="category_id">
                        <option value="">--Please Select--</option>
                        @foreach ($categories as $cid => $category)
                        <option value="{{ $cid }}" {{$sellmachine->category_id == $cid? "selected": ""}}>
                          {{ $category }}
                        </option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>

                <div class="row clearfix">
                  <div class="col-lg-3 col-md-3 col-sm-3 form-control-label">
                    <label for="country">Country Of Origin</label>
                  </div>
                  <div class="col-lg-9 col-md-9 col-sm-9">
                    <div class="form-group">
                      <select class="form-control show-tick ms sel-country" name="country_id">
                        <option value="">--Please Select--</option>
                        @foreach ($countries as $country)
                        <option value="{{ $country->id }}" {{$sellmachine->country_id == $country->id? "selected": ""}}>
                          {{ $country->name }}
                        </option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>

                <div class="row clearfix">
                  <div class="col-lg-3 col-md-3 col-sm-3 form-control-label">
                    <label for="brands">Brands/ Manufaturer</label>
                  </div>
                  <div class="col-lg-9 col-md-9 col-sm-9">
                    <div class="form-group">
                      <select class="form-control show-tick ms sel-brand" name="brand_id">
                        <option value="">--Please Select--</option>
                        @foreach ($brands as $brand)
                        <option value="{{ $brand->id }}" {{$sellmachine->brand_id == $brand->id? "selected": ""}}>
                          {{ $brand->manufacturer }}
                        </option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>

                <div class="row clearfix">
                  <div class="col-lg-3 col-md-3 col-sm-3 form-control-label">
                    <label for="yearof">Year Of Manufacturing</label>
                  </div>
                  <div class="col-lg-9 col-md-9 col-sm-9">
                    <div class="form-group">
                      <input type="text" id="yearof" name="yearof" class="form-control" value="{{ $sellmachine->yearof }}" placeholder="2004">
                    </div>
                  </div>
                </div>

                <div class="row clearfix">
                  <div class="col-lg-3 col-md-3 col-sm-3 form-control-label">
                    <label for="modelno">Model No</label>
                  </div>
                  <div class="col-lg-9 col-md-9 col-sm-9">
                    <div class="form-group">
                      <input type="text" id="modelno" name="modelno" class="form-control" value="{{ $sellmachine->modelno }}" placeholder="Model No">
                    </div>
                  </div>
                </div>
                <div class="row clearfix">
                  <div class="col-lg-3 col-md-3 col-sm-3 form-control-label">
                    <label for="modelno">Serial No</label>
                  </div>
                  <div class="col-lg-9 col-md-9 col-sm-9">
                    <div class="form-group">
                      <input type="text"  name="serialno" class="form-control" value="{{ $sellmachine->serialno }}" placeholder="Serial No">
                    </div>
                  </div>
                </div>


                <div class="row clearfix">
                  <div class="col-lg-3 col-md-3 col-sm-3 form-control-label">
                    <label for="approve">Usage Type</label>
                  </div>
                  <div class="col-lg-9 col-md-9 col-sm-9">
                    <div class="form-group">
                      <select class="form-control show-tick ms select2" name="usage">
                        <option value='used' {{$sellmachine->usage == 'used' ? "selected": ""}}>Used</option>
                        <option value='new' {{$sellmachine->usage == 'new' ? "selected": ""}}>New</option>

                      </select>
                    </div>
                  </div>
                </div>
                <div class="row clearfix">
                  <div class="col-lg-3 col-md-3 col-sm-3 form-control-label">
                    <label for="approve">Capital Machine</label>
                  </div>
                  <div class="col-lg-9 col-md-9 col-sm-9">
                    <div class="checkbox">
                      <input type="checkbox" id="is_capital" name="is_capital" class="form-control" value="1" {{$sellmachine->is_capital? "checked": ""}}>
                      <label for="is_capital">
                        Is this under a capital equipment?
                      </label>
                    </div>
                  </div>
                </div>
                <div class="row clearfix">
                  <div class="col-lg-3 col-md-3 col-sm-3 form-control-label">
                    <label for="approve">Expected Machine Price (AED)</label>
                  </div>
                  <div class="col-lg-9 col-md-9 col-sm-9">
                    <div class="form-group">
                      <input type="number" class="form-control" name="expected_price" placeholder="25000.00" value="{{$sellmachine->expected_price}}">
                    </div>
                  </div>
                </div>

                <div class="row clearfix">
                  <div class="col-lg-3 col-md-3 col-sm-3 form-control-label">
                    <label for="location">Address Location</label>
                  </div>
                  <div class="col-lg-9 col-md-9 col-sm-9">
                    <div class="form-group">
                      <textarea id="location" name="location" class="form-control" placeholder="Location">{{$sellmachine->location}}</textarea>
                    </div>
                  </div>
                </div>
                <div class="row clearfix">
                  <div class="col-lg-3 col-md-3 col-sm-3 form-control-label">
                    <label for="country">Country Of Origin</label>
                  </div>
                  <div class="col-lg-9 col-md-9 col-sm-9">
                    <div class="form-group">
                      <select class="form-control show-tick ms sel-country" name="country_id">
                        <option value="">--Please Select--</option>
                        @foreach ($countries as $country)
                        <option value="{{ $country->id }}" {{$sellmachine->country_id == $country->id? "selected": ""}}>
                          {{ $country->name }}
                        </option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>

                <div class="row clearfix">
                  <div class="col-lg-3 col-md-3 col-sm-3 form-control-label">
                    <label for="slug">Meta Title</label>
                  </div>
                  <div class="col-lg-9 col-md-9 col-sm-9">
                    <div class="form-group">
                      <input type="text" id="title" name="meta_title" class="form-control" value="{{$sellmachine->meta_title}}" placeholder="Enter your Meta Title">
                    </div>
                  </div>
                </div>
                <div class="row clearfix">
                  <div class="col-lg-3 col-md-3 col-sm-3 form-control-label">
                    <label for="slug">Keywords</label>
                  </div>
                  <div class="col-lg-9 col-md-9 col-sm-9">
                    <div class="form-group">
                      <textarea name="keywords" class="form-control">{{$sellmachine->keywords}}</textarea>

                    </div>
                  </div>
                </div>
                <div class="row clearfix">
                  <div class="col-lg-3 col-md-3 col-sm-3 form-control-label">
                    <label for="slug">Meta Description</label>
                  </div>
                  <div class="col-lg-9 col-md-9 col-sm-9">
                    <div class="form-group">
                      <textarea name="meta_descriptions" class="form-control">{{$sellmachine->meta_descriptions}}</textarea>

                    </div>
                  </div>
                </div>
                <div class="row clearfix">
                  <div class="col-lg-3 col-md-3 col-sm-3 form-control-label">
                    <label for="approve">Ad Status</label>
                  </div>
                  <div class="col-lg-9 col-md-9 col-sm-9">
                    <div class="form-group">
                      <select class="form-control" name="status">
                        <option selected disabled>--Please Select--</option>
                        <option value='1' {{($sellmachine->status=='1')?'selected':''}}>Approve</option>
                        <option value='0' {{($sellmachine->status=='0')?'selected':''}}>Deactivate</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row clearfix">
                  <div class="col-lg-3 col-md-3 col-sm-3 form-control-label">
                    <label for="slug">Set Default Image</label>
                  </div>
                  <div class="col-lg-9 col-md-9 col-sm-9">
                    @if($sellmachine->default_image!="")
                    <input type="file" class="dropify" name="single_image_url" id="single_image_url" accept=".png,.jpeg,.jpg,.svg,.webp" data-default-file="{{ asset(config('app.image_root_url'). $sellmachine->default_image) }}">
                    @else
                    <input type="file" class="dropify" name="single_image_url" id="single_image_url" accept=".png,.jpeg,.jpg,.svg,.webp" data-default-file="{{asset('frontend/assets/images/no-image.png')}}">
                    @endif

                    <input type="hidden" id="image_folder" name="image_folder" value="machines">

                    <div id="image-input-error" class="alert"></div>
                    <input type="hidden" id="default_image" name="default_image" value="{{$sellmachine->default_image}}">
                  </div>
                </div>
            

              </div>
            </div>

            <div class="card">
              <div class="header">
                <h2><strong>Gallery</strong> (Upload Mutliple Images)</h2>

              </div>
              <div class="body">

                <div class="row">
                  <div class="col-xl-12">
                    <label for="image_url"> Add More Images </label>
                    <input id="select-image" class="form-control" type="file" accept="image/*" name="multi_image_url[]" autofocus autocomplete="multi_image_url" multiple />

                    <p class="small text-muted mt-2 mb-2">
                      Please select multiple images at once to upload.
                      File upload size should be less than 2MB. Supported format is jpeg, png, jpg, gif, svg, webp</p>
                      <div class="preview_image">
                        <!-- It will show the total number of files selected -->
                        <p class="mt-2"><span id="total-images">0</span> File(s) Selected</p>

                        <!-- All images will display inside this div -->
                        @php $image_url_arr = []; @endphp
                        <div id="images">
                          @foreach($sellmachineimages as $images)

                          @php $image_url_arr[] = $images->image_url; @endphp
                          <div class="image_box" id="row-{{$images->id}}">
                            <img src="{{ asset(config('app.image_root_url').$images->image_url)}}" />
                            <a href='javascript:void(0);' class="btn btn-danger" title='Delete' onclick="deleteImg({{$images->id}}, '{{$images->image_url}}')"> Remove </a>
                          </div>
                          @endforeach
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-xl-12">
                      <a href="javascript:void(0);" id="clear-img" class="btn btn-danger mt-2 d-none">Remove All</a>
                    </div>
                    <div id="multi-image-input-error" class="alert"></div>
                    <input type="hidden" id="image_url" name="image_url">
                  </div>
                  <!-- @foreach($sellmachineimages as $model)
                  <div class="row mb-4 " id="mrw-{{$model->id}}">

                  <div class="col-5 col-lg-5">

                  @if( $model->image_url!="")
                  <img src="{{ asset(config('app.image_root_url'). $model->image_url) }}" style="width: 25%;" alt="">
                  @else
                  <img src="{{asset('frontend/assets/images/no-image.png')}}" style="width: 25%;" alt="">
                  @endif
                </div>
                <div class="col-2 col-lg-2 text-lg-right">

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

  <button data-repeater-delete class="remove-btn style--two" type="button">
  <img src="{{asset('frontend/assets/images/remove.svg')}}" alt="" class="svg">
</button>
</div>
</div>
</div>
</div>

<div class="pt-2">

<button data-repeater-create type="button" class="repeater-add-btn btn btn-circle position-relative">
<img src="{{asset('frontend/assets/images/plus_white.svg')}}" alt="" class="svg">
</button>
<span class="bold c2 ml-1">Add New</span>
</div>
</div> -->

<hr class="mt-4" />
<h5 class="mb-3 mt-4"> Upload Technical Catalog </h5>
<div class="row">
  <div class="col-6">
    <div class="form-group">
      <label for="file_path"> {{ 'Default Catalog'}}</label>
      <input id="single_doc_url" class="form-control" accept="application/pdf" type="file" placeholder="Upload Default Catalog" name="single_doc_url" />

      <p class="small text-muted m-1">
        File upload size should be less than 3MB. Format should be pdf </p>

        <input type="hidden" id="doc_folder" name="doc_folder" value="catalog">
        <div id="file-input-error" class="alert"></div>
        <input type="hidden" id="file_path" name="file_path" value="{{$technicalpdf->file_path}}">
      </div>
    </div>
    <div class="col-6">
      @if(!empty($technicalpdf->file_path))
      @if(isset($technicalpdf->file_path))
      <iframe class="up-tech-catalog" id="up-tech-catalog" src="{{asset(config('app.image_root_url').$technicalpdf->file_path)}}" width="30%"></iframe>
      @endif
      @endif
    </div>
  </div>
</div>
</div>

<div class="card">
  <div class="header mb-4">
    <h2>Add Machine <strong>Specifications</strong>
      <a href="javascript:void(0);" class="addCF btn btn-secondary btn-sm" style="float: right;">
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
              <a href="javascript:void(0);" onclick="deleteSpec({{$item->id}})" class="text-danger" title="Delete Specification"><i class="zmdi zmdi-delete"></i></a>
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
  <div class="row mt-4">
    <div class="col-lg-4 col-md-4 col-sm-4 form-control-label">&nbsp;</div>
    <div class="col-lg-8 col-md-8 col-sm-8">
      <button type="submit" class="btn btn-raised btn-primary btn-round waves-effect" id="save-btn">Save</button>
      <a href="{{route('sellmachines.index')}}" class=" btn btn-raised  btn-round waves-effect btn-secondary">Back</a>
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
<!-- <script src="{{asset('frontend/assets/plugins/summernote/dist/summernote.js')}}"></script> -->
<!-- <script src="{{asset('frontend/assets/plugins/jquery-repeater/repeater.min.js')}}"></script>
<script src="{{asset('frontend/assets/plugins/jquery-repeater/custom-repeater.js')}}"></script> -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
  $('.sel-customers').select2();
  $('.sel-country').select2();
  $('.sel-category').select2();
  $('.sel-brand').select2();
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

    if ($("#default_image").val() != '') {
      // already have an uploaded file, please remove it
      deleteExistingImage();
    }

    let formData = new FormData();
    formData.append("single_image_url", sFile);
    formData.append("image_folder", document.getElementById('image_folder').value);
    formData.append("_token", "{{ csrf_token() }}");

    $('#image-input-error').text('');
    $("#default_image").val('');

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
          $("#default_image").val(response.data.single_image_url);
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
        $("#default_image").val('');
        $("#save-btn").attr('disabled', true);
      }
    });
  });

  $('.dropify-clear').click(function(e) {
    e.preventDefault();

    deleteExistingImage();
  });

  function deleteExistingImage() {
    let existingImage = $("#default_image").val();
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
          $("#default_image").val('');
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

  /************************************************************************
  * Multiple Images Upload
  **************************************************************************/
  const fileInput = document.getElementById('select-image');
  const images = document.getElementById('images');
  const totalImages = document.getElementById('total-images');

  // Listen to the change event on the <input> element
  fileInput.addEventListener('change', (event) => {
    // Get the selected image file
    const imageFiles = event.target.files;

    // Show the number of images selected
    totalImages.innerText = imageFiles.length;

    const maxSize = 1024 * 1024 * 2;
    let allowedExtension = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/bmp', 'image/svg', 'image/webp'];
    // Check if any file is selected.
    let fSizeFlag = false,
    fFormatFlag = false;

    let formData = new FormData();
    formData.append("image_folder", document.getElementById('image_folder').value);
    formData.append("_token", "{{ csrf_token() }}");

    // Empty the images div
    //  images.innerHTML = '';
    $('#clear-img').removeClass('d-none');

    if (imageFiles.length > 0) {

      // validate image file size
      for (let i = 0; i < imageFiles.length; i++) {
        // check file size
        if (imageFiles[i].size > maxSize) // 20 MiB for bytes.
        {
          fSizeFlag = true;
        }
        //check format
        if (allowedExtension.indexOf(imageFiles[i].type) > -1) {} else {
          fFormatFlag = true;
        }
      }
      if (fSizeFlag == true) {
        alert('Each file size must not be more than 2 MB');
        fileInput.value = "";
        totalImages.innerText = 0;
        return;
      }
      if (fFormatFlag == true) {
        alert("File format must be supported one");
        fileInput.value = "";
        totalImages.innerText = 0;
        return;
      }

      if ($("#image_url").val() != '') {
        // already have an uploaded file, please remove it
        deleteExistingMultiImages();
      }

      $('#multi-image-input-error').text('');
      $("#image_url").val('');

      let api_root = "{{ env('API_URL') }}";
      let apiurl = api_root + "/multipleimages";

      // Loop through all the selected images
      for (const imageFile of imageFiles) {
        const reader = new FileReader();

        // Convert each image file to a string
        reader.readAsDataURL(imageFile);

        formData.append("multiple_image_url[]", imageFile);

        // FileReader will emit the load event when the data URL is ready
        // Access the string using reader.result inside the callback function
        reader.addEventListener('load', () => {
          // Create new <img> element and add it to the DOM
          images.innerHTML += `<div class="image_box new_img_up"><img src='${reader.result}'>
          <span class='image_name'>${imageFile.name}</span>
          </div>`;
        });
      }

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
            let result = response.data.map(item => item.multiple_image_url);
            $("#image_url").val(result.join(','));
            $("#save-btn").removeAttr('disabled');
            Swal.fire({
              title: "Uploaded!",
              text: response.message,
              icon: "success",
            });
          }
        },
        error: function(response) {
          $('#multi-image-input-error').text(response.responseJSON.message);
          $("#image_url").val('');
          $("#save-btn").attr('disabled', true);
        }
      });

    } else {
      // Empty the images div
      //images.innerHTML = '';
    }
  });

  function deleteExistingMultiImages() {
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
  /*******************************************************************
  * Clear all images
  ****************************************************/

  $('#clear-img').on('click', function(e) {
    e.preventDefault();

    fileInput.value = '';
    // images.innerHTML = '';
    $("#images").find(".new_img_up").remove();
    totalImages.innerText = 0;

    if ($("#image_url").val() != '') {
      // already have an uploaded file, please remove it
      deleteExistingMultiImages();
    }

    $(this).addClass('d-none');
  });

  // delete row image
  // jQuery(document).delegate('.remove-btn', 'click', function(e) {

  //     e.preventDefault();

  //     let mid = jQuery(this).attr('data-id');
  //     mid = parseInt(mid);
  //     var token = $("meta[name='csrf-token']").attr("content");

  //     $.ajax({
  //         url: "{{ route('sellmachine.imagedelete', '')}}" + "/" + mid,
  //         type: 'DELETE',
  //         data: {
  //             "id": mid,
  //             "_token": token,
  //         },
  //         success: function() {
  //             jQuery('#mrw-' + mid).remove();
  //         }
  //     });
  // });


  // catalog file upload
  $('#single_doc_url').change(function(e) {
    e.preventDefault();

    const oFile = document.getElementById("single_doc_url");
    const sFile = oFile.files[0];
    const maxSize = 1024 * 1024 * 3;
    // Check if any file is selected.
    if (sFile.size > maxSize) // 20 MiB for bytes.
    {
      alert("File size must under 3MB!");
      oFile.value = "";
      return;
    }
    let allowedExtension = ['application/pdf'];
    let type = sFile.type;
    if (allowedExtension.indexOf(type) > -1) {

    } else {
      alert("File format must be supported one");
      oFile.value = "";
      return;
    }

    if ($("#file_path").val() != '') {
      // already have an uploaded file, please remove it
      deleteExistingCatalog();
    }

    let formData = new FormData();
    formData.append("single_doc_url", sFile);
    formData.append("doc_folder", document.getElementById('doc_folder').value);
    formData.append("_token", "{{ csrf_token() }}");

    $('#file-input-error').text('');
    $("#file_path").val('');

    let api_root = "{{ env('API_URL') }}";
    let apiurl = api_root + "/singledocument";

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
          $("#file_path").val(response.data.single_doc_url);
          document.getElementById("up-tech-catalog").src = "{{ config('app.image_root_url') }}" + response.data.single_doc_url;

          $("#save-btn").removeAttr('disabled');
          Swal.fire({
            title: "Uploaded!",
            text: response.message,
            icon: "success",
          });
        }
      },
      error: function(response) {
        $('#file-input-error').text(response.responseJSON.message);
        $("#file_path").val('');
        $("#save-btn").attr('disabled', true);
      }
    });
  });

  function deleteExistingCatalog() {
    let existingDoc = $("#file_path").val();
    if (!existingDoc) {
      return false;
    }

    let formData = new FormData();
    formData.append("docurl", existingDoc);
    formData.append("_token", "{{ csrf_token() }}");

    let api_root = "{{ env('API_URL') }}";
    let apiurl = api_root + "/deleteDocument";

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
          $("#file_path").val('');
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

/**********************************************************
* Delete Multiple Images
**********************************************************/

function deleteImg(imgId, existingImage) {
  imgId = parseInt(imgId);

  if (imgId) {
    if (!confirm("Do you really want to delete?")) {
      return false;
    }

    if (existingImage) {
      // delete existing image from the folder

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
            console.log("Existing file deleted success");
          }
        },
        error: function(response) {
          console.log(response.responseJSON.message);


        }
      });
    }
    // delete image from database
    $.ajax({
      url: "{{route('sellmachine.imagedelete', '')}}" + "/" + imgId,
      type: 'DELETE',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      dataType: 'JSON',
      contentType: false,
      cache: false,
      processData: false,
      success: function(data) {
        if (data) {
          jQuery("#row-" + imgId).remove();
          Swal.fire({
            title: "Deleted!",
            text: "Image deleted successfully",
            icon: "success",
          });
        }
      },
      error: function(data) {
        if (data.responseJSON.errors) {
          err_str = '';
          $.each(data.responseJSON.errors, function(key, val) {
            err_str += key.replace("_", " ") + ' : ' + val;
          });

          Swal.fire({
            icon: "error",
            title: "Whoops!, There were some problems with your input.",
            text: err_str
          });

          return;
        }
      }

    });

  } else {
    jQuery("#row-" + imgId).remove();
  }

}

/*************** ADD NEW ROW *******************/
$(document).ready(function() {
  $(".addCF").click(function() {
    $("#customFields").append(`<tr valign="top">
    <td><input type="text" class="form-control" id="specTitle" name="spec_title[]" value="" placeholder="Title" /></td>
    <td> <input type="text" class="form-control" id="specValue" name="spec_value[]" value="" placeholder="Value" /></td>
    <td><a href="javascript:void(0);" class="remCF" title="DELETE ROW"><i class="zmdi zmdi-delete"></i></a></td></tr>`);
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
    if (!confirm("Do you really want to delete this spec?")) {
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
          Swal.fire({
            title: "Deleted!",
            text: "Specifications deleted successfully",
            icon: "success",
          });
        }
      },
      error: function(data) {
        if (data.responseJSON.errors) {

          err_str = '';
          $.each(data.responseJSON.errors, function(key, val) {
            err_str += key.replace("_", " ") + ' : ' + val;
          });

          Swal.fire({
            icon: "error",
            title: "Whoops!, There were some problems with your input.",
            text: err_str
          });

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