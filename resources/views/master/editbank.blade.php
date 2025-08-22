 @extends('html.default')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

@section('content')
<div class="body-content__header">
  <ul>
    <li><a href="#">Update Bank Account</a></li>
  </ul>
</div>

<div class="body-content__wrapper">
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
              <div class="col-md-6">
                <div class="form-col">
                  <label for="bankName">Bank</label>
                  <select id="bankName" class="js-example-basic-single form-control" name="bankName" required>
                    <option selected value="{{ $bank->bankName }}">{{ $bank->bankName }}</option>
                    @foreach($banks as $role)
                      @if($role->name != $bank->bankName)
                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                      @endif
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-col">
                  <label for="branch">Branch Name</label>
                  <input id="branch" class="form-control" name="branch" type="text" value="{{ $bank->branch }}" placeholder="Enter Branch Name">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-col">
                  <label for="accountName">Account Name</label>
                  <input id="accountName" class="form-control" name="accountName" type="text" value="{{ $bank->accountName }}" placeholder="Enter Account Name">
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-col">
                  <label for="accountType">Account Type</label>
                  <input id="accountType" class="form-control" name="accountType" type="text" value="{{ $bank->accountType }}" placeholder="Enter Account Type">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-col">
                  <label for="accountNumber">Account Number</label>
                  <input id="accountNumber" class="form-control" name="accountNumber" type="text" value="{{ $bank->accountNumber }}" placeholder="Enter Account Number">
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-col">
                  <label for="accountPurpose">Account Purpose</label>
                  <input id="accountPurpose" class="form-control" name="accountPurpose" type="text" value="{{ $bank->accountPurpose }}" placeholder="Enter Account Purpose">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-col">
                  <label for="branchCode">Branch Code</label>
                  <input id="branchCode" class="form-control" name="branchCode" type="text" value="{{ $bank->branchCode }}" placeholder="Enter Branch Code">
                </div>
              </div>

              <div class="col-md-1 col-form-label d-flex align-items-center">
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" role="switch" name="IsActive" value="1" id="isActiveSwitch" {{ $bank->isActive ? 'checked' : '' }}>
                  <label class="form-check-label" for="isActiveSwitch">Active</label>
                </div>
              </div>
            </div>

            <hr style="border-color: black;">
          </div>

          <div class="card-footer">
            <div class="d-flex justify-content-end">
              <input type="submit" class="btn btn-success" value="Update" style="padding:10px 20px; font-size:16px; min-width:100px;">
              <input type="reset" class="btn btn-danger" value="Cancel" style="padding:10px 20px; font-size:16px; min-width:100px;">
            </div>
          </div>

        </div>
      </form>

    </div>
  </div>
</div>
@endsection
