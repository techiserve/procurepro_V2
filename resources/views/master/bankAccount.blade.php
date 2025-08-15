@extends('html.default')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
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
            </div>

            <div class="card-body">
              
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="bank">Bank</label>
                    <select class="js-example-basic-single form-control" name="bank" required>
                      <option value="">Select Bank</option>
                      @foreach($banks as $role)
                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="branchname">Branch Name</label>
                    <input class="form-control" name="branchname" type="text" placeholder="Branch Name" required>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="accountname">Account Name</label>
                    <input class="form-control" name="accountname" type="text" placeholder="Account Name" required>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="accounttype">Account Type</label>
                    <input class="form-control" name="accounttype" type="text" placeholder="Account Type" required>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="accountnumber">Account Number</label>
                    <input class="form-control" name="accountnumber" type="number" placeholder="Account Number" required>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="accountpurpose">Account Purpose</label>
                    <input class="form-control" name="accountpurpose" type="text" placeholder="Account Purpose">
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="branchcode">Branch Code</label>
                    <input class="form-control" name="branchcode" type="text" placeholder="Branch Code">
                  </div>
                </div>

                <div class="col-md-1">
                  <div class="form-group" style="margin-top: 37px;">
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" role="switch" name="IsActive" value="1">
                      <label class="form-check-label" for="flexSwitchCheckDefault">Active</label>
                    </div>
                  </div>
                </div>
              </div>

              <hr style="border-color: black;">
            </div>

            <div class="card-footer">
              <div class="form-group pull-right">
                <input type="submit" class="btn btn-success" value="Save Bank Account" style="padding: 10px 20px; font-size: 16px; min-width: 100px;"/>
                <input type="reset" class="btn btn-danger" value="Cancel Registration" style="padding: 10px 20px; font-size: 16px; min-width: 100px;"/>
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
                    @php
                      $bankImg = '/coreui/img/avatars/6.jpg';
                      if(strtolower($user->bankName) == 'fnb') $bankImg = '/coreui/img/avatars/fnbbb.png';
                      elseif($user->bankName == 'Capitec') $bankImg = '/coreui/img/avatars/capitec.jpg';
                      elseif(strtolower($user->bankName) == 'absa') $bankImg = '/coreui/img/avatars/absa.jpg';
                    @endphp
                    <div class="avatar avatar-md">
                   
                      <span class="avatar-status bg-success"></span>
                    </div>
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
                    <a href='#' class='btn btn-danger btn-sm' onclick="
                      event.preventDefault();
                      Swal.fire({
                        title: 'Delete Bank Account?',
                        text: 'You won\'t be able to undo this!',
                        icon: 'info',
                        showCancelButton: true,
                        confirmButtonText: 'Continue',
                        cancelButtonText: 'Cancel'
                      }).then((result) => {
                        if(result.isConfirmed){
                          window.location.href='/bankaccount/{{$user->id}}/delete';
                        }
                      })
                    ">
                      <span class='fa fa-trash'></span>
                      <span class='hidden-sm hidden-sm hidden-md'>Delete</span>
                    </a>
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
