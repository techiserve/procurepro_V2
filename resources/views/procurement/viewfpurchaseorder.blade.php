@extends('html.default')

@section('content')
<div class="container-fluid">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-sm-12">
    <form method="POST" action="/procurement/{{$fpurchaseorder->id}}/sendback">
       @csrf
        @method('put')
          <div class="card">
          <div class="card-header">
            <strong>View Purchase Order</strong>
            <div class="d-flex justify-content-end">
             <a href="/procurement/indexrequisition" class="btn btn-primary btn-sm pull-right"><i style="color:white;" class="fa fa-align-justify"></i> Purchase Orders List</a>
            </div>
           </div>
@php
      $vendorNames = ['vendor', 'vendor list', 'vendors', 'Vendor', 'Vendor List'];
      $propertyNames = ['property', 'properties','Property List', 'property list'];
      $serviceNames = ['service', 'service list', 'services', 'Service List'];
      $taxtypeNames = ['Tax', 'Tax Type', 'taxtype', 'tax list', 'Tax List'];
      $paymentmethodNames = ['payment method', 'Payment Method', 'payment', 'paymentmethod'];
      $transactionNames = ['transaction', 'transaction list', 'transactions','transaction description'];
       $departmentNames = ['department', 'department list', 'departments','department description'];
        $amount = ['amount', 'Amount'];
          $invoiceamount = ['invoiceamount', 'Invoiceamount','invoice amount'];
@endphp
           <div class="card-body">
        <div class="row">
            @foreach ($formFields as $field)

             @php
            $normalizedAttributes = collect($fpurchaseorder->getAttributes())
             ->keyBy(fn($v, $k) => strtolower($k));

            $fieldName = strtolower($field->name);
            $value = $normalizedAttributes[$fieldName] ?? '';
            @endphp
                 
                @if(in_array($fieldName, array_map('strtolower', $paymentmethodNames)))
                <div class="col-md-6 mb-3">
                 <label class="form-label">{{ $field->label }}</label>
               <input type="text" class="form-control" name="{{ $fieldName }}" value="{{ $value }}" readonly>
                </div>
                @elseif(in_array($fieldName, array_map('strtolower', $amount)))
                   <div class="col-md-6 mb-3">
                    <label class="form-label">{{ $field->label }}</label>
                    <input type="text" class="form-control" name="{{ $fieldName }}" value="{{ $value }}" readonly>
                </div>
                   @elseif(in_array($fieldName, array_map('strtolower', $invoiceamount)))
                   <div class="col-md-6 mb-3">
                    <label class="form-label">{{ $field->label }}</label>
                    <input type="text" class="form-control" name="{{ $fieldName }}" value="{{ $value }}" readonly>
                </div>
                    @elseif(in_array($fieldName, array_map('strtolower', $departmentNames)))
                   <div class="col-md-6 mb-3">
                    <label class="form-label">{{ $field->label }}</label>
                   <input type="text" class="form-control" name="{{ $fieldName }}" value="{{ $departments->name ?? 'Unknown' }}" readonly>
                </div>
                @else
                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ $field->label }}</label>
                    <input type="text" class="form-control"  name="{{ $fieldName }}" value="{{ $value }}" readonly>
                </div>
                @endif
            @endforeach
        </div>
               @if ($fpurchaseorder->status == 4 OR $fpurchaseorder->status == 3 )
        <div class="row">
        <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_number">Reason for Return</label>
                  <input type="text" class="form-control" id="inputGroupFile04" name="reason" aria-describedby="inputGroupFileAddon04" value="{{$fpurchaseorder->reason}}" aria-label="Upload" readonly>
                </div>
              </div>    
        
        </div>
         @endif
 
      </div>
     

      
			<hr style="border-color: black;">
			<br>
                
       @if($fpurchaseorder->userId != auth()->user()->id)
            @if($fpurchaseorder->approvedby == auth()->user()->userrole AND $fpurchaseorder->approvallevel <= $fpurchaseorder->totalapprovallevels AND $fpurchaseorder->status != '2')
            <div class="card-footer">
            <div class="form-group pull-right">

    				   @if($departmentapproval->IsBankAccount == auth()->user()->userrole)
                    <a href=''   data-target="#bankAccount" data-toggle="modal"  class='btn btn-success' style='color: white;'>
                      <span class='fa fa-check-circle'></span>
                      <span class='hidden-sm hidden-sm hidden-md'>Approve</span>
                    </a> 
               @else
                    <a href='/procurement/{{$fpurchaseorder->id}}/accept' class='btn btn-success' style='color: white;'>
                      <span class='fa fa-check-circle'></span>
                      <span class='hidden-sm hidden-sm hidden-md'>Approve</span>
                    </a> 
               @endif
        
                    <a href=''  data-target="#returnback" data-toggle="modal"  class='btn btn-info' style='color: white;'>
                      <span class='fa fa-arrow-left'></span>
                      <span class='hidden-sm hidden-sm hidden-md'>Return</span>
                    </a>

            <a href=''  data-target="#emailCopy" data-toggle="modal"  class='btn btn-danger' style='color: white;'>
                      <span class='fa fa-times-circle'></span>
                      <span class='hidden-sm hidden-sm hidden-md'>Reject</span>
                    </a>
    			</div> 
          </div>
          @endif
          @else
  

          @endif
          
       </div>
    </div>
      
    </form>
