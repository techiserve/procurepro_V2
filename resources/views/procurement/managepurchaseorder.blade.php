@extends('stack.layouts.admin')
@section('content')
<div class="container-fluid">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <strong>Purchase Order</strong>
            <small>List</small>
           <!-- <a style="color:white;" href="#" class="btn btn-primary btn-sm pull-right"><i style="color:white;" class="icon-cloud-upload"></i></a> -->
          </div>

          <div class="card-body">
            
          <form action="{{ route('purchaseorder.release') }}" method="POST">
          @csrf <!-- Always include CSRF token for security -->
          <button  type="submit"  name="action" value="Complete_Selected_Orders" class="btn btn-primary btn-sm pull-right" style="padding: 10px 20px; font-size: 16px; min-width: 100px;"><i class="fa fa-filter" ></i> Complete Selected Orders</button>
          <button  type="submit"  name="action" value="Release_Selected_Orders" class="btn btn-success btn-sm pull-right" style="padding: 10px 20px; font-size: 16px; min-width: 100px;margin-bottom:40px"><i class="fa fa-filter"></i> Release Purchase Orders</button>
            <table class="table table-responsive-sm table-bordered table-striped table-sm">
              <thead>
                <tr>
                <th><input type="checkbox"  id="selectAll"></th> <!-- Select All Checkbox -->

                  <th class="text-center">Vendor Name</th>
                  <th class="text-center">Services</th>
                  <th class="text-center">Payment method</th>
                  <th class="text-center">Expenses</th>
                  <th class="text-center">Amount</th>
                 
                  <th class="text-center">Approved By</th>

                  <th class="text-center">Status</th>

                  <th class="text-center">Action</th>   
                </tr>
              </thead>
              <tbody>
                @foreach($purchaseorders as $company)
                <tr>
                @php  $active = $company->status; @endphp
                <td><input type="checkbox" name="selected_items[]" value="{{ $company->id }}"   @if($active != '2') disabled @endif>
                </td>
                  <td>{{$company->vendor}}</td>
                  <td>{{$company->services}}</td>
                  <td>{{$company->paymentmethod}}</td>
                  <td>{{$company->expenses}}</td>
                  <td>{{$company->amount}}</td>
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
                  @if($company->status == 0 OR $company->status == 4)
                
                   <a  href="/procurement/{{$company->requisitionId}}/logs" class='btn btn-success btn-sm' style='color: white;'>
                      <span class='fa fa-pencil'></span>
                      <span class='hidden-sm hidden-sm hidden-md'> View Logs</span>
                   </a>&nbsp;

                    @else
                  
                   <a  href="/procurement/{{$company->requisitionId}}/logs" class='btn btn-success btn-sm' style='color: white;'>
                      <span class='fa fa-pencil'></span>
                      <span class='hidden-sm hidden-sm hidden-md'> View Logs</span>
                   </a>&nbsp;


                    @endif
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
           
            </form>

          </div>

        </div>
      </div>
    </div>


  </div>
</div>
@endsection
