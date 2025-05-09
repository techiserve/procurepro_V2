@extends('stack.layouts.admin')

@section('content')
<div class="container-fluid">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <strong>Vendor Details</strong>
            <a href="{{ route('vendors.approval') }}" class="btn btn-secondary btn-sm pull-right">Back</a>
          </div>

          <div class="card-body">
            <form method="POST" action="{{ route('vendors.approvalAction', $vendor->id) }}">
              @csrf
              <input type="hidden" name="action" id="actionType" value="">
              <input type="hidden" name="message" id="returnMessage" value="">

              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" value="{{ $vendor->name }}" readonly>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Type</label>
                    <input type="text" class="form-control" value="{{ $vendor->type }}" readonly>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Description</label>
                    <input type="text" class="form-control" value="{{ $vendor->description }}" readonly>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Finance Manager</label>
                    <input type="text" class="form-control" value="{{ $vendor->finance_manager }}" readonly>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>VAT Registered</label>
                    <input type="text" class="form-control" value="{{ $vendor->vat_registered }}" readonly>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>VAT Allocation</label>
                    <input type="text" class="form-control" value="{{ $vendor->vat_allocation }}" readonly>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Contact No 1</label>
                    <input type="text" class="form-control" value="{{ $vendor->contact_no_1 }}" readonly>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Contact No 2</label>
                    <input type="text" class="form-control" value="{{ $vendor->contact_no_2 }}" readonly>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Supplier Code</label>
                    <input type="text" class="form-control" value="{{ $vendor->supplier_code }}" readonly>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Address</label>
                    <input type="text" class="form-control" value="{{ $vendor->address }}" readonly>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Bank Name</label>
                    <input type="text" class="form-control" value="{{ $vendor->bank_name }}" readonly>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Account Number</label>
                    <input type="text" class="form-control" value="{{ $vendor->account_number }}" readonly>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Account Type</label>
                    <input type="text" class="form-control" value="{{ $vendor->account_type }}" readonly>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Branch Code</label>
                    <input type="text" class="form-control" value="{{ $vendor->branch_code }}" readonly>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label>Uploaded Documents</label>
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

              <div class="text-center mt-4">
                <button type="submit" onclick="submitApproval('approve')" class="btn btn-success">Approve</button>
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#returnModal">Return</button>
                <button type="submit" onclick="submitApproval('reject')" class="btn btn-danger">Reject</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Return Modal -->
<div class="modal fade" id="returnModal" tabindex="-1" role="dialog" aria-labelledby="returnModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="returnModalLabel">Return Reason</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{ route('vendors.approvalAction', $vendor->id) }}">
          @csrf
          <input type="hidden" name="action" value="return">
          <div class="form-group">
            <textarea name="message" id="returnTextReal" class="form-control" placeholder="Enter reason for return..."></textarea>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" onclick="prepareReturnMessage()" class="btn btn-primary">Submit Return</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  function submitApproval(actionType) {
    document.getElementById('actionType').value = actionType;
  }

  function prepareReturnMessage() {
    document.getElementById('returnTextReal').value = document.getElementById('returnTextReal').value;
  }
</script>
@endsection
