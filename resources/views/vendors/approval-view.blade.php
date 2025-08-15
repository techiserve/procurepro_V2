@extends('html.default')

@section('content')
<div class="body-content__header">
    <ul>
        <li><a href="#">Vendor Details</a></li>
    </ul>
</div>

<div class="body-content__wrapper requesition-body">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong>Vendor Details</strong>
            <a href="{{ route('vendors.approval') }}" class="btn btn-secondary btn-sm">Back</a>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('vendors.approvalAction', $vendor->id) }}">
                @csrf
                <input type="hidden" name="action" id="actionType" value="">
                <input type="hidden" name="message" id="returnMessage" value="">

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" value="{{ $vendor->name }}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Type</label>
                        <input type="text" class="form-control" value="{{ $vendor->type }}" readonly>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Description</label>
                        <input type="text" class="form-control" value="{{ $vendor->description }}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Finance Manager</label>
                        @php
                            $manager = $users->firstWhere('id', $vendor->finance_manager);
                        @endphp
                        <input type="text" class="form-control" value="{{ $manager?->name ?? 'N/A' }}" readonly>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">VAT Registered</label>
                        <input type="text" class="form-control" value="{{ $vendor->vat_registered }}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">VAT Allocation</label>
                        <input type="text" class="form-control" value="{{ $vendor->vat_allocation }}" readonly>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Contact No 1</label>
                        <input type="text" class="form-control" value="{{ $vendor->contact_no_1 }}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Contact No 2</label>
                        <input type="text" class="form-control" value="{{ $vendor->contact_no_2 }}" readonly>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Supplier Code</label>
                        <input type="text" class="form-control" value="{{ $vendor->supplier_code }}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Address</label>
                        <input type="text" class="form-control" value="{{ $vendor->address }}" readonly>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Bank Name</label>
                        <input type="text" class="form-control" value="{{ $vendor->bank_name }}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Account Number</label>
                        <input type="text" class="form-control" value="{{ $vendor->account_number }}" readonly>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Account Type</label>
                        <input type="text" class="form-control" value="{{ $vendor->account_type }}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Branch Code</label>
                        <input type="text" class="form-control" value="{{ $vendor->branch_code }}" readonly>
                    </div>
                </div>

                <div class="mt-4">
                    <label class="form-label">Uploaded Documents</label>
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

                @if($vendor->finance_manager == auth()->user()->id)
                <div class="text-center mt-4">
                    <button type="submit" onclick="submitApproval('approve')" class="btn btn-success me-2">Approve</button>
                    <button type="button" class="btn btn-info me-2" data-bs-toggle="modal" data-bs-target="#returnModal">Return</button>
                    <button type="submit" onclick="submitApproval('reject')" class="btn btn-danger">Reject</button>
                </div>
                @endif
            </form>
        </div>
    </div>
</div>

<!-- Return Modal -->
<div class="modal fade" id="returnModal" tabindex="-1" aria-labelledby="returnModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('vendors.approvalAction', $vendor->id) }}">
                @csrf
                <input type="hidden" name="action" value="return">
                <div class="modal-header">
                    <h5 class="modal-title" id="returnModalLabel">Return Reason</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <textarea name="message" class="form-control" placeholder="Enter reason for return..."></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Submit Return</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function submitApproval(actionType) {
    document.getElementById('actionType').value = actionType;
}
</script>
@endsection
