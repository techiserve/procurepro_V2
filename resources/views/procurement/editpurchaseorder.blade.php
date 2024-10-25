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
            <strong>Edit Purchase Order</strong>
            <a href="/procurement/indexpurchaseorder" class="btn btn-primary btn-sm pull-right"><i style="color:white;" class="fa fa-align-justify"></i> Purchase Order List</a>
           </div>

           <div class="card-body">
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_name">Vendor</label>
                  <input class="form-control" id="grower_address" name="vendor" type="text" value="{{$purchaseorder->vendor}}" placeholder="Description of Expense" readonly>
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_rep">Service Types</label>
                  <input class="form-control" id="grower_address" name="services" type="text" value="{{$purchaseorder->services}}" placeholder="Description of Expense" readonly>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_address">Payment Method</label>
                  <input class="form-control" id="grower_address" name="paymentmethod" type="text" value="{{$purchaseorder->paymentmethod}}" placeholder="Description of Expense" readonly>
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_address">Department</label>
                  <input class="form-control" id="grower_address" name="department" type="text"  value="{{$purchaseorder->department}}" placeholder="Description of Expense" readonly>
                </div>
              </div>
            </div>
     
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_address">Description of Expense</label>
                  <input class="form-control" id="grower_address" name="expenses" type="text" value="{{$purchaseorder->expenses}}" placeholder="Description of Expense" readonly>
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_address">Project Code</label>
                  <input class="form-control" id="grower_address" name="projectcode" type="text" value="{{$purchaseorder->projectcode}}" placeholder="Project Code" readonly>
                </div>
              </div>
            </div>

            <div class="row">

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_type">Requisition Amount (Rands)</label>
                  <input class="form-control" id="national_id" name="amount" type="text" value="{{$purchaseorder->amount}}" placeholder="Amount" readonly>
                </div>
              </div>
            
              <div class="col-sm-6">
          <div class="form-group">
            <label for="grower_type">Invoice Amount (Rands)</label>
            <input  type="number" step="0.01"  class="form-control" id="national_id" name="invoiceamount"   max="{{ $purchaseorder->amount }}" placeholder="Amount" required>
          </div>
        </div>
         
            </div>

      <div class="row">
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



			<hr style="border-color: black;">
			<br>
          </div>
          <div class="card-footer">
            <div class="form-group pull-right">
    				<input type="submit" class="btn btn-success" value="Upload Documents"/>
    				<input type="reset" class="btn btn-danger" value="Cancel"/>
    			</div>
          </div>
       </div>
      </form>
     </div>
    </div>
   </div>
</div>
@endsection
