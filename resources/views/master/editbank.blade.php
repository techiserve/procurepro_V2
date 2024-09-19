@extends('coreui.layouts.admin')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
@section('content')
<div class="container-fluid">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-sm-12">
        
       <form method="POST" action="/bankaccount/{{ $bank->id }}/update">
       @csrf
       @method('put')
        <div class="card">
          <div class="card-header">
            <strong>Update Bank Account</strong>
            <a href="#" class="btn btn-primary btn-sm pull-right"><i style="color:white;" class="fa fa-align-justify"></i></a>
           </div>

           <div class="card-body">

           <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_address">Bank</label>
                  <select class="js-example-basic-single form-control" id="grower_size" name="bankName">
                  <option selected value="{{ $bank->bankName }}">{{ $bank->bankName }}</option>
                  
                           @foreach($banks as $role)
                           @if($role->name !=  $bank->bankName ){
                            <option value="{{ $role->name }}"> {{ $role->name }}</option>
                           }
                           @endif
                           
                            @endforeach
                        </select>
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                <label for="national_id">Branch Name</label>
                <input class="form-control" id="grower_name" name="branch" value="{{$bank->branch}}" type="text" placeholder="Branch Name">
                </div>
              </div>
            </div>


            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_name">Account Name</label>
                  <input class="form-control" id="grower_name" name="accountName" value="{{$bank->accountName}}" type="text" placeholder="Acoount Number">
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_rep">Account Type</label>
                  <input class="form-control" id="grower_rep" name="accountType" value="{{$bank->accountType}}" type="text" placeholder="Account Type">
                </div>
              </div>
            </div>
          

            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_name">Account Number</label>
                  <input class="form-control" id="grower_name" name="accountNumber"  value="{{$bank->accountNumber}}"  type="text" placeholder="Account Number">
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_rep">Account Purpose</label>
                  <input class="form-control" id="grower_rep" name="accountPurpose"  value="{{$bank->accountPurpose}}" type="text" placeholder="Account Purpose">
                </div>
              </div>
            </div>

             <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_name">Branch Code</label> 
                  <input class="form-control" id="grower_name" name="branchCode" type="text"  value="{{$bank->branchCode}}" placeholder="Branch Code">
                </div>
              </div>
       
              <div class="col-md-1">
                <div class="form-group">
                <div class="form-check">
                <!-- <label style="visibility: hidden;" for="defaultCheck1">
                 Active 
               </label>
                <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" name="IsActive"  value="1"  id="flexSwitchCheckDefault" />
                <label class="form-check-label" for="defaultCheck1">
                 Active 
               </label>
                </div>
              -->
               </div>
                </div>
              </div>
            </div>

         
      
			<hr style="border-color: black;">
			<br>
          </div>
          <div class="card-footer">
            <div class="form-group pull-right">
    				<input type="submit" class="btn btn-success" value="Update"/>
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
