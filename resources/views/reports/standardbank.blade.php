@extends('stack.layouts.admin')

@section('content')
<div class="container-fluid">
  <div class="animated fadeIn">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong>Standard Bank Report</strong>
                    <button class="btn btn-primary btn-sm pull-right"  data-toggle="modal" data-target="#filterModal" style="padding: 10px 20px; font-size: 16px; min-width: 100px;"><i class="fa fa-filter"></i> Filter </button>
                    <!-- <a href="/growers/" class="btn btn-primary btn-sm pull-right"><i style="color:white;" class="fa fa-align-justify"></i> Filter Requisitions</a> -->
               
                </div>

                <div class="card-body">
                    <div class="datatable-dashv1-list custom-datatable-overright">
                        <div id="toolbar">
                    
                        </div>
                        <table class="table table-striped table-bordered file-export">
                            <thead>
                                <tr>
                                    <th data-field="id" class='text-center'>RICIPIENT NAME</th>
                                    <th data-field="grower_name" class='text-center'> RICIPIENT ACCOUNT</th>
                                    <th data-field="grower_number" class='text-center'>RICIPIENT ACCOUNT TYPE</th>
                                    <th data-field="province" class='text-center'>BRANCH</th>
                                    <th data-field="grower_type" class='text-center'>AMOUNT</th>
                                    <th data-field="grower_size" class='text-center'>OWN REFERENCES</th>
                                    <th data-field="grower_agent" class='text-center'>RICIPIENT REFERENCES</th> 
                               
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($fpurchaseorder as $grower)
                                    <tr>
       
                                        <td>{{ $grower->vendor }}</td>
                                        <td>{{ $grower->bankAccountNumber }}</td>
                                        <td>{{ $grower->bankAccountType }}</td>
                                        <td>3310</td>
                                        <td>{{$grower->invoiceamount}}</td>
                                        <td>{{ $grower->ownref }}</td>
                                        <td>{{ $grower->benref }}</td>
                                                               
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <!-- /.modal for documents-->
        <div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-primary modal-md" role="document">
        <form method="post" action="{{ route('purchaseorder.filtered') }}" enctype="multipart/form-data">
          {{ csrf_field() }}
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Filter Purchase Order Summary</h4>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label for="areas">Date From</label>
                <input class="form-control" id="grower_name" name="start_date" type="date">
              </div>
              <div class="form-group">
                <label for="assessors">Date To</label>
                <input class="form-control" id="grower_name" name="end_date" type="date" >
              </div>
              <div class="form-group">
                <label for="status">Status</label>
                <select name="status" id="status" class="js-example-basic-single form-control"  style="width:100%;">     
                    <option value="">--Select Status--</option>       
                    <option value="2">Approved</option>       
                    <option value="3">Rejected</option>  
                    <option value="1">Pending</option>     
                </select>
              </div>
              <div class="form-group">
                <label for="vendor">Vendor</label>
                <select name="vendor" id="vendor" class="js-example-basic-single form-control"  style="width:100%;">   
                <option value="">--Select Vendor--</option> 
                @foreach($vendors as $vendor)
               
                <option value="{{ $vendor->SupplierName }}"> {{ $vendor->SupplierName }}</option>
                  @endforeach        
                </select>
              </div>
              <div class="form-group">
                <label for="service">Service Type</label>
                <select name="service" id="service" class="js-example-basic-single form-control"  style="width:100%;"> 
                <option value="">--Select Service--</option> 
                @foreach($servicetype as $servicetype)  
                
                <option value="{{ $servicetype->ServiceTypeDescription }}"> {{ $servicetype->ServiceTypeDescription }}</option>
                  @endforeach          
                </select>
              </div>
            </div>
            <div class="modal-footer">
              <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
              <button class="btn btn-primary" type="submit">Filter Summary</button>
            </div>
          </div>
        </form>
        <!-- /.modal-content-->
      </div>
      <!-- /.modal-dialog-->
    </div>


  </div>
</div>
@endsection
