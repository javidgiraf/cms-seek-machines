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
                        <li class="breadcrumb-item active">View Selling Machines Ads</li>
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
                                    <span class="badge badge-warning">{{$sellmachine->expected_price}} USD</span>
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
                                    <label for="yearof">Serial No</label>
                                </div>
                                <div class="col-lg-9 col-md-9 col-sm-9">
                                {{$sellmachine->serialno}}
                                </div>
                            </div>
                            <div class="row clearfix">
                              <div class="col-lg-3 col-md-3 col-sm-3 form-control-label">
                                <label for="yearof">Available Country</label>
                              </div>
                              <div class="col-lg-9 col-md-9 col-sm-9">
                                @if ($sellmachine->avail_country)
                                {{ $sellmachine->avail_country->name }}
                                @endif
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

                            <div class="row mt-2">
                                <div class="col-12 col-lg-12">
                                    <hr />
                                </div>
                            </div>
                            <h5 class="mb-2 mt-2"> Upload Technical Catalog </h5>
                            <div class="row">
                                <div class="col-6">
                                    @if(!empty($technicalpdf->file_path))
                                    @if(isset($technicalpdf->file_path))
                                    <iframe class="up-tech-catalog" src="{{asset(config('app.image_root_url').$technicalpdf->file_path)}}" width="80%"></iframe>
                                    @endif
                                    @else
                                    <p class="text-muted">-- No technical catalog ---</p>
                                    @endif
                                </div>
                                <div class="col-6"></div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="card">
                        <div class="header">
                            <h2><strong>Technical</strong> Specifications</h2>
                        </div>

                        <div class="body">
                            <table class="table form-table" id="customFields">
                                <thead>
                                    <tr>
                                        <th width="60%">Title</th>
                                        <th>Value</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($specifications as $item)
                                    <tr id="srow-{{$item->id}}">
                                        <th>{{$item->spec_title}}</th>
                                        <td>{{$item->spec_value}}</td>

                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="2">No data found</td>
                                    </tr>
                                    @endforelse

                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
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
                    <form method="post" enctype="multipart/form-data" action="{{route('sellmachines.changestatus',$sellmachine->id) }}">
                        @csrf
                        @method('put')
                        <div class="card">
                            <div class="header">
                                <h2><strong>Approval </strong> Of Machine Ad</h2>
                            </div>
                            <div class="body">
                                <div class="row clearfix">

                                    <div class="col-lg-4 col-md-4 col-sm-4 form-control-label">
                                        <label for="approve">Change Status</label>

                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8">
                                        <div class="form-group">
                                            <select class="form-control" name="status">
                                                <option selected disabled>--Please Select--</option>
                                                <option value='1' {{($sellmachine->status=='1')?'selected':''}}>Approve</option>
                                                <option value='0' {{($sellmachine->status=='0')?'selected':''}}>Deactivate</option>
                                                <!-- <option value='2' {{($sellmachine->status=='2')?'selected':''}}>Pending</option> -->

                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <div class="row mt-4">
                                    <div class="col-lg-4 col-md-4 col-sm-4 form-control-label">&nbsp;</div>
                                    <div class="col-lg-8 col-md-8 col-sm-8">
                                        <button type="submit" class="btn btn-raised btn-primary btn-round waves-effect" id="save-btn">Save</button>
                                        <a href="{{route('sellmachines.index')}}" class=" btn btn-raised  btn-round waves-effect btn-secondary">Back</a>
                                    </div>
                                </div>
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
