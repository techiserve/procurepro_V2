@extends('stack.layouts.admin')

@section('content')
<div class="container-fluid">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-sm-12">
        
       <form method="POST" action="/procurement/{{$purchaseorder->id}}/approve">
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
                  <input class="form-control" id="grower_address" name="department" type="text"  value="{{$departments->name}}" placeholder="Description of Expense" readonly>
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
            <label for="grower_type">Reason</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" name="reason" rows="3" readonly>{{$purchaseorder->reason}}</textarea>
          </div>
        </div>
        </div>

    

			<hr style="border-color: black;">
			<br>
          </div>
    
            @if($purchaseorder->userId != auth()->user()->id AND $history == NULL)
            <div class="card-footer">
            <div class="form-group pull-right">
    				
            <a href='/procurement/{{$purchaseorder->id}}/approve' class='btn btn-success' style='color: white;'>
                      <span class='fa fa-check-circle'></span>
                      <span class='hidden-sm hidden-sm hidden-md'>Approve</span>
                    </a> 
        
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
          @else
  

          @endif
          
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
  
                  <form method="POST" action="/procurement/{{$purchaseorder->id}}/rejection">
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

   <div class="modal fade" id="returnback" tabindex="-1"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            	<div class="modal-dialog modal-primary modal-md" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title"><i style="color:white;" class="fa fa-envelope"></i> Return  Purchase Requisition</h4>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">×</span>
                    </button>
                  </div>
                  <div class="modal-body"  style="font-size: 14px;">							
  
                  <form method="POST" action="/procurement/{{$purchaseorder->id}}/sendbackrequistion">
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
@endsection
