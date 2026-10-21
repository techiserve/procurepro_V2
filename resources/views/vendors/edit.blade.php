@extends('html.default')

@section('content')
<style>
    .vendor-edit-document-list {
        max-width: 760px;
        border-top: 1px solid #e2e8f0;
    }
    .vendor-edit-document-item {
        display: flex;
        align-items: center;
        gap: 12px;
        min-height: 66px;
        padding: 12px 4px;
        border-bottom: 1px solid #e2e8f0;
    }
    .vendor-edit-document-link {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 0;
        flex: 1;
        color: #25364a;
        text-decoration: none;
    }
    .vendor-edit-document-link:hover,
    .vendor-edit-document-link:focus-visible {
        color: #1456b8;
    }
    .vendor-edit-document-icon {
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
    .vendor-edit-document-name {
        min-width: 0;
        flex: 1;
        overflow-wrap: anywhere;
        font-weight: 600;
    }
    .vendor-edit-document-type {
        display: block;
        margin-top: 2px;
        color: #64748b;
        font-size: 13px;
        font-weight: 400;
    }
    .vendor-edit-document-delete {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        flex: 0 0 auto;
        margin: 0;
        color: #b42336;
        cursor: pointer;
    }
    #vendor_pending_documents td { overflow-wrap: anywhere; }
    @media (max-width: 575px) {
        .vendor-edit-document-item { flex-wrap: wrap; }
        .vendor-edit-document-delete { margin-left: 50px; }
    }
</style>
<div class="body-content__header">
    <ul>
        <li><a href="#">Edit Vendor</a></li>
        {{-- <li class="ms-auto">
            <a href="/vendors/index" class="btn btn-primary btn-sm">
                <i class="fa fa-align-justify"></i> Back to Vendor List
            </a>
        </li> --}}
    </ul>
</div>

<div class="body-content__wrapper requesition-body">
    <form method="POST" action="/vendors/update/{{ $vendor->id }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="card">
            <div class="card-header">
                <strong>Edit Vendor</strong>
            </div>

            <div class="card-body">
                <!-- Vendor Info -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-col">
                            <label for="name">Vendor Name</label>
                            <input class="form-control" id="name" name="name" value="{{ $vendor->name }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-col">
                            <label for="type">Vendor Type</label>
                            <select class="form-control" id="type" name="type">
                                <option value="">--Select--</option>
                                @foreach($vendorTypes as $type)
                                    <option value="{{ $type->name }}" {{ $vendor->type == $type->name ? 'selected' : '' }}>{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-col">
                            <label for="description">Description</label>
                            <input class="form-control" id="description" name="description" value="{{ $vendor->description }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="col-md-6">
                        <label class="form-label d-block">VAT Registered</label>
                        <div class="form-check form-check-inline mt-1">
                            <input class="form-check-input" type="radio" name="vat_registered" value="Yes" {{ $vendor->vat_registered == 'Yes' ? 'checked' : '' }}>
                            <label class="form-check-label">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="vat_registered" value="No" {{ $vendor->vat_registered == 'No' ? 'checked' : '' }}>
                            <label class="form-check-label">No</label>
                        </div>
                    </div>
                    </div>
                </div>

                <!-- Contact & VAT -->
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-col">
                            <label for="vat_allocation">VAT Allocation</label>
                            <input class="form-control" id="vat_allocation" name="vat_allocation" value="{{ $vendor->vat_allocation }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-col">
                            <label for="contact_no_1">Contact Number 1</label>
                            <input class="form-control" id="contact_no_1" name="contact_no_1" value="{{ $vendor->contact_no_1 }}">
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-col">
                            <label for="contact_no_2">Contact Number 2</label>
                            <input class="form-control" id="contact_no_2" name="contact_no_2" value="{{ $vendor->contact_no_2 }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-col">
                            <label for="supplier_code">Supplier Code</label>
                            <input class="form-control" id="supplier_code" name="supplier_code" value="{{ $vendor->supplier_code }}">
                        </div>
                    </div>
                </div>

                <!-- Address & Finance Manager -->
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-col">
                            <label for="address">Address</label>
                            <textarea class="form-control" id="address" name="address">{{ $vendor->address }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-col">
                            <label for="finance_manager">Finance Manager</label>
                            <select class="form-control" id="finance_manager" name="finance_manager">
                                <option value="{{ $vendor->finance_manager }}">{{ $finance->name }}</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Bank Info -->
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-col">
                            <label for="bank_name">Bank Name</label>
                            <select name="bank_name" id="bank_name" class="form-control">
                                <option value="{{$vendor->bank_name}}">{{$vendor->bank_name}}</option>
                                @foreach($banks as $bank)
                                <option value="{{ $bank->name }}">{{ $bank->name }}</option>
                               @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-col">
                            <label for="account_number">Account Number</label>
                            <input type="text" class="form-control" id="account_number" name="account_number" value="{{ $vendor->account_number }}">
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-col">
                            <label for="account_type">Account Type</label>
                            <select name="account_type" id="account_type" class="form-control">
                                <option value="">--Select--</option>
                                @foreach(['Cheque','Savings','Business'] as $type)
                                    <option value="{{ $type }}" {{ $vendor->account_type == $type ? 'selected' : '' }}>{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-col">
                            <label for="branch_code">Branch Code</label>
                            <input type="text" class="form-control" id="branch_code" name="branch_code" value="{{ $vendor->branch_code }}">
                        </div>
                    </div>
                </div>

                @if(!empty($vendor->message))
                <div class="row mt-3">
                    <div class="col-md-12">
                        <div class="form-col">
                            <label>Return Reason</label>
                            <textarea class="form-control" readonly>{{ $vendor->message }}</textarea>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Document Upload -->
                <section class="mt-4" aria-labelledby="vendor-upload-heading">
                <h4 id="vendor-upload-heading" class="mb-3">Upload Documents</h4>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-col">
                            <label for="vendor_document_name_temp">Document Name</label>
                            <input type="text" class="form-control" id="vendor_document_name_temp" placeholder="Enter document name">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-col">
                            <label for="vendor_document_temp">Upload File(s)</label>
                            <input type="file" class="form-control" id="vendor_document_temp" multiple>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-primary mt-3" onclick="addDocument()"><i class="fa fa-plus" aria-hidden="true"></i> Add Document</button>

                <div id="vendor_pending_documents" class="table-responsive mt-3 d-none">
                <table class="table table-bordered table-sm mb-0">
                    <thead>
                        <tr>
                            <th>Document Name</th>
                            <th>File(s)</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="vendor_documents_list"></tbody>
                </table>
                </div>
                <div id="document_inputs_container" class="d-none"></div>
                </section>

                <section class="mt-4" aria-labelledby="vendor-existing-documents-heading">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <h4 id="vendor-existing-documents-heading" class="mb-0">Existing Documents</h4>
                    <span class="badge bg-light text-secondary border">{{ $vendor->documents->count() }}</span>
                </div>
                @if($vendor->documents->isNotEmpty())
                    <div class="vendor-edit-document-list">
                        @foreach($vendor->documents as $doc)
                            @php($extension = strtoupper(pathinfo($doc->file_path ?? '', PATHINFO_EXTENSION)))
                            <div class="vendor-edit-document-item">
                                <a class="vendor-edit-document-link" href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" rel="noopener noreferrer" aria-label="Open {{ $doc->document_name ?: 'document' }} in a new tab">
                                    <span class="vendor-edit-document-icon" aria-hidden="true"><i class="fa fa-file-o"></i></span>
                                    <span class="vendor-edit-document-name">
                                        {{ $doc->document_name ?: 'Untitled document' }}
                                        <span class="vendor-edit-document-type">{{ $extension ?: 'File' }} document</span>
                                    </span>
                                    <i class="fa fa-external-link text-muted" aria-hidden="true"></i>
                                </a>
                                <label class="vendor-edit-document-delete">
                                    <input type="checkbox" name="delete_documents[]" value="{{ $doc->id }}"> Delete
                                </label>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted mb-0">No documents uploaded.</p>
                @endif
                </section>
            </div>

            <div class="card-footer">
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-success" style="padding:10px 20px; font-size:16px; min-width:120px;">Update Vendor</button>
                    <a href="/vendors/index" class="btn btn-danger" style="padding:10px 20px; font-size:16px; min-width:120px;">Cancel</a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection


<script>
let documentIndex = 0;

function addDocument() {
    const name = document.getElementById('vendor_document_name_temp').value;
    const filesInput = document.getElementById('vendor_document_temp');
    const files = filesInput.files;

    if (!name || files.length === 0) {
        alert("Please enter a document name and select file(s).");
        return;
    }

    for (let i = 0; i < files.length; i++) {
        const rowId = `doc_row_${documentIndex}`;

        const row = document.createElement('tr');
        row.id = rowId;
        row.insertCell().textContent = name;
        row.insertCell().textContent = files[i].name;
        const removeButton = document.createElement('button');
        removeButton.type = 'button';
        removeButton.className = 'btn btn-danger btn-sm';
        removeButton.textContent = 'Remove';
        removeButton.addEventListener('click', () => removeDocument(rowId));
        row.insertCell().appendChild(removeButton);
        document.getElementById('vendor_documents_list').appendChild(row);
        document.getElementById('vendor_pending_documents').classList.remove('d-none');

        const container = document.getElementById('document_inputs_container');

        const nameInput = document.createElement('input');
        nameInput.type = 'hidden';
        nameInput.name = `new_documents[${documentIndex}][name]`;
        nameInput.value = name;

        const fileInput = document.createElement('input');
        fileInput.type = 'file';
        fileInput.name = `new_documents[${documentIndex}][file]`;
        fileInput.files = createFileList(files[i]);

        const wrapper = document.createElement('div');
        wrapper.id = `wrapper_${rowId}`;
        wrapper.appendChild(nameInput);
        wrapper.appendChild(fileInput);

        container.appendChild(wrapper);
        documentIndex++;
    }

    document.getElementById('vendor_document_name_temp').value = '';
    filesInput.value = '';
}

function removeDocument(rowId) {
    document.getElementById(rowId)?.remove();
    document.getElementById(`wrapper_${rowId}`)?.remove();
    if (!document.getElementById('vendor_documents_list').children.length) {
        document.getElementById('vendor_pending_documents').classList.add('d-none');
    }
}

function createFileList(file) {
    const dataTransfer = new DataTransfer();
    dataTransfer.items.add(file);
    return dataTransfer.files;
}
</script>
