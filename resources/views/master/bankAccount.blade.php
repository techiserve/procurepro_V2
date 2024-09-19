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
        
       <form method="POST" action="/bankaccount/store">
       @csrf
        <div class="card">
          <div class="card-header">
            <strong>Add Bank Account</strong>
            <a href="#" class="btn btn-primary btn-sm pull-right"><i style="color:white;" class="fa fa-align-justify"></i></a>
           </div>

           <div class="card-body">

           <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_address">Bank</label>
                  <select class="js-example-basic-single form-control" id="grower_size" name="bank">
                          <option value="" >Select Bank</option>
                           @foreach($banks as $role)
                            <option value="{{ $role->name }}"> {{ $role->name }}</option>
                            @endforeach
                        </select>
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                <label for="national_id">Branch Name</label>
                <input class="form-control" id="grower_name" name="branchname" type="text" placeholder="Branch Name">
                </div>
              </div>
            </div>


            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_name">Account Name</label>
                  <input class="form-control" id="grower_name" name="accountname" type="text" placeholder="Acoount Number">
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_rep">Account Type</label>
                  <input class="form-control" id="grower_rep" name="accounttype" type="text" placeholder="Account Type">
                </div>
              </div>
            </div>
          

            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_name">Account Number</label>
                  <input class="form-control" id="grower_name" name="accountnumber" type="text" placeholder="Account Number">
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_rep">Account Purpose</label>
                  <input class="form-control" id="grower_rep" name="accountpurpose" type="text" placeholder="Account Purpose">
                </div>
              </div>
            </div>

             <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="grower_name">Branch Code</label>
                  <input class="form-control" id="grower_name" name="branchcode" type="text" placeholder="Branch Code">
                </div>
              </div>
       
              <div class="col-md-1">
                <div class="form-group">
                <div class="form-check">
                <label style="visibility: hidden;" for="defaultCheck1">
                Active
               </label>
                <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" name="IsActive"  value="1"  id="flexSwitchCheckDefault" />
                <label class="form-check-label" for="defaultCheck1">
                Active
               </label>
                </div>
             
               </div>
                </div>
              </div>
            </div>

         
      
			<hr style="border-color: black;">
			<br>
          </div>
          <div class="card-footer">
            <div class="form-group pull-right">
    				<input type="submit" class="btn btn-success" value="Save Bank Account"/>
    				<input type="reset" class="btn btn-danger" value="Cancel Registration"/>
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
            <strong>Bank Accounts</strong>
            <small>List</small>
          </div>

          <div class="card-body">
            <table class="table table-responsive-sm table-bordered table-striped table-sm">
              <thead>
                <tr>
                  <th>#</th>
                  <th class="text-center">Bank</th>
                  <th class="text-center">Branch</th>
                  <th class="text-center">Account Name</th>
                  <th class="text-center">Account Number</th>
                  <th class="text-center">Status</th>
                  <th class="text-center">Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($bankaccounts as $user)
                <tr>

            <td class="text-center">
              
              @if($user->bankName == 'FNB' or $user->bankName == 'fnb')
              <div class="avatar avatar-md"><img class="avatar-img" src="{{ asset('/coreui/img/avatars/fnbbb.png') }}" alt="user@email.com"><span class="avatar-status bg-success"></span></div>
                @elseif($user->bankName == 'Capitec')
                <div class="avatar avatar-md"><img class="avatar-img" src="{{ asset('/coreui/img/avatars/capitec.jpg') }}" alt="user@email.com"><span class="avatar-status bg-success"></span></div>
                @elseif($user->bankName == 'absa')
                <div class="avatar avatar-md"><img class="avatar-img" src="{{ asset('/coreui/img/avatars/absa.jpg') }}" alt="user@email.com"><span class="avatar-status bg-success"></span></div>
                @elseif($user->bankName == 'FNB')
                <div class="avatar avatar-md"><img class="avatar-img" src="{{ asset('/coreui/img/avatars/fnbbb.png') }}" alt="user@email.com"><span class="avatar-status bg-success"></span></div>
                @else
                <!-- <span class='badge badge-success'>Active</span> -->
                <div class="avatar avatar-md"><img class="avatar-img" src="{{ asset('/coreui/img/avatars/6.jpg') }}" alt="user@email.com"><span class="avatar-status bg-success"></span></div>
                @endif
              
              </td>
                  <td class="text-center">{{$user->bankName}}</td>
                  <td class="text-center">{{$user->branch}}</td>
                  <td class="text-center">{{$user->accountName}}</td>
                  <td class="text-center">{{$user->accountNumber}}</td>
                  <td class="text-center">
                  @if($user->isActive == null)
                    <span class='badge badge-secondary'>Inactive</span>
                    @else
                    <span class='badge badge-success'>Active</span>
                    @endif
                    </td>           
                  <td class="text-center">
                  <a href='/bankaccount/{{$user->id}}/edit' class='btn btn-info btn-sm' style='color: white;'>
                      <span class='fa fa-pencil'></span>
                      <span class='hidden-sm hidden-sm hidden-md'>Edit</span>
                    </a>
                  <a href='#' class='btn btn-danger btn-sm'   onclick="
                        event.preventDefault(); // Prevent the default link behavior
                        Swal.fire({
                            title: 'Delete Bank Account?',
                            text: 'You won\'t be able to undo this!',
                            icon: 'info', // Updated property for SweetAlert2
                            showCancelButton: true,
                            confirmButtonText: 'Continue',
                            cancelButtonText: 'Cancel'
                          }).then((result) => {
                            if (result.isConfirmed) {
                              // Redirect to the URL or perform an action
                              window.location.href = '/bankaccount/{{$user->id}}/delete'; // Replace with your actual URL
                            }
                          })
                      "
                    >
                      <span class='fa fa-trash'></span>
                      <span class='hidden-sm hidden-sm hidden-md'>Delete</span>
                    </a>&nbsp;
                  
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
