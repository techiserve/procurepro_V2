@extends('stack.layouts.admin')

@section('content')
<div class="container-fluid">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-sm-12">
        <form method="POST" action="/vendors/update/{{ $vendor->id }}" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <div class="card">
            <div class="card-header">
              <strong>Edit Vendor</strong>
              <a href="/vendors/index" class="btn btn-primary btn-sm pull-right">
                <i class="fa fa-align-justify"></i> Back to Vendor List
              </a>
            </div>

            <div class="card-body">
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Vendor Name</label>
                    <input class="form-control" name="name" value="{{ $vendor->name }}">
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Vendor Type</label>
                    <select class="form-control" name="type">
                      <option value="">--Select--</option>
                      @foreach($vendorTypes as $type)
                        <option value="{{ $type->name }}" {{ $vendor->type == $type->name ? 'selected' : '' }}>{{ $type->name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Description</label>
                    <input class="form-control" name="description" value="{{ $vendor->description }}">
                  </div>
                </div>
                <div class="col-sm-6">
  <div class="form-group">
    <label>VAT Registered</label><br>
    <div class="mt-1"> <!-- Added margin top -->
      <label class="radio-inline">
        <input type="radio" name="vat_registered" value="Yes" {{ $vendor->vat_registered == 'Yes' ? 'checked' : '' }}> Yes
      </label>
      <label class="radio-inline ml-3">
        <input type="radio" name="vat_registered" value="No" {{ $vendor->vat_registered == 'No' ? 'checked' : '' }}> No
      </label>
    </div>
  </div>
</div>
              </div>

              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>VAT Allocation</label>
                    <input class="form-control" name="vat_allocation" value="{{ $vendor->vat_allocation }}">
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Contact Number 1</label>
                    <input class="form-control" name="contact_no_1" value="{{ $vendor->contact_no_1 }}">
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Contact Number 2</label>
                    <input class="form-control" name="contact_no_2" value="{{ $vendor->contact_no_2 }}">
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Supplier Code</label>
                    <input class="form-control" name="supplier_code" value="{{ $vendor->supplier_code }}">
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Address</label>
                    <textarea class="form-control" name="address">{{ $vendor->address }}</textarea>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Finance Manager</label>
                    <select class="form-control" name="finance_manager">
                      <option value="0">--Select--</option>
                         @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                     @endforeach
                      
                    </select>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="bank_name">Bank Name</label>
                    <select id="bank_name" name="bank_name" class="form-control">
                      <option value="">--Select--</option>
                      <option value="ABSA" {{ $vendor->bank_name == 'ABSA' ? 'selected' : '' }}>ABSA</option>
                      <option value="FNB" {{ $vendor->bank_name == 'FNB' ? 'selected' : '' }}>FNB</option>
                      <option value="Standard Bank" {{ $vendor->bank_name == 'Standard Bank' ? 'selected' : '' }}>Standard Bank</option>
                      <option value="Nedbank" {{ $vendor->bank_name == 'Nedbank' ? 'selected' : '' }}>Nedbank</option>
                      <option value="Capitec" {{ $vendor->bank_name == 'Capitec' ? 'selected' : '' }}>Capitec</option>
                      <option value="Investec" {{ $vendor->bank_name == 'Investec' ? 'selected' : '' }}>Investec</option>
                    </select>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="account_number">Account Number</label>
                    <input type="text" id="account_number" name="account_number" class="form-control" value="{{ $vendor->account_number }}">
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="account_type">Account Type</label>
                    <select id="account_type" name="account_type" class="form-control">
                      <option value="">--Select--</option>
                      <option value="Cheque" {{ $vendor->account_type == 'Cheque' ? 'selected' : '' }}>Cheque</option>
                      <option value="Savings" {{ $vendor->account_type == 'Savings' ? 'selected' : '' }}>Savings</option>
                      <option value="Business" {{ $vendor->account_type == 'Business' ? 'selected' : '' }}>Business</option>
                    </select>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="branch_code">Branch Code</label>
                    <input type="text" id="branch_code" name="branch_code" class="form-control" value="{{ $vendor->branch_code }}">
                  </div>
                </div>
              </div>

              @if(!empty($vendor->message))
              <div class="row">
                <div class="col-sm-12">
                  <div class="form-group">
                    <label>Return Reason</label>
                    <textarea class="form-control" readonly>{{ $vendor->message }}</textarea>
                  </div>
                </div>
              </div>
              @endif


              <hr>
              <h4>Uploaded Documents</h4>
              @if($vendor->documents && count($vendor->documents))
                <ul>
                  @foreach($vendor->documents as $doc)
                    <li><a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank">{{ $doc->document_name }}</a></li>
                  @endforeach
                </ul>
              @else
                <p>No documents uploaded.</p>
              @endif
            </div>

            <div class="card-footer">
              <div class="form-group pull-right">
                <button type="submit" class="btn btn-primary">Update Vendor</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
