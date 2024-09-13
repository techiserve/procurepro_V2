@extends('coreui.layouts.admin')

@section('content')
<div class="container-fluid">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-sm-12">
        
       <form method="POST" action="/requisition/store"  enctype="multipart/form-data">
       @csrf
        <div class="card">
          <div class="card-header">
            <strong>Add Purchase Requisition</strong>
            <a href="/procurement/indexrequisition" class="btn btn-primary btn-sm pull-right"><i style="color:white;" class="fa fa-align-justify"></i> Requisition List</a>
           </div>

           <div class="card-body">
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_name">Vendor</label>
                  <select class="js-example-basic-single form-control" id="grower_sizesss" name="vendor">
                           <option value="" >Select Vendor</option>
                           @foreach($vendors as $vendor)
                           <option value="{{ $vendor->SupplierName }}"> {{ $vendor->SupplierName }}</option>
                           @endforeach
                  </select>
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_rep">Service Types</label>
                  <select class="js-example-basic-single form-control" id="servicetype" name="service">
                          <option value="" >Select Services</option>
                           @foreach($servicetype as $servicetype)
                            <option value="{{ $servicetype->ServiceTypeDescription }}"> {{ $servicetype->ServiceTypeDescription }}</option>
                            @endforeach
                        </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_address">Payment Method</label>
                  <select class="js-example-basic-single form-control" id="grower_sizes" name="paymentmethod">
                            <option value="" >Select Payment Method</option>                       
                            <option value="EFT">EFT</option>                          
                            <option value="Credit Card">Credit Card</option>                                                         
                  </select>
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_address">Department</label>
                  <select class="js-example-basic-single form-control" id="grower_size" name="department">
                          <option value="" >Select Department</option>
                           @foreach($departments as $department)
                            <option value="{{ $department->id }}"> {{ $department->name }}</option>
                            @endforeach
                        </select>
                </div>
              </div>
            </div>
     
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_address">Description of Expense</label>
                  <input class="form-control" id="grower_address" name="expenses" type="text" placeholder="Description of Expense">
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_address">Project Code</label>
                  <input class="form-control" id="grower_address" name="projectcode" type="text" placeholder="Project Code">
                </div>
              </div>
            </div>

            <div class="row">

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_type">Amount (Rands)</label>
                  <input class="form-control" id="national_id" name="amount" type="text" placeholder="Amount" required>
                </div>
              </div>
            

            <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_number">Quotation</label>
                  <input type="file" class="form-control" id="inputGroupFile04" name="file" aria-describedby="inputGroupFileAddon04" aria-label="Upload" required>
                </div>
              </div>    
          
            </div>


			<hr style="border-color: black;">
			<br>
          </div>
          <div class="card-footer">
            <div class="form-group pull-right">
    				<input type="submit" class="btn btn-success" value="Save New Requisition"/>
    				<input type="reset" class="btn btn-danger" value="Cancel Registration"/>
    			</div>
          </div>
       </div>
      </form>
     </div>
    </div>
   </div>
</div>
@endsection
