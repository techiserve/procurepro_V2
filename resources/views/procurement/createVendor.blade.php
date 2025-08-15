@extends('html.default')

@section('content')
<div class="container-fluid">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-12"> {{-- Full width --}}
        <form method="POST" action="/vendors/store" enctype="multipart/form-data" id="vendorForm">
          @csrf
          <input type="hidden" name="is_frm_continue" id="is_frm_continue" value="exit">

          <div class="card">
            <div class="card-header">
              <strong>Request a Vendor</strong>
            <div class="d-flex justify-content-end mb-3" style="gap: 10px;">
              <a href="/vendors/index" class="btn btn-primary btn-sm pull-right">
                <i class="fa fa-align-justify" style="color:white;"></i> Vendor List
              </a>
            </div>
              </div>

            <div class="card-body">
              {{-- Vendor Details --}}
              <div class="row">
                <div class="col-sm-6">
                  <label for="name" class="form-label">Vendor Name</label>
                  <input class="form-control" id="name" name="name" type="text">
                </div>

                <div class="col-sm-6">
                  <label for="type" class="form-label">Vendor Type</label>
                  <select class="form-control" id="type" name="type">
                    <option value="">--Select--</option>
                    @foreach($vendorTypes as $type)
                      <option value="{{ $type->name }}">{{ $type->name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="row mt-3">
                <div class="col-sm-6">
                  <label for="description" class="form-label">Description</label>
                  <input class="form-control" id="description" name="description" type="text">
                </div>

                <div class="col-sm-6">
                  <label class="form-label d-block">VAT Registered</label>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="vat_registered" value="Yes" id="vat_yes">
                    <label class="form-check-label" for="vat_yes">Yes</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="vat_registered" value="No" id="vat_no">
                    <label class="form-check-label" for="vat_no">No</label>
                  </div>
                </div>
              </div>

              <div class="row mt-3">
                <div class="col-sm-6">
                  <label for="vat_allocation" class="form-label">VAT Allocation</label>
                  <input class="form-control" id="vat_allocation" name="vat_allocation" type="text">
                </div>

                <div class="col-sm-6">
                  <label for="contact_no_1" class="form-label">Contact Number 1</label>
                  <input class="form-control" id="contact_no_1" name="contact_no_1" type="text">
                </div>
              </div>

              <div class="row mt-3">
                <div class="col-sm-6">
                  <label for="contact_no_2" class="form-label">Contact Number 2</label>
                  <input class="form-control" id="contact_no_2" name="contact_no_2" type="text">
                </div>

                <div class="col-sm-6">
                  <label for="supplier_code" class="form-label">Supplier Code</label>
                  <input class="form-control" id="supplier_code" name="supplier_code" type="text">
                </div>
              </div>

              <div class="row mt-3">
                <div class="col-sm-6">
                  <label for="address" class="form-label">Address</label>
                  <textarea class="form-control" id="address" name="address" rows="3"></textarea>
                </div>

                <div class="col-sm-6">
                  <label for="finance_manager" class="form-label">Finance Manager</label>
                  <select class="form-control" id="finance_manager" name="finance_manager" required>
                    <option value="">--Select--</option>
                    @foreach($users as $user)
                      <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>

              {{-- Upload Documents --}}
              <hr>
              <h4>Upload Documents</h4>
              <div class="row">
                <div class="col-sm-6">
                  <label class="form-label">Document Name</label>
                  <input type="text" class="form-control" id="vendor_document_name_temp" placeholder="Enter document name">
                </div>

                <div class="col-sm-6">
                  <label class="form-label">Upload File(s)</label>
                  <input type="file" class="form-control" id="vendor_document_temp" multiple>
                </div>
              </div>

              <button type="button" class="btn btn-primary mt-3" onclick="addDocument()">Add Document</button>

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
            </div>

            <div class="card-footer">
              <div class="form-group pull-right">
                <button type="button" class="btn btn-info" onclick="submitForm('exit')">Save & Close</button>
                <button type="button" class="btn btn-primary" onclick="submitForm('continue')">Save & Continue</button>
                <button type="reset" class="btn btn-danger">Cancel</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

{{-- Scripts --}}
<script>
  function addDocument() {
    const name = document.getElementById('vendor_document_name_temp').value;
    const files = document.getElementById('vendor_document_temp').files;
    const container = document.getElementById('document_inputs_container');
    const table = document.getElementById('vendor_documents_list');

    if (!name || files.length === 0) {
      alert("Please provide both document name and file(s).");
      return;
    }

    Array.from(files).forEach((file, index) => {
      const fileInputId = 'file_input_' + Date.now() + '_' + index;

      const fileInput = document.createElement('input');
      fileInput.type = 'file';
      fileInput.name = 'vendor_documents[]';
      fileInput.style.display = 'none';
      fileInput.files = createFileList(file);
      fileInput.id = fileInputId;

      const nameInput = document.createElement('input');
      nameInput.type = 'hidden';
      nameInput.name = 'document_names[]';
      nameInput.value = name;

      container.appendChild(fileInput);
      container.appendChild(nameInput);

      const row = `
        <tr>
          <td>${name}</td>
          <td>${file.name}</td>
          <td><button type="button" class="btn btn-danger btn-sm" onclick="removeDocumentRow(this, '${fileInputId}')">Remove</button></td>
        </tr>`;
      table.insertAdjacentHTML('beforeend', row);
    });

    document.getElementById('vendor_document_name_temp').value = '';
    document.getElementById('vendor_document_temp').value = '';
  }

  function createFileList(file) {
    const dt = new DataTransfer();
    dt.items.add(file);
    return dt.files;
  }

  function removeDocumentRow(button, fileInputId) {
    button.closest('tr').remove();
    document.getElementById(fileInputId)?.remove();
  }

  function submitForm(action) {
    document.getElementById('is_frm_continue').value = action;
    document.getElementById('vendorForm').requestSubmit();
  }
</script>
@endsection
