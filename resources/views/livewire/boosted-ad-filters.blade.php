<div class="container-fluid">
    <!-- Basic Examples -->
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="header">
                    @include('layouts.partials.messages')
                    <h2><strong>Banners </strong> Of Boosted Ads </h2>
                    <!-- <div style='text-align: end;'><a href="{{route('banners.create')}}" class="btn btn-primary"><i class="zmdi zmdi-plus" style="padding-right: 6px;"></i><span>Add Banner</span></a></div> -->
                </div>
                <div class="body">

                    <div class="row clearfix">
                        <div class="col-3">
                            <input class="form-control mr-sm-12" type="search" placeholder="Search By title" aria-label="Search" wire:model="keyword">
                        </div>
                        <div class="col-3"></div>
                        <div class="col-3"></div>
                        <div class="col-3"></div>
                    </div>
                    <div class="table-responsive mt-4">

                        <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                            <thead>
                                <tr>
                                    <th>Banner</th>
                                    <th>Title</th>
                                    <th>Period</th>
                                    <th>Amount (AED)</th>
                                    <th>Status</th>
                                    <th>Posted On</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Banner</th>
                                    <th>Title</th>
                                    <th>Period</th>
                                    <th>Amount (AED)</th>
                                    <th>Status</th>
                                    <th>Posted On</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @forelse($banners as $banner)
                                <tr>
                                    @if($banner->image_url!="")
                                    <td><img src="{{ asset(config('app.image_root_url'). $banner->image_url) }}" width="200"></td>
                                    @else
                                    <td><img src="{{asset('frontend/assets/images/no-image.png')}}" style="width:100px"></td>
                                    @endif
                                    <td width="35%">{{$banner->title}}
                                        <span class="ml-2 badge badge-primary">{{$banner->label}}</span>
                                    </td>
                                    <td>{{$banner->boostad->start_date}} to {{$banner->boostad->end_date}}
                                        <br /><span class="badge badge-info">{{$banner->boostad->days}} Days</span>
                                    </td>
                                    <td>{{$banner->boostad->total_amount}} AED</td>
                                    <td>
                                        @if($banner->boostad->status==1 || $banner->boostad->status==0)
                                        <input type="checkbox" name="verify_status" id="verify_status_{{$banner->boostad->id}}" {{ ($banner->boostad->status)? 'checked' : ''}} data-toggle="toggle" data-on="Active" data-off="Inactive" data-onstyle="success" data-offstyle="danger" value="{{ $banner->boostad->id }}">
                                        @elseif($banner->boostad->status==2)
                                        <span class="badge badge-warning">On review</span>
                                        @endif
                                    </td>
                                    <td>{{date("d-m-Y", strtotime($banner->boostad->created_at))}}</td>
                                    <td>

                                        <a href="{{route('banners.view',$banner->id)}}" class="mr-2"><i class="zmdi zmdi-eye"></i></a>
                                        <a href="{{route('banners.edit',$banner->id)}}" class="mr-2"><i class="zmdi zmdi-edit"></i></a>

                                        @if($banner->boostad->status==0)
                                        <a href="javascript:void(0)" data-id="{{$banner->id}}" data-url="{{ route('banners.destroy', $banner->id) }}" class="delete-banner"><i class="zmdi zmdi-delete"></i></a>
                                        <input type="hidden" id="image_url_{{$banner->id}}" name="image_url" value="{{$banner->image_url}}">
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7">There are no data.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {!! $banners->withQueryString()->links('pagination::bootstrap-5') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
         When click ads on Delete Button
         --------------------------------------------
         --------------------------------------------*/

        $(document).on('click', '.delete-banner', function() {

            var adsURL = $(this).data('url');
            var adsId = $(this).data('id');
            var trObj = $(this);

            if (confirm("Are you sure you want to delete this banner?") == true) {
                deleteExistingImage(adsId);

                $.ajax({
                    url: adsURL,
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

        function deleteExistingImage(adsId) {
            let existingImage = $("#image_url_" + adsId).val();
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
                        $("#image_url_" + adsId).val('');
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
            let checked = $(this).prop('checked') ? 1 : 0;
            let posturl = "{{ route('banners.changestatus', ':id' ) }}";
            posturl = posturl.replace(':id', obj.val());

            $.ajax({
                url: posturl,
                method: "PUT",
                data: {
                    isajax: 1,
                    status: checked
                },
                success: function(data) {

                    Swal.fire({
                        title: (checked) ? "Enabled" : "Disabled",
                        text: data.message,
                        icon: "success",
                    });
                    setTimeout(() => {
                        location.reload();
                    }, 2000);

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