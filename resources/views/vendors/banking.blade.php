@extends('html.default')

@section('content')
<div class="body-content__header">
    <ul>
        <li><a href="#">Vendor Banking Details</a></li>
    </ul>
</div>

<div class="body-content__wrapper requesition-body">
    <form method="POST" action="/vendors/store-banking" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="vendor_id" value="{{ session('vendor_id') }}">

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong>Vendor Banking Details</strong>
                <a href="/vendors/index" class="btn btn-primary btn-sm">
                    <i class="fa fa-align-justify"></i> Vendor List
                </a>
            </div>

            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="bank_name" class="form-label">Bank Name</label>
                        <select id="bank_name" name="bank_name" class="form-select">
                            <option value="">--Select--</option>
                            @foreach($banks as $bank)
                                <option value="{{ $bank->name }}">{{ $bank->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="account_number" class="form-label">Account Number</label>
                        <input type="text" id="account_number" name="account_number" class="form-control">
                    </div>
                </div>

                <div class="row g-3 mt-2">
                    <div class="col-md-6">
                        <label for="account_type" class="form-label">Account Type</label>
                        <select id="account_type" name="account_type" class="form-select">
                            <option value="">--Select--</option>
                            <option value="Cheque">Cheque</option>
                            <option value="Savings">Savings</option>
                            <option value="Business">Business</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="branch_code" class="form-label">Branch Code</label>
                        <input type="text" id="branch_code" name="branch_code" class="form-control">
                    </div>
                </div>
            </div>

            <div class="card-footer text-end">
                <button type="submit" class="btn btn-success">Submit Banking Details</button>
            </div>
        </div>
    </form>
</div>
@endsection
