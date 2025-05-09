@extends('stack.layouts.admin')

@section('content')
<div class="container-fluid">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-sm-12">
        <form method="POST" action="/vendors/store-banking" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="vendor_id" value="{{ session('vendor_id') }}">

          <div class="card">
            <div class="card-header">
              <strong>Vendor Banking Details</strong>
              <a href="/vendors/index" class="btn btn-primary btn-sm pull-right">
                <i class="fa fa-align-justify" style="color:white;"></i> Vendor List
              </a>
            </div>

            <div class="card-body">
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="bank_name">Bank Name</label>
                    <select id="bank_name" name="bank_name" class="form-control">
                      <option value="">--Select--</option>
                      <option value="ABSA">ABSA</option>
                      <option value="FNB">FNB</option>
                      <option value="Standard Bank">Standard Bank</option>
                      <option value="Nedbank">Nedbank</option>
                      <option value="Capitec">Capitec</option>
                      <option value="Investec">Investec</option>
                      <!-- Add more as needed -->
                    </select>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="account_number">Account Number</label>
                    <input type="text" id="account_number" name="account_number" class="form-control">
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="account_type">Account Type</label>
                    <select id="account_type" name="account_type" class="form-control">
                      <option value="">--Select--</option>
                      <option value="Cheque">Cheque</option>
                      <option value="Savings">Savings</option>
                      <option value="Business">Business</option>
                    </select>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="branch_code">Branch Code</label>
                    <input type="text" id="branch_code" name="branch_code" class="form-control">
                  </div>
                </div>
              </div>
            </div>

            <div class="card-footer">
              <div class="form-group pull-right">
                <button type="submit" class="btn btn-success">Submit Banking Details</button>
              </div>
            </div>

          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
