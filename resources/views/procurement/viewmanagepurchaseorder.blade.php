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
            <strong>View Requisition</strong>
              <div class="d-flex justify-content-end">
            <a href="/procurement/indexrequisition" class="btn btn-primary btn-sm pull-right"><i style="color:white;" class="fa fa-align-justify"></i> Requistions List</a>
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
                    $fieldName = $field->name;
                    $value = $fpurchaseorder->$fieldName ?? '';
                @endphp
                 
                @if(in_array($fieldName, array_map('strtolower', $paymentmethodNames)))
                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ $field->label }}</label>
              <select class="js-example-basic-single form-control" name="{{ $fieldName }}" readonly>
                <option value="">Select Payment Method</option>
                <option value="EFT" {{ $value === 'EFT' ? 'selected' : '' }}>EFT</option>
                <option value="Credit Card" {{ $value === 'Credit Card' ? 'selected' : '' }}>Credit Card</option>
            </select>
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
                    <input type="text" class="form-control" name="{{ $fieldName }}" value="{{ $value }}" readonly>
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

                  <tr>         
                  <td class="text-center">Quotation</td>         
                  <td class="text-center">
                  @if (isset($vendor))
                  <a href="{{ asset('/storage/uploads/'.$vendor->file_path) }}" target="_blank"class='btn btn-info btn-sm' style='color: white;'>
                      <span class='fa fa-pencil'></span>
                      <span class='hidden-sm hidden-sm hidden-md'>View Quotation</span>
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



    <div class="row">
  <div class="col-sm-12">
    <div class="card">
      <div class="card-header">
        <strong>Requisition History</strong>
      </div>
      <div class="card-body">
        <table class="table table-responsive-sm table-bordered table-striped table-sm">
          <thead>
            <tr>
              <th>Action</th>
              <th>Done by</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($history as $history)
            <tr>
              <td>{{ $history->action }}</td>
              <td>{{ $history->doneby }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
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