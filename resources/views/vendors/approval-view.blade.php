@extends('html.default')
@section('content')
<style>
    .vendor-document-list {
        max-width: 760px;
        border-top: 1px solid #e2e8f0;
    }
    .vendor-document-item {
        display: flex;
        align-items: center;
        gap: 12px;
        min-height: 66px;
        padding: 12px 4px;
        border-bottom: 1px solid #e2e8f0;
        color: #25364a;
        text-decoration: none;
    }
    .vendor-document-item:hover,
    .vendor-document-item:focus-visible {
        color: #1456b8;
        background: #f7faff;
    }
    .vendor-document-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 38px;
        height: 38px;
        flex: 0 0 38px;
        border: 1px solid #d6e4f5;
        border-radius: 6px;
        background: #eef5ff;
        color: #1d5fbe;
    }
    .vendor-document-name {
        min-width: 0;
        flex: 1;
        overflow-wrap: anywhere;
        font-weight: 600;
    }
    .vendor-document-type {
        display: block;
        margin-top: 2px;
        color: #64748b;
        font-size: 13px;
        font-weight: 400;
    }
</style>
<div class="body-content__header">
    <ul>
        <li><a href="#">Vendor Details</a></li>
        {{-- <li class="ms-auto">
            <a href="{{ route('vendors.approval') }}" class="btn btn-primary btn-sm">
                Back
            </a>
        </li> --}}
    </ul>
</div>

<div class="body-content__wrapper requesition-body">
    <div class="card">
        <div class="card-header">
            <strong>Vendor Details</strong>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('vendors.approvalAction', $vendor->id) }}">
                @csrf
                <input type="hidden" name="action" id="actionType" value="">
                <input type="hidden" name="message" id="returnMessage" value="">

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-col">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" value="{{ $vendor->name }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-col">
                            <label class="form-label">Type</label>
                            <input type="text" class="form-control" value="{{ $vendor->type }}" readonly>
                        </div>
                    </div>

                    <div class="col-md-6 mt-3">
                        <div class="form-col">
                            <label class="form-label">Description</label>
                            <input type="text" class="form-control" value="{{ $vendor->description }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="form-col">
                            <label class="form-label">Finance Manager</label>
                            @php
                                $manager = $users->firstWhere('id', $vendor->finance_manager);
                            @endphp
                            <input type="text" class="form-control" value="{{ $manager?->name ?? 'N/A' }}" readonly>
                        </div>
                    </div>

                    <div class="col-md-6 mt-3">
                        <div class="form-col">
                            <label class="form-label">VAT Registered</label>
                            <input type="text" class="form-control" value="{{ $vendor->vat_registered }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="form-col">
                            <label class="form-label">VAT Allocation</label>
                            <input type="text" class="form-control" value="{{ $vendor->vat_allocation }}" readonly>
                        </div>
                    </div>

                    <div class="col-md-6 mt-3">
                        <div class="form-col">
                            <label class="form-label">Contact No 1</label>
                            <input type="text" class="form-control" value="{{ $vendor->contact_no_1 }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="form-col">
                            <label class="form-label">Contact No 2</label>
                            <input type="text" class="form-control" value="{{ $vendor->contact_no_2 }}" readonly>
                        </div>
                    </div>

                    <div class="col-md-6 mt-3">
                        <div class="form-col">
                            <label class="form-label">Supplier Code</label>
                            <input type="text" class="form-control" value="{{ $vendor->supplier_code }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="form-col">
                            <label class="form-label">Address</label>
                            <input type="text" class="form-control" value="{{ $vendor->address }}" readonly>
                        </div>
                    </div>

                    <div class="col-md-6 mt-3">
                        <div class="form-col">
                            <label class="form-label">Bank Name</label>
                            <input type="text" class="form-control" value="{{ $vendor->bank_name }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="form-col">
                            <label class="form-label">Account Number</label>
                            <input type="text" class="form-control" value="{{ $vendor->account_number }}" readonly>
                        </div>
                    </div>

                    <div class="col-md-6 mt-3">
                        <div class="form-col">
                            <label class="form-label">Account Type</label>
                            <input type="text" class="form-control" value="{{ $vendor->account_type }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="form-col">
                            <label class="form-label">Branch Code</label>
                            <input type="text" class="form-control" value="{{ $vendor->branch_code }}" readonly>
                        </div>
                    </div>
                </div>

                <section class="mt-4" aria-labelledby="vendor-documents-heading">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <h2 id="vendor-documents-heading" class="h6 mb-0">Uploaded Documents</h2>
                        <span class="badge bg-light text-secondary border">{{ $vendor->documents->count() }}</span>
                    </div>
                    @if($vendor->documents->isNotEmpty())
                        <div class="vendor-document-list">
                            @foreach($vendor->documents as $doc)
                                @php($extension = strtoupper(pathinfo($doc->file_path ?? '', PATHINFO_EXTENSION)))
                                <a class="vendor-document-item" href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" rel="noopener noreferrer" aria-label="Open {{ $doc->document_name ?: 'document' }} in a new tab">
                                    <span class="vendor-document-icon" aria-hidden="true"><i class="fa fa-file-o"></i></span>
                                    <span class="vendor-document-name">
                                        {{ $doc->document_name ?: 'Untitled document' }}
                                        <span class="vendor-document-type">{{ $extension ?: 'File' }} document</span>
                                    </span>
                                    <i class="fa fa-external-link text-muted" aria-hidden="true"></i>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted mb-0">No documents uploaded.</p>
                    @endif
                </section>

                @if($vendor->finance_manager == auth()->user()->id)
                <div class="mt-4">
                    <div class="d-flex justify-content-end gap-2">
                        <button type="submit" onclick="submitApproval('approve')" class="btn btn-success">Approve</button>
                        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#returnModal">Return</button>
                        <button type="submit" onclick="submitApproval('reject')" class="btn btn-danger">Reject</button>
                    </div>
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
