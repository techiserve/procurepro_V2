@extends('stack.layouts.admin')

@section('content')
<div class="container-fluid">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-sm-12">
        <form method="POST" action="/vendors/store" enctype="multipart/form-data" id="vendorForm">
          @csrf
          <input type="hidden" name="is_frm_continue" id="is_frm_continue" value="exit">

          <div class="card">
            <div class="card-header">
              <strong>Request a Vendor</strong>
              <a href="/vendors/index" class="btn btn-primary btn-sm pull-right">
                <i class="fa fa-align-justify" style="color:white;"></i> Vendor List
              </a>
            </div>

            <div class="card-body">
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="name">Vendor Name</label>
                    <input class="form-control" id="name" name="name" type="text">
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="type">Vendor Type</label>
                    <select class="form-control" id="type" name="type">
                      <option value="">--Select--</option>
                      @foreach($vendorTypes as $type)
                        <option value="{{ $type->name }}">{{ $type->name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="description">Description</label>
                    <input class="form-control" id="description" name="description" type="text">
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group" style="margin-top: 20px;">
                    <label>VAT Registered</label><br>
                    <label class="radio-inline"><input type="radio" name="vat_registered" value="Yes"> Yes</label>
                    <label class="radio-inline"><input type="radio" name="vat_registered" value="No"> No</label>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="vat_allocation">VAT Allocation</label>
                    <input class="form-control" id="vat_allocation" name="vat_allocation" type="text">
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="contact_no_1">Contact Number 1</label>
                    <input class="form-control" id="contact_no_1" name="contact_no_1" type="text">
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="contact_no_2">Contact Number 2</label>
                    <input class="form-control" id="contact_no_2" name="contact_no_2" type="text">
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="supplier_code">Supplier Code</label>
                    <input class="form-control" id="supplier_code" name="supplier_code" type="text">
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="address">Address</label>
                    <textarea class="form-control" id="address" name="address" rows="3"></textarea>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="finance_manager">Finance Manager</label>
                    <select class="form-control" id="finance_manager" name="finance_manager">
                      <option value="0">--Select--</option>
                      <option value="55">Bilal_Finance Manager</option>
                      <option value="60">Bilal_finance2</option>
                      <option value="119">Owftest001_11</option>
                      <option value="122">M.Kajee Test</option>
                      <option value="133">Mr Laher 2_20</option>
                      <option value="134">Mr Laher 3</option>
                      <option value="136">Mr Laher 3_22</option>
                    </select>
                  </div>
                </div>
              </div>

              <hr>
              <h4>Upload Documents</h4>
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Document Name</label>
                    <input type="text" class="form-control" id="vendor_document_name_temp" placeholder="Enter document name">
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Upload File(s)</label>
                    <input type="file" class="form-control" id="vendor_document_temp" multiple>
                  </div>
                </div>
              </div>

              <button type="button" class="btn btn-primary" onclick="addDocument()">Add Document</button>

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

              <!-- Real hidden inputs to submit files and names -->
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
    document.getElementById('vendorForm').submit();
  }
</script>
@endsection
