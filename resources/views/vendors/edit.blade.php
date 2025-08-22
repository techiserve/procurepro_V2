@extends('html.default')

@section('content')
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
                                <option value="">--Select--</option>
                                @foreach(['ABSA','FNB','Standard Bank','Nedbank','Capitec','Investec'] as $bank)
                                    <option value="{{ $bank }}" {{ $vendor->bank_name == $bank ? 'selected' : '' }}>{{ $bank }}</option>
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
                <h4 class="mt-4">Upload Documents</h4></br>
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
                <button type="button" class="btn btn-primary mt-2" onclick="addDocument()">Add Document</button>

                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>Document Name</th>
                            <th>File(s)</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="vendor_documents_list"></tbody>
                </table>
                <div id="document_inputs_container"></div>

                <h4 class="mt-4">Existing Documents</h4>
                @if($vendor->documents && count($vendor->documents))
                    <ul>
                        @foreach($vendor->documents as $doc)
                            <li>
                                <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank">{{ $doc->document_name }}</a>
                                <label class="ms-2 text-danger" style="cursor:pointer;">
                                    <input type="checkbox" name="delete_documents[]" value="{{ $doc->id }}"> Delete
                                </label>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p>No documents uploaded.</p>
                @endif
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

        const row = `
        <tr id="${rowId}">
            <td>${name}</td>
            <td>${files[i].name}</td>
            <td>
                <button type="button" class="btn btn-danger btn-sm" onclick="removeDocument('${rowId}')">Remove</button>
            </td>
        </tr>`;
        document.getElementById('vendor_documents_list').insertAdjacentHTML('beforeend', row);

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
}

function createFileList(file) {
    const dataTransfer = new DataTransfer();
    dataTransfer.items.add(file);
    return dataTransfer.files;
}
</script>
