@extends('stack.layouts.admin')
<link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.4/tutorials/timelines/timeline-7/assets/css/timeline-7.css">
@section('content')
<div class="container-fluid">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <strong>Manage Purchase Order</strong>
           <!-- <a style="color:white;" href="#" class="btn btn-primary btn-sm pull-right"><i style="color:white;" class="icon-cloud-upload"></i></a> -->
          </div>

          <div class="card-body">
            
          <form action="{{ route('purchaseorder.release') }}" method="POST">
          @csrf <!-- Always include CSRF token for security -->
          <button  type="submit"  name="action" value="Complete_Selected_Orders" class="btn btn-primary btn-sm pull-right" style="padding: 10px 20px; font-size: 16px; min-width: 100px;margin-top:-60px"><i class="fa fa-filter" ></i> Complete Selected Orders</button>
          <button  type="submit"  name="action" value="Release_Selected_Orders" class="btn btn-success btn-sm pull-right" style="padding: 10px 20px; font-size: 16px; min-width: 100px;margin-top:-60px;margin-right: 260px;"><i class="fa fa-filter"></i> Release Purchase Orders</button>
            <table class="table table-striped table-bordered zero-configuration">
              <thead>
                <tr>
                <th><input type="checkbox"  id="selectAll"></th> <!-- Select All Checkbox -->
                <th>Requisition #</th>   
                @foreach($formFields as $field)
                <th>{{ ucfirst($field->name) }}</th>
                @endforeach
                <th>Approved By</th>   
                <th>Status</th>         
                <th class="text-center" style="width: 180px;">Action</th>    
                </tr>
              </thead>
              <tbody>
                 @foreach($fpurchaseorders as $fpurchaseorder)
                <tr>
                  @php  $active = $fpurchaseorder->status; @endphp
                <td><input type="checkbox" name="selected_items[]" value="{{ $fpurchaseorder->id }}"   @if($active != '2') disabled @endif>
                    <td>{{ $fpurchaseorder->requisitionNumber }}</td>
                  @foreach($formFields as $field)
                        <td>{{ $fpurchaseorder->{$field->name} ?? '' }}</td>
                    @endforeach
                
                  <td class="text-center">

                  @foreach($roles as $role)
                  @if($fpurchaseorder->approvedby == $role->id)
                  {{$role->name}}
                  @endif
                  @endforeach
             
                  </td>

              <td class="text-center">
              
              @if($fpurchaseorder->status == 0)
              <button type="button" class="btn btn-outline-primary"><span class="fa fa-spinner"></span> Pending</button>
                @elseif($fpurchaseorder->status == 1)
                <button type="button" class="btn btn-outline-primary"><span class="fa fa-spinner"></span> Pending</button>
                @elseif($fpurchaseorder->status == 2)
                <button type="button" class="btn btn-outline-success"><span class="fa fa-check-circle"></span> Approved</button>
                @elseif($fpurchaseorder->status == 3)
                <button type="button" class="btn btn-outline-danger"><span class="fa fa-times-circle"></span> Rejected</button>
                @elseif($fpurchaseorder->status == 4)
                <button type="button" class="btn btn-outline-info"><span class="fa fa-arrow-left"></span> Returned</button>
                @else
                <button type="button" class="btn btn-outline-primary"><span class="fa fa-spinner"></span> Processing</button>
                @endif
              
              </td>
          
                  <td class="text-center" style="width: 180px;">
                  @if($fpurchaseorder->status == 0 OR $fpurchaseorder->status == 4)
                
                    <a  href="#" class='btn btn-success btn-sm' data-toggle="modal" data-target="#historyModal{{ $fpurchaseorder->id }}" style='color: white;'>
                      <span class='fa fa-pencil'></span>
                      <span class='hidden-sm hidden-sm hidden-md'>  Logs</span>
                   </a>&nbsp;

                    @else
                  
                    <a  href="#" class='btn btn-success btn-sm' data-toggle="modal" data-target="#historyModal{{ $fpurchaseorder->id }}" style='color: white;'>
                      <span class='fa fa-pencil'></span>
                      <span class='hidden-sm hidden-sm hidden-md'>  Logs</span>
                   </a>&nbsp;               

                    @endif
                        
                     <a  href="#" class='btn btn-info btn-sm' data-toggle="modal" data-target="#pop{{ $fpurchaseorder->id }}" style='color: white;'>
                      <span class='fa fa-download'></span>
                      <span class='hidden-sm hidden-sm hidden-md'> Upload POP</span>
                     </a>&nbsp;

                     <a  href="/procurement/{{$fpurchaseorder->id}}/paymentRelease" class='btn btn-secondary btn-sm' style='color: white;'>
                      <span class='fa fa-pencil'></span>
                      <span class='hidden-sm hidden-sm hidden-md'>Payment Release</span>
                     </a>&nbsp;  

                     <a  href="/procurement/{{$fpurchaseorder->frequisition_id}}/view" class='btn btn-info btn-sm' style='color: white;'>
                      <span class='fa fa-desktop'></span>
                      <span class='hidden-sm hidden-sm hidden-md'>View</span>
                     </a>&nbsp;  

                     <a  href="#" class='btn btn-success btn-sm' data-toggle="modal" data-target="#viewdocuments{{ $fpurchaseorder->id }}"style='color: white;'>
                      <span class='fa fa-download'></span>
                      <span class='hidden-sm hidden-sm hidden-md'>View Documents</span>
                     </a>&nbsp;  
                     


                     
               {{-- modal --}}
  <div class="modal fade" id="viewdocuments{{ $fpurchaseorder->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-primary modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h4 class="modal-title"><i class="fa fa-envelope"></i> View Documentsfai</h4>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form method="POST" action="" enctype="multipart/form-data">
        @csrf
        @method('put')

        <div class="modal-body" style="font-size: 14px;">
          @php
            // Assuming $documents is an array of up to 4 filenames passed from the controller
          $docs = [
                  'Quotation' => $fpurchaseorder->quotation ?? null,
                  'Invoice'   => $fpurchaseorder->invoice ?? null,
                  'POP'       => $fpurchaseorder->pop ?? null,
                  'Job Card'  => $fpurchaseorder->jobcard ?? null,
                ];

          @endphp

          @if(array_filter($docs))
            <div class="mt-4">
              <h5>View Documents</h5>
              <table class="table table-sm table-bordered table-striped">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Document Name</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                 @php $counter = 1; @endphp
                  @foreach($docs as $label => $file)
                    @if($file)
                      <tr>
                        <td>{{ $counter++ }}</td>
                        <td>{{ $label }}</td>
                        <td>
                          <a href="{{ asset('storage/uploads/' . $file) }}" target="_blank" class="btn btn-sm btn-info">
                            <i class="fa fa-eye"></i> View
                          </a>
                        </td>
                      </tr>
                    @endif
                  @endforeach
                </tbody>
              </table>
            </div>
          @endif

        </div>

        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
          <button class="btn btn-primary" type="submit">
            <i class="fa fa-upload"></i> Upload
          </button>
        </div>

      </form>
    </div>
  </div>
