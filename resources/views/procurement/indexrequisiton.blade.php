@extends('coreui.layouts.admin')

@section('content')
<div class="container-fluid">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <strong>Requisition</strong>
            <small>List</small>
             <a style="color:white;" href="/companies/create" class="btn btn-primary btn-sm pull-right"><i style="color:white;" class="icon-cloud-upload"></i> Add New Company</a>
          </div>

          <div class="card-body">
            <table class="table table-responsive-sm table-bordered table-striped table-sm">
              <thead>
                <tr>
                  <th>#</th>
                  <th> vendor Name</th>
                  <th> services</th>
                  <th>paymentmethod</th>
                  <th class="text-center">expenses</th>
                  <th class="text-center">amount</th>
                 
                  <th class="text-center">Level</th>
                  <th class="text-center">Status</th>
                
                  <th class="text-center">Action</th>   
                </tr>
              </thead>
              <tbody>
                @foreach($requisitions as $company)
                <tr>
                <td></td>
                  <td>{{$company->vendor}}</td>
                  <td>{{$company->services}}</td>
                  <td>{{$company->paymentmethod}}</td>
                  <td>{{$company->expenses}}</td>
                  <td>{{$company->amount}}</td>
                  <td class="text-center">
              
                  @if($company->approvallevel == 1)
                    <span class='badge badge-info'>1st Line</span>
                    @elseif($company->approvallevel == 2)
                    <span class='badge badge-info'>2nd Line</span>
                    @elseif($company->approvallevel == 3)
                    <span class='badge badge-info'>3rd Line</span>
                    @else
                    <span class='badge badge-info'>4th Line</span>
                    @endif
                  
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

                    @if($company->userId != auth()->user()->id)
                    <a  href="{{ asset('/storage/uploads/'.$company->file) }}" target="_blank" class='btn btn-info btn-sm' style='color: white;'>
                      <span class='fa fa-desktop'></span>
                      <span class='hidden-sm hidden-sm hidden-md'> View Quotation</span>
                    </a>&nbsp;
                    <a href='/procurement/{{$company->id}}/approve' class='btn btn-success btn-sm' style='color: white;'>
                      <span class='fa fa-pencil'></span>
                      <span class='hidden-sm hidden-sm hidden-md'> Approve</span>
                    </a>&nbsp;
                    <a href='/procurement/{{$company->id}}/rejection' class='btn btn-danger btn-sm' style='color: white;'>
                      <span class='fa fa-pencil'></span>
                      <span class='hidden-sm hidden-sm hidden-md'> Reject</span>
                    </a>
                   @else
                   <a  href="{{ asset('/storage/uploads/'.$company->file) }}" target="_blank"class='btn btn-info btn-sm' style='color: white;'>
                      <span class='fa fa-desktop'></span>
                      <span class='hidden-sm hidden-sm hidden-md'> View Quotation</span>
                    </a>

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
