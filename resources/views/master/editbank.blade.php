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

        <form method="POST" action="/bankaccount/{{ $bank->id }}/update">
          @csrf
          @method('PUT')
          <div class="card">
            <div class="card-header">
              <strong>Update Bank Account</strong>
            </div>

            <div class="card-body">

              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="bankName">Bank</label>
                    <select class="js-example-basic-single form-control" name="bankName" required>
                      <option selected value="{{ $bank->bankName }}">{{ $bank->bankName }}</option>
                      @foreach($banks as $role)
                        @if($role->name != $bank->bankName)
                          <option value="{{ $role->name }}">{{ $role->name }}</option>
                        @endif
                      @endforeach
                    </select>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="branch">Branch Name</label>
                    <input class="form-control" name="branch" type="text" value="{{ $bank->branch }}" placeholder="Branch Name">
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="accountName">Account Name</label>
                    <input class="form-control" name="accountName" type="text" value="{{ $bank->accountName }}" placeholder="Account Name">
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="accountType">Account Type</label>
                    <input class="form-control" name="accountType" type="text" value="{{ $bank->accountType }}" placeholder="Account Type">
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="accountNumber">Account Number</label>
                    <input class="form-control" name="accountNumber" type="text" value="{{ $bank->accountNumber }}" placeholder="Account Number">
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="accountPurpose">Account Purpose</label>
                    <input class="form-control" name="accountPurpose" type="text" value="{{ $bank->accountPurpose }}" placeholder="Account Purpose">
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="branchCode">Branch Code</label>
                    <input class="form-control" name="branchCode" type="text" value="{{ $bank->branchCode }}" placeholder="Branch Code">
                  </div>
                </div>

                <div class="col-md-1">
                  <div class="form-group">
                    <div class="form-check form-switch" style="visibility:hidden;">
                      <input class="form-check-input" type="checkbox" role="switch" name="IsActive" value="1" {{ $bank->isActive ? 'checked' : '' }}>
                      <label class="form-check-label">Active</label>
                    </div>
                  </div>
                </div>
              </div>

              <hr style="border-color: black;">
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