</div>




             <!-- Modal Structure -->
                   <div class="modal fade" id="historyModal{{ $fpurchaseorder->id }}" tabindex="-1" role="dialog" aria-labelledby="historyModalLabel{{ $fpurchaseorder->id }}" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="timelineModalLabel">Requisition Logs</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Timeline 7 - Bootstrap Brain Component -->
                <section class="bsb-timeline-7 py-3">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-12">
                            @if($fpurchaseorder->histories->isEmpty())
                                        <p>No history found for this requisition.</p>
                                    @else
                                <ul class="timeline">
                                @foreach($fpurchaseorder->histories as $history)

                                @php
                                    $date = \Carbon\Carbon::parse($history->created_at);
                                    @endphp

                                    <li class="timeline-item">
                                        <div class="timeline-body">
                                            <div class="timeline-meta">
                                                <div class="d-inline-flex flex-column px-2 py-1 text-success-emphasis bg-success-subtle border border-success-subtle rounded-2 text-md-end">
                                                    <span class="fw-bold">{{$date->format('d F Y')}}</span>
                                                    <span>{{$date->format('g:ia')}}</span>
                                                </div>
                                            </div>
                                            <div class="timeline-content timeline-indicator">
                                                <div class="card border-0 shadow">
                                                    <div class="card-body p-xl-4"  style="position: relative;">
                                                    <h6 class="card-subtitle text-secondary mb-3" style="position: absolute; top: 10; right: 10;">{{ $loop->iteration }}</h6>
                                                        <h2 class="card-title mb-2">{{$history->doneby}}</h2>
                                                      
                                                        <p class="card-text m-0">{{$history->action}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>             
                                 @endforeach
                                </ul>

                                @endif

                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
{{--  --}}
                   
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
           
            </form>

         {{--  --}}
            <div class="modal fade" id="pop{{ $fpurchaseorder->id }}" tabindex="-1"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            	<div class="modal-dialog modal-primary modal-md" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title"><i style="color:white;" class="fa fa-envelope"></i>Upload Proof of Payment</h4>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">×</span>
                    </button>
                  </div>
                  <div class="modal-body"  style="font-size: 14px;">							
  
                  <form method="POST" action="/procurement/{{$fpurchaseorder->id}}/pop"   enctype="multipart/form-data">
                   @csrf
                   @method('put')
										<div class="form-group">
											<label for="message">Upload document</label>
											<input type="file" name="pop" class="form-control" maxlength="150"  required/>
										</div>
                  </div>

                  <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
										<button class="btn btn-primary" type="submit" ><span class='fa fa-arrow-left'></span> Upload</button>
                  </div>
                </div> 
              </form>
          
            </div>
          
            </div>
       {{--  --}}

          </div>

        </div>
      </div>
    </div>


  </div>
</div>
@endsection
