@extends('stack.layouts.admin')

@section('content')
<div class="container-fluid">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-sm-12">
    <form method="POST" action="/purchaseorder/update/{{$purchaseorder->id}}"  enctype="multipart/form-data">
       @csrf
       @method('put')
          <div class="card">
          <div class="card-header">
            <strong>View Requisition</strong>
            <a href="/procurement/indexrequisition" class="btn btn-primary btn-sm pull-right"><i style="color:white;" class="fa fa-align-justify"></i> Requistions List</a>
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
                    $value = $purchaseorder->$fieldName ?? '';
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
                    <input type="text" class="form-control" name="{{ $fieldName }}" value="{{ $value }}" >
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
   {{--  --}}
             <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_number">Beneficiary Reference</label>
                  <input type="text" class="form-control" name="benref" aria-describedby="inputGroupFileAddon04" >
                </div>
              </div>    

             <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_number">Own Reference</label>
                  <input type="text" class="form-control" name="ownref" aria-describedby="inputGroupFileAddon04" >
                </div>
              </div> 
              
              
        

        @if ($purchaseorder->status == 4 OR $purchaseorder->status == 3 )
       
        <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_number">Reason for Return</label>
                  <input type="text" class="form-control" id="inputGroupFile04" name="reason" aria-describedby="inputGroupFileAddon04" value="{{$purchaseorder->reason}}" aria-label="Upload" readonly>
                </div>
              </div>    
        
        </div>
         @endif

          
        <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_number">Upload Invoice</label>
                  <input type="file" class="form-control" id="inputGroupFile04" name="invoice" aria-describedby="inputGroupFileAddon04" aria-label="Upload" required>
                </div>
              </div>    
        

        <div class="col-sm-6">
          <div class="form-group">
            <label for="grower_number">Upload Job Card</label>
            <input type="file" class="form-control" id="inputGroupFile04" name="jobcard" aria-describedby="inputGroupFileAddon04" aria-label="Upload">
          </div>
        </div>    

        </div>
      </div>
      
			<hr style="border-color: black;">
			<br>
         
         
            <div class="card-footer">
            <div class="form-group pull-right">
    				
             <input type="submit" class="btn btn-success" value="Save"/>

    			</div> 
          </div>
      
          
       </div>
    </div>
      
    </form>
</div>
</div>


</div>


</div>


@endsection