</div>
</div>
  

    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <strong>Documents</strong>
            <small>List</small>
          </div>

          <div class="card-body">
            <table class="table table-responsive-sm table-bordered table-striped table-sm">
              <thead>
                <tr>              
                  <th>Name</th>              
                  <th class="text-center">Action</th>
                </tr>
              </thead>
              <tbody>
          
                <tr>          
                  <td class="text-center">Invoice</td> 
                  <td class="text-center"> 
                  @if (isset($invoicepath))
               
                  <a href="{{ asset('/storage/uploads/'.$fpurchaseorder->invoice) }}" target="_blank"class='btn btn-info btn-sm' style='color: white;'>
                      <span class='fa fa-pencil'></span>
                      <span class='hidden-sm hidden-sm hidden-md'>View Invoice</span>
                    </a> 
                    @else
                  <p>No document available.</p>
                  @endif                          
                  </td>
                </tr>

                <tr>         
                  <td class="text-center">Job Card</td>         
                  <td class="text-center">
                  @if (isset($jobcardpath))
                  <a href="{{ asset('/storage/uploads/'.$fpurchaseorder->jobcardfile) }}" target="_blank"class='btn btn-info btn-sm' style='color: white;'>
                      <span class='fa fa-pencil'></span>
                      <span class='hidden-sm hidden-sm hidden-md'>View Job Card</span>
                    </a> 
                    @else
                  <p>No document available.</p>
                  @endif                 
                  </td>
                </tr>
              
              </tbody>
            </table>
          </div>

        </div>
      </div>
    </div>  

    

@if(isset($itemizedItems) && $itemizedItems->isNotEmpty())
<div class="row">
  <div class="col-sm-12">
    <div class="card mt-3">
      <div class="card-header">
        <strong>Itemized Purchase Order Details</strong>
      </div>
      <div class="card-body table-responsive">
        <table class="table table-bordered table-striped">
          <thead class="table-light">
            <tr>
              <th>#</th>
              <th>Item</th>
              <th>Description</th>
              <th>Quantity</th>
              <th>Price/Item</th>
              <th>Total Weight</th>
              <th>Line Total</th>
              <th>V.A.T</th>
            </tr>
          </thead>
          <tbody>
            @foreach($itemizedItems as $index => $item)
            <tr>
              <td>{{ $index + 1 }}</td>
              <td>{{ $item->item }}</td>
              <td>{{ $item->description }}</td>
              <td>{{ $item->quantity }}</td>
              <td>{{ number_format($item->price, 2) }}</td>
              <td>{{ $item->weight }}</td>
              <td>{{ number_format($item->linetotal, 2) }}</td>
              <td>{{ number_format($item->vat, 2) }}</td>
            </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <th colspan="6" class="text-end">Sub Total</th>
              <th>ZAR {{ number_format($itemizedItems->sum('linetotal'), 2) }}</th>
              <th>ZAR {{ number_format($itemizedItems->sum('vat'), 2) }}</th>
            </tr>
               <tr>
              <th colspan="6" class="text-end">Total</th>
              <th>ZAR {{ number_format($itemizedItems->sum('linetotal') + $itemizedItems->sum('vat'), 2) }}</th>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>
