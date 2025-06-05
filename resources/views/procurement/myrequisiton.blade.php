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
            <strong>Requisition</strong>
            <small>List</small>
          </div>

          <div class="card-body">
            <table class="table table-striped table-bordered zero-configuration">
              <thead>
                <tr>
                  <th>#</th>
                  <th class="text-center"> Vendor Name</th>
                  <th class="text-center"> Services</th>
                  <th class="text-center">Payment method</th>
                  <th class="text-center">Expenses</th>
                  <th class="text-center">Amount</th>
                 
                  <th class="text-center">Approved By</th>
                  <th class="text-center">Status</th>
                
                  <th class="text-center">Action</th>   
                </tr>
              </thead>
              <tbody>
                @foreach($requisitions as $company)
                <tr>
                <td></td>
                  <td class="text-center">{{$company->vendor}}</td>
                  <td class="text-center">{{$company->services}}</td>
                  <td class="text-center">{{$company->paymentmethod}}</td>
                  <td class="text-center">{{$company->expenses}}</td>
                  <td class="text-center">{{$company->amount}}</td>
                  <td class="text-center">

                  @foreach($roles as $role)
                  @if($company->approvedby == $role->id)
                     {{$role->name}}
                  @endif
                   @endforeach
             
                  </td>

                  <td class="text-center">
              
              @if($company->status == 0)
              <button type="button" class="btn btn-outline-primary"><span class="fa fa-spinner"></span> Pending</button>
                @elseif($company->status == 1)
                <button type="button" class="btn btn-outline-primary"><span class="fa fa-spinner"></span> Pending</button>
                @elseif($company->status == 2)
                <button type="button" class="btn btn-outline-success"><span class="fa fa-check-circle"></span> Approved</button>
                @elseif($company->status == 3)
                <button type="button" class="btn btn-outline-danger"><span class="fa fa-times-circle"></span> Rejected</button>
                @elseif($company->status == 4)
                <button type="button" class="btn btn-outline-info"><span class="fa fa-arrow-left"></span> Returned</button>
                @else
                <button type="button" class="btn btn-outline-primary"><span class="fa fa-spinner"></span> Processing</button>
                @endif
              
              </td>
            
                  <td class="text-center">

                    @if($company->userId == auth()->user()->id)

                    @if($company->status == 4)
                    <a  href="/procurement/{{$company->id}}/editrequisition"  class='btn btn-info btn-sm' style='color: white;'>
                      <span class='fa fa-desktop'></span>
                      <span class='hidden-sm hidden-sm hidden-md'> Update Requisition</span>
                    </a>&nbsp;
                    <a  href="#" class='btn btn-success btn-sm' data-toggle="modal" data-target="#historyModal{{ $company->id }}" style='color: white;'>
                      <span class='fa fa-pencil'></span>
                      <span class='hidden-sm hidden-sm hidden-md'> View Logs</span>
                   </a>&nbsp;
                   
                <!-- Modal Structure -->
                <div class="modal fade" id="historyModal{{ $company->id }}" tabindex="-1" role="dialog" aria-labelledby="historyModalLabel{{ $company->id }}" aria-hidden="true">
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
                            @if($company->histories->isEmpty())
                                        <p>No history found for this requisition.</p>
                                    @else
                                <ul class="timeline">
                                @foreach($company->histories as $history)

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


                    @else
                      <a  href="/procurement/{{$company->id}}/viewrequisition"  class='btn btn-info btn-sm' style='color: white;'>
                      <span class='fa fa-desktop'></span>
                      <span class='hidden-sm hidden-sm hidden-md'> View Requisition</span>
                    </a>&nbsp;
                    <a  href="#" class='btn btn-success btn-sm' data-toggle="modal" data-target="#historyModal{{ $company->id }}" style='color: white;'>
                      <span class='fa fa-pencil'></span>
                      <span class='hidden-sm hidden-sm hidden-md'> View Logs</span>
                   </a>&nbsp;

                <!-- Modal Structure -->
                <div class="modal fade" id="historyModal{{ $company->id }}" tabindex="-1" role="dialog" aria-labelledby="historyModalLabel{{ $company->id }}" aria-hidden="true">
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
                            @if($company->histories->isEmpty())
                                        <p>No history found for this requisition.</p>
                                    @else
                                <ul class="timeline">
                                @foreach($company->histories as $history)

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


                   @endif

                    
                
                    <!-- <a href='/procurement/{{$company->id}}/approve' class='btn btn-success btn-sm' style='color: white;'>
                      <span class='fa fa-pencil'></span>
                      <span class='hidden-sm hidden-sm hidden-md'> Approve</span>
                    </a>&nbsp;
                    <a href='/procurement/{{$company->id}}/rejection' class='btn btn-danger btn-sm' style='color: white;'>
                      <span class='fa fa-pencil'></span>
                      <span class='hidden-sm hidden-sm hidden-md'> Reject</span>
                    </a> -->
                   @else
                   <a  href="/procurement/{{$company->id}}/viewrequisition" class='btn btn-info btn-sm' style='color: white;'>
                      <span class='fa fa-desktop'></span>
                      <span class='hidden-sm hidden-sm hidden-md'> View Requisition</span>
                   </a>&nbsp;
                   <a  href="#" class='btn btn-success btn-sm' data-toggle="modal" data-target="#historyModal{{ $company->id }}" style='color: white;'>
                      <span class='fa fa-pencil'></span>
                      <span class='hidden-sm hidden-sm hidden-md'> View Logs</span>
                   </a>&nbsp;

                                       <!-- Modal Structure -->
                <div class="modal fade" id="historyModal{{ $company->id }}" tabindex="-1" role="dialog" aria-labelledby="historyModalLabel{{ $company->id }}" aria-hidden="true">
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
                            @if($company->histories->isEmpty())
                                        <p>No history found for this requisition.</p>
                                    @else
                                <ul class="timeline">
                                @foreach($company->histories as $history)

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
                timer: 1000,
                showConfirmButton: false
            });

            // Fire confetti slightly after the alert starts
            setTimeout(() => {
                confetti({
                    particleCount: 300,
                    spread: 250,
                    origin: { y: 0.6 }
                });
            }, 1100);
        });
    </script>
@endif
