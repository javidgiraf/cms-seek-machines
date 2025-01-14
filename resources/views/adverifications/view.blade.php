@extends('layouts.default')
@section('content')
@push('styles')
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<link rel="stylesheet" href="{{asset('frontend/assets/plugins/dropify/css/dropify.min.css')}}">
<link href="{{asset('frontend/assets/plugins/bootstrap-select/css/bootstrap-select.css')}}" rel="stylesheet" />
@endpush
<section class="content">
  <div class="body_scroll">
    <div class="block-header">
      <div class="row">
        <div class="col-lg-7 col-md-6 col-sm-12">
          <h2>View Ads Verification</h2>
          <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="zmdi zmdi-home"></i> Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('sellmachines.index')}}">Selling Machines Ads</a></li>
            <li class="breadcrumb-item active">View Ads Verification</li>
          </ul>
          <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
        </div>
        {{-- <div class="col-lg-5 col-md-6 col-sm-12">
          <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>
        </div> --}}
      </div>
    </div>

    <div class="container-fluid">

      <!-- Horizontal Layout -->
      <div class="row clearfix">
        <div class="col-lg-6 col-md-6 col-sm-6">
          <div class="card">
            <div class="header">
              <h2><strong>Gallery</strong> Of Machine Images</h2>

            </div>
            <div class="body">
              <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-3 form-control-label">
                  <label for="slug">Set as Default Image</label>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9">
                  @if( $sellmachine->default_image!="")
                  <img src="{{ asset(config('app.image_root_url'). $sellmachine->default_image) }}">
                  @else
                  <img src="{{asset('frontend/assets/images/no-image.png')}}">
                  @endif
                </div>
              </div>
              <div class="row">
                <div class="col-12 col-lg-12">
                  &nbsp;
                </div>
              </div>
              <div class="row mt-4 mb-2">
                @foreach($sellmachineimages as $model)
                <div class="col-3 ">

                  @if($model->image_url!="")
                  <img src="{{ asset(config('app.image_root_url').$model->image_url) }}">
                  @else
                  <img src="{{asset('frontend/assets/images/no-image.png')}}">
                  @endif
                </div>
                @endforeach
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
          <div class="card">
            <div class="header">
              <h2><strong>View Details </strong> Of Machine Ad</h2>
            </div>
            <div class="body">
              <div class="row clearfix">
                <div class="col-lg-3 col-md-3 col-sm-3 form-control-label">
                  <label for="item_code">Reference No.</label>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9">
                  <span class="badge badge-info"> {{$sellmachine->item_code}} </span>
                </div>
              </div>

              <div class="row clearfix">
                <div class="col-lg-3 col-md-3 col-sm-3 form-control-label">
                  <label for="name">Ads Name</label>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9">
                  {{$sellmachine->title}}
                </div>
              </div>
              <div class="row clearfix">
                <div class="col-lg-3 col-md-3 col-sm-3 form-control-label">
                  <label for="category">Industry of machine used</label>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9">
                  {{$sellmachine->category->name}}
                </div>
              </div>
              <div class="row clearfix">
                <div class="col-lg-3 col-md-3 col-sm-3 form-control-label">
                  <label for="category">Usage Type</label>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9">
                  <span class="badge badge-danger"> {{$sellmachine->usage}}</span>
                </div>
              </div>
              <div class="row clearfix">
                <div class="col-lg-3 col-md-3 col-sm-3 form-control-label">
                  <label for="category">Country Of Origin</label>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9">
                  {{$sellmachine->country->name}}
                </div>
              </div>
              <div class="row clearfix">
                <div class="col-lg-3 col-md-3 col-sm-3 form-control-label">
                  <label for="yearof">Year Of Manufacture</label>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9">
                  {{$sellmachine->yearof }}
                </div>
              </div>
              <div class="row clearfix">
                <div class="col-lg-3 col-md-3 col-sm-3 form-control-label">
                  <label for="yearof">Manufacturer</label>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9">
                  {{($sellmachine->brand)? $sellmachine->brand->manufacturer: '--'}}
                </div>
              </div>
              <div class="row clearfix">
                <div class="col-lg-3 col-md-3 col-sm-3 form-control-label">
                  <label for="yearof">Model No.</label>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9">
                  {{$sellmachine->modelno }}
                </div>
              </div>

              <div class="row clearfix">
                <div class="col-lg-3 col-md-3 col-sm-3 form-control-label">
                  <label for="yearof">Is a Capital Machine?</label>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9">
                  {{($sellmachine->is_capital == 1)? "Yes": "No"}}
                </div>
              </div>
              <div class="row clearfix">
                <div class="col-lg-3 col-md-3 col-sm-3 form-control-label">
                  <label for="yearof">Expected Price</label>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9">
                  <span class="badge badge-warning">{{$sellmachine->expected_price}} AED</span>
                </div>
              </div>
              <div class="row clearfix">
                <div class="col-lg-3 col-md-3 col-sm-3 form-control-label">
                  <label for="yearof">Description</label>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9">

                  <pre style="white-space: pre-wrap; font-family: inherit; font-size: 14px; font-weight: inherit; line-height: inherit; width: 100%; margin: 0;padding:1px;">
                    {{$sellmachine->description}}
                  </pre>
                </div>
              </div>
              <div class="row clearfix">
                <div class="col-lg-3 col-md-3 col-sm-3 form-control-label">
                  <label for="yearof">Verification request submitted on</label>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9">
                  <span class="text-warning">{{$sellmachine->verify_submitted_on}}</span>
                </div>
              </div>
              <div class="row clearfix">
                <div class="col-lg-3 col-md-3 col-sm-3 form-control-label">
                  <label for="yearof">Verify Status</label>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9">
                  @switch($sellmachine->isverified)
                  @case(1)
                  <span class="badge badge-success">Verified</span>
                  @break;
                  @case(2)
                  <span class="badge badge-warning">On Review</span>
                  @break;
                  @default
                  <span class="badge badge-danger">Failed</span>
                  @break;
                  @endswitch
                </div>
              </div>

              <div class="row clearfix">
                <div class="col-lg-3 col-md-3 col-sm-3 form-control-label">
                  <label for="yearof">Serial No</label>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9">
                  <span class="text-warning">{{$sellmachine->serialno}}</span>
                </div>
              </div>
              <div class="row clearfix">
                <div class="col-lg-3 col-md-3 col-sm-3 form-control-label">
                  <label for="yearof">Available Country</label>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9">
                <span class="text-warning">{{ $sellmachine->avail_country->name ?? '' }}</span>

                </div>
              </div>
              <div class="row">
                <div class="col-12 col-lg-12">
                  <hr />
                </div>
              </div>
              <h5 class="mb-2 mt-2"> Seller Details </h5>
              <div class="row clearfix">
                <div class="col-lg-3 col-md-3 col-sm-3 form-control-label">
                  <label for="yearof">Company</label>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9">
                  {{$sellmachine->user->customer->company}}
                </div>
              </div>
              <div class="row clearfix">
                <div class="col-lg-3 col-md-3 col-sm-3 form-control-label">
                  <label for="yearof">Contact Name</label>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9">
                  {{$sellmachine->user->name}}
                </div>
              </div>
              <div class="row clearfix">
                <div class="col-lg-3 col-md-3 col-sm-3 form-control-label">
                  <label for="yearof">Email</label>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9">
                  {{$sellmachine->user->email}}
                </div>
              </div>
              <div class="row clearfix">
                <div class="col-lg-3 col-md-3 col-sm-3 form-control-label">
                  <label for="yearof">Phone Number</label>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9">
                  {{$sellmachine->user->customer->phone}}
                </div>
              </div>
              <div class="row clearfix">
                <div class="col-lg-3 col-md-3 col-sm-3 form-control-label">
                  <label for="yearof">Country</label>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9">
                  {{$sellmachine->user->customer->country->name}}
                </div>
              </div>
              <div class="row clearfix">
                <div class="col-lg-3 col-md-3 col-sm-3 form-control-label">
                  <label for="location">Location</label>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9">
                  {{$sellmachine->location }}
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12">
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
              <!-- @if(session()->has('success'))
              <div class="alert alert-success">
              {{ session()->get('success') }}
            </div>
            @endif -->
          </div>
        </div>

        <form method="post" enctype="multipart/form-data" action="{{route('adverifications.verification-status-update',$sellmachine->id) }}">
          @csrf
          @method('put')
          <div class="card">
            <div class="header">
              <h2>Update <strong>Report and Status</strong> Of Machine</h2>
            </div>
            <div class="body">
              @include('layouts.partials.messages')
              <div class="row clearfix">

                <div class="col-lg-4 col-md-4 col-sm-4 form-control-label">
                  <label for="approve">Verify Date</label>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8">
                  <div class="form-group">
                    <input type="text" name="verified_on" id="verified_on" class="form-control" value="{{(isset($sellmachine->report) && $sellmachine->report->verified_on) ? date('d-m-Y', strtotime($sellmachine->report->verified_on)):'' }}">
                  </div>
                </div>
              </div>
              <div class="row clearfix">

                <div class="col-lg-4 col-md-4 col-sm-4 form-control-label">
                  <label for="approve">Verify Status</label>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8">
                  <div class="form-group">
                    <select class="form-control" name="isverified">
                      <option value="">--Please Select--</option>
                      <option value='1' {{($sellmachine->isverified =='1')?'selected':''}}>Success</option>
                      <option value='0' {{($sellmachine->isverified =='0')?'selected':''}}>Failed</option>
                      <option value='2' {{($sellmachine->isverified =='2')?'selected':''}}>On Review</option>
                    </select>

                  </div>
                </div>
              </div>
              <div class="row clearfix" id="failed_reason">

                <div class="col-lg-4 col-md-4 col-sm-4 form-control-label">
                  <label for="approve">Remarks</label>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8">
                  <div class="form-group">
                    <textarea name="description" class="form-control">{{(isset($sellmachine->report)?$sellmachine->report->description:'')}}</textarea>
                  </div>
                </div>

              </div>

              <div class="row clearfix">
                <div class="col-lg-4 col-md-4 col-sm-4 form-control-label">
                  <label for="slug">Seek Agent</label>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8">
                  <div class="form-group">
                    <select class="form-control show-tick ms sel-country" name="agent_id">
                      <option value="" disabled {{ old('agent_id', $sellmachine->report->agent_id ?? '') ? '' : 'selected' }}>--Please Select--</option> <!-- Placeholder -->
                      @if ($seekAgentUsers->isNotEmpty())
                      @foreach ($seekAgentUsers as $data)
                      <option value="{{ $data->id }}" {{ (old('agent_id', $sellmachine->report->agent_id ?? '') == $data->id) ? 'selected' : '' }}>
                        {{ $data->name }}
                      </option>
                      @endforeach
                      @endif
                      @if ($seekAgentUsers->isEmpty())
                      <option value="" disabled>No agents available</option> <!-- Message if no agents are found -->
                      @endif
                    </select>
                  </div>
                </div>
              </div>

              <div class="row clearfix" id="success_reason">
                <div class="col-lg-4 col-md-4 col-sm-4 form-control-label">
                  <label for="approve">Upload Report</label>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8">
                  <div class="form-group">
                    <input id="single_doc_url" name="single_doc_url" class="form-control" accept="application/pdf" type="file" placeholder="Upload Report" />
                    <p class="small text-muted m-1">
                      File upload size should be less than 3MB. Format should be pdf </p>

                      <input type="hidden" id="doc_folder" name="doc_folder" value="documents">
                      <div id="file-input-error" class="alert"></div>
                      <input type="hidden" id="inspection_file" name="inspection_file" value="{{isset($sellmachine->report)? $sellmachine->report->inspection_file: ''}}">

                      @if(isset($sellmachine->report))
                      <iframe id="up-tech-catalog" class="up-tech-catalog" src="{{asset(config('app.image_root_url').$sellmachine->report->inspection_file)}}" width="50%"></iframe>
                      @endif

                    </div>
                  </div>
                </div>


                <div class="row mt-4">
                  <div class="col-lg-4 col-md-4 col-sm-4 form-control-label">&nbsp;</div>
                  <div class="col-lg-8 col-md-8 col-sm-8">
                    <button type="submit" class="btn btn-raised btn-primary btn-round waves-effect" id="save-btn">Save</button>
                    <a href="{{route('adverifications.success')}}" class=" btn btn-raised  btn-round waves-effect btn-secondary">Back</a>
                  </div>
                </div>

              </div>
            </div>
          </form>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12"></div>
      </div>
    </div>
  </div>
</section>

@push('scripts')
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script src="{{asset('frontend/assets/plugins/dropify/js/dropify.min.js')}}"></script>
<script src="{{asset('frontend/assets/js/pages/forms/dropify.js')}}"></script>
<script type="text/javascript">
$(function() {

  $("#verified_on").datepicker({
    dateFormat: 'dd-mm-yy'
  });

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

    if ($("#inspection_file").val() != '') {
      // already have an uploaded file, please remove it
      deleteExistingCatalog();
    }

    let formData = new FormData();
    formData.append("single_doc_url", sFile);
    formData.append("doc_folder", document.getElementById('doc_folder').value);
    formData.append("_token", "{{ csrf_token() }}");

    $('#file-input-error').text('');
    $("#inspection_file").val('');

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
          $("#inspection_file").val(response.data.single_doc_url);
          //   document.getElementById("up-tech-catalog").src = "{{ config('app.image_root_url') }}" + response.data.single_doc_url;

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
        $("#inspection_file").val('');
        $("#save-btn").attr('disabled', true);
      }
    });
  });

  function deleteExistingCatalog() {
    let existingDoc = $("#inspection_file").val();
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
          $("#inspection_file").val('');
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
</script>
@endpush
@endsection
