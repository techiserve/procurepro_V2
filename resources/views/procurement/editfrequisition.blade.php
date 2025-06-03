@extends('stack.layouts.admin')

@section('content')
<div class="container-fluid">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-sm-12">
    <form method="POST" action="/procurement/{{$frequisition->id}}/updaterequisition">
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
@endphp
           <div class="card-body">
        <div class="row">
            @foreach ($formFields as $field)
                @php
                    $fieldName = $field->name;
                    $value = $frequisition->$fieldName ?? '';
                @endphp
                 
                @if(in_array($fieldName, array_map('strtolower', $paymentmethodNames)))
                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ $field->label }}</label>
              <select class="js-example-basic-single form-control" name="{{ $fieldName }}">
                <option value="">Select Payment Method</option>
                <option value="EFT" {{ $value === 'EFT' ? 'selected' : '' }}>EFT</option>
                <option value="Credit Card" {{ $value === 'Credit Card' ? 'selected' : '' }}>Credit Card</option>
            </select>
                </div>
                @elseif(in_array($fieldName, array_map('strtolower', $amount)))
                   <div class="col-md-6 mb-3">
                    <label class="form-label">{{ $field->label }}</label>
                    <input type="text" class="form-control" name="{{ $fieldName }}" value="{{ $value }}" >
                </div>
                    @elseif(in_array($fieldName, array_map('strtolower', $departmentNames)))
                   <div class="col-md-6 mb-3">
                    <label class="form-label">{{ $field->label }}</label>
                    <input type="text" class="form-control" name="{{ $fieldName }}" value="{{ $value }}" >
                </div>
                @else
                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ $field->label }}</label>
                    <input type="text" class="form-control"  name="{{ $fieldName }}" value="{{ $value }}" readonly>
                </div>
                @endif
            @endforeach
        </div>

         <div class="row">
            
            <div class="col-sm-6">
          <div class="form-group">
            <label for="grower_type">Reason</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" name="reason" rows="3" readonly>{{$frequisition->reason}}</textarea>
          </div>
        </div>
        </div>
      </div>
      
			<hr style="border-color: black;">
			<br>
         
         
            <div class="card-footer">
            <div class="form-group pull-right">
    				
             <input type="submit" class="btn btn-success" value="Update"/>

    			</div> 
          </div>
      
          
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
                  <th class="text-center">Name</th>              
                  <th class="text-center">Action</th>
                </tr>
              </thead>
              <tbody>
                 
               @foreach ($files as $faira)
                
                <tr>          
                  <td class="text-center">Quotation </td> 
                  <td class="text-center"> 
                  @if (isset($faira))
               
                  <a href="{{ asset('/storage/uploads/'.$faira->file) }}" target="_blank"class='btn btn-info btn-sm' style='color: white;'>
                      <span class='fa fa-pencil'></span>
                      <span class='hidden-sm hidden-sm hidden-md'>View Quotation</span>
                    </a> 
                    @else
                  <p>No document available.</p>
                  @endif                          
                  </td>
                </tr>
                @endforeach
              
              </tbody>
            </table>
          </div>

        </div>
      </div>
    </div>

</div>


</div>


@endsection
