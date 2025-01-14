  <div class="body">
      <form style="padding: 20px;">
          <input class="form-control mr-sm-12" type="search" placeholder="search" aria-label="Search" wire:model="keyword">

      </form>
      <div class="table-responsive">
          <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
              <thead>
                  <tr>
                      <td colspan="6"></td>
                      <td><strong>Total Amount</strong></td>
                      <td><strong>AED: {{$total}}</strong></td>
                  </tr>
                  <tr>
                      <th>User</th>
                      <th>Image</th>
                      <th>Title</th>
                      <th>Payment Method</th>
                      <th>Amount</th>
                      <th>Paid On</th>
                      <th>Reference Id</th>
                      <th>Status</th>


                  </tr>
              </thead>
              <tfoot>
                  <tr>
                      <th>User</th>
                      <th>Image</th>
                      <th>Title</th>
                      <th>Payment Method</th>
                      <th>Amount</th>
                      <th>Paid On</th>
                      <th>Reference Id</th>
                      <th>Status</th>


                  </tr>
                  <tr>
                      <td colspan="6"></td>
                      <td><strong>Total Amount</strong></td>
                      <td><strong>AED: {{$total}}</strong></td>
                  </tr>
              </tfoot>
              <tbody>
                  @foreach($boostAdTransactions as $transaction)

                  <tr>
                      <th>{{$transaction->transaction->user->name}}</th>
                      @if((file_exists('storage/' . $transaction->boostad->sell_machine->default_image)) && $transaction->boostad->sell_machine->default_image!="")

                      <td><img src="{{ asset('storage/' . $transaction->boostad->sell_machine->default_image) }}"></td>
                      @else
                      <td><img src="{{asset('frontend/assets/images/no-image.png')}}" style="width:100px"></td>
                      @endif
                      <th>{{$transaction->boostad->sell_machine->title}}</th>
                      <th>{{$transaction->transaction->payment_method}}</th>
                      <th>{{$transaction->transaction->total_amount}}</th>
                      <th>{{$transaction->transaction->paid_on}}</th>
                      <th>{{$transaction->transaction->reference_id}}</th>
                      <th>{{$transaction->transaction->payment_status}}</th>

                  </tr>
                  @endforeach
              </tbody>
          </table>
      </div>
  </div>