@extends('stack.layouts.admin')

@section('content')
<div class="container-fluid">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-sm-12">
    <form method="POST" action="/procurement/{{$frequisition->id}}/approve">
       @csrf
       @method('put')
          <div class="card">
          <div class="card-header">
            <strong>View Requisition</strong>
            <a href="/procurement/indexrequisition" class="btn btn-primary btn-sm pull-right"><i style="color:white;" class="fa fa-align-justify"></i> Requistions List</a>
           </div>

           <div class="card-body">
        <div class="row">
            @foreach ($formFields as $field)
                @php
                    $fieldName = $field->name;
                    $value = $frequisition->$fieldName ?? '';
                @endphp
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ $field->label }}</label>
                    <input type="text" class="form-control" value="{{ $value }}" readonly>
                </div>
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
         
    
            @if($frequisition->userId != auth()->user()->id AND $history == NULL )
            @if($frequisition->approvedby == auth()->user()->userrole AND $frequisition->approvallevel <= $frequisition->totalapprovallevels)
            <div class="card-footer">
            <div class="form-group pull-right">
    				
            <a href='/procurement/{{$frequisition->id}}/approve' onclick="celebrate()" class='btn btn-success' style='color: white;'>
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
  
                  <form method="POST" action="/procurement/{{$frequisition->id}}/rejection">
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
  
                  <form method="POST" action="/procurement/{{$frequisition->id}}/sendbackrequistion">
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
@if(session('approved'))
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        window.addEventListener('DOMContentLoaded', function () {
            // Wait 500ms so alert shows first
            Swal.fire({
                title: 'Approved!',
                text: 'Your request was successfully approved.',
                icon: 'success',
                timer: 2500,
                showConfirmButton: false
            });

            // Fire confetti slightly after the alert starts
            setTimeout(() => {
                confetti({
                    particleCount: 100,
                    spread: 70,
                    origin: { y: 0.6 }
                });
            }, 500);
        });
    </script>
@endif
