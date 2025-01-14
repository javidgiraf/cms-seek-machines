 <div class="container-fluid">
     <!-- Basic Examples -->
     <div class="row clearfix">
         <div class="col-lg-12">
             <div class="card">
                 <div class="header">
                     @include('layouts.partials.messages')
                     <h2><strong>List </strong> Selling Machines Ads</h2>
                     <!-- <div style='text-align: end' ;><a href="{{route('sellmachines.create')}}" class="btn btn-primary"><i class="zmdi zmdi-plus" style="padding-right: 6px;"></i><span>Add Selling Machines Ads</span></a></div> -->
                 </div>
                 <div class="body">
                     <div class="row clearfix">
                         <div class="col-3">
                             <input class="form-control" type="search" placeholder="Search By Keywords" aria-label="Search" wire:model="keyword">
                         </div>
                         <div class="col-3"></div>
                         <div class="col-3"></div>
                         <div class="col-3"></div>
                     </div>

                     <div class="table-responsive mt-4">
                         <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                             <thead>
                                 <tr>
                                     <th>Image</th>
                                     <th>Title</th>
                                     <th>Industry</th>
                                     <th>Customer</th>
                                     <th>Year</th>
                                     <th>Origin</th>
                                     <th>Ad Status</th>
                                     <th>Posted On</th>
                                     <th>Action</th>
                                 </tr>
                             </thead>
                             <tfoot>
                                 <tr>
                                     <th>Image</th>
                                     <th>Title</th>
                                     <th>Industry</th>
                                     <th>Customer</th>
                                     <th>Year</th>
                                     <th>Origin</th>
                                     <th>Ad Status</th>
                                     <th>Posted On</th>
                                     <th>Action</th>
                                 </tr>
                             </tfoot>
                             <tbody>
                                 @forelse($sellMachines as $sellMachine)

                                 <tr>

                                     @if( $sellMachine->default_image!="")

                                     <td>
                                         <img src="{{ asset(config('app.image_root_url'). $sellMachine->default_image) }}" width="100"><br />
                                         <span class="badge badge-info mt-2">{{$sellMachine->item_code}}</span>
                                     </td>
                                     @else
                                     <td>
                                         <img src="{{asset('frontend/assets/images/no-image.png')}}" width="100"><br />
                                         <span class="badge badge-info mt-2">{{$sellMachine->item_code}}</span>
                                     </td>
                                     @endif
                                     <td>
                                         {{ Str::limit($sellMachine->title, 40, $end='...') }}
                                         <span class="badge badge-danger">{{$sellMachine->usage}}</span>
                                     </td>
                                     <td>{{$sellMachine->category->name}}</td>
                                     <td width="15%">{{(isset($sellMachine->user->customer->company))? $sellMachine->user->customer->company : ''}} /

                                     {{$sellMachine->user->name}}</td>
                                     <td>{{$sellMachine->yearof}}</td>
                                     <td>{{$sellMachine->country->name}}</td>
                                     <th>
                                         @switch($sellMachine->status)
                                         @case(1)
                                         <span class="badge badge-success">Active</span>
                                         @break
                                         @case(2)
                                         <span class="badge badge-warning">Pending</span>
                                         @break
                                         @default
                                         <span class="badge badge-danger">Inactive</span>
                                         @break
                                         @endswitch
                                     </th>
                                     <td>{{ date("d-m-Y", strtotime($sellMachine->created_at))}}</td>
                                     <td>
                                         <a href="{{route('sellmachines.view',$sellMachine->id)}}" class="mr-2"><i class="zmdi zmdi-eye"></i></a>
                                         <a href="{{route('sellmachines.edit',$sellMachine->id)}}" class="mr-2"><i class="zmdi zmdi-edit"></i></a>

                                         <!-- DELETE ADS -->
                                         <a href="javascript:void(0)" data-id="{{$sellMachine->id}}" data-url="{{ route('sellmachines.destroy', $sellMachine->id) }}" class="delete-ads"><i class="zmdi zmdi-delete"></i></a>

                                         <input type="hidden" id="image_url_{{$sellMachine->id}}" name="image_url" value="{{$sellMachine->default_image}}">
                                         <input type="hidden" id="catalog_url_{{$sellMachine->id}}" name="catalog_url" value="{{($sellMachine->machine_catalog)? $sellMachine->machine_catalog->file_path: ''}}">

                                         @forelse($sellMachine->sell_machines_image as $imageUrl)
                                         <input type="hidden" class="multi_image_urls" id="multi_image_url_{{$sellMachine->id}}_{{$imageUrl->id}}" name="multi_image_url[{{$sellMachine->id}}][]" value="{{ $imageUrl->image_url }}">
                                         @empty
                                         <input type="hidden" class="multi_image_urls" id="multi_image_url_{{$sellMachine->id}}_0" name="multi_image_url[{{$sellMachine->id}}][]" value="">
                                         @endforelse
                                         <!-- DELETE -->
                                     </td>

                                 </tr>
                                 @empty
                                 <tr>
                                     <td colspan="9">There are no data.</td>
                                 </tr>
                                 @endforelse
                             </tbody>
                         </table>
                         {!! $sellMachines->withQueryString()->links('pagination::bootstrap-5') !!}
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

         $(document).on('click', '.delete-ads', function() {

             var adsURL = $(this).data('url');
             var adsId = $(this).data('id');
             var trObj = $(this);

             if (confirm("Are you sure you want to delete this ad?") == true) {
                 deleteExistingImage(adsId);

                 deleteMultipleImages(adsId);

                 deleteExistingCatalog(adsId);

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

         function deleteMultipleImages(adsId) {

             let existingImages = $("input[name='multi_image_url[" + adsId + "][]']").map(function() {
                 return $(this).val();
             }).get();

             if (!existingImages.length) {
                 return false;
             }

             let formData = new FormData();
             formData.append("imageurl", existingImages);
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
                         $("input[name='multi_image_url[" + adsId + "][]']").val('');
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

         function deleteExistingCatalog(adsId) {
             let existingDoc = $("#catalog_url_" + adsId).val();
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
                         $("#catalog_url_" + adsId).val('');
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
