@extends('coreui.layouts.admin')

@section('content')
<div class="container-fluid">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-sm-12">
        
       <form method="POST" action="/procurement/{{$purchaseorder->id}}/updaterequisition">
       @csrf
       @method('put')
        <div class="card">
          <div class="card-header">
            <strong>View Requisition</strong>
            <a href="/procurement/indexrequisition" class="btn btn-primary btn-sm pull-right"><i style="color:white;" class="fa fa-align-justify"></i> Requistions List</a>
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
                  <input class="form-control" id="grower_address" name="expenses" type="text" value="{{$purchaseorder->expenses}}" placeholder="Description of Expense" >
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_address">Project Code</label>
                  <input class="form-control" id="grower_address" name="projectcode" type="text" value="{{$purchaseorder->projectcode}}" placeholder="Project Code" >
                </div>
              </div>
            </div>

            <div class="row">

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_type">Requisition Amount (Rands)</label>
                  <input class="form-control" id="national_id" name="amount" type="text" value="{{$purchaseorder->amount}}" placeholder="Amount" >
                </div>
              </div>
            
              <div class="col-sm-6">
          <div class="form-group">
            <label for="grower_type">Reason</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" name="reason" rows="3" readonly>{{$purchaseorder->reason}}</textarea>
          </div>
        </div>
        </div>

    

			<hr style="border-color: black;">
			<br>
          </div>
    
      
            <div class="card-footer">
            <div class="form-group pull-right">
    				
            <input type="submit" class="btn btn-success" value="Edit Requisition"/>
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
                  <td class="text-center">Quotation</td> 
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
@endsection