</div>
@endif



    			<!-- modal for sending copy of cashflow to grower -->
          <div class="modal fade" id="emailCopy" tabindex="-1"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            	<div class="modal-dialog modal-primary modal-md" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title"><i style="color:white;" class="fa fa-envelope"></i> Reject Purchase Order</h4>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">×</span>
                    </button>
                  </div>
                  <div class="modal-body"  style="font-size: 14px;">							
  
                  <form method="POST" action="/procurement/{{$fpurchaseorder->id}}/reject">
                   @csrf
                  @method('put')
										<div class="form-group">
											<label for="message">Reason for rejecting</label>
											<textarea rows="3" name="message" class="form-control" maxlength="150" required></textarea>
										</div>
                  </div>

                  <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
										<button class="btn btn-danger" type="submit" ><span class='fa fa-times-circle'></span> Reject</button>
                  </div>
                </div> 
              </form>
              <!-- /.modal-content-->
            </div>
            <!-- /.modal-dialog-->
   </div>

<!-- modal for sending copy of cashflow to grower -->
<div class="modal fade" id="bankAccount" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-primary modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><i style="color:white;" class="fa fa-envelope"></i> Bank Account</h4>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>

      <form method="POST" action="/procurement/{{$fpurchaseorder->id}}/bankAccount">
        @csrf
        @method('put')
        <div class="modal-body" style="font-size: 14px;">							

          <div class="form-group">
            <label for="account_id">Pick Bank Account</label>
            <select name="account_id" id="account_id" class="form-control" required>
              <option value="" disabled selected>-- Select Account --</option>
              @foreach($accounts as $account)
                <option value="{{ $account->id }}" 
                        data-name="{{ $account->bankName }}" 
                        data-number="{{ $account->accountNumber }}">
                  {{ $account->bankName }} ({{ $account->accountNumber }})
                </option>
              @endforeach
            </select>
          </div>

          <div class="form-group">
            <label for="account_name">Account Name</label>
            <input type="text" id="account_name" class="form-control" readonly>
          </div>

          <div class="form-group">
            <label for="account_number">Account Number</label>
            <input type="text" id="account_number" class="form-control" readonly>
          </div>

        </div>

        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
          <button class="btn btn-success" type="submit"><span class='fa fa-times-circle'></span> Save</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content-->
  </div>
  <!-- /.modal-dialog-->
</div>


   <div class="modal fade" id="returnback" tabindex="-1"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            	<div class="modal-dialog modal-primary modal-md" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title"><i style="color:white;" class="fa fa-envelope"></i> Return Purchase Order</h4>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">×</span>
                    </button>
                  </div>
                  <div class="modal-body"  style="font-size: 14px;">							
  
                  <form method="POST" action="/procurement/{{$fpurchaseorder->id}}/sendback">
                   @csrf
                  @method('put')
										<div class="form-group">
											<label for="message">Reason for Returning</label>
											<textarea rows="3" name="message" class="form-control" maxlength="150" required></textarea>
										</div>
                  </div>

                  <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
										<button class="btn btn-primary" type="submit" ><span class='fa fa-arrow-left'></span> Return</button>
                  </div>
                </div> 
              </form>
              <!-- /.modal-content-->
            </div>
            <!-- /.modal-dialog-->


</div>


</div>


@endsection
<script>
  document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("account_id").addEventListener("change", function () {
      var selected = this.options[this.selectedIndex];
      document.getElementById("account_name").value = selected.getAttribute("data-name") || '';
      document.getElementById("account_number").value = selected.getAttribute("data-number") || '';
    });
  });
</script>